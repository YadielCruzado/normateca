<?php

session_start();
if(!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

print_r($_SESSION['login']);

include_once("../controllers/backend/adminController.php");
setData();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Normateca</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/admin.css" />

</head>

<body>
  <header>
    <img src="../assets/images/uprlogo.png" />
    <div>
      <h1>Administrador Normateca</h1>
      <h3><i> Universidad de Puerto Rico en Arecibo </i></h3>
    </div>
    <div>
      <?php
        if (count($_SESSION['login']) > 0) {
          foreach ($_SESSION['login'] as $log) {
              echo $log['Nombre'] . ' ' . $log['Apellido'];
          }
        }
      ?>
      <a href="../controllers/backend/logoutController.php">Cerrar Sesion</a>
    </div>
   
  </header>

  <main>
    <section>
      <div class="buttons">
        <button type="button" name="tab" id="subirBtn" class="active">Subir Documento</button>
        <button type="button" name="tab" id="editarBtn">Editar Documento</button>
        <button type="button" name="tab" id="crearBtn">Crear Categorias</button>
      </div>

      <div class="tabs">
        <div id="subir" class="subir">
          <form method="POST" action="../controllers/backend/adminController.php" enctype="multipart/form-data">
          <input type="hidden" value="1" name="type">
            <div class="file">
              <label for="pdf"> Subir Documento: </label><input type="file" id="pdf" name="pdf" value="" required />
            </div>
            <div class="box">
              <div class="innerBox">
                <label for="filename"> Nombre: </label>
                <input type="text" name="filename" id="filename" placeholder="nombre del documento" />

                <label for="fecha"> Fecha: </label><input type="date" name="filedate" id="fecha" />

                <label for="decripcion"> Descripcion: </label>
                <textarea type="text" name="desc" id="descripcion" rows="5" maxlength="150" placeholder="decripcion del documento. Breve oracion del tema."></textarea>

                <label for="Numero_certificacion"> Numero_certificacion: </label>
                <input type="text" id="Numero_certificacion" name="number" placeholder="Numero_certificacion" />

                <label for="estado"> Estado del Documento: </label>
                <select id="estado" name="state">
                  <option value="">Select</option>
                  <option value="activo">Activo</option>
                  <option value="inactivo">Inactivo</option>
                </select>

                <label for="categorias">Categoria del Documento:</label>
                <select id="categorias" name="category">
                  <option disabled selected>Categorias</option>
                  <?php
                  if (count($_SESSION['cats']) > 0) {
                    foreach ($_SESSION['cats'] as $cat) {
                      echo '<option value="' . $cat['cat_abbr'] . '">' . $cat['cat_name'] . '</option>';
                    }
                  }
                  ?>
                </select>


              </div>

              <div class="innerBox">
                <label for="filename"> Lenguaje de Documento: </label>
                <select id="lenguaje" name="lenguaje">
                  <option value="">Select</option>
                  <option value="esp">Español</option>
                  <option value="eng">Ingles</option>

                </select>

                <label for="filename"> Año Fiscal : </label>
                <select id="añofiscal" name="fiscalYear">
                  <option value="">Select</option>
                  <option value="2022-2023">2022-2023</option>
                  <option value="2023-2024">2023-2024</option>
                  <option value="2024-2025">2024-2025</option>
                  <option value="2025-2026">2025-2026</option>
                </select>
                <label for="subcategorias">Cuerpo: </label>
                <select id="subcategorias" name="corp">
                  <option selected disabled>Select</option>
                  <?php
                  if (count($_SESSION['corps']) > 0) {
                    foreach ($_SESSION['corps'] as $corp) {
                      echo '<option value="' . $corp['corp_abbr'] . '">' . $corp['corp_name'] . '</option>';
                    }
                  }
                  ?>
                </select>



                <label for="firma"> Firmado por: </label><input type="text" id="firma" name="signature" />
              </div>
            </div>

            <input class ="btn btn-primary" type="submit" name="submit" value="Guardar" />
          </form>
          <div class="backline">
            <h3>Añadir enlace a otro Documento</h3>
            <div class="search-bar">
                <input type="text" placeholder="Buscar por nombre" />
                <button class ="color" type="submit">Buscar</button>
            </div>

            <table>
              <thead>
                <tr>
                  <th>Certification number</th>
                  <th>Titulo</th>
                  <th>Categoria</th>
                  <th>Enlazar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if (count($_SESSION['Enlazar']) > 0) {
                        foreach ($_SESSION['Enlazar'] as $Enlazar) {
                            echo '<tr><th>' . $Enlazar['number'] .'-'. $Enlazar['fiscal'] .'</th><th>'.$Enlazar['title'] .'</th>'.'</th><th>'.$Enlazar['category'] .'</th>';
                            echo '<td style="text-align: center;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Enlazar"
                                  onclick="enlazar(this)">Enlazar</button></td>';
                                  echo '</tr>';
                        }
                    } else {
                        print '<tr><td colspan="2" style="text-align:center">Documentos no disponibles</td></tr>';
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>

        
        <div id="editar" class="editar" style="display: none">
    <div class="backline">
        <h3>Editar Documento</h3>
        <div class="search-bar">
            <input type="text" placeholder="Buscar por nombre" />
            <button type="submit">Buscar</button>
        </div>
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="admin.php" id="formEditarDocumento">
                        <input type="hidden" value="2" name="type">
                            
                            <div class="form-group">
                            <input type="hidden" id="documentoId" name="documentoId" value="documentoId">
                                <label for="nombreDocumento">Nombre del Documento</label>
                                <input type="text" class="form-control" id="nombreDocumento" name="nombreDocumento">
                            </div>
                            
                            <div class="form-group">
                                <label for="fechaDocumento">Fecha del Documento</label>
                                <input type="text" class="form-control" id="fechaDocumento" name="fechaDocumento">
                            </div>

                            <label for="cuerpo">Cuerpo: </label>
                                <select id="cuerpo" name="cuerpo">
                                  <option selected disabled>Select</option>
                                  <?php
                                  if (count($_SESSION['corps']) > 0) {
                                    foreach ($_SESSION['corps'] as $corp) {
                                      echo '<option value="' . $corp['corp_abbr'] . '">' . $corp['corp_name'] . '</option>';
                                    }
                                  }
                                  ?>
                                </select>
      
                            <div class="form-group">
                                <label for="fiscal">Año Fiscal</label>
                                <input type="text" class="form-control" id="fiscal" name="fiscal">
                            </div>


                            <label for="lenguaje"> Lenguaje de Documento: </label>
                                <select id="lenguaje" name="lenguaje" class="form-control">
                                  <option value="">Select</option>
                                  <option value="esp">Español</option>
                                  <option value="eng">Ingles</option>

                                </select>
                          
                            
                            <label for="estado"> Estado del Documento: </label>
                              <select id="estado" name="estado" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                              </select>


                            <div class="form-group">
                                <label for="certi">Numero de certificacion </label>
                                <input type="text" class="form-control" id="certi" name="certi">
                            </div>

                            <div class="form-group">
                                <label for="path"> Subir Documento: </label><input type="file" id="path" name="path" value=""  />
                            </div>

                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <!-- Puedes añadir más campos de edición según sea necesario -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table>
        <thead>
          <tr>
              <th>Nombre </th>
              <th>Fecha</th>
              <th>Editar</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
          foreach ($_SESSION['documentos'] as $indice => $documento) {
              echo '<tr><td>' . $documento['Document_title'] . '</td><td>' . $documento['Date_created'] . '</td>';
              echo '<td><button type="button" class="btn btn-primary editar-btn" data-toggle="modal" data-target="#exampleModal" data-id="' . $documento['Document_id'] . '" data-title="' . $documento['Document_title'] . '" data-fecha="' . $documento['Date_created'] . '" data-fiscal="' . $documento['fiscal'] . '" data-cuerpo="' . $documento['cuerpo'] . '" data-certi="' . $documento['certi'] . '" data-path="' . $documento['path'] . '" data-estado="' . $documento['estado'] . '" data-lenguaje="' . $documento['lenguaje'] . '">Editar</button></td>';
          }
          
          
          ?>
        </tbody>
      </table>
    </div>
    </div>
    </div>

        <div id="crear" class="crear back" style="display: none">

          <h3>Categorias disponibles</h3>
          <table>
            <thead>
              <tr>
                <th>Categoria</th>
                <th>Abreviacion</th>
                <th>Cuerpo</th>
                <th>Acccion</th>
              </tr>
            </thead>
            <tbody id="categorias">
              <?php
                if (count($_SESSION['cats']) > 0) {
                  foreach ($_SESSION['cats'] as $cat) {
                    echo '<tr>';
                    echo '<td>' . $cat['cat_name'] . '</td>';
                    echo '<td>' . $cat['cat_abbr'] . '</td>';
                    echo '<td>' . $cat['cat_corp'] . '</td>';
                    echo '<td style="text-align: center;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditCategoria"
                    data-nombre="' . $cat['cat_name'] . '"
                    data-abreviacion="' . $cat['cat_abbr'] . '"
                    data-cuerpo="' . $cat['cat_corp_abbr'] . '" 
                    onclick="editcategori(this)">Editar</button></td>';
                    echo '</tr>';
                  }
                } else {
                  print '<tr><td colspan="2" style="text-align:center">Categorias no disponibles</td></tr>';
                }
              ?>
              <tr>
                <td colspan="4" style="text-align: center;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddCategoria">Añadir Category</button></td>
              </tr>
            </tbody>
          </table>

          <h3>Cuerpos disponibles</h3>
          <table>
            <thead>
              <tr>
                <th>Cuerpos</th>
                <th>Abreviacion</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (count($_SESSION['corps']) > 0) {
                foreach ($_SESSION['corps'] as $corp) {
                  echo '<tr>';
                  echo '<td>' . $corp['corp_name'] . '</td>';
                  echo '<td>' . $corp['corp_abbr'] . '</td>';
                  echo '<td style="text-align: center;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Editcuerpo"
                    data-nombreCuerpo="' . $corp['corp_name'] . '"
                    data-abreviacionCuerpo="' . $corp['corp_abbr'] . '"
                    onclick="Editcuerpo(this)">Editar</button></td>';
                    echo '</tr>';
                }
              } else {
                print '<tr><td colspan="2" style="text-align:center">Categorias no disponibles</td></tr>';
              }
              ?>
              <tr>
                <td colspan="4" style="text-align: center;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddCuerpo">Añadir Cuerpo</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <h4>Visita nuestro sitio web:<a href="#"> upra.edu</a></h4>
  </footer>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/admin.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
  if (isset($_POST['submit'])){
    $categoria = isset($_POST['cate']) ? $_POST['cate'] : '';
    $abbv = isset($_POST['abbv']) ? $_POST['abbv'] : '';
  }
?>

<!-- AddCategoria -->
<div class="modal" id="AddCategoria">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabecera del modal -->
      <div class="modal-header" >
          <h4 class="modal-title">Añadir Category</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Contenido del modal -->
      <div class="modal-body editar form">
        <form method="POST" action="../controllers/backend/adminController.php" enctype="multipart/form-data">
          <input type="hidden" value="3" name="type">
          <label for="cate">Nombre de la categoria</label>
          <input type="text" class="form-control" id="cate" name="categoria">

          <label for="Abre">Abreviacion</label>
          <input type="text" class="form-control" id="Abre" min="2" max="3" name="Abreviacion">

          <label for="cuerpoCategoria">Cuerpo</label>
            <select class="form-control" id="cuerpoCategoria" name="cuerpo">
                <?php
                if (count($_SESSION['corps']) > 0) {
                  echo '<option value=""> </option>';
                  foreach ($_SESSION['corps'] as $corp) {
                    echo "<option value='" . $corp['corp_abbr'] . "'>" . $corp['corp_name'] . "</option>";
                  }
                }
                ?>
            </select>
          <br>
          <input class ="btn btn-primary" type="submit" name="submit" value="Guardar" />
        </form>
      </div>
    </div>
  </div>
</div>

<!-- editCategoria -->
<div class="modal" id="EditCategoria">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabecera del modal -->
      <div class="modal-header" >
          <h4 class="modal-title">Editar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Contenido del modal -->
      <div class="modal-body editar form">
        <form method="POST" action="../controllers/backend/adminController.php" enctype="multipart/form-data">
          <input type="hidden" value="6" name="type">
          <input type="hidden" value="" name="oldabbr" id="oldabbr">
          <label for="nombreCategoria">Nombre de la Categoria</label>
          <input type="text" class="form-control" id="nombreCategoria" name="categoria">

          <label for="abreviacionCategoria">Abreviacion</label>
          <input type="text" class="form-control" id="abreviacionCategoria" min="2" max="3" name="Abreviacion">

          <label for="editCatCorporacion">Cuerpo</label>
          <select id="cuerpoDropdown" name="cuerpoDropdown" class="form-control">
            <?php
            if (count($_SESSION['corps']) > 0) {
              echo '<option value=""> </option>';
              foreach ($_SESSION['corps'] as $corp) {
                $value = $corp['corp_abbr'];
                $text = $corp['corp_name'];
                echo "<option value='$value'>$text</option>";
              }
            }
            ?>
          </select>

          <input class ="btn btn-primary" type="submit" name="submit" value="Guardar" />
        </form>
      </div>
    </div>
  </div>
</div>

<!-- AddCuerpo -->
<div class="modal" id="AddCuerpo">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabecera del modal -->
      <div class="modal-header" >
          <h4 class="modal-title">Añadir Cuerpo</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Contenido del modal -->
      <div class="modal-body editar form">
        <form method="POST" action="../controllers/backend/adminController.php" enctype="multipart/form-data">
          <input type="hidden" value="4" name="type">
          <label for="cuerpo">Nombre de la Cuerpo</label>
          <input type="text" class="form-control" id="cuerpo" name="cuerpo">

          <label for="Abre">Abreviacion</label>
          <input type="text" class="form-control" id="Abre" min="2" max="3" name="Abreviacion">
          <input class ="btn btn-primary" type="submit" name="submit" value="Guardar" />
        </form>
      </div>
    </div>
  </div>
</div>

<!-- AddCuerpo -->
<div class="modal" id="Editcuerpo">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabecera del modal -->
      <div class="modal-header" >
          <h4 class="modal-title">Editar Cuerpo</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Contenido del modal -->
      <div class="modal-body editar form">
        <form method="POST" action="../controllers/backend/adminController.php" enctype="multipart/form-data">
          <input type="hidden" value="5" name="type">
          <input type="hidden" value="" name="oldabbr" id="oldabbr2">
          <label for="EnombreCuerpo">Nombre de la Cuerpo</label>
          <input type="text" class="form-control" id="EnombreCuerpo" name="cuerpo">

          <label for="Eabreviacioncuerpo">Abreviacion</label>
          <input type="text" class="form-control" id="Eabreviacioncuerpo" min="2" max="3" name="Abreviacion">
          <input class ="btn btn-primary" type="submit" name="submit" value="Guardar" />
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Enlazar -->
<div class="modal" id="Enlazar">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabecera del modal -->
      <div class="modal-header" >
          <h4 class="modal-title">enlazar documento</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Contenido del modal -->
      <div class="modal-body editar form">
        <form method="POST" action="../controllers/backend/adminController.php" enctype="multipart/form-data">
          <input type="hidden" value="7" name="type">
          <input type="hidden" value="" name="oldabbr" id="oldabbr2">
          <label for="EnombreCuerpo">Nombre de la Cuerpo</label>
          <input type="text" class="form-control" id="EnombreCuerpo" name="cuerpo">

          <label for="Eabreviacioncuerpo">Abreviacion</label>
          <input type="text" class="form-control" id="Eabreviacioncuerpo" min="2" max="3" name="Abreviacion">
          <input class ="btn btn-primary" type="submit" name="submit" value="Guardar" />
        </form>
      </div>
    </div>
  </div>
</div>