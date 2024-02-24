<?php
session_start();
include_once("../models/backend/adminModel.php");
function setData()
{
    $model = new AdminModel("localhost", "normateca", "root", "");
    $model->start_connection();
    $categorias = [];
    $cuerpos = [];
    $documentos = [];

    $result = $model->getdocinfo();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "Document_title" => $row['Document_title'],
                "Date_created" => $row['Date_created'],
                "Document_id" => $row['Document_id']
            );

            array_push($documentos, $values);
        }
    } else {
        $documentos = null;
    }


    $result = $model->getCategorias();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "cat_abbr" => $row['Category_abbr'],
                "cat_name" => $row['Category_name'],
                "cat_corp" => $row['Category_abbr']
            );

            array_push($categorias, $values);
        }
    } else {
        $categorias = null;
    }

    $result = $model->getCuerpos();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "corp_abbr" => $row['Cuerpo_abbr'],
                "corp_name" => $row['Cuerpo_name']
            );

            array_push($cuerpos, $values);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["documentoId"]) && isset($_POST["nombreDocumento"]) && isset($_POST["fechaDocumento"])) {
            $documentoId = $_POST["documentoId"];
            $nombreDocumento = $_POST["nombreDocumento"];
            $fechaDocumento = $_POST["fechaDocumento"];
            $success = $model->updateDocument($documentoId, $nombreDocumento, $fechaDocumento);

            if ($success) {
                // Update session variable with the modified document details
                // Optionally, you may also fetch fresh data from the database and update the session variable
                // $_SESSION['documentos'][$documentoId]['Document_title'] = $nombreDocumento;
                // $_SESSION['documentos'][$documentoId]['Date_created'] = $fechaDocumento;
                header("Location: admin.php");
        }else{
            echo "errorrr";
        }

        }
    }

    $_SESSION['corps'] = $cuerpos;
    $_SESSION['cats'] = $categorias;
    $_SESSION['documentos'] = $documentos;
}
   


