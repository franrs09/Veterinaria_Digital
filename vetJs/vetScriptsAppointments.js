let serviciosDisponibles = [];
let fechasOcupadas = [];
let horariosOcupados = [];

document.addEventListener("DOMContentLoaded", function() {
    const formCita = document.getElementById('formCita');
    const contenedorResultados = document.getElementById('resultadosCitas');

    if (formCita) {
        inicializarPantallaAgendar();
    }

    if (contenedorResultados) {
        inicializarPantallaConsultar();
    }
});

// --- Pantalla Agendar Cita ---
function inicializarPantallaAgendar() {
    console.log("Inicializando pantalla de agendamiento...");
    cargarServicios();
    configurarFormularioCitas();
    configurarSelectorFecha();
}

// Cargar servicios desde la base de datos
function cargarServicios() {
    fetch('vetPHP/obtener_servicios.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                serviciosDisponibles = data.servicios;
                llenarSelectServicios();
            } else {
                console.error('Error cargando servicios:', data.mensaje);
                // Si no hay servicios en BD, usar servicios predefinidos
                usarServiciosPredefinidos();
            }
        })
        .catch(error => {
            console.error('Error en peticion de servicios:', error);
            usarServiciosPredefinidos();
        });
}

// Usar servicios predefinidos si no se pueden cargar desde BD
function usarServiciosPredefinidos() {
    serviciosDisponibles = [
        {nombre: 'Consulta general', precio: '15000'},
        {nombre: 'Vacunación', precio: '12000'},
        {nombre: 'Desparasitación', precio: '8000'},
        {nombre: 'Estética', precio: '20000'},
        {nombre: 'Cirugía', precio: '50000'},
        {nombre: 'Control', precio: '10000'}
    ];
    llenarSelectServicios();
}

function llenarSelectServicios() {
    const selectServicio = document.getElementById('servicio');
    if (!selectServicio) return;
    
    while (selectServicio.children.length > 1) {
        selectServicio.removeChild(selectServicio.lastChild);
    }
    
    serviciosDisponibles.forEach(servicio => {
        const option = document.createElement('option');
        option.value = servicio.nombre;
        option.textContent = servicio.nombre;
        if (servicio.precio) {
            option.textContent += ` - ₡${servicio.precio}`;
        }
        selectServicio.appendChild(option);
    });
}

function configurarFormularioCitas() {
    const formCita = document.getElementById('formCita');
    if (!formCita) return;
    
    formCita.addEventListener('submit', function(evento) {
        evento.preventDefault(); // Evitar envio normal del form
        procesarFormularioCita();
    });
    configurarValidacionesCampos();
}

