<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/models/backend/adminModel.php');
function setData()
{
    $model = new AdminModel("localhost", "normateca", "root", "");
    $model->start_connection();
    $categorias = [];
    $cuerpos = [];
    $docuentos = [];

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

    $result = $model->getDocuments();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "number" => $row['Certification_number'],
                "fiscal" => $row['Fiscal_year'],
                "category" => $row['Category_name']
            );
            array_push($docuentos,$values);
        }
    }

    $_SESSION['corps'] = $cuerpos;
    $_SESSION['cats'] = $categorias;
    $_SESSION['docs'] = $docuentos;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['type'])) {
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

    } else {
        // Maneja la lógica cuando el método es POST pero 'type' no está presente (si es necesario)
        // Puedes agregar aquí el código necesario para manejar esta situación antes de la redirección
    }
}
?>