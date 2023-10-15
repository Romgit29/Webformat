<?php
    require_once('./authorize.php');
    authorize($_POST['login'], $_POST['password']);
    setcookie('webformat-login', $_POST['login']);
    setcookie('webformat-password', $_POST['password']);

    echo 'Успех!';
?>