<?php
    require_once('./authorize.php');
    require_once('./sendError.php');
    header('Content-Type: application/json; charset=utf-8');
    
    if(!array_key_exists('file', $_FILES) || $_FILES['file'] == null) sendError('Attach a file please');
    checkHashSum($_FILES['file']['tmp_name'], $_POST['filehash']);
    authorize($_POST['login'], $_POST['password']);
    file_put_contents('./files/' . hash('md5', $_FILES['file']['name']), file_get_contents($_FILES['file']['tmp_name']));
    
    echo 'Успех!';

    function checkHashSum($file, $filehash) {
        if(hash_file('sha256', $file) !== $filehash) sendError('File was corrupted during transmissnon');
    }
?>