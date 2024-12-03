function abrirModalModificarProveedor(id, nombreEmpresa, ruc, telefono, email, direccion, estado) {
    // Asignar los valores a los campos del modal
    document.getElementById('id_proveedor').value = id;
    document.getElementById('nombre_empresaModificar').value = nombreEmpresa;
    document.getElementById('rucModificar').value = ruc;
    document.getElementById('telefonoModificar').value = telefono;
    document.getElementById('emailModificar').value = email;
    document.getElementById('direccionModificar').value = direccion;
    document.getElementById('estadoModificar').value = estado;

    // Mostrar el modal
    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
    modificarModal.show();
}
 
 // Función para validar el RUC
 function validarRUC(input) {
    // Eliminar caracteres no válidos (solo permitir números)
    input.value = input.value.replace(/[^0-9]/g, '');

    // Verificar que el RUC tenga exactamente 11 dígitos
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11); // Limitar a los primeros 11 dígitos
    }

    // Verificar que el RUC comience con 10, 20, 15 o 17
    const validPrefixes = ['10', '20', '15', '17'];
    const rucPrefix = input.value.substring(0, 2);

    if (input.value.length === 11 && !validPrefixes.includes(rucPrefix)) {
        alert("El RUC debe comenzar con 10, 20, 15 o 17.");
        input.value = ''; // Limpiar el campo si no cumple con la validación
    }
}

// Agregar evento al campo de RUC
document.getElementById('ruc').addEventListener('input', function() {
    validarRUC(this);
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
    document.getElementById('telefono').addEventListener('input', function() {
        validarTelefono(this);
    });
});
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('telefonoModificar').addEventListener('input', function() {
        validarTelefono(this);
    });
});
