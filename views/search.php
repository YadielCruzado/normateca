<?php

include_once("../controllers/frontend/frontController.php");

// Verificar y asignar valores de $_POST a variables
$certificationNumber = isset($_POST['certification_number']) ? $_POST['certification_number'] : '';
$fiscalYear = isset($_POST['Fiscal_year']) ? $_POST['Fiscal_year'] : '';
$keyword = isset($_POST['Keywordnames']) ? $_POST['Keywordnames'] : '';
$documentTitle = isset($_POST['Document_title']) ? $_POST['Document_title'] : '';
$dateCreated = isset($_POST['Date_created']) ? $_POST['Date_created'] : '';
$desde = isset($_POST['desde']) ? $_POST['desde'] : '';
$hasta = isset($_POST['hasta']) ? $_POST['hasta'] : '';

// Asignar valores a $_SESSION
$_SESSION['certificationNumber'] = $certificationNumber;
$_SESSION['fiscalYear'] = $fiscalYear;
$_SESSION['keyword'] = $keyword;
$_SESSION['documentTitle'] = $documentTitle;
$_SESSION['dateCreated'] = $dateCreated;
$_SESSION['desde'] = $desde;
$_SESSION['hasta'] = $hasta;

// Procesar cambio de número de registros por página
if (isset($_POST['selectedRecords'])) {
  $_SESSION['registros'] = $_POST['selectedRecords'];
}

// Procesar búsqueda
doc();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Normateca - Certificaciones</title>
    <link rel="stylesheet" href="../assets/css/main.css" />
  </head>

  <body>
    <header>
      <img src="../assets/images/arecibo.png" />
      <div>
        <h1>Normateca</h1>
        <h3><i> Universidad de Puerto Rico en Arecibo </i></h3>
      </div>
    </header>
    <div class="titulo">
      <h2>Búsqueda de Certificaciones</h2>
    </div>

    <main>
      <section>
        <div class="firstBox">
          <div>
            <h2>Parámetros de Búsqueda</h2>
            <form class="search" action="search.php" method="POST">

              <label for="certification_number">Número de Certificación</label>
              <!-- <input type="search" id="certification_number" name="certification_number" placeholder="Buscar documento..." /> -->
              <input type="search" id="certification_number" name="certification_number" placeholder="Buscar documento..." value="<?php echo isset($_SESSION['certificationNumber']) ? $_SESSION['certificationNumber'] : ''; ?>" />
          
              <label for="Fiscal_year">Año Fiscal</label>
              <!-- <input type="search" id="Fiscal_year" name="Fiscal_year" placeholder="Buscar documento..." /> -->
              <input type="search" id="Fiscal_year" name="Fiscal_year" placeholder="Buscar documento..." value="<?php echo isset($_SESSION['fiscalYear']) ? $_SESSION['fiscalYear'] : ''; ?>" />




              <label for="Keywordnames">Palabra Clave</label>
              <!-- <input type="search" id="Keywordnames" name="Keywordnames" placeholder="Buscar documento..." /> -->
              <input type="search" id="Keywordnames" name="Keywordnames" placeholder="Buscar documento..." value="<?php echo isset($_SESSION['keyword']) ? $_SESSION['keyword'] : ''; ?>" />

              <label for="Document_title">Título</label>
              <!-- <input type="search" id="Document_title" name="Document_title" placeholder="Buscar documento..." /> -->
              <input type="search" id="Document_title" name="Document_title" placeholder="Buscar documento..." value="<?php echo isset($_SESSION['documentTitle']) ? $_SESSION['documentTitle'] : ''; ?>" />

              <label>Cuerpo</label>
              <div class="filters">
              <?php
foreach ($_SESSION['corps'] as $corp) {
  $checked = (isset($_SESSION['cuerpo']) && is_array($_SESSION['cuerpo']) && in_array($corp['corp_abbr'], $_SESSION['cuerpo'])) ? 'checked' : '';
  echo '<input type="checkbox" id="' . $corp['corp_abbr'] . '" name="cuerpo[]" value="' . $corp['corp_abbr'] . '" ' . $checked . ' />';
    echo '<label for="' . $corp['corp_abbr'] . '"> ' . $corp['corp_abbr'] . ' - ' . $corp['corp_name'] . ' </label><br />';
}
?>
              </div>

              

              <label>Categoría</label>
              <div class="filters">
              <?php
