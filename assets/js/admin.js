//editar documentos
$(document).ready(function () {
	$("#exampleModal").modal({
		show: false, // Ensure modal is hidden by default
	});
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

//modal editardocumento

function EditDocumentos(button) {
	var id = button.getAttribute("data-EDid");
	var title = button.getAttribute("data-EDtitle");
	var Cuerpo = button.getAttribute("data-EDcuerpo");
	var category = button.getAttribute("data-EDcategory");
	var certi = button.getAttribute("data-EDcerti");
	var fiscal = button.getAttribute("data-EDfiscal");
	var lenguaje = button.getAttribute("data-EDlenguaje");
	var path = button.getAttribute("data-EDpath");
	var Estado = button.getAttribute("data-EDestado");

	document.getElementById("EDid").value = id;
	document.getElementById("EDtitle").value = title;
	document.getElementById("EDcuerpo").value = Cuerpo;
	document.getElementById("EDcategory").value = category;
	document.getElementById("EDcerti").value = certi;
	// document.getElementById("EDfiscal").value = fiscal;
	document.getElementById("EDlenguaje").value = lenguaje;
	document.getElementById("EDpath").value = path;
	document.getElementById("EDestado").value = Estado;

	var selectedYear = fiscal; // Assuming you have the selected year in JavaScript

	// Find the select element
	var selectElement = document.getElementById("EDfiscal");
	// Loop through options and select the one that matches the selectedYear
	for (var i = 0; i < selectElement.options.length; i++) {
		if (selectElement.options[i].value === selectedYear) {
			selectElement.options[i].selected = true;
			break; // Once found and selected, exit the loop
		}
	}
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
//modal derrogar
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