// Configurar validaciones de campos individuales
function configurarValidacionesCampos() {
    const telefono = document.getElementById('telefono');
    if (telefono) {
        telefono.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
        });
    }
    
    // Validacion de email
    const email = document.getElementById('email');
    if (email) {
        email.addEventListener('blur', function() {
            if (this.value && !validarEmail(this.value)) {
                this.classList.add('is-invalid');
                mostrarMensajeError('Email no válido');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
    
    // Configurar selector de tipo de mascota
    const tipoMascota = document.getElementById('tipoMascota');
    if (tipoMascota) {
        tipoMascota.addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
    }
}

// Configurar el selector de fecha con restricciones
function configurarSelectorFecha() {
    const fechaCita = document.getElementById('fechaCita');
    if (!fechaCita) return;
    
    const hoy = new Date();
    const fechaMinima = hoy.toISOString().slice(0, 16);
    fechaCita.min = fechaMinima;

    const fechaMaxima = new Date();
    fechaMaxima.setDate(fechaMaxima.getDate() + 30);
    fechaCita.max = fechaMaxima.toISOString().slice(0, 16);
    
    // Validar fecha y hora cuando se selecciona
    fechaCita.addEventListener('change', function() {
        if (this.value) {
            const esValida = validarFechaYHorario(this.value);
            if (!esValida) {
                this.value = '';
                return;
            }
            verificarDisponibilidad(this.value);
        }
    });
    
    cargarDisponibilidad();
}

// Cargar disponibilidad desde el servidor
function cargarDisponibilidad() {
    fetch('vetPHP/obtener_disponibilidad.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fechasOcupadas = data.fechas_ocupadas || [];
                const horarios = data.horarios_ocupados || [];
                horariosOcupados = horarios.map(h => (h || '').toString().slice(0,5));
                console.log('Disponibilidad cargada');
            }
        })
        .catch(error => {
            console.error('Error cargando disponibilidad:', error);
        });
}

function verificarDisponibilidad(fechaHora) {
    const fecha = fechaHora.split('T')[0];
    const hora = fechaHora.split('T')[1];
    
    // Verificar si la fecha esta completamente ocupada
    if (fechasOcupadas.includes(fecha)) {
        mostrarMensajeError('Esta fecha está completamente ocupada. Seleccione otra fecha.');
        return false;
    }
    
    const hoy = new Date().toISOString().slice(0, 10);
    if (fecha === hoy && horariosOcupados.includes(hora)) {
        mostrarMensajeError('Este horario ya está ocupado. Seleccione otro horario.');
        return false;
    }
    
    return true;
}

function validarFechaYHorario(fechaHora) {
    if (!fechaHora) return false;
    
    // Separar fecha y hora
    const [fecha, hora] = fechaHora.split('T');
    const fechaSeleccionada = new Date(fechaHora);
    const hoy = new Date();
    
    // Validar que no sea una fecha pasada
    if (fechaSeleccionada < hoy) {
        mostrarMensajeError('No se pueden agendar citas en fechas pasadas.');
        return false;
    }
    
    // Validar que no sea domingo (0 = domingo)
    const diaSemana = fechaSeleccionada.getDay();
    if (diaSemana === 0) {
        mostrarMensajeError('No atendemos los domingos. Por favor seleccione otro día.');
        return false;
    }
    
    // Validar horarios laborales: 8:00-11:00 AM y 2:00-5:00 PM
    if (!validarHorarioLaboral(hora)) {
        mostrarMensajeError('Horario no válido. Los horarios disponibles son:\n• Mañana: 8:00 AM - 11:00 AM\n• Tarde: 2:00 PM - 5:00 PM');
        return false;
    }
    
    return true;
}

function validarHorarioLaboral(horaString) {
    if (!horaString) return false;
    
    // Convertir hora a minutos para facilitar comparacion
    const [horas, minutos] = horaString.split(':').map(Number);
    const tiempoEnMinutos = (horas * 60) + minutos;
    
    // 8:00 AM (480 min) - 11:00 AM (660 min)
    const inicioManana = 8 * 60;  // 480 minutos
    const finManana = 11 * 60;    // 660 minutos
    
    // 2:00 PM (840 min) - 5:00 PM (1020 min)
    const inicioTarde = 14 * 60;  // 840 minutos (2:00 PM)
    const finTarde = 17 * 60;     // 1020 minutos (5:00 PM)
    
    // Verificar si esta en alguno de los rangos permitidos
    const esHorarioManana = tiempoEnMinutos >= inicioManana && tiempoEnMinutos <= finManana;
    const esHorarioTarde = tiempoEnMinutos >= inicioTarde && tiempoEnMinutos <= finTarde;
    
    return esHorarioManana || esHorarioTarde;
}

function procesarFormularioCita() {
    console.log("Procesando formulario de cita...");
    const datosCita = recopilarDatosFormulario();
    if (!validarDatosCita(datosCita)) {
        return;
    }
    mostrarCargando(true);
    
    enviarCitaServidor(datosCita);
}

function recopilarDatosFormulario() {
    return {
        nombreDueno: document.getElementById('nombreDueno').value.trim(),
        telefono: document.getElementById('telefono').value.trim(),
        email: document.getElementById('email').value.trim(),
        nombreMascota: document.getElementById('nombreMascota').value.trim(),
        tipoMascota: document.getElementById('tipoMascota').value,
        raza: document.getElementById('raza').value.trim(),
        edad: document.getElementById('edad').value.trim(),
        fechaCita: document.getElementById('fechaCita').value,
        servicio: document.getElementById('servicio').value,
        motivo: document.getElementById('motivo').value.trim(),
        alergias: document.getElementById('alergias').value.trim()
    };
}
function validarDatosCita(datos) {
    const camposObligatorios = [
        'nombreDueno', 'telefono', 'nombreMascota', 
        'tipoMascota', 'fechaCita', 'servicio', 'motivo'
    ];
    
    for (let campo of camposObligatorios) {
        if (!datos[campo]) {
            mostrarMensajeError(`El campo ${campo} es obligatorio`);
            document.getElementById(campo).focus();
            return false;
        }
    }
    
    // Validar telefono: 8 DIGITOS
    if (datos.telefono.length !== 8 || !/^\d{8}$/.test(datos.telefono)) {
        mostrarMensajeError('El teléfono debe tener exactamente 8 dígitos numéricos.');
        document.getElementById('telefono').focus();
        return false;
    }
    
    // Validar email
    if (datos.email && !validarEmail(datos.email)) {
        mostrarMensajeError('El email no tiene un formato válido');
        document.getElementById('email').focus();
        return false;
    }
    
    // Validar fecha y horario laboral
    if (!validarFechaYHorario(datos.fechaCita)) {
        return false;
    }
    
    // Validar disponibilidad en el servidor
    if (!verificarDisponibilidad(datos.fechaCita)) {
        return false;
    }
    
    return true;
}

// Enviar cita al servidor
function enviarCitaServidor(datos) {
    fetch('vetPHP/agendar_cita.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(resultado => {
        mostrarCargando(false);
        
        if (resultado.success) {
            // Mostrar mensaje de exito con opcion de ver citas
            mostrarMensajeExitoConEnlace('¡Cita agendada exitosamente!', resultado.cita_id);
            limpiarFormulario();
            cerrarModal();
        } else {
            mostrarMensajeError(resultado.mensaje || 'Error al agendar cita');
        }
    })
    .catch(error => {
        mostrarCargando(false);
        console.error('Error:', error);
        mostrarMensajeError('Error de conexión. Inténtelo nuevamente.');
    });
}

