function emailValidation() {
    let btnIniciar = document.getElementById("btnLogin");
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    btnIniciar.addEventListener("click", function (e) {
        let email = document.getElementById("uMail").value;
        if (!emailPattern.test(email)) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Por ingrese un correo válido",
            });
            return false;
        } else {
            e.preventDefault();
            Swal.fire({
                title: "¡Bienvenido!",
                icon: "success",
            }).then(() => {
                // Enviar el formulario después de mostrar el mensaje
                btnIniciar.closest('form').submit();
            });
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    emailValidation();
});