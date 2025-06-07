document.addEventListener("DOMContentLoaded", () => {
    loadProducts();
    document.getElementById("addProductForm").addEventListener("submit", addProduct);
});

// Función para cargar productos desde la base de datos
function loadProducts() {
    fetch("get_productos.php")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector("#productTable tbody");
            tableBody.innerHTML = "";
            data.forEach(product => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${product.Nombre_Producto}</td>
                    <td>${product.Stock_Local}</td>
                    <td>${product.Stock_Almacén}</td>
                    <td>$${product.Precio_Unitario.toFixed(2)}</td>
                    <td>
                        <button onclick="editProduct(${product.id})">Editar</button>
                        <button onclick="deleteProduct(${product.id})">Eliminar</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error al cargar productos:", error));
}

// Función para agregar un nuevo producto
function addProduct(event) {
    event.preventDefault();
    
    const formData = new FormData(document.getElementById("addProductForm"));

    fetch("add_producto.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            loadProducts(); // Recargar la lista después de agregar un producto
        }
    })
    .catch(error => console.error("Error al agregar producto:", error));
}

// Función para eliminar un producto
function deleteProduct(id) {
    if (confirm("¿Seguro que quieres eliminar este producto?")) {
        fetch("delete_producto.php", {
            method: "POST",
            body: JSON.stringify({ id: id }),
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                loadProducts(); // Recargar la lista después de eliminar
            }
        })
        .catch(error => console.error("Error al eliminar producto:", error));
    }
}