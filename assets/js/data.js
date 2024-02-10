const data = {
  allFiles: {
    1: {
      name: "aprovacion de presupuesto 2022-2023",
      fecha: "2022-08-17",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    2: {
      name: "comites permanentes Junta Administrativa",
      fecha: "2022-08-25",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    3: {
      name: "prioridades academicas y administrativas 2022-2023",
      fecha: "2022-08-19",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    4: {
      name: "Calendario Junta Administrativa",
      fecha: "2022-10-20",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    5: {
      name: "Calendario Junta Administrativa",
      fecha: "2022-10-20",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    6: {
      name: "Calendario Junta Administrativa",
      fecha: "2022-10-20",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    7: {
      name: "Calendario Junta Administrativa",
      fecha: "2022-10-20",
      categoria: "JA",
      subCategoria: "CER",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    8: {
      name: "file8",
      fecha: "2019-10-05",
      categoria: "C3",
      subCategoria: "ENM",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
    9: {
      name: "file9",
      fecha: "2020-08-20",
      categoria: "SA",
      subCategoria: "SOL",
      Backlink: {},
      info: "No info",
      path: "NA",
    },
  },

  recent: [7, 4, 3],
};

sessionStorage.setItem("files", JSON.stringify(data));
console.log(JSON.parse(sessionStorage.getItem("files")));

function createRow(
  data,
  table,
  categorias = "*",
  subCategorias = "*",
  inputName = "*"
) {
  if (categorias != "*" && !categorias.includes(data.categoria)) {
    return null;
  }

  const idString = `${data.name}-${data.fecha}-${data.categoria}-${data.subCategoria}`;

  if (inputName != "*" && !idString.includes(inputName)) {
    return null;
  }

  if (subCategorias != "*" && !subCategorias.includes(data.subCategoria)) {
    return null;
  }

  const name = document.createElement("td");
  const fecha = document.createElement("td");
  const categoria = document.createElement("td");
  const subCategoria = document.createElement("td");
  const backlink = document.createElement("td");
  const path = document.createElement("td");
  const a = document.createElement("a");
  a.href = "";
  a.textContent = "Download";
  path.appendChild(a);

  name.textContent = data.name;
  fecha.textContent = data.fecha;
  categoria.textContent = data.categoria;
  subCategoria.textContent = data.subCategoria;
  backlink.textContent = "Enlace";

  const row = document.createElement("tr");
  row.appendChild(name);
  row.appendChild(fecha);
  row.appendChild(categoria);
  row.appendChild(subCategoria);
  row.appendChild(backlink);
  row.appendChild(path);

  table.appendChild(row);
}

function createListItem(list, data) {
  const li = document.createElement("li");

  li.innerHTML = `${data.name}, ${data.categoria}, NA <br> ${data.info}`;
  list.appendChild(li);
}

function updateTable(table, cats, subCats, nameInput) {
  while (table.firstChild) table.removeChild(table.firstChild);

  let name = nameInput.value.trim();

  if (name == undefined || name == "") {
    name = "*";
  }

  for (let i in data.allFiles) {
    createRow(data.allFiles[i], table, cats, subCats, name);
  }
}

function updateRecent(list) {
  while (list.firstChild) list.removeChild(list.firstChild);

  for (let i of data.recent) {
    createListItem(list, data.allFiles[i]);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const elements = {
    categorias: {
      JuntaCheck: document.getElementById("JA"),
      SenadoCheck: document.getElementById("SA"),
      Cat3Check: document.getElementById("C3"),
    },
    subCategorias: {
      Certificacion: document.getElementById("Certificacion"),
      Enmendacion: document.getElementById("Enmendacion"),
      Solicitud: document.getElementById("Solicitud"),
    },

    tableBody: document.getElementById("tableBody"),
    list: document.getElementById("recentList"),
    searchElements: {
      search: {
        input: document.getElementById("search"),
        btn: document.getElementById("submit"),
      },
      title: document.getElementById("searchTitle"),
      table: document.getElementById("searchTable"),
    },
    recentElements: {
      title: document.getElementById("recentTitle"),
      div: document.getElementById("recents"),
    },
  };

  let cats = "*";
  let subCats = "*";

  elements.categorias.JuntaCheck.addEventListener("click", () => {
    if (cats.includes("JA")) {
      cats = cats.filter((cat) => cat != "JA");

      if (cats.length == 0) {
        cats = "*";
      }
    } else {
      if (cats == "*") {
        cats = ["JA"];
      } else {
        cats.push("JA");
      }
    }

    updateTable(
      elements.tableBody,
      cats,
      subCats,
      elements.searchElements.search.input
    );
  });

  elements.categorias.SenadoCheck.addEventListener("click", () => {
    if (cats.includes("SA")) {
      cats = cats.filter((cat) => cat != "SA");

      if (cats.length == 0) {
        cats = "*";
      }
    } else {
      if (cats == "*") {
        cats = ["SA"];
      } else {
        cats.push("SA");
      }
    }

    updateTable(
      elements.tableBody,
      cats,
      subCats,
      elements.searchElements.search.input
    );
  });

  elements.categorias.Cat3Check.addEventListener("click", () => {
    if (cats.includes("C3")) {
      cats = cats.filter((cat) => cat != "C3");

      if (cats.length == 0) {
        cats = "*";
      }
    } else {
      if (cats == "*") {
        cats = ["C3"];
      } else {
        cats.push("C3");
      }
    }

    updateTable(
      elements.tableBody,
      cats,
      subCats,
      elements.searchElements.search.input
    );
  });

  elements.subCategorias.Certificacion.addEventListener("click", () => {
    if (subCats.includes("CER")) {
      subCats = subCats.filter((sub) => sub != "CER");

      if (subCats.length == 0) {
        subCats = "*";
      }
    } else {
      if (subCats == "*") {
        subCats = ["CER"];
      } else {
        subCats.push("CER");
      }
    }

    updateTable(
      elements.tableBody,
      cats,
      subCats,
      elements.searchElements.search.input
    );
  });

  elements.subCategorias.Enmendacion.addEventListener("click", () => {
    if (subCats.includes("ENM")) {
      subCats = subCats.filter((sub) => sub != "ENM");

      if (subCats.length == 0) {
        subCats = "*";
      }
    } else {
      if (subCats == "*") {
        subCats = ["ENM"];
      } else {
        subCats.push("ENM");
      }
    }

    updateTable(
      elements.tableBody,
      cats,
      subCats,
      elements.searchElements.search.input
    );
  });

  elements.subCategorias.Solicitud.addEventListener("click", () => {
    if (subCats.includes("SOL")) {
      subCats = subCats.filter((sub) => sub != "SOL");

      if (subCats.length == 0) {
        subCats = "*";
      }
    } else {
      if (subCats == "*") {
        subCats = ["SOL"];
      } else {
        subCats.push("SOL");
      }
    }

    updateTable(
      elements.tableBody,
      cats,
      subCats,
      elements.searchElements.search.input
    );
  });

  elements.searchElements.search.btn.addEventListener("click", () => {
    const input = elements.searchElements.search.input;

    elements.searchElements.table.style.display = "block";
    elements.searchElements.title.style.display = "block";

    elements.recentElements.title.style.display = "none";
    elements.recentElements.div.style.display = "none";

    updateTable(elements.tableBody, cats, subCats, input);
  });

  //updateTable(elements.tableBody, cats, subCats, elements.search.input);

  updateRecent(elements.list);
});
