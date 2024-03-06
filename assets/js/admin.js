//editar documentos
$(document).ready(function () {
	$("#exampleModal").modal({
		show: false, // Ensure modal is hidden by default
	});
});
function openEditarModal(title, fecha, id) {
	document.getElementById("nombreDocumento").value = title;
	document.getElementById("fechaDocumento").value = fecha;
	document.getElementById("documentoId").value = id; // Set the documentoId value

	$("#exampleModal").modal("show");
}

//modal editcategori
function editcategori(button) {
	var nombre = button.getAttribute("data-nombre");
	var abreviacion = button.getAttribute("data-abreviacion");
	var cuerpo = button.getAttribute("data-cuerpo");

	document.getElementById("nombreCategoria").value = nombre;
	document.getElementById("abreviacionCategoria").value = abreviacion;

	// Obtener el valor del cuerpo
	var cuerpoValue = cuerpo;

	// Obtener el elemento select
	var selectElement = document.getElementById("selectCuerpoCategoria");

	// Buscar la opción con el valor correspondiente y seleccionarla
	for (var i = 0; i < selectElement.options.length; i++) {
		if (selectElement.options[i].value === cuerpoValue) {
			selectElement.selectedIndex = i;
			break;
		}
	}
}

//modal editcuerpo

function Editcuerpo(button) {
	console.log("hola");
	var nombre = button.getAttribute("data-nombreCuerpo");
	var abreviacion = button.getAttribute("data-abreviacionCuerpo");

	document.getElementById("EnombreCuerpo").value = nombre;
	document.getElementById("Eabreviacioncuerpo").value = abreviacion;
}
