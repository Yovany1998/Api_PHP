<?php
    //Librerias
    //Al ejecutar estre script ejecuta el de la conexion
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");
    
    //Limpieza de parametros
    //!isset si existe una variable
    //Post Envio por formularios
    $UsrUsr     = (isset($_POST["UsrUsr"]))?$_POST["UsrUsr"]:"";
    $UsrPwd     = (isset($_POST["UsrPwd"]))?$_POST["UsrPwd"]:"";

    $UsrUsr = mysqli_real_escape_string($mydb, $UsrUsr);
    $UsrPwd = mysqli_real_escape_string($mydb, $UsrPwd);

    /*  
        Realizamos la consulta a la base de datos
        
        - Metodos para acceder a una funcion -> 
        - Prepaaramos un query de la estructura de nombres del arreglo para
        - poder acceder a la consulta. 
    */
    $pst = $mydb->prepare($querys["usuarios"]["1_obtener"]);
    //Decimos que es un string y le pasamos el parametro
    $pst->bind_param("s", $UsrUsr);
    //Ejecutamos el query
    $pst->execute();
    //Obtenemos el resultado
    $rs = $pst->get_result();
    
    header("Content-type: application/json");
    
    //Calculos o logica del negocio
    if($usuario = $rs->fetch_assoc()){
        //Si existe el usuario verificamos las contraseña
        if($UsrPwd == $usuario["UsrPwd"]){

            session_start();
            $_SESSION['UsrUsr'] = $usuario['UsrUsr'];

            echo json_encode(array(
                "status" => "OK",
                "payload" => array(
                    "message" => "Usuario autenticado con éxito."
                )
            ));
        }else{
            echo json_encode(array(
                "status" => "ER",
                "payload" => array(
                    "message" => "Usuario / Password Incorrectos."
                )
            ));
        }
    }else{
        echo json_encode(array(
            "status" => "ER",
            "payload" => array(
                "message" => "Usuario no encontrado."
            )
        ));
    }
    
?>