// --- Pantalla Consultar Citas ---
function inicializarPantallaConsultar() {
    console.log("Inicializando pantalla de consulta de citas...");
    const fechaDesde = document.getElementById('fechaDesde');
    const fechaHasta = document.getElementById('fechaHasta');
    const btnBuscar = document.getElementById('btnBuscarCitas');
    const estadoFiltro = document.getElementById('estadoFiltro');

    if (fechaDesde && fechaHasta) {
        const hoy = new Date();
        const semanaProxima = new Date();
        semanaProxima.setDate(hoy.getDate() + 7);
        fechaDesde.value = hoy.toISOString().split('T')[0];
        fechaHasta.value = semanaProxima.toISOString().split('T')[0];
    }

    // Eventos de búsqueda
    if (btnBuscar) {
        btnBuscar.addEventListener('click', function(e) {
            e.preventDefault();
            buscarCitas();
        });
    }
    if (fechaDesde) fechaDesde.addEventListener('change', buscarCitas);
    if (fechaHasta) fechaHasta.addEventListener('change', buscarCitas);
    if (estadoFiltro) estadoFiltro.addEventListener('change', buscarCitas);
    buscarCitas();
}

// Buscar citas en el servidor
function buscarCitas() {
    const fechaDesde = document.getElementById('fechaDesde')?.value || '';
    const fechaHasta = document.getElementById('fechaHasta')?.value || '';
    const estado = document.getElementById('estadoFiltro')?.value || 'todas';

    const resultados = document.getElementById('resultadosCitas');
    if (!resultados) return;

    resultados.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando citas...</div>';

    const params = new URLSearchParams({
        fecha_desde: fechaDesde,
        fecha_hasta: fechaHasta,
        estado: estado
    });

    fetch(`vetPHP/consultar_citas.php?${params}`)
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                mostrarCitas(data.citas || []);
            } else {
                mostrarError(data.mensaje || 'No fue posible consultar las citas.');
            }
        })
        .catch(err => {
            console.error(err);
            mostrarError('Error de conexión');
        });
}

