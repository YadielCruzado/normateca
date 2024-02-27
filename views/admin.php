<?php
include_once("../controllers/backend/adminController.php");
setData();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Normateca</title>
  <link rel="stylesheet" href="../assets/css/admin.css" />
</head>

<body>
  <header>
    <img src="../assets/images/uprlogo.png" />
    <div>
      <h1>Administrador Normateca</h1>
      <h3><i> Universidad de Puerto Rico en Arecibo </i></h3>
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
          <input type="hidden" value="upload" name="type">
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

            <input type="submit" name="submit" value="Guardar" />
          </form>
          <div class="backline">
            <h3>Añadir enlace a otro Documento</h3>

            <div class="search-bar">
              <input type="text" placeholder="Buscar por nombre" />
              <button type="submit">Buscar</button>
            </div>

            <table>
              <thead>
                <tr>
                  <th>Certification number</th>
                  <th>Category</th>
                  <th>Enlazar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if (count($_SESSION['docs']) > 0) {
                        foreach ($_SESSION['docs'] as $doc) {
                            echo '<tr><th>' . $doc['number'] .'-'. $doc['fiscal'] .'</th><th>'.$doc['category'] .'</th></tr>';
                        }
                    } else {
                        print '<tr><td colspan="2" style="text-align:center">Documentos no disponibles</td></tr>';
                    }
                  ?>
              </tbody>
            </table>

            <!--<div class="razon">
              <form>
                <label>¿Por que es enlazado?:</label>
                <input typw="text" name="razon" placeholder="enmendado por/a, derrogado por/a ..." />
              </form>
            </div>-->
          </div>
        </div>

        <div id="editar" class="editar" style="display: none">
          <div class="backline">
            <h3>Editar Documento</h3>

            <div class="search-bar">
              <input type="text" placeholder="Buscar por nombre" />
              <button type="submit">Buscar</button>
            </div>

            <table>
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Editar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                print '<tr><td colspan="3" style="text-align:center">Documentos no disponibles</td></tr>'
                ?>
              </tbody>
            </table>

            <!--<div class="razon">
              <form>
                <label>¿Por que es enlazado?:</label>
                <input typw="text" name="razon" placeholder="enmendado por/a, derrogado por/a ..." />
              </form>
            </div>-->
          </div>
          
        </div>

        <div id="crear" class="crear" style="display: none">

          <h3>Categorias disponibles</h3>
          <table>
            <thead>
              <tr>
                <th>Categoria</th>
                <th>Abreviacion</th>
                <th>Cuerpo</th>
              </tr>
            </thead>
            <tbody id="categorias">
              <?php
              if (count($_SESSION['cats']) > 0) {
                foreach ($_SESSION['cats'] as $cat) {
                  echo '<tr><td>' . $cat['cat_name'] . '</td><td>' . $cat['cat_abbr'] . '</td><td>' . $cat['cat_corp'] . '</td></tr>';
                }
              } else {
                print '<tr><td colspan="2" style="text-align:center">Categorias no disponibles</td></tr>';
              }
              ?>


              <tr id="catForm" style="display:none">
                <form action="#" method="get">
                  <td><input type="text" name="name"></td>
                  <td><input type="text" maxlength="2" name="abbv"></td>
                  <td><input type="text" maxlength="2" name="cuerpo"></td>
                  
                </form>
              </tr>

              <tr>
                <td colspan="3" style="text-align: center;"><button id="categoriaBtn">Añadir categoria</button></td>
              </tr>
            </tbody>
          </table>

          <h3>Sub-Categorias disponibles</h3>
          <table>
            <thead>
              <tr>
                <th>Sub-Categoria</th>
                <th>Abreviacion</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (count($_SESSION['corps']) > 0) {
                foreach ($_SESSION['corps'] as $corp) {
                  echo '<tr><td>' . $corp['corp_name'] . '</td><td>' . $corp['corp_abbr'] . '</td></tr>';
                }
              } else {
                print '<tr><td colspan="2" style="text-align:center">Categorias no disponibles</td></tr>';
              }
              ?>

              <tr id="subcatForm" style="display:none">
                <form action="#" method="get">
                  <td><input type="text" name="cate"></td>
                  <td><input type="text" maxlength="2" name="abbv"></td>
                  <!-- <td><input type="text" maxlength="2" name="cat"></td> -->
                  
                </form>
              </tr>

              <tr>
                <td colspan="3" style="text-align: center;"><button id="subcatBtn">Añadir Sub-Categoria</button></td>
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

  <script src="../assets/js/main.js"></script>
</body>

</html>
<?php
if (isset($_POST['submit'])){
$categoria = isset($_POST['cate']) ? $_POST['cate'] : '';
$abbv = isset($_POST['abbv']) ? $_POST['abbv'] : '';

}

?>