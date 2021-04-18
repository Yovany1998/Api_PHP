<?php
    // Librerias
    include("../../tools/config.php");
    include("../../tools/mysql.php");
    include("../../tools/querys.php");
    include("../../tools/mailer.php");

    // Limpieza de parametros
    $UsrUsr     = (isset($_POST["UsrUsr"]))?$_POST["UsrUsr"]:"";
    $UsrNom     = (isset($_POST["UsrNom"]))?$_POST["UsrNom"]:"";
    $UsrPwd     = (isset($_POST["UsrPwd"]))?$_POST["UsrPwd"]:"";
    $UsrMail    = (isset($_POST["UsrMail"]))?$_POST["UsrMail"]:"";
    $UsrTel     = (isset($_POST["UsrTel"]))?$_POST["UsrTel"]:"";
    $UsrEst     = (isset($_POST["UsrEst"]))?$_POST["UsrEst"]:"";

    $UsrUsr     = mysqli_real_escape_string($mydb, $UsrUsr);
    $UsrNom     = mysqli_real_escape_string($mydb, $UsrNom);
    $UsrPwd     = mysqli_real_escape_string($mydb, $UsrPwd);
    $UsrMail    = mysqli_real_escape_string($mydb, $UsrMail);
    $UsrTel     = mysqli_real_escape_string($mydb, $UsrTel);
    $UsrEst     = mysqli_real_escape_string($mydb, $UsrEst);

    // Insertamos el registro
    $pst = $mydb->prepare($querys['usuarios']['2_insertar']);
    $pst->bind_param("ssssss", $UsrUsr, $UsrNom, $UsrPwd, $UsrMail, $UsrTel, $UsrEst);
    $pst->execute();
    
    // Logica del negocio
    header("Content-Type: application/json");
    if($mydb->error){
        echo json_encode(array(
            "status"=>"ER",
            "payload"=>array(
                "error"=> $mydb->error,
                "message"=>"Ocurrio un error registrando el usuario."
            )
        ));
    }else{
        $body = "
            Su cuenta fue creada correctamente. Debe confirmarla haciend click en este enlace.
        ";
        
        send_email("remd@unicah.edu", "Registro de Cuenta", $UsrMail, "Confirmación de Cuenta", $body);
        echo json_encode(array(
            "status"=>"OK",
            "payload"=>array(
                "message"=>"Usuario registrado."
            )
        ));
    }
?>