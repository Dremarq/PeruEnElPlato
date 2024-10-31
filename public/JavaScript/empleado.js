
document.addEventListener('DOMContentLoaded', function() {
    // Función para abrir el modal de modificar empleado
    window.abrirModalModificarEmpleado = function(id, nombre, apellido, dni, telefono, email, rol) {
        document.getElementById('id_empleado').value = id;
        document.getElementById('nombreModificar').value = nombre;
        document.getElementById('apellidoModificar').value = apellido;
        document.getElementById('dniModificar').value = dni;
        document.getElementById('telefonoModificar').value = telefono;
        document.getElementById('emailModificar').value = email;
        document.getElementById('rolModificar').value = rol;

        var modificarEmpleadoModal = new bootstrap.Modal(document.getElementById('modificarEmpleadoModal'));
        modificarEmpleadoModal.show();
    }

});

function eliminarempleados() {
    var respuesta = confirm("¿Estás seguro que deseas eliminar?");
    return respuesta;
}