function mostrarCitas(citas) {
    const contenedor = document.getElementById('resultadosCitas');
    if (!contenedor) return;

    if (!citas.length) {
        contenedor.innerHTML = '<div class="alert alert-info">No se encontraron citas para los criterios seleccionados.</div>';
        return;
    }

    let html = `<h5 class="mb-3">Total de citas encontradas: ${citas.length}</h5><div class="row g-3">`;
    citas.forEach(cita => {
        html += `
            <div class="col-12 col-md-6">
                <div class="card cita-card estado-${cita.estado}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-calendar"></i>
                                ${cita.fecha_formateada} - ${cita.hora_formateada}
                            </h6>
                            <span class="badge bg-${obtenerColorEstado(cita.estado)}">${cita.estado.toUpperCase()}</span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <strong>Dueño:</strong><br>
                                ${cita.dueno}<br>
                                <i class="fas fa-phone"></i> ${cita.telefono}
                            </div>
                            <div class="col-6">
                                <strong>Servicio:</strong><br>
                                ${cita.servicio}<br>
                                <span class="text-success fw-bold">${cita.precio_formateado}</span>
                            </div>
                        </div>
                        <div class="mascota-info mt-2">
                            <strong><i class="fas fa-paw"></i> Mascota:</strong> ${cita.mascota} (${cita.tipo_mascota})
                        </div>
                        <div class="mt-2">
                            <strong>Motivo:</strong><br>
                            <small>${cita.motivo_consulta}</small>
                        </div>
                    </div>
                </div>
            </div>`;
    });
    html += '</div>';
    contenedor.innerHTML = html;
}

function obtenerColorEstado(estado) {
    const colores = {
        'pendiente': 'warning',
        'confirmada': 'success',
        'completada': 'primary',
        'cancelada': 'danger'
    };
    return colores[estado] || 'secondary';
}

function mostrarError(mensaje) {
    const contenedor = document.getElementById('resultadosCitas');
    if (contenedor) {
        contenedor.innerHTML = `<div class="alert alert-danger">Error: ${mensaje}</div>`;
    } else {
        mostrarMensajeError(mensaje);
    }
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function mostrarMensajeError(mensaje) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje
        });
    } else {
        alert('Error: ' + mensaje);
    }
}

function mostrarMensajeExito(mensaje) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: mensaje
        });
    } else {
        alert(mensaje);
    }
}

function mostrarMensajeExitoConEnlace(mensaje, citaId) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¡Excelente!',
            html: `
                <div class="text-center">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    <p class="mt-3">${mensaje}</p>
                    <p><strong>Número de cita: ${citaId}</strong></p>
                    <p class="text-muted">¿Desea consultar todas las citas agendadas?</p>
                </div>
            `,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-calendar-alt me-2"></i>Ver Citas',
            cancelButtonText: 'Cerrar',
            allowOutsideClick: false
        }).then((resultado) => {
            if (resultado.isConfirmed) {
                window.location.href = 'ver_citas.html';
            }
        });
    } else {
        const respuesta = confirm(`${mensaje}\nNúmero de cita: ${citaId}\n\n¿Desea consultar todas las citas agendadas?`);
        if (respuesta) {
            window.location.href = 'ver_citas.html';
        }
    }
}

function mostrarCargando(mostrar) {
    const btnSubmit = document.querySelector('#formCita button[type="submit"]');
    if (btnSubmit) {
        if (mostrar) {
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        } else {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Agendar Cita';
        }
    }
}

function limpiarFormulario() {
    const form = document.getElementById('formCita');
    if (form) {
        form.reset();
        // Remover clases de validacion
        const inputs = form.querySelectorAll('.is-invalid');
        inputs.forEach(input => input.classList.remove('is-invalid'));
    }
}

function cerrarModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCita'));
    if (modal) {
        modal.hide();
    }
}
