function abrirModalModificarUsuario(id_usuario, nombre, apellido, dni, telefono, email, direccion, usuario, contrasena) {
    document.getElementById('id_usuario').value = id_usuario;
    document.getElementById('nombreModificar').value = nombre;
    document.getElementById('apellidoModificar').value = apellido;
    document.getElementById('dniModificar').value = dni;
    document.getElementById('telefonoModificar').value = telefono;
    document.getElementById('emailModificar').value = email;
    document.getElementById('direccionModificar').value = direccion;
    document.getElementById('usuarioModificar').value = usuario;
    document.getElementById('contrasenaModificar').value = contrasena;


    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
    modificarModal.show();
}

// Función para formatear texto a mayúsculas y eliminar números
 function formatearTexto(input) {
    let valor = input.value;

    // Eliminar números
    valor = valor.replace(/[0-9]/g, '');

    // Convertir a mayúsculas y separar palabras
    valor = valor.split(' ').map(function(palabra) {
        return palabra.charAt(0).toUpperCase() + palabra.slice(1).toLowerCase();
    }).join(' ');

    // Asignar el valor formateado de nuevo al campo
    input.value = valor;
}

// Agregar evento al campo de nombre
document.getElementById('nombre').addEventListener('input', function(e) {
    formatearTexto(e.target);
});

// Agregar evento al campo de apellido
document.getElementById('apellido').addEventListener('input', function(e) {
    formatearTexto(e.target);
});
// Función para validar el DNI
function validarDNI(input) {
    // Eliminar caracteres no válidos (solo permitir números)
    input.value = input.value.replace(/[^0-9]/g, '');

    // Limitar a 8 dígitos
    if (input.value.length > 8) {
        input.value = input.value.slice(0, 8); // Cortar a los primeros 8 dígitos
    }
}

// Agregar evento al campo de DNI
document.getElementById('dni').addEventListener('input', function() {
    validarDNI(this);
});

// Función para validar el teléfono
function validarTelefono(input) {
    // Eliminar caracteres no válidos (solo permitir números)
    input.value = input.value.replace(/[^0-9]/g, '');

    // Limitar a 9 dígitos
    if (input.value.length > 9) {
        input.value = input.value.slice(0, 9); // Cortar a los primeros 9 dígitos
    }

    // Asegurarse de que el primer dígito sea 9
    if (input.value.length === 1 && input.value !== '9') {
        input.value = ''; // Limpiar el campo si no empieza con 9
    }
}

// Agregar evento al campo de teléfono
document.getElementById('telefono').addEventListener('input', function() {
    validarTelefono(this);
});