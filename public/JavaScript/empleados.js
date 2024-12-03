function abrirModalModificarEmpleado(id, nombre, apellido, dni, telefono, email, direccion, fecha_contratacion, id_rol) {
    document.getElementById('id_empleado').value = id;
    document.getElementById('nombreModificar').value = nombre;
    document.getElementById('apellidoModificar').value = apellido;
    document.getElementById('dniModificar').value = dni;
    document.getElementById('telefonoModificar').value = telefono;
    document.getElementById('emailModificar').value = email;
    document.getElementById('direccionModificar').value = direccion;
    document.getElementById('fecha_contratacionModificar').value = fecha_contratacion;
    document.getElementById('rolModificar').value = id_rol; // Asigna el rol al campo correspondiente

    // Mostrar el modal
    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
    modificarModal.show();
}

function validarNombreApellido(input) {
    // Eliminar caracteres no válidos (números y caracteres especiales)
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');

    // Capitalizar la primera letra de cada palabra
    input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nombreModificar').addEventListener('input', function() {
        validarNombreApellido(this);
    });

    document.getElementById('apellidoModificar').addEventListener('input', function() {
        validarNombreApellido(this);
    });
});

function validarDNI(input) {
    // Eliminar caracteres no válidos (solo permitir números)
    input.value = input.value.replace(/[^0-9]/g, '');

    // Limitar a 8 dígitos
    if (input.value.length > 8) {
        input.value = input.value.slice(0, 8); // Cortar a los primeros 8 dígitos
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('dniModificar').addEventListener('input', function() {
        validarDNI(this);
    });
});

function validarTelefono(input) {
    // Eliminar caracteres no válidos (solo permitir números)
    input.value = input.value.replace(/[^0-9]/g, '');

    // Verificar que el primer dígito sea 9 y limitar a 9 dígitos
    if (input.value.length > 9) {
        input.value = input.value.slice(0, 9); // Cortar a los primeros 9 dígitos
    }

    // Asegurarse de que el primer dígito sea 9
    if (input.value.length === 1 && input.value !== '9') {
        input.value = ''; // Limpiar el campo si no empieza con 9
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('telefonoModificar').addEventListener('input', function() {
        validarTelefono(this);
    });
});

function validarEmail(input) {
    // Expresión regular para validar el formato del correo electrónico
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(input.value)) {
        input.setCustomValidity("Por favor ingrese un correo electrónico válido.");
    } else {
        input.setCustomValidity(""); // Restablecer el mensaje de error
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('emailModificar').addEventListener('input', function() {
        validarEmail(this);
    });
});

function validarDireccion(input) {
    // No se permiten caracteres especiales, solo letras, números y espacios
    input.value = input.value.replace(/[^A-Za-z0-9\s,.]/g, '');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('direccionModificar').addEventListener('input', function() {
        validarDireccion(this);
    });
});