fetch("get_productos.php")
    .then(response => response.json())
    .then(data => {
        console.log("Productos:", data);
        // Aquí puedes usar los datos para actualizar el DOM
    })
    .catch(error => console.error("Error al obtener los productos:", error));
    fetch("get_productos.php")
    .then(response => response.json())
    .then(data => {
        const tabla = document.querySelector("#productosTabla tbody");
        tabla.innerHTML = "";

        data.forEach(producto => {
            const fila = `<tr>
                <td>${producto.ID_Producto}</td>
                <td>${producto.Nombre_Producto}</td>
                <td>${producto.Precio_Unitario}</td>
            </tr>`;
            tabla.innerHTML += fila;
        });
    });
    fetch("get_productos.php")
    .then(response => response.json())
    .then(data => {
        const tabla = document.querySelector("#inventarioTabla tbody");
        tabla.innerHTML = "";

        data.forEach(producto => {
            const fila = `<tr>
                <td>${producto.ID_Producto}</td>
                <td>${producto.Nombre_Producto}</td>
                <td>${producto.Precio_Unitario}</td>
            </tr>`;
            tabla.innerHTML += fila;
        });
    })
    .catch(error => console.error("Error al obtener productos:", error));
    fetch("get_ventas.php")
    .then(response => response.json())
    .then(data => {
        const tabla = document.querySelector("#tablaVentas tbody");
        tabla.innerHTML = "";

        data.forEach(venta => {
            const fila = `<tr>
                <td>${venta.Fecha}</td>
                <td>${venta.Cliente}</td>
                <td>${venta.Producto}</td>
                <td>${venta.Cantidad}</td>
                <td>${venta.Total}</td>
            </tr>`;
            tabla.innerHTML += fila;
        });
    })
    .catch(error => console.error("Error al obtener ventas:", error));