<?php

    // Librerias
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");

    session_start();

    header("Content-Type: application/json");

    // Validamos sesión
    if(!isset($_SESSION['UsrUsr'])){
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "message"=>"Usuario no autenticado."
            )
        ));

        die();
    }

    // Limpieza de parametros
    $UsrUsr     = $_SESSION['UsrUsr'];
    $UsrNom     = (isset($_POST["UsrNom"]))?$_POST["UsrNom"]:"";
    $UsrTel     = (isset($_POST["UsrTel"]))?$_POST["UsrTel"]:"";

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
    $UsrNom     = mysqli_real_escape_string($mydb, $UsrNom);
    $UsrTel     = mysqli_real_escape_string($mydb, $UsrTel);
    
    // Actulizar el registro
    $pst = $mydb->prepare($querys['usuarios']['3_actualizar']);
    $pst->bind_param("sss", $UsrNom, $UsrTel, $UsrUsr);
    $pst->execute();
    
    // Logica del negocio
    if($mydb->error){
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error actualizando el usuario."
            )
        ));
    }else{
        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Usuario actualizado."
            )
        ));
    }
    
?>