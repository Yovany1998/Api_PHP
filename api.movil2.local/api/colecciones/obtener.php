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

    // Datos de Entrada
    $UsrUsr     = $_SESSION["UsrUsr"];
    $ColCod = (isset($_POST['ColCod']))?$_POST['ColCod']:'';

    // Obtenemos la datos de colección
    $pst = $mydb->prepare($querys['coleccion']['5_obtener']);
    $pst->bind_param("ss", $UsrUsr, $ColCod);
    $pst->execute();
    $rs = $pst->get_result();

    // Logica del negocio
    $adata = array();
    if($coleccion = $rs->fetch_assoc()){

        // Obtenemos las fotos de la colección
        $pst = $mydb->prepare($querys['coleccion']['6_obtener_fotos']);
        $pst->bind_param("ss", $UsrUsr, $ColCod);
        $pst->execute();
        $rs = $pst->get_result();

        $afotos = [];
        while($foto = $rs->fetch_assoc()){
            $afotos[] = $foto;
        }

        $coleccion['fotos'] = $afotos;

        echo json_encode(array(
            "status"=> "OK",
            "payload"=> $coleccion
        ));
    }else{
        echo json_encode(array(
            "status"=> "ER",
            "payload"=> array(
                "message" => "Colección no encontrada"
            )
        ));
    }

    
?>