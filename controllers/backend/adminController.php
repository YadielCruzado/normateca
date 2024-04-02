<?php
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/models/backend/adminModel.php');

function setData()
{
    $model = new AdminModel("localhost", "normateca", "root", "");
    $model->start_connection();
    $categorias = [];
    $cuerpos = [];
    $enlazarDocumentos = [];
    $documentos = [];
    $documentosn = [];

    $result = $model->getCategorias();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "cat_abbr" => $row['Category_abbr'],
                "cat_name" => $row['Category_name'],
                "cat_corp" => $row['Cuerpo_name'],
                "cat_corp_abbr" => $row['Cuerpo_abbr']
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
    } else {
        $cuerpos = null;
    }

    //enlazar documentos
    $result = $model->enlazarDocumentos();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "number" => $row['Certification_number'],
                "fiscal" => $row['Fiscal_year'],
                "title" => $row['Document_title'],
                "category" => $row['Category_name']
            );
            array_push($enlazarDocumentos, $values);
        }
    } else {
        $enlazarDocumentos = null;
    }

    $result = $model->getdocinfo();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "Document_title" => $row['Document_title'],
                "Date_created" => $row['Date_created'],
                "Document_id" => $row['Document_id'],
                "fiscal" => $row['Fiscal_year'],
                "cuerpo" => $row['Cuerpo_abbr'],
                "certi" => $row['Certification_number'],
                "path" => $row['Document_path'],
                "estado" => $row['Document_state'],
                "lenguaje" => $row['Document_lenguaje']
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
    $_SESSION['documentosn'] = $documentosn;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {//subir documentos
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
                    "file_number" => $_POST['number'],
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
    } else if ($_POST['type'] == "2") { //editar documentos
        if (isset($_POST["documentoId"]) OR isset($_POST["nombreDocumento"]) OR isset($_POST["fechaDocumento"]) OR isset($_POST["fiscalYear"]) OR isset($_POST["cuerpo"]) OR isset($_POST["certi"]) OR isset($_POST["path"]) OR isset($_POST["estado"]) OR isset($_POST["lenguaje"])) {

            $documentoId = $_POST["documentoId"];
            $nombreDocumento = $_POST["nombreDocumento"];
            $fechaDocumento = $_POST["fechaDocumento"];
            $fiscalYear = $_POST["fiscalYear"];
            $cuerpo = $_POST["cuerpo"];
            $certi = $_POST["certi"];
            $path = $_POST["path"];
            $estado = $_POST["estado"];
            $lenguaje = $_POST["lenguaje"];
            echo $nombreDocumento;
            echo $fechaDocumento;
            echo $documentoId;
            echo $fiscalYear;
            echo $cuerpo;
            echo $certi;
            echo $path;
            echo $estado;
            echo $lenguaje;
            echo "hola";
            $model = new AdminModel("localhost", "normateca", "root", "");
            $model->start_connection();
            $success = $model->updateDocument($documentoId, $nombreDocumento, $fechaDocumento, $fiscalYear, $cuerpo, $certi, $path, $estado, $lenguaje);
            $model->connection->close();

            if ($success) {
                echo "se uoopdate la dataaa";
                header("Location:admin.php");

            } else {
                echo "errorrr";
            }
        }
    } else if ($_POST['type'] == "3") { //crear categorias
        $categoria = $_POST["categoria"];
        $Abreviacion = $_POST["Abreviacion"];
        $cuerpo = $_POST["cuerpo"];

        $model = new AdminModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $success = $model->NewCategory($categoria, $Abreviacion, $cuerpo);
        $model->connection->close();

        if ($success) {
            echo "se uoopdate la dataaa";
            header("Location: ../../views/admin.php?succes");

        } else {
            echo "errorrr";
        }

    } else if ($_POST['type'] == "4") { //crear cuerpos

        $cuerpo = $_POST["cuerpo"];
        $Abreviacion = $_POST["Abreviacion"];

        $model = new AdminModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $success = $model->NewCuerpo($cuerpo, $Abreviacion);
        $model->connection->close();

        if ($success) {
            echo "se uoopdate la dataaa";
            header("Location: ../../views/admin.php?succes");

        } else {
            echo "errorrr";
        }
    } else if ($_POST['type'] == "5") { //editar cuerpos

        $cuerpo = $_POST["cuerpo"];
        $Abreviacion = $_POST["Abreviacion"];
        $oldabbr = $_POST["oldabbr"];

        $model = new AdminModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $model->updateACuerpo($Abreviacion, $oldabbr);
        $model->connection->close();


        $model = new AdminModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $success = $model->updateCuerpo($cuerpo, $Abreviacion, $oldabbr);
        $model->connection->close();

        if ($success) {
            header("Location: ../../views/admin.php?succes");
        } else {
            echo "errorrr";
        }

    } else if ($_POST['type'] == "6") { //editar categorias
        $categoria = $_POST["categoria"];
        $Abreviacion = $_POST["Abreviacion"];
        $cuerpo = $_POST["cuerpoDropdown"];
        $oldabbr = $_POST["oldabbr"];

        $model = new AdminModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $success = $model->updateCategory($categoria, $Abreviacion, $cuerpo, $oldabbr);
        $model->connection->close();

        if ($success) {
            header("Location: ../../views/admin.php?succes");
            echo "$oldabbr";

        } else {
            echo "errorrr";
        }
    }else if ($_POST['type'] == "7") { //buscar documentos por filtrado de nombre
        if (isset($_POST["searchQuery"])) {
            $searchQuery = $_POST["searchQuery"];
            $model = new AdminModel("localhost", "normateca", "root", ""); 
            $model->start_connection(); 
    
            //query para buscar por nombre
            $result = $model->search_queryn($searchQuery);
    
            //si el query tiene algo, entonces se ejecuta o no
            if ($result !== false) {
                if ($result->num_rows > 0) {//si es > 0, entonces hay resultados
                    while ($row = $result->fetch_assoc()) {
                        $values = array(
                            "Document_title" => $row['Document_title'],
                            "Date_created" => $row['Date_created'],
                            "Document_id" => $row['Document_id'],
                            "fiscal" => $row['Fiscal_year'],
                            "cuerpo" => $row['Cuerpo_abbr'],
                            "certi" => $row['Certification_number'],
                            "path" => $row['Document_path'],
                            "estado" => $row['Document_state'],
                            "lenguaje" => $row['Document_lenguaje']
                        );
                        array_push($documentosn, $values);
                    }
                } else {
                    $documentosn = null;
                }
            } 
            $model->connection->close();
        }
    }
    
}

?>
