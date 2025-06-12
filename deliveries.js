document.addEventListener("DOMContentLoaded", function () {
    const toggleMenu = document.getElementById("toggleMenu");
    const sidebar = document.getElementById("sidebar");

    toggleMenu.addEventListener("click", function () {
        sidebar.classList.toggle("active"); // 👈 Hace que el menú se despliegue
    });

    // Carga los productos en el selector
    const productSelect = document.getElementById("productType");

    fetch("db/get_productos.php")
        .then(res => res.json())
        .then(productos => {
            productos.forEach(producto => {
                const option = document.createElement("option");
                option.value = producto.ID_Producto;
                option.textContent = producto.Nombre_Producto;
                productSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar productos en entregas:", error));
});