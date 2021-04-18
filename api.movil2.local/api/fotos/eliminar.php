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

    $UsrUsr     = $_SESSION["UsrUsr"];
    $ColCod     = isset($_POST['ColCod'])?$_POST['ColCod']:"";
    $FotCod     = isset($_POST['FotCod'])?$_POST['FotCod']:"";

    // Obtener los datos del archivo a eliminar
    $pst = $mydb->prepare($querys["fotos"]["2_obtener"]);
    $pst->bind_param("sss", $UsrUsr, $ColCod, $FotCod);
    $pst->execute();
    $rs = $pst->get_result();

    if($file = $rs->fetch_assoc()){
        // Eliminamos el archivo fisico
        $path = "../../data".$file["FotPath"];
        @unlink($path);

        // Eliminamos el registro de la base de datos
        $pst = $mydb->prepare($querys["fotos"]["3_eliminar"]);
        $pst->bind_param("sss", $UsrUsr, $ColCod, $FotCod);
        $pst->execute();

        if($mydb->error){
            echo json_encode(array(
                "status"=>"ER",
                "payload"=>array(
                    "error" => $mydb->error,
                    "message"=>"Ocurrio un error eliminando la foto."
                )
            ));

            die();
        }

        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Foto eliminada."
            )
        ));
    }else{
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "message"=>"Foto no encontrada."
            )
        ));
    }

?>