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

    // Obtenemos la lista de colecciones
    $pst = $mydb->prepare($querys['coleccion']['4_listado']);
    $pst->bind_param("s", $UsrUsr);
    $pst->execute();
    $rs = $pst->get_result();

    $adata = array();
    while($coleccion = $rs->fetch_assoc()){
        $adata[] = $coleccion;
    }

    // Logica del negocio
    echo json_encode(array(
        "status"=> "OK",
        "payload"=> $adata
    ));
?>