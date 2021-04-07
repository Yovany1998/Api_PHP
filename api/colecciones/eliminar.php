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

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
    $ColCod     = mysqli_real_escape_string($mydb, $ColCod);

    //Actulizacion de la coleccion
    $pst = $mydb->prepare($querys['coleccion']['3_eliminar']);
    $pst->bind_param("ss", $ColCod ,$UsrUsr);
    $pst->execute();

    if ($mydb->error) {
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error al eliminar la coleccion."
            )
        ));
    }else{
        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Coleccion eliminada."
            )
        ));
    }

?>