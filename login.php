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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="vetCSS/vetStyLog.css">
    <link rel="stylesheet" href="vetCSS/vetStyGlobal.css">
    <link rel="stylesheet" href="vetCSS/vetStyFooter.css">
    <link rel="stylesheet" href="vetCSS/vetStyHeader.css">
    <script src="vetJs/vetScriptsLogin.js"></script>
</head>

<body>
    <?php include 'navMenu.php'; ?>
    <main>
        <div class="min-vh-100 d-flex justify-content-center align-items-center">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center mb-3">
                        <h3>Iniciar de sesi&oacute;n</h3>
                    </div>
                    <form id="login" method="post">
                        <div class="mb-3">
                            <label for="uMail" class="form-label"><i class="fa-solid fa-envelope"></i> Correo
                                electr&oacute;nico</label>
                            <input id="uMail" class="form-control" type="email" placeholder="Pepe@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="uPassword" class="form-label"><i class="fa-solid fa-lock"></i>
                                Contraseña</label>
                            <input id="uPassword" class="form-control" type="password" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" id="btnLogin">Iniciar sesi&oacute;n</button>
                        </div>
                    </form>
                </div>
                <div class="card-button">
                    <p class="text-center">¿No tienes cuenta? <a href="register.html">Crear cuenta</a></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 400px;">
            <h3 class="card-title text-center mb-4">Register </h3>
            <form id="register-form" action="dashboard.html" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" placeholder="Email" required>
                </div>
                <div class="input-group mb-3">    
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>               
                    <input type="password" class="form-control" id="password" required placeholder="Password">
                </div>
                <div class="input-group mb-3">    
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>               
                    <input type="password" class="form-control" id="confirm-password" required placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <!-- <div id="register-error" class="text-danger mt-3" style="display: none;">Password and confimation don't match</div> -->
            <div id="register-error" class="mt-3"></div>
            <p class="text-center mt-3">You already have a account? <a href="index.php">Login here</a></p>
        </div>