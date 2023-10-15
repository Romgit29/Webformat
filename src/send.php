<?php
    if(array_key_exists('url', $_POST)) $url = $_POST['url'];
    else $url = "https://httpbin.org/anything";
    if(!array_key_exists('file', $_FILES) || $_FILES['file'] == null) sendError('Attach a file please');
    $file = $_FILES['file']['tmp_name'];
    
    $ch = curl_init();
    $hash = hash_file('sha256', $file);
    $file = new \CURLFile($file);
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,           1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     array('file' => $file, 'filehash' => $hash)); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array("Content-Type: multipart/form-data", "Api-Key: " . getallheaders()['Api-Key'])); 

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;

    function sendError($text) {
        echo json_encode([
            'success' => false, 
            'error' => $text
        ]);
        exit;
    }
?>