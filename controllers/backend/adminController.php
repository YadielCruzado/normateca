<?php
session_start();
include_once("../models/backend/adminModel.php");
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
            $target_dir = '../../files/';
            $target_file = $target_dir . basename($_FILES['file']['name']);
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (file_exists($target_file)) {
                header("Location: ../../views/admin.php?error=exists");
            }

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

                $result = $model->checkFile($values['file_name']);

                if ($result->num_rows == 0) {
                    $model->InsertFile($values);
                    $model->connection->close();

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                        setData();
                        header("Location: ../../views/admin.php?succes");
                    } else {
                        header("Location: ../../views/admin.php?error=path");
                    }
                } else {
                    header("Location: ../../views/admin.php?error=file-exist");
                }
            }
        }
    }
}