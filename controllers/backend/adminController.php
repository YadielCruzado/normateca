<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/models/backend/adminModel.php');
function setData()
{
    $model = new AdminModel("localhost", "normateca", "root", "");
    $model->start_connection();
    $categorias = [];
    $cuerpos = [];
    $enlazarDocumentos = [];
    $documentos = [];

    $result = $model->getCategorias();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "cat_abbr" => $row['Category_abbr'],
                "cat_name" => $row['Category_name'],
                "cat_corp" => $row['Cuerpo_name']
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
    }else {
        $cuerpos = null;
    }

    $result = $model->enlazarDocumentos();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "number" => $row['Certification_number'],
                "fiscal" => $row['Fiscal_year'],
                "title" => $row['Document_title'],
                "category" => $row['Category_name']
            );
            array_push($enlazarDocumentos,$values);
        }
    }else {
        $enlazarDocumentos = null;
    }
    
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

    $_SESSION['corps'] = $cuerpos;
    $_SESSION['cats'] = $categorias;
    $_SESSION['Enlazar'] = $enlazarDocumentos;
    $_SESSION['documentos'] = $documentos;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['type'] == "1") {
        if ($_POST['type'] == "upload" and isset($_POST['filename'])) {
            $target_file = '../../files/' . basename($_FILES['pdf']['name']);
            $upload_file = '../files/' . basename($_FILES['pdf']['name']);

            $file_type = mime_content_type($_FILES['pdf']['tmp_name']);

            if ($file_type == "application/pdf") {
                $values = array(
                    "file_name" => $_POST['filename'],
                    "file_date" => $_POST['filedate'],
                    "file_desc" => $_POST['desc'],
                    "file_number" =>  $_POST['number'],
                    "file_state" => $_POST['state'],
                    "file_cat" => $_POST['cat'],
                    "file_lang" => $_POST['lang'],
                    "file_year" => $_POST['fiscalYear'],
                    "file_corp" => $_POST['corp'],
                    "file_signature" => $_POST['signature'],
                    "file_path" => $upload_file
                );

                $model = new AdminModel("localhost", "normateca", "root", "");
                $model->start_connection();
                $model->InsertFile($values);
                $model->connection->close();

                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $target_file)) {
                    setData();
                    header("Location: ../../views/admin.php?succes");
                } else {
                    header("Location: ../../views/admin.php?error=path");
                }

                // echo "<script> location.href='../../views/admin.php?error=yes'; </script>";
                // exit; 
            }
        }

    } else if ($_POST['type'] == "2") {
        if (isset($_POST["documentoId"]) OR isset($_POST["nombreDocumento"]) OR isset($_POST["fechaDocumento"])) {
            echo"controller ";
    
            $documentoId = $_POST["documentoId"];
            $nombreDocumento = $_POST["nombreDocumento"];
            $fechaDocumento = $_POST["fechaDocumento"];
            echo $nombreDocumento;
            echo $fechaDocumento;
            echo $documentoId;
            $model = new AdminModel("localhost", "normateca", "root", "");
            $model->start_connection();
            $success = $model->updateDocument($documentoId, $nombreDocumento, $fechaDocumento);
            $model->connection->close();
    
            if ($success) {
                echo "se uoopdate la dataaa";
                header("Location:admin.php");
    
            }else{
                echo "errorrr";
            }
        }
    }
}
?>
