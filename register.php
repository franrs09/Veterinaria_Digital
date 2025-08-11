<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 viewport-fit=cover">
    <title>HospiPet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="vetCSS/vetStyLog.css">
    <link rel="stylesheet" href="vetCSS/vetStyGlobal.css">
    <link rel="stylesheet" href="vetCSS/vetStyHeader.css">
    <link rel="stylesheet" href="vetCSS/vetStyFooter.css">
    <script src="vetJs/vetScriptsLogin.js"></script>
</head>

<body>
    <div class="site">
        <?php include 'navMenu.php'; ?>
        <main>
            <div class="min-vh-100 d-flex justify-content-center align-items-center">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center mb-3">
                            <h3>Registro</h3>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="nombre" class="form-label"><i class="fa-solid fa-user"></i> Nombre</label>
                                <input id="nombre" class="form-control" type="text" placeholder="Juan" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label"><i class="fa-solid fa-user"></i>
                                    Apellido</label>
                                <input id="apellido" class="form-control" type="text" placeholder="Pérez" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label"><i class="fa-solid fa-envelope"></i> Correo
                                    electrónico</label>
                                <input id="correo" class="form-control" type="email" placeholder="juanperez@gmail.com"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"><i class="fa-solid fa-lock"></i>
                                    Contraseña</label>
                                <input id="password" class="form-control" type="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label"><i class="fa-solid fa-phone"></i>
                                    Teléfono</label>
                                <input id="telefono" class="form-control" type="tel" placeholder="8888-8888" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" id="btnRegistro">Crear cuenta</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-button">
                        <p class="text-center">¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </main>
        <footer class="bs-primary-bg-subtle text-center p-3 mt-4">
            <div class="container">
                <p class="mb-0">©2025 HospiPet. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>