<?php
    session_start();
    $type = $_REQUEST["type"];
    $_SESSION["type"] = $type;
?>