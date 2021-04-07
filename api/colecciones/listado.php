<?php

    //Librerias
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

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);

    //Actulizacion de la coleccion
    $pst = $mydb->prepare($querys['coleccion']['4_listado']);
    $pst->bind_param("s", $UsrUsr);
    $pst->execute();
    //Obtener los resultados
    $rs = $pst->get_result();
    //Vammos a tener asociativamente una coleccion
    
    $adata = array();
    while ($coleccion = $rs->fetch_assoc()) {
        //Arreglo de todos loas filas
        $adata[] = $coleccion;
    }

    //Logica del negocio
        echo json_encode(array(
            "status"=>"OK",
            "payload"=> $adata
        ));

?>