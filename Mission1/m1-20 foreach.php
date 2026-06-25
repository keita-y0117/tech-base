<?php

$members = array("Ken", "Alice", "Judy", "BOSS", "Bob");

foreach ($members as $member) {

    if ($member == "BOSS") {
        echo "Good morning " . $member . "!<br>";
    } else {
        echo "Hi! " . $member . "<br>";
    }

}

?>