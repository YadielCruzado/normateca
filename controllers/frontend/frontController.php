<?php
 session_start();
// inicializar las variables
if (!isset($_SESSION['certificationNumber'])) {
    $_SESSION['certificationNumber'] = '';
}
if (!isset($_SESSION['fiscalYear'])) {
    $_SESSION['fiscalYear'] = '';
}
if (!isset($_SESSION['keyword'])) {
    $_SESSION['keyword'] = '';
}
if (!isset($_SESSION['documentTitle'])) {
    $_SESSION['documentTitle'] = '';
}
if (!isset($_SESSION['categorias'])) {
    $_SESSION['categoria'] = '';
}
if (!isset($_SESSION['cuerpo'])) {
    $_SESSION['cuerpo'] = '';
}
if (!isset($_SESSION['dateCreated'])) {
    $_SESSION['dateCreated'] = '';
}
if (!isset($_SESSION['desde'])) {
    $_SESSION['desde'] = '';
}
if (!isset($_SESSION['hasta'])) {
    $_SESSION['hasta'] = '';
}
if (!isset($_SESSION['paginaActual'])) {
    $_SESSION['paginaActual'] = '1';
}
if (!isset($_SESSION['registros'])) {
    $_SESSION['registros'] = '10';
}

include_once("../models/front/frontModel.php");

function doc()
{
    $model = new frontModel("localhost", "normateca", "root", "");
    $model->start_connection();

    $cuerpos = [];
    $documentos = [];
    $recientes = [];
    $paginas =[];
    $categorias = [];

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['limpiar'])) {
        $_SESSION['certificationNumber'] = '';
        $_SESSION['fiscalYear'] = '';
        $_SESSION['keyword'] = '';
        $_SESSION['documentTitle'] = '';
        $_SESSION['categoria'] = '';
        $_SESSION['cuerpo'] = '';
        $_SESSION['dateCreated'] = '';
        $_SESSION['desde'] = '';
        $_SESSION['hasta'] = '';
        $_SESSION['paginaActual'] = '1';
        $_SESSION['registros'] = '10';
    }

    if (isset($_POST['certification_number']) && $_POST['certification_number'] !== '') {
    $_SESSION['certificationNumber'] = $_POST['certification_number'];
    }
    if (isset($_POST['Fiscal_year']) && $_POST['Fiscal_year'] !== '') {
        $_SESSION['fiscalYear'] = $_POST['Fiscal_year'];
    }
    if (isset($_POST['Keywordnames']) && $_POST['Keywordnames'] !== '') {
        $_SESSION['keyword'] = $_POST['Keywordnames'];
    }
    if (isset($_POST['Document_title']) && $_POST['Document_title'] !== '') {
        $_SESSION['documentTitle'] = $_POST['Document_title'];
    }
    if (isset($_POST['categoria']) && $_POST['categoria'] !== '') {
        $_SESSION['categoria'] = $_POST['categoria'];
    }
    if (isset($_POST['cuerpo']) && $_POST['cuerpo'] !== '') {
        $_SESSION['cuerpo'] = $_POST['cuerpo'];
    }
    if (isset($_POST['Date_created']) && $_POST['Date_created'] !== '') {
        $_SESSION['dateCreated'] = $_POST['Date_created'];
    }
    if (isset($_POST['desde']) && $_POST['desde'] !== '') {
        $_SESSION['desde'] = $_POST['desde'];
    }
    if (isset($_POST['hasta']) && $_POST['hasta'] !== '') {
        $_SESSION['hasta'] = $_POST['hasta'];
    }
    if (isset($_GET['pagina'])) {
        $_SESSION['paginaActual'] = (int)$_GET['pagina'];
    }
    if (isset($_POST['selectedRecords'])) {
        $_SESSION['registros'] = (int)$_POST['selectedRecords'];
    }
        
        // Opcional: puedes también definir variables adicionales para simplificar el código
        $certificationNumber = isset($_SESSION['certificationNumber']) ? $_SESSION['certificationNumber'] : '';
        $fiscalYear = isset($_SESSION['fiscalYear']) ? $_SESSION['fiscalYear'] : '';
        $keyword = isset($_SESSION['keyword']) ? $_SESSION['keyword'] : '';
        $documentTitle = isset($_SESSION['documentTitle']) ? $_SESSION['documentTitle'] : '';
        $date_created = isset($_SESSION['date_created']) ? $_SESSION['date_created'] : '';
        $desde = isset($_SESSION['desde']) ? $_SESSION['desde'] : '';
        $hasta = isset($_SESSION['hasta']) ? $_SESSION['hasta'] : '';
        $cuerpo = isset($_SESSION['cuerpo']) ? $_SESSION['cuerpo'] : [];
        $categoria = isset($_SESSION['categoria']) ? $_SESSION['categoria'] : [];



        $paginaActual = $_SESSION['paginaActual'];
        $registros = $_SESSION['registros'];
        var_dump($paginaActual);
        var_dump($registros);
        $inicio = ($paginaActual - 1) * $registros;

        $result = $model->filtrarDocs($certificationNumber, $fiscalYear, $keyword, $documentTitle,$cuerpo,$categoria,$date_created,$desde,$hasta,$paginaActual,$registros,$inicio);
    
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $values = array(
                        "id" => $row['Document_id'],
                        "title" => $row['Document_title'],
                        "cuerpo" => $row['Cuerpo_abbr'],
                        "categoria" => $row['Category_abbr'],
                        "certi" => $row['Certification_number'],
                        "fiscal" => $row['Fiscal_year'],
                        "target_derroga" => $row['derroga'],
                        "target_enmienda" => $row['enmienda'],
                        "path" => $row['Doc_Path'],
                        
                        "certi_derr" => $row['certificacion_number'],
                        "fiscal_derr" => $row['fiscal_year'],
                        "doc_path" => $row['doc_path'],

                        "certi_enm" => $row['enm_cert'],
                        "fiscal_enm" => $row['enm_fisc'],
                        "doc_path_enm" => $row['enm_doc_path'],
                        
                        "derrogadopor_cert" => $row['derrogadopor_cert'],
                        "derrogadopor_path" => $row['derrogadopor_path'],
                        "derrogadopor_fiscal" => $row['derrogadopor_fiscal'],

                        "enmiendapor_cert" => $row['enmiendapor_cert'],
                        "enmiendapor_path" => $row['enmiendapor_path'],
                        "enmiendapor_fiscal" => $row['enmiendapor_fiscal']
                    );

                    array_push($documentos, $values);
                }
            } else {
                $documentos = null;
            }
        } else {
            
            echo "Error executing query: ";
        }

    $result = $model->recientes();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "title" => $row['Document_title'],
                "cuerpo" => $row['Cuerpo_abbr'],
                "number" => $row['Certification_number'],
                "fiscal" => $row['Fiscal_year'],
                "path" => $row['Document_path']
            );
            array_push($recientes, $values);
        }
    } else {
        $recientes = null;
    }

    $result = $model->numPages($certificationNumber, $fiscalYear, $keyword, $documentTitle, $date_created, $desde, $hasta, $cuerpo, $categoria);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalPaginas = ceil($row['total'] / $registros);
        $values = array(
            "pag" => $totalPaginas,
            "registros" => $registros,
            "total" => $row['total']
        );
        array_push($paginas, $values);
    }
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

  

    $_SESSION['cats'] = $categorias;
    $_SESSION['corps'] = $cuerpos;
    $_SESSION['registros'] = $registros;
    $_SESSION['paginas'] = $paginas;
    $_SESSION['documentos'] = $documentos;
    $_SESSION['recientes'] = $recientes;
}

