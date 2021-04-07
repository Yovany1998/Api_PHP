<?php
    // 09/Febrero
    //Librerias
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");
    include("../../tools/mailer.php");
    
    //Query de referencia
    //"2_insertar" => "INSERT INTO usuarios VALUES('UsrUsr','UsrNom','UsrPwd','UsrMail','UsrTel','UsrEst');"
    
    //Limpieza de parametros
    $UsrUsr     = (isset($_POST["UsrUsr"]))?$_POST["UsrUsr"]:"";
    $UsrNom     = (isset($_POST["UsrNom"]))?$_POST["UsrNom"]:"";
    $UsrPwd     = (isset($_POST["UsrPwd"]))?$_POST["UsrPwd"]:"";
    $UsrMail    = (isset($_POST["UsrMail"]))?$_POST["UsrMail"]:"";
    $UsrTel     = (isset($_POST["UsrTel"]))?$_POST["UsrTel"]:"";
    $UsrEst     = (isset($_POST["UsrEst"]))?$_POST["UsrEst"]:"";

    $UsrUsr = mysqli_real_escape_string($mydb, $UsrUsr);
    $UsrNom = mysqli_real_escape_string($mydb, $UsrNom);
    $UsrPwd = mysqli_real_escape_string($mydb, $UsrPwd);
    $UsrMail = mysqli_real_escape_string($mydb, $UsrMail);
    $UsrTel = mysqli_real_escape_string($mydb, $UsrTel);
    $UsrEst = mysqli_real_escape_string($mydb, $UsrEst);

    //Insertamos el registro
    $pst = $mydb->prepare($querys['usuarios']['2_insertar']);
    //Las 's' son la cantidad de parametros que indicadn string en el query
    $pst->bind_param("ssssss",$UsrUsr, $UsrNom, $UsrPwd, $UsrMail, $UsrTel, $UsrEst);
    $pst->execute();

    header("Content-type: application/json");
    if ($mydb->error) {
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error registando el usuario."
            )
        ));
    }else{
        //Envio del correo electronico
        $body = "Su cuenta fue creada correctamente. Debe confirmarla haciendo click en este enlace.";
        send_email("desde@correo.com","Mi nombre",$UsrMail,"Confirmacion de cuenta",$body);

        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Usuario registrado."
            )
        ));
    }

?>