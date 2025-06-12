document.addEventListener("DOMContentLoaded", function () {
    cargarInventario();
});

function cargarInventario() {
    fetch("db/get_productos.php")
    .then(res => res.json())
    .then(productos => {
        const tbody = document.querySelector("#inventoryTable tbody");
        tbody.innerHTML = "";

        productos.forEach(producto => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${producto.ID_Producto}</td>
                <td>${producto.Nombre_Producto}</td>
                <td>${producto.Stock_Local}</td>
                <td>${producto.Stock_Almacen}</td>
                <td>$${producto.Precio_Unitario}</td>
                <td>
                    <button onclick="actualizarStock(${producto.ID_Producto})">📦 Actualizar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    })
    .catch(error => console.error("Error al cargar inventario:", error));
}

function actualizarStock(idProducto) {
    const nuevoStockLocal = prompt("Nuevo stock en local:");
    const nuevoStockAlmacen = prompt("Nuevo stock en almacén:");

    if (nuevoStockLocal !== null && nuevoStockAlmacen !== null) {
        fetch("db/update_stock.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${idProducto}&Stock_Local=${nuevoStockLocal}&Stock_Almacen=${nuevoStockAlmacen}`
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            cargarInventario();
        })
        .catch(error => console.error("Error al actualizar stock:", error));
    }
}