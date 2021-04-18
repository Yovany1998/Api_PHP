<?php

    @header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Max-Age: 86400'); 
        header("Access-Control-Allow-Headers: X-Requested-With");
        @header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    @$params = json_decode(file_get_contents('php://input'), true);
    if(!empty($params)){
        $_POST = $params;
    }

    ini_set('session.cookie_samesite', 'None');
    ini_set('session.cookie_secure', '1');
?>