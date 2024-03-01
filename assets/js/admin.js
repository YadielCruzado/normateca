const form = document.getElementById("catForm");
const addCategoryButton = document.getElementById("addCategory");

addCategoryButton.addEventListener("click", () => {
	if (form.style.display === "none" || form.style.display === "") {
		form.style.display = "table-row";
		addCategoryButton.innerHTML = "Hide Form";
	} else {
		form.style.display = "none";
		addCategoryButton.innerHTML = "Add Category";
	}
});
