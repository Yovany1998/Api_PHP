<?php

    //Librerias
    //Al ejecutar estre script ejecuta el de la conexion
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");

    session_start();

    header("Content-type: application/json");

    //Validamos sesion
    if (!isset($_SESSION['UsrUsr'])) {
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "message"=>"Usuario no autenticado."
            )
        ));

        die();
    }

    //Limpieza de parametros
    $UsrUsr     = $_SESSION['UsrUsr'];
    $ColCod     = (isset($_POST["ColCod"]))?$_POST["ColCod"]:"";
    $ColNom     = (isset($_POST["ColNom"]))?$_POST["ColNom"]:"";
    $ColDsc     = (isset($_POST["ColDsc"]))?$_POST["ColDsc"]:"";

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
    $ColCod     = mysqli_real_escape_string($mydb, $ColCod);
    $ColNom     = mysqli_real_escape_string($mydb, $ColNom);
    $ColDsc     = mysqli_real_escape_string($mydb, $ColDsc);

    //Actulizacion de la coleccion
    $pst = $mydb->prepare($querys['coleccion']['2_actualizar']);
    $pst->bind_param("ssss", $ColNom , $ColDsc, $ColCod ,$UsrUsr);
    $pst->execute();

    if ($mydb->error) {
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error al actualizar la coleccion."
            )
        ));
    }else{
        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Coleccion actulizada."
            )
        ));
    }

?>