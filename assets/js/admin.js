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
	document.getElementById("oldabbr").value = abreviacion;
}
