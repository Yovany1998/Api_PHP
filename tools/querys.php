<?php
    $querys = array(
        "usuarios"=> array(
            "1_obtener" => "SELECT * FROM usuarios WHERE UsrUsr =?;",
            "2_insertar" => "INSERT INTO usuarios VALUES(?,?,?,?,?,?);",
            "3_actualizar" => "UPDATE usuarios SET UsrNom =?, UsrTel=?  WHERE UsrUsr =?;"
        ),
        "coleccion" => array(
            "1_insertar" => "INSERT INTO coleccion VALUES (?,?,?,?,?);",
            "2_actualizar" => "UPDATE coleccion SET ColNom = ?, ColDsc = ? WHERE ColCod = ? AND UsrUsr = ?;",
            "3_eliminar" => "DELETE FROM coleccion wHERE ColCod = ? AND UsrUsr = ?;",
            "4_listado" => "SELECT * FROM coleccion wHERE UsrUsr = ?;",
            "5_obtener" => "SELECT * FROM coleccion WHERE UsrUsr = ? AND ColCod = ?;",
            "6_obtener_fotos" => "SELECT * FROM fotos WHERE UsrUsr = ? AND ColCod = ?;"
        ),
        "fotos" => array(
            "1_insertar" => "INSERT INTO fotos  VALUES(?, ?, ?, ?, ?);",
            "2_obtener" => "SELECT * FROM fotos WHERE UsrUsr = ? AND ColCod = ? AND FotCod =?;",
            "3_eliminar" => "DELETE FROM fotos wHERE UsrUsr = ? AND ColCod = ? AND FotCod = ?;"
        )
    )
?>