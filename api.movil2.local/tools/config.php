<?php

    include("../../tools/cors.php");

    $config = json_decode('
        {
            "db": {
                "hostname": "127.0.0.1",
                "username": "root",
                "password": "Coba123 ",
                "database": "picme"
            },
            "smtp": {
                "host": "email-smtp.us-east-1.amazonaws.com",
                "user": "AKIA6NYUMABGLZS7FZNY", 
                "pass": "BLRF1JzK+gA6ZzHlAwvU0pg3TyqPQnvmOOXxqxcHsx1y"
            }
        }
    ');

?>