import limpiarHTML from "./limpiarHTML.js";

const pintarTabla = (busqueda) => {
    const { origen, submit, plantilla, destino } = busqueda;

    if (!origen || !destino)
        return;

    const formulario = document.querySelector(origen);
    const contenedorTabla = document.querySelector(destino);

    // Si tiene éxito se utilizará:
    const button = document.querySelector(submit);
    const template = document.querySelector(plantilla);

    if (!formulario || !contenedorTabla) return;
    if (!template) return;

    // Se obtiene la animación de carga ubicada en la plantilla:
    const animacion = template.content.cloneNode(true).firstElementChild;

    // Crear la tabla con los datos de las empresas encontradas
    const table = document.createElement("table");
    const thead = document.createElement("thead");
    const tbody = document.createElement("tbody");

    table.classList.add("enterprise-table");

    // Columnas:
    let columnas = `
        <colgroup>
            <col />
            <col />
            <col />

            <col />
            <col />
            <col />

            <col />
            <col />
            <col />
        </colgroup>
    `;

    let theader = `
        <tr>
            <th>Nº company</th>
            <th>Title</th>
            <th>Date of creation</th>
            <th>Description</th>
            <th>Country</th>
            <th>Address Line 1</th>
            <th>Postal Code</th>
            <th>Locality</th>
            <th>Status</th>
        </tr>
    `;

    // Incorporar el contenido HTML:
    thead.innerHTML = limpiarHTML(theader);

    // Incorporando columnas en la tabla:
    table.innerHTML = limpiarHTML(columnas);

    // Construyendo la tabla:
    table.append(thead, tbody);

    // Pintar la tabla en pantalla:
    contenedorTabla.append(table);


    // Obtener caja de texto de búsqueda:
    const inputText = formulario.firstElementChild.control;

    formulario.addEventListener("submit", (e) => {
        e.preventDefault();

        const formData = new FormData(formulario);

        const path = formulario.getAttribute("action");
        const datos = fetch(path, {
            method: "POST",
            cache: "no-cache",
            body: formData
        });

        let htmlButton = button.innerHTML;

        // Cambiar de estado al botón para indicar
        // que se está procesando la búsqueda:
        button.textContent = "";
        button.append(animacion);
        button.innerHTML += "Search";

        datos
            .then(respuesta => respuesta.json())
            .then(data => {
                // console.clear();

                // Actualizar el estado del botón:
                button.innerHTML = htmlButton;

                if (!Array.isArray(data.items))
                    return;

                let enterprises = data.items;

                let registro = "";
                enterprises.forEach(enterprise => {
                    // Esto se hace para prevenir un "undefined" en la tabla:
                    let nCompany = enterprise.company_number ? enterprise.company_number : "";
                    let title = enterprise.title ? enterprise.title : "";
                    let creacion = enterprise.date_of_creation ? enterprise.date_of_creation : "";

                    let description = enterprise.description ? enterprise.description : "";
                    let country = enterprise.address.country ? enterprise.address.country : "";
                    let addressLine1 = enterprise.address.address_line_1 ? enterprise.address.address_line_1 : "";

                    let postalCode = enterprise.address.postal_code ? enterprise.address.postal_code : "";
                    let locality = enterprise.address.locality ? enterprise.address.locality : "";
                    let status = enterprise.company_status ? enterprise.company_status : "";

                    // Creación de registro a partir de los datos devueltos por la API:
                    registro += `
                        <tr class="enterprise-table__item">
                            <td>${nCompany}</td>
                            <td>${title}</td>
                            <td>${creacion}</td>

                            <td>${description}</td>
                            <td>${country}</td>
                            <td>${addressLine1}</td>

                            <td>${postalCode}</td>
                            <td>${locality}</td>
                            <td>${status}</td>
                        </tr>
                    `;
                });

                if (!registro.length > 0) {
                    registro = `
                        <tr class="enterprise-table__success">
                            <td colspan="9">The name <strong>${inputText.value}</strong> is available for register</td>
                        </tr>
                    `;

                    registro = limpiarHTML(registro);
                }

                tbody.innerHTML = limpiarHTML(registro);
            })
            .catch(error => {
                console.log(error);
            });
    })
}

export default pintarTabla;