foreach ($_SESSION['cats'] as $cat) {
    $checked = (isset($_SESSION['cats']) && in_array($cat['cat_abbr'], $_SESSION['cats'])) ? 'checked' : '';
    echo '<input type="checkbox" id="' . $cat['cat_abbr'] . '" name="categoria[]" value="' . $cat['cat_abbr'] . '" ' . $checked . ' />';
    echo '<label for="' . $cat['cat_abbr'] . '"> ' . $cat['cat_abbr'] . ' - ' . $cat['cat_name'] . '</label><br />';
}
?>
              </div>

              <label for="Date_created">Fecha</label>
              <input type="date" id="Date_created" name="Date_created" placeholder="Buscar documento..." />

              <label>Rango de Fecha</label>
              <div class="dates">
                <label for="desde">Desde</label>
                <input type="date" id="desde" name="desde" placeholder="Buscar documento..." />
                <br /><label for="hasta">Hasta</label>
                <input type="date" id="hasta" name="hasta" placeholder="Buscar documento..." />
              </div>
              <button type="submit" onclick="Formulariolimpiar()">Limpiar</button>
              <button type="submit">Buscar</button>
            </form>

            <form id="searchForm" method="POST" action="search.php">
              <input type="hidden" name="certificationNumber" value="<?php echo $_SESSION['certificationNumber']; ?>">
              <input type="hidden" name="fiscalYear" value="<?php echo $_SESSION['fiscalYear']; ?>">
              <input type="hidden" name="keyword" value="<?php echo $_SESSION['keyword']; ?>">
              <input type="hidden" name="documentTitle" value="<?php echo $_SESSION['documentTitle']; ?>">
              <input type="hidden" name="cats" value="<?php echo $_SESSION['cats']; ?>">
              <input type="hidden" name="cuerpo" value="<?php echo $_SESSION['cuerpo']; ?>">
              <input type="hidden" name="dateCreated" value="<?php echo $_SESSION['dateCreated']; ?>">
              <input type="hidden" name="desde" value="<?php echo $_SESSION['desde']; ?>">
              <input type="hidden" name="hasta" value="<?php echo $_SESSION['hasta']; ?>">
              <input type="hidden" name="paginaActual" value="<?php echo $_SESSION['paginaActual']; ?>">
              <input type="hidden" name="registros" value="<?php echo $_SESSION['registros']; ?>">
            </form>
          </div>
        </div>
             <div class="lastBox">
               <div>
                 <h2>Certificaciones Recientes</h2>
                 <hr />
                 <div class="recents">
                   <div class="JA">
                    <?php
                      foreach ($_SESSION['recientes'] as $rec) {
                        echo '<tr>';
                        echo '<li><a href="'.$rec['path'].'" target="_blank">'.$rec['cuerpo'].' - '.$rec['number'].' - '.$rec['fiscal'].'</a> - '.$rec['title'].'</li>';
                        echo '</tr>';
                        
                      }
                    ?>
                   </div>
                 </div>
               </div>
     
               <div class="results">
                 <label for="records">Registros:</label>
                 <form id="myForm" method="post" action="search.php">
                    <select id="records" name="selectedRecords" onchange="updateRecords()">
                      <option value="10" <?php if ($_SESSION['registros'] == 10) echo 'selected'; ?>>10</option>
                      <option value="25" <?php if ($_SESSION['registros'] == 25) echo 'selected'; ?>>25</option>
                      <option value="50" <?php if ($_SESSION['registros'] == 50) echo 'selected'; ?>>50</option>
                        
                    </select>
                    <input type="hidden" id="selectedRecords" name="selectedRecords" value="10">
                  </form>

                  <script>
                    function updateRecords() {
                        // Obtén el valor seleccionado
                        var selectedValue = document.getElementById("records").value;

                        // Actualiza el valor del campo oculto
                        document.getElementById("selectedRecords").value = selectedValue;

                        // Envía el formulario automáticamente
                        document.getElementById("myForm").submit();
                    }
                    </script>
