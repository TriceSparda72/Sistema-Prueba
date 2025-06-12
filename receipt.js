document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("productDescription");
    const unitPriceInput = document.getElementById("unitPrice");
    const quantityInput = document.getElementById("quantity");
    const totalDisplay = document.getElementById("total");
    const ivaDisplay = document.getElementById("iva");
    const totalPagoDisplay = document.getElementById("totalPago");

    if (!productSelect || !unitPriceInput || !quantityInput || !totalDisplay || !ivaDisplay || !totalPagoDisplay) {
        console.error("❌ Uno o más elementos no encontrados en el DOM.");
        return;
    }

    fetch("db/get_productos_receipt.php")
        .then(res => res.json())
        .then(productos => {
            console.log("✅ Productos recibidos:", productos);

            if (!productos || productos.length === 0) {
                console.error("⚠️ No se encontraron productos.");
                return;
            }

            productSelect.innerHTML = '<option disabled selected>Selecciona un producto</option>';

            productos.forEach(producto => {
                const option = document.createElement("option");
                option.value = producto.ID_Producto;
                option.dataset.precio = producto.Precio_Unitario; // 🔹 Guardamos el precio en un atributo `data`
                option.textContent = `${producto.Nombre_Producto} - $${producto.Precio_Unitario}`;
                productSelect.appendChild(option);
            });

            console.log("✅ Productos cargados correctamente.");
        })
        .catch(error => console.error("❌ Error al cargar productos:", error));

    // 🟢 Evento para actualizar el precio unitario al seleccionar un producto
    productSelect.addEventListener("change", function () {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const precioUnitario = selectedOption.dataset.precio || 0;
        unitPriceInput.value = precioUnitario;
        calcularTotal(); // 🔹 Recalcula los valores cuando cambia el producto
    });

    // 🟢 Evento para actualizar el total cuando cambia la cantidad
    quantityInput.addEventListener("input", calcularTotal);

    function calcularTotal() {
        const precioUnitario = parseFloat(unitPriceInput.value) || 0;
        const cantidad = parseInt(quantityInput.value) || 0;
        const total = precioUnitario * cantidad;
        const iva = total * 0.16; // IVA del 16%
        const totalPago = total + iva;

        totalDisplay.textContent = `$${total.toFixed(2)}`;
        ivaDisplay.textContent = `$${iva.toFixed(2)}`;
        totalPagoDisplay.textContent = `$${totalPago.toFixed(2)}`;
    }
});