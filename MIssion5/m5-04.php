<?php

require __DIR__ . '/../db_connect.php';

// 初回実行時はテーブルを作成し、5-3までのテーブルにはpassword列を追加する。
$pdo->query("CREATE TABLE IF NOT EXISTS tbboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32) NOT NULL,
    comment TEXT NOT NULL,
    date DATETIME NOT NULL,
    password VARCHAR(255) NULL
)");

$column = $pdo->query("SHOW COLUMNS FROM tbboard LIKE 'password'")->fetch();
if (!$column) {
    $pdo->exec("ALTER TABLE tbboard ADD password VARCHAR(255) NULL AFTER date");
}

$message = '';
$editId = '';
$editName = '';
$editComment = '';
$editPassword = '';

// 新規投稿、または編集内容の保存。
if (isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $inputPassword = $_POST['password'] ?? '';
    $requestedEditId = filter_input(INPUT_POST, 'edit_id', FILTER_VALIDATE_INT);

    if ($name === '' || $comment === '' || $inputPassword === '') {
        $message = '名前・コメント・パスワードをすべて入力してください。';
        $editId = $requestedEditId ?: '';
        $editName = $name;
        $editComment = $comment;
        $editPassword = $inputPassword;
    } elseif ($requestedEditId) {
        $stmt = $pdo->prepare('SELECT password FROM tbboard WHERE id = :id');
        $stmt->bindValue(':id', $requestedEditId, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post && !empty($post['password']) && password_verify($inputPassword, $post['password'])) {
            // 編集しても、投稿時に設定したパスワードは変更しない。
            $stmt = $pdo->prepare(
                'UPDATE tbboard SET name = :name, comment = :comment, date = :date WHERE id = :id'
            );
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':date', date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->bindValue(':id', $requestedEditId, PDO::PARAM_INT);
            $stmt->execute();
            $message = '投稿を編集しました。';
        } else {
            $message = 'パスワードが違うため、編集できません。';
        }
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO tbboard (name, comment, date, password) VALUES (:name, :comment, :date, :password)'
        );
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':date', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($inputPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->execute();
        $message = '投稿しました。';
    }
}

// 削除は、保存済みパスワードと一致した場合だけ実行する。
if (isset($_POST['delete'])) {
    $deleteId = filter_input(INPUT_POST, 'delete_id', FILTER_VALIDATE_INT);
    $inputPassword = $_POST['delete_password'] ?? '';

    $stmt = $pdo->prepare('SELECT password FROM tbboard WHERE id = :id');
    $stmt->bindValue(':id', $deleteId, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post && !empty($post['password']) && password_verify($inputPassword, $post['password'])) {
        $stmt = $pdo->prepare('DELETE FROM tbboard WHERE id = :id');
        $stmt->bindValue(':id', $deleteId, PDO::PARAM_INT);
        $stmt->execute();
        $message = '投稿を削除しました。';
    } else {
        $message = '投稿番号またはパスワードが違うため、削除できません。';
    }
}

// 編集フォームには、パスワードが一致した投稿だけを読み込む。
if (isset($_POST['edit'])) {
    $requestedEditId = filter_input(INPUT_POST, 'edit_target_id', FILTER_VALIDATE_INT);
    $inputPassword = $_POST['edit_password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, name, comment, password FROM tbboard WHERE id = :id');
    $stmt->bindValue(':id', $requestedEditId, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post && !empty($post['password']) && password_verify($inputPassword, $post['password'])) {
        $editId = $post['id'];
        $editName = $post['name'];
        $editComment = $post['comment'];
        $editPassword = $inputPassword;
        $message = '編集内容を入力し、編集を保存してください。';
    } else {
        $message = '投稿番号またはパスワードが違うため、編集できません。';
    }
}

$posts = $pdo->query('SELECT id, name, comment, date FROM tbboard ORDER BY id ASC')->fetchAll(PDO::FETCH_ASSOC);

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード付き掲示板</title>
</head>
<body>
    <h1>パスワード付き掲示板</h1>
    <p>投稿時に設定したパスワードを使って、本人だけが編集・削除できます。</p>

    <?php if ($message !== ''): ?>
        <p><?= h($message) ?></p>
    <?php endif; ?>

    <h2><?= $editId !== '' ? '投稿を編集' : '新規投稿' ?></h2>
    <form method="post">
        <input type="hidden" name="edit_id" value="<?= h($editId) ?>">
        <input type="text" name="name" value="<?= h($editName) ?>" placeholder="名前" required>
        <input type="text" name="comment" value="<?= h($editComment) ?>" placeholder="コメント" required>
        <input type="password" name="password" value="<?= h($editPassword) ?>" placeholder="パスワード" required>
        <input type="submit" name="submit" value="<?= $editId !== '' ? '編集を保存' : '投稿' ?>">
    </form>

    <h2>投稿を削除</h2>
    <form method="post">
        <input type="number" name="delete_id" min="1" placeholder="削除対象番号" required>
        <input type="password" name="delete_password" placeholder="パスワード" required>
        <input type="submit" name="delete" value="削除">
    </form>

    <h2>投稿を編集</h2>
    <form method="post">
        <input type="number" name="edit_target_id" min="1" placeholder="編集対象番号" required>
        <input type="password" name="edit_password" placeholder="パスワード" required>
        <input type="submit" name="edit" value="編集">
    </form>

    <h2>投稿一覧</h2>
    <?php if (!$posts): ?>
        <p>まだ投稿はありません。</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <p>
                <?= h($post['id']) ?>
                <?= h($post['name']) ?>
                <?= h($post['comment']) ?>
                <?= h($post['date']) ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
