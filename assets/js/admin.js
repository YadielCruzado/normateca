//editar documentos
$(document).ready(function () {
	$("#exampleModal").modal({
		show: false, // Ensure modal is hidden by default
	});
});
// modal documentos
$("#exampleModal").on("show.bs.modal", function (event) {
	var button = $(event.relatedTarget);
	var id = button.data("id");
	var title = button.data("title");
	var fecha = button.data("fecha");
	var fiscal = button.data("fiscal");
	var cuerpo = button.data("cuerpo");
	var certi = button.data("certi");
	var path = button.data("path");
	var estado = button.data("estado");
	var lenguaje = button.data("lenguaje");

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

function limpiar() {
	// Get the input field
	console.log("Limpiar button clicked!");
	var inputField = document.querySelector('input[name="search_query2"]');

	// Clear the input field value
	inputField.value = "";

	// Submit the form to reload the page without search query
	// You can modify the form action accordingly if needed
	document.querySelector(".gabriel").submit();
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
	document.getElementById("oldabbr2").value = abreviacion;
}

//modal enlazar
function Enmendar(button) {
	var id = button.getAttribute("data-Eid");
	var number = button.getAttribute("data-Enumber");
	var fiscal = button.getAttribute("data-Efiscal");
	var title = button.getAttribute("data-Etitle");
	var category = button.getAttribute("data-Ecategory");

	// Aquí puedes asignar los valores a los campos del modal
	document.getElementById("EnId").value = id;
	document.getElementById("EnNumber").innerText = number;
	document.getElementById("EnFiscal").innerText = fiscal;
	document.getElementById("EnTitulo").innerText = title;
}

function derrogar(button) {
	var id = button.getAttribute("data-Did");
	var number = button.getAttribute("data-Dnumber");
	var fiscal = button.getAttribute("data-Dfiscal");
	var title = button.getAttribute("data-Dtitle");
	console.log(id, number, fiscal, title);

	// Aquí puedes asignar los valores a los campos del modal
	document.getElementById("DerId").value = id;
	document.getElementById("DerNumber").innerText = number;
	document.getElementById("DerFiscal").innerText = fiscal;
	document.getElementById("DerTitle").innerText = title;
}
