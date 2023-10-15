<?php
    header('Content-Type: application/json; charset=utf-8');
    
    if(!array_key_exists('file', $_FILES) || $_FILES['file'] == null) sendError('Attach a file please');
    checkHashSum($_FILES['file']['tmp_name'], $_POST['filehash']);
    authorize( getallheaders()['Api-Key'] );
    file_put_contents('./files/' . hash('md5', $_FILES['file']['name']), file_get_contents($_FILES['file']['tmp_name']));
    
    echo json_encode([
        'success' => true
    ]);

    function authorize($apiKey) {
        if($apiKey == null) sendError('Access error');
        $host = "pgsql-webformat"; 
        $user = "webformat"; 
        $pass = "123"; 
        $db = "postgres"; 

        $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or sendError('Internal server error'); 
    
        $query = "SELECT COUNT(api_key) FROM api_keys WHERE api_key='$apiKey' LIMIT 1"; 
        
        $rs = pg_query($con, $query) or sendError('Internal server error');
        if(pg_fetch_row($rs)[0] === '0') sendError('Access error');
    
        pg_close($con); 
    }

    function checkHashSum($file, $filehash) {
        if(hash_file('sha256', $file) !== $filehash) sendError('File was corrupted during transmissnon');
    }

    function sendError($text) {
        echo json_encode([
            'success' => false, 
            'error' => $text
        ]);
        exit;
    }

?>