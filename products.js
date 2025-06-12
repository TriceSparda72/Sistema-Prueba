document.addEventListener("DOMContentLoaded", function () {
    cargarProductos();

    document.getElementById("addProductForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        
        fetch("db/add_producto.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                this.reset();
                cargarProductos();
            }
        })
        .catch(error => console.error("Error al agregar producto:", error));
    });
});

function cargarProductos() {
    fetch("db/get_productos.php")
    .then(res => res.text()) // 👈 Usamos `.text()` en vez de `.json()` para ver la respuesta en bruto
    .then(data => {
        console.log("Respuesta del servidor:", data); // 👈 Mostramos en la consola la respuesta sin procesar

        try {
            const productos = JSON.parse(data); // 👈 Convertimos a JSON solo si es válido
            const tbody = document.querySelector("#productTable tbody");
            tbody.innerHTML = "";

            productos.forEach(producto => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${producto.ID_Producto}</td>  <!-- ✅ Cambio de "id" a "ID_Producto" -->
                    <td>${producto.Nombre_Producto}</td>
                    <td>${producto.Stock_Local}</td>
                    <td>${producto.Stock_Almacen}</td>
                    <td>$${producto.Precio_Unitario}</td>
                `;

                tbody.appendChild(row);
            });
        } catch (error) {
            console.error("Error al procesar la respuesta JSON:", error);
        }
    })
    .catch(error => console.error("Error al cargar productos:", error));
}