<?php
    // Librerias
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");

    session_start();

    header("Content-Type: application/json");

    // Validacion de sesión
    if(!isset($_SESSION['UsrUsr'])){
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "message"=>"Usuario no autenticado."
            )
        ));

        die();
    }
    //Preparacion para el almacenamiento de la foto
    $UsrUsr     = $_SESSION["UsrUsr"];
    $ColCod     = (isset($_POST["ColCod"]))?$_POST["ColCod"]:""; 
    $store_dir  = "../../data/$UsrUsr/$ColCod/";
    @mkdir($store_dir,0777, true);
    
    $FotFile     = $_FILES["FotFile"];
    $tmp_path    = $FotFile["tmp_name"];
    $path        = "../../data/".$FotFile["name"];
    $public_path = "/$UsrUsr/$ColCod/".$FotFile["name"];
    
    if (move_uploaded_file($tmp_path, $path)) {
        
        ///Limpieza de parametros       
        
        $FotCod     = uniqid();
        $FotFch     = date("Y-m-d", time());
        $FotPath    = $public_path;

        $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
        $ColCod     = mysqli_real_escape_string($mydb, $ColCod);
        $FotCod     = mysqli_real_escape_string($mydb, $FotCod);
        $FotFch     = mysqli_real_escape_string($mydb, $FotFch);
        $FotPath    = mysqli_real_escape_string($mydb, $FotPath);

        // Inserccion de la colección
        $pst = $mydb->prepare($querys['fotos']['1_insertar']);
        $pst->bind_param("sssss", $UsrUsr, $ColCod, $FotCod, $FotFch, $FotPath);
        $pst->execute();

        // Logica
        if($mydb->error){
            echo json_encode(array(
                "status"=>"ER",
                "payload"=>array(
                    "error"=> $mydb->error,
                    "message"=>"Ocurrio un error insertando la foto."
                )
            ));
        }else{
            echo json_encode(array(
                "status"=>"OK",
                "payload"=>array(
                    "message"=>"Foto guardada."
                )
            ));
        }
    }else{
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "message"=>"Ocurrio un error almacenando la foto."
            )
        ));
    }
?>