<?php
    require_once('./sendError.php');
    function authorize($login, $password) {
        $host = "pgsql-webformat"; 
        $user = "webformat"; 
        $pass = "123"; 
        $db = "postgres"; 

        $con = pg_connect("host=$host dbname=$db user=$user password=$pass") or sendError('Internal server error'); 
        
        $query = "SELECT COUNT(*) FROM users WHERE login='$login' AND password='$password' LIMIT 1"; 
        
        $rs = pg_query($con, $query) or sendError('Internal server error');
        if(pg_fetch_row($rs)[0] === '0') sendError('Access error');
    
        pg_close($con); 
    }
?>