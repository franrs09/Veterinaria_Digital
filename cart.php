<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 viewport-fit=cover">
    <title>HospiPet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="vetCSS/vetStyCart.css">
    <script src="vetJs/vetScriptsCart.js" defer></script>
</head>

<body>
    <div class="site">
        <?php include 'navMenu.php'; ?>
        <main>
            <section id="cart-section" class="container py-5">
                <h2 class="mb-4 text-center">Carrito de compras</h2>
                <div id="cart-empty" class="alert alert-info text-center" style="display: none;">
                    Tu carrito está vacío.
                </div>
                <div id="cart-table-wrapper">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <h4 id="cart-total" class="me-4">Total: ₡0</h4>
                    <button class="btn btn-success" type="button" id="btnCheckout">Finalizar compra</button>
                </div>
            </section>
        </main>
    </div>
</body>
<footer class="bs-primary-bg-subtle text-center p-3 mt-4">
    <div class="container">
        <p class="mb-0">©2025 HospiPet. Todos los derechos reservados.</p>
    </div>
</footer>


</html>