<script>
function Formulariolimpiar() {
    // Obtener todos los elementos de tipo checkbox dentro del formulario
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    
    // Desmarcar todos los checkboxes
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
    
    // Limpiar otros tipos de campos de formulario si es necesario
    document.getElementById("certification_number").value = "";
    document.getElementById("Fiscal_year").value = "";
    document.getElementById("Keywordnames").value = "";
    document.getElementById("Document_title").value = "";
    document.getElementById("Date_created").value = "";
    document.getElementById("desde").value = "";
    document.getElementById("hasta").value = "";

    // Limpiar las variables de sesión relacionadas con los filtros
    <?php
    unset($_SESSION['certificationNumber']);
    unset($_SESSION['fiscalYear']);
    unset($_SESSION['keyword']);
    unset($_SESSION['documentTitle']);
    unset($_SESSION['cuerpo']);
    unset($_SESSION['categoria']);
    unset($_SESSION['dateCreated']);
    unset($_SESSION['desde']);
    unset($_SESSION['hasta']);
    ?>
    
    // Redirigir a la misma página después de limpiar el formulario
    window.location.href = 'search.php';
}
</script>



                  <table>
                    <thead>
                      <tr>
                        <th>Cuerpo</th>
                        <th>Número</th>
                        <th>Año Fiscal</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Relaciones</th>
                        <th>Descargar</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (empty($_SESSION['documentos'])) {
                      echo '<tr><td colspan="7">No hay documentos disponibles</td></tr>';
                  }else{

                      foreach ($_SESSION['documentos'] as $doc) {
                      echo '<tr>';
                      echo '<td>'.$doc['cuerpo'].'</td>'; 
                      echo '<td>'.$doc['certi'].'</td>';
                      echo '<td>'.$doc['fiscal'].'</td>';
                      echo '<td>'.$doc['title'].'</td>';
                      echo '<td>'.$doc['categoria'].'</td>';

                      // echo '<td>'.$doc['certificacion_fiscal'].'</td>';
                    //   if ($doc['certi_derr'] == '') {
                    //     echo '<td></td>'; // Print "(no derr)" in the table cell when certi_derr is empty
                    // } else {
                    //   echo '<td><p>Derrogados</p>' . ' <a href="' . $doc['doc_path'] . '">' . $doc['certi_derr'] . ' - ' . $doc['fiscal_derr'] . '</a></td>';
                    // }
                    // && $doc['enmiendapor_cert'] != ''
                    if ($doc['certi_derr'] == '' && $doc['certi_enm'] == '' && $doc['derrogadopor_cert'] == '' && $doc['enmiendapor_cert'] == '') {
                      echo '<td></td>';
                  } elseif ($doc['certi_derr'] != '' && $doc['certi_enm'] != '' && $doc['derrogadopor_cert'] != '' && $doc['enmiendapor_cert'] != '' ) {
                      echo '<td>';
                      echo '<p>Derroga a</p> <a href="' . $doc['doc_path'] . '"target="_blank">' . $doc['certi_derr'] . ' - ' . $doc['fiscal_derr'] . '</a><br>';
                      echo '<p>Enmienda a</p> <a href="' . $doc['doc_path_enm'] . '"target="_blank">' . $doc['certi_enm'] . ' - ' . $doc['fiscal_enm'] . '</a>';
                      echo '<p>Derrogado por</p> <a href="' . $doc['derrogadopor_path'] . '"target="_blank">' . $doc['derrogadopor_cert'] . ' - ' . $doc['derrogadopor_fiscal'] . '</a>';
                      echo '<p>Enmendado por</p> <a href="' . $doc['enmiendapor_path'] . '"target="_blank">' . $doc['enmiendapor_cert'] . ' - ' . $doc['enmiendapor_fiscal'] . '</a>';
                      echo '</td>';
                  } elseif ($doc['certi_derr'] != '') {
                      echo '<td>';
                      echo '<p>Derroga a</p> <a href="' . $doc['doc_path'] . '"target="_blank">' . $doc['certi_derr'] . ' - ' . $doc['fiscal_derr'] . '</a>';
                      echo '</td>';
                  } elseif ($doc['certi_enm'] != '') {
                      echo '<td>';
                      echo '<p>Enmienda a</p> <a href="' . $doc['doc_path_enm'] . '"target="_blank">' . $doc['certi_enm'] . ' - ' . $doc['fiscal_enm'] . '</a>';
                      echo '</td>';
                  } elseif ($doc['derrogadopor_cert'] != '') {
                    echo '<td>';
                    echo '<p>Derrogado por</p> <a href="' . $doc['derrogadopor_path'] . '"target="_blank">' . $doc['derrogadopor_cert'] . ' - ' . $doc['derrogadopor_fiscal'] . '</a>';  
                    echo '</td>';
                 } elseif ($doc['enmiendapor_cert'] != '') {
                  echo '<td>';
                  echo '<p>Enmendado por</p> <a href="' . $doc['enmiendapor_path'] . '"target="_blank">' . $doc['enmiendapor_cert'] . ' - ' . $doc['enmiendapor_fiscal'] . '</a>';
                  echo '</td>';
              } 
                  echo '<td> <a href="' . $doc['path'] . '"target="_blank">PDF</a></td>';
                  echo '</tr>';
                  
                    }

                      }
                   
                    ?>
                    </tbody>
                  </table>

                  <?php
if (isset($_SESSION['paginas'])) {
    $paginas = $_SESSION['paginas'];
    foreach ($paginas as $pagina) {
        $totalPaginas = $pagina['pag'];
        $registros = $pagina['registros'];
        $total = $pagina['total'];
        $current_page = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $first = ($current_page - 1) * $registros + 1;
        $last = min($current_page * $registros, $total);

        // Calculate the range of pages to display
        $range = 3; // Number of pages before and after the current page to display
        $start = max(1, $current_page - $range);
        $end = min($totalPaginas, $current_page + $range);

        ?>
        <div class="table-aditional">
    <p>Mostrando <?php echo $first; ?> a <?php echo $last; ?> de <?php echo $total; ?> récords</p>
    <div class="pagination">

    <?php if ($totalPaginas > 1): ?>
        <?php if ($current_page > 1): ?>
            <a href="?pagina=1">&laquo;</a>
        <?php endif; ?>

        <?php if ($start > 1): ?>
            <span>...</span>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php $class = ($i == $current_page) ? 'active' : ''; ?>
            <a href='?pagina=<?php echo $i; ?>' class='<?php echo $class; ?>'><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($end < $totalPaginas): ?>
            <span>...</span>
        <?php endif; ?>

        <?php if ($current_page < $totalPaginas): ?>
            <a href='?pagina=<?php echo $totalPaginas; ?>'>&raquo;</a>
        <?php endif; ?>
    <?php endif; ?>

    </div>
</div>
        <?php
    }
}
?>

          </div>
        </div>
      </section>
    </main>
  </body>
