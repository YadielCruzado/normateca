document.addEventListener("DOMContentLoaded", function () {
	// Capturar clic en el botón "Editar"
	var editButtons = document.querySelectorAll(".btn-edit");
	editButtons.forEach(function (button) {
		button.addEventListener("click", function () {
			// Obtener datos de la fila correspondiente
			var catNombre = button.getAttribute("data-nombre");
			var catAbreviacion = button.getAttribute("data-abreviacion");
			var catCorporacion = button.getAttribute("data-cuerpo");
			console.log(catCorporacion);

			// Llenar el formulario en el modal con los datos
			document.getElementById("editCatNombre").value = catNombre;
			document.getElementById("editCatAbreviacion").value = catAbreviacion;
			document.getElementById("editCatCorporacion").value = catCorporacion;

			// Mostrar el modal
			var modal = new bootstrap.Modal(document.getElementById("EditCategoria"));
			modal.show();
		});
	});

	// ... otras funciones o eventos necesarios
});
