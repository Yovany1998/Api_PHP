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
    $UsrUsr     = $_SESSION["UsrUsr"];
    //Se genera con uniq id: es una funcion que genera un id unico en php basado en el TIMESTAMP
    $ColCod     = uniqid();
    $ColNom     = (isset($_POST["ColNom"]))?$_POST["ColNom"]:"";
    //Formato y time devulve la hora actual
    $ColFechCre = date("Y-m-d", time());
    $ColDsc     = (isset($_POST["ColDsc"]))?$_POST["ColDsc"]:"";

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
    $ColCod     = mysqli_real_escape_string($mydb, $ColCod);
    $ColNom     = mysqli_real_escape_string($mydb, $ColNom);
    $ColFechCre = mysqli_real_escape_string($mydb, $ColFechCre);
    $ColDsc     = mysqli_real_escape_string($mydb, $ColDsc);

    //Inserccion de la coleccion
    $pst = $mydb->prepare($querys['coleccion']['1_insertar']);
    $pst->bind_param("sssss", $UsrUsr ,$ColCod ,$ColNom ,$ColFechCre, $ColDsc);
    $pst->execute();

    if ($mydb->error) {
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error creando la coleccion."
            )
        ));
    }else{
        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Coleccion creada."
            )
        ));
    }

?>