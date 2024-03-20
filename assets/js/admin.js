//editar documentos
$(document).ready(function () {
  $("#exampleModal").modal({
    show: false, // Ensure modal is hidden by default
  });
});
// function openEditarModal(
//   title,
//   fecha,
//   id,
//   fiscal,
//   cuerpo,
//   certi,
//   path,
//   estado,
//   lenguaje
// ) {
//   document.getElementById("nombreDocumento").value = title;
//   document.getElementById("fechaDocumento").value = fecha;
//   document.getElementById("documentoId").value = id; // Set the documentoId value
//   document.getElementById("fiscal").value = fiscal;
//   document.getElementById("cuerpo").value = cuerpo;
//   document.getElementById("certi").value = certi;
//   document.getElementById("path").value = path;
//   document.getElementById("estado").value = estado;
//   document.getElementById("lenguaje").value = lenguaje;

//   $("#exampleModal").modal("show");
// }

$("#exampleModal").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var id = button.data("id");
  var title = button.data("title");
  var fecha = button.data("fecha");
  var fiscal = button.data("fiscal");
  var cuerpo = button.data("cuerpo");
  var certi = button.data("certi");
  var path = button.data("path");
  var estado = button.data("estado");
  var lenguaje = button.data("lenguaje");

  // Populate modal with document details
  $("#nombreDocumento").val(title);
  $("#fechaDocumento").val(fecha);
  $("#documentoId").val(id);
  $("#fiscal").val(fiscal);
  $("#cuerpo").val(cuerpo);
  $("#certi").val(certi);
  $("#path").val(path);
  $("#estado").val(estado);
  $("#lenguaje").val(lenguaje);
});

//modal editcategori
function editcategori(button) {
  var nombre = button.getAttribute("data-nombre");
  var abreviacion = button.getAttribute("data-abreviacion");
  var cuerpo = button.getAttribute("data-cuerpo");

  document.getElementById("nombreCategoria").value = nombre;
  document.getElementById("abreviacionCategoria").value = abreviacion;
  document.getElementById("oldabbr").value = abreviacion;

  var cuerpoDropdown = document.getElementById("cuerpoDropdown");

  // Loop through options and set the selected attribute
  for (var i = 0; i < cuerpoDropdown.options.length; i++) {
    var optionValue = cuerpoDropdown.options[i].value;

    // Check if cuerpo is equal to corp_abbr
    if (cuerpo === optionValue) {
      cuerpoDropdown.options[i].selected = true;
    }
  }
}

//modal editcuerpo

function Editcuerpo(button) {
  var nombre = button.getAttribute("data-nombreCuerpo");
  var abreviacion = button.getAttribute("data-abreviacionCuerpo");

  document.getElementById("EnombreCuerpo").value = nombre;
  document.getElementById("Eabreviacioncuerpo").value = abreviacion;
  document.getElementById("oldabbr2").value = abreviacion;
}
