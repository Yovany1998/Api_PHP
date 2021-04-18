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

    // Limpiamos parametros
    $UsrUsr     = $_SESSION["UsrUsr"];
    $ColCod     = (isset($_POST["ColCod"]))?$_POST["ColCod"]:"";
    $ColNom     = (isset($_POST["ColNom"]))?$_POST["ColNom"]:"";
    $ColDsc     = (isset($_POST["ColDsc"]))?$_POST["ColDsc"]:"";

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
    $ColCod     = mysqli_real_escape_string($mydb, $ColCod);
    $ColNom     = mysqli_real_escape_string($mydb, $ColNom);
    $ColDsc     = mysqli_real_escape_string($mydb, $ColDsc);

    // Actualizamos la colección
    $pst = $mydb->prepare($querys['coleccion']['2_actualizar']);
    $pst->bind_param("ssss", $ColNom, $ColDsc, $ColCod, $UsrUsr);
    $pst->execute();

    // Logica del negocio
    if($mydb->error){
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error actualizando la colección."
            )
        ));
    }else{
        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Colección Actualizada."
            )
        ));
    }

?>