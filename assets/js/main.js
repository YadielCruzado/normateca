function changeVisibility(tab, lastTab, btn, lastBtn) {
  lastTab.style.display = "none";
  tab.style.display = "grid";

  btn.classList.toggle("active");
  lastBtn.classList.toggle("active");
}

document.addEventListener("DOMContentLoaded", () => {
  const elements = {
    tabs: {
      subir: document.getElementById("subir"),
      editar: document.getElementById("editar"),
      crear: document.getElementById("crear"),
    },
    buttons: {
      subir: document.getElementById("subirBtn"),
      editar: document.getElementById("editarBtn"),
      crear: document.getElementById("crearBtn"),
      categoria: document.getElementById("categoriaBtn"),
      subcategoria: document.getElementById("subcatBtn"),
    },
    lastTab: document.getElementById("subir"),
    lastBtn: document.getElementById("subirBtn"),
    catStatus: false,
    subcatStatus: false,
  };

  elements.buttons.subir.addEventListener("click", () => {
    changeVisibility(
      elements.tabs.subir,
      elements.lastTab,
      elements.buttons.subir,
      elements.lastBtn
    );

    elements.lastTab = elements.tabs.subir;
    elements.lastBtn = elements.buttons.subir;
    localStorage.setItem("lastTab", "subir");
  });

  elements.buttons.editar.addEventListener("click", () => {
    changeVisibility(
      elements.tabs.editar,
      elements.lastTab,
      elements.buttons.editar,
      elements.lastBtn
    );

    elements.lastTab = elements.tabs.editar;
    elements.lastBtn = elements.buttons.editar;
    localStorage.setItem("lastTab", "editar");
  });

  elements.buttons.crear.addEventListener("click", () => {
    changeVisibility(
      elements.tabs.crear,
      elements.lastTab,
      elements.buttons.crear,
      elements.lastBtn
    );

    elements.lastTab = elements.tabs.crear;
    elements.lastBtn = elements.buttons.crear;
    localStorage.setItem("lastTab", "crear");
  });

  elements.buttons.categoria.addEventListener("click", () => {
    if (!elements.catStatus) {
      elements.buttons.categoria.innerHTML = "Guardar";

      const form = document.getElementById("catForm");
      form.style.display = "table-row";

      elements.catStatus = true;
    }
  });

  elements.buttons.subcategoria.addEventListener("click", () => {
    if (!elements.subcatStatus) {
      elements.buttons.subcategoria.innerHTML = "Guardar";

      const form = document.getElementById("subcatForm");
      form.style.display = "table-row";

      elements.subcatStatus = true;
    }
  });
});
