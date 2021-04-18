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
    
    // Almacenamos la Foto.
    $UsrUsr     = $_SESSION["UsrUsr"];
    $ColCod     = (isset($_POST["ColCod"]))?$_POST["ColCod"]:"";
    $store_dir  = "../../data/$UsrUsr/$ColCod/";
    @mkdir($store_dir, 0777, true);
    
    $FotFile    = $_FILES["FotFile"];
    $tmp_path   = $FotFile["tmp_name"];
    $path       = $store_dir.$FotFile["name"];
    $public_path = "/$UsrUsr/$ColCod/".$FotFile["name"];

    if(move_uploaded_file($tmp_path, $path)){
        // Limpiamos parametros        
        $FotCod     = uniqid();
        $FotFch     = date("Y-m-d H:i:s", time());
        $FotPath    = $public_path;
    
        $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
        $ColCod     = mysqli_real_escape_string($mydb, $ColCod);
        $FotCod     = mysqli_real_escape_string($mydb, $FotCod);
        $FotFch     = mysqli_real_escape_string($mydb, $FotFch);
        $FotPath    = mysqli_real_escape_string($mydb, $FotPath);
    
        // Insertamos la colección
        $pst = $mydb->prepare($querys['fotos']['1_insertar']);
        $pst->bind_param("sssss", $UsrUsr, $ColCod, $FotCod, $FotFch, $FotPath);
        $pst->execute();
    
        // Logica del negocio
        if($mydb->error){
            echo json_encode(array(
                "status"=>"ER",
                "payload"=>array(
                    "error"=> $mydb->error,
                    "message"=>"Ocurrio un error creando la foto."
                )
            ));
        }else{
            echo json_encode(array(
                "status"=>"OK",
                "payload"=>array(
                    "message"=>"Foto creada."
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