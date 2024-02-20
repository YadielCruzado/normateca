<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/models/backend/adminModel.php');
function setData()
{
    $model = new AdminModel("localhost", "normateca", "root", "");
    $model->start_connection();
    $categorias = [];
    $cuerpos = [];

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

    $_SESSION['corps'] = $cuerpos;
    $_SESSION['cats'] = $categorias;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['type'])) {
        if ($_POST['type'] == "upload" and isset($_POST['filename'])) {
            $target_dir = '../files/';
            $target_file = $target_dir . basename($_FILES['pdf']['name']);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if ($file_type == "pdf") {
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
                    "file_path" => $target_file
                );

                $model = new AdminModel("localhost", "normateca", "root", "");
                $model->start_connection();
                $model->InsertFile($values);
                move_uploaded_file($file_name, "$target_dir/$file_name");
                echo "<script> location.href='../../views/admin.php?error=yes'; </script>";
                exit; 
            }
        }
        // echo "<script> location.href='../../views/admin.php'; </script>";
        // exit; 
    } else {
        // Maneja la lógica cuando el método es POST pero 'type' no está presente (si es necesario)
        // Puedes agregar aquí el código necesario para manejar esta situación antes de la redirección
    }
}
?>