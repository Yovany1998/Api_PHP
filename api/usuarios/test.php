<?php
    //Este es un mini ejemplo de lo que se necesita para
    //construir el correo que enviaremos.

    // Librerias
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");
    include("../../tools/mailer.php");

    $body = "Su cuenta fue creada correctamente.";
    
    send_email("desde@correo.com","Mi nombre","para@quien.com","Confirmacion de cuenta",$body);
?>