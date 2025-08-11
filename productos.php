<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 viewport-fit=cover">
    <title>Productos - HospiPet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="vetCSS/vetStyHom.css">
    <link rel="stylesheet" href="vetCSS/vetStyGlobal.css">
    <link rel="stylesheet" href="vetCSS/vetStyHeader.css">
    <link rel="stylesheet" href="vetCSS/vetStyFooter.css">
</head>

<body>
    <div class="site">
        <?php include 'navMenu.php'; ?>
        <main>
            <section class="py-5">
                <div class="container">
                    <h1 class="text-center mb-4">Nuestros Productos</h1>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        <!-- Aquí se repiten los mismos productos que en el home -->

                        <!-- Producto 1 -->
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="https://media.istockphoto.com/id/1473825736/es/vector/dise%C3%B1o-de-envases-de-alimentos-para-perros-vector-de-ilustraci%C3%B3n.jpg?s=612x612&w=0&k=20&c=HN_MrgAuXTEkPi8Oph0e0eGJ1vApYNDUpZJtrYBuuMc="
                                    class="card-img-top" alt="Alimento para perros"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Alimento Premium para Perros</h5>
                                    <p class="card-text">Nutritivo alimento balanceado para todas las razas.</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">₡12,500</span>
                                        <button class="btn btn-sm btn-primary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 2 -->
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="https://www.suplidoraroyal.com/4105-large_default/juguete-para-gato-con-plumas-y-cascabel-animal-planet.jpg"
                                    class="card-img-top" alt="Juguete para gatos"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Juguete Interactivo para Gatos</h5>
                                    <p class="card-text">Juguete con plumas para gatos.</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">₡2,900</span>
                                        <button class="btn btn-sm btn-primary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 3 -->
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="https://bsecommerceprod.blob.core.windows.net/magento/catalog/product/cache/bc9e311e664dbb5929888a78159490c8/1/5/1505150664021-a.jpg"
                                    class="card-img-top" alt="Cama para mascotas"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Cama para Mascotas</h5>
                                    <p class="card-text">Cama para mascotas, con juguete interactivo.</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">₡25,000</span>
                                        <button class="btn btn-sm btn-primary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 4 -->
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="https://www.todomascotascr.com/17345-large_default/correa-con-soporte-y-pop-bag-para-perros-medianos-y-grandes.jpg"
                                    class="card-img-top" alt="Arnés con correa"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Arnés con Correa</h5>
                                    <p class="card-text">Juego de arnés con correa para perro.</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">₡7,000</span>
                                        <button class="btn btn-sm btn-primary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 5 -->
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="https://www.aquatorus.cl/wp-content/uploads/2022/01/X_azimut2618-300x300.png"
                                    class="card-img-top" alt="Dispensador de comida"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Dispensador de Comida</h5>
                                    <p class="card-text">Dispensador de comida para mascotas.</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">₡7,000</span>
                                        <button class="btn btn-sm btn-primary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto 6 -->
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="https://arcadenoe.com.gt/cdn/shop/files/372945.jpg?v=1702924153"
                                    class="card-img-top" alt="Juguete para perro"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Juguete para Perro</h5>
                                    <p class="card-text">Juguete de hule para perro en forma de hueso.</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="text-primary fw-bold">₡2,000</span>
                                        <button class="btn btn-sm btn-primary">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->
            </section>
        </main>
        <footer class="bs-primary-bg-subtle text-center p-3 mt-4">
            <div class="container">
                <p class="mb-0">©2025 HospiPet. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>