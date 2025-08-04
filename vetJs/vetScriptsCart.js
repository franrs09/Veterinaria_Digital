// Detector para el eventos DOMContentLoaded
document.addEventListener("DOMContentLoaded", function() {
    eventListeners();
});

function eventListeners() {
    console.log("Aqui detecta el DOMContentLoaded");
};


// Inicializa el popover del carrito
function initCartPopover() {
    var btnCart = document.getElementById("btnCart");
    if (!btnCart) return;
    var popoverContent = `
        <table class='table table-bordered table-hover align-middle mb-0'>
            <thead class='table-primary'>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id='cart-items-popover'>
                <tr><td colspan='5' class='text-center'>Tu carrito está vacío.</td></tr>
            </tbody>
        </table>
        <div class='d-flex justify-content-end mt-2'>
            <h6 id='cart-total-popover' class='me-4 mb-0'>Total: ₡0</h6>
            <button class='btn btn-success btn-sm' type='button' id='btnCheckoutPopover'>Finalizar compra</button>
        </div>
    `;
    new bootstrap.Popover(btnCart, {
        content: popoverContent,
        trigger: 'focus',
        placement: 'bottom',
        html: true
    });
}

function eventListeners() {
    console.log("Aqui detecta el DOMContentLoaded");
    initCartPopover();
}