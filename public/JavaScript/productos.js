function abrirModalModificarProducto(id, nombre, descripcion, costo, id_proveedor) {
    document.getElementById('id_producto').value = id;
    document.getElementById('nombreModificar').value = nombre;
    document.getElementById('descripcionModificar').value = descripcion;
    document.getElementById('costoModificar').value = costo;

    // Asignar el ID del proveedor al campo de selección
    document.getElementById('id_proveedorModificar').value = id_proveedor;

    // Mostrar el modal
    var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
    modificarModal.show();
}

function eliminarProducto() {
    return confirm("¿Estás seguro que deseas eliminar este producto?");
}
function preventNegativeValue(input) {
    if (input.value < 0) {
        input.value = 0; // Si el valor es menor a 0, se establece en 0
    }
}

// Aplicar la función a los campos de cantidad y precio unitario
const costo = document.getElementById('costo');


costo.addEventListener('input', function() {
    preventNegativeValue(this);
});


const costoModal = document.getElementById('costoModificar');


costoModal.addEventListener('input', function() {
    preventNegativeValue(this);
});
// Función para validar el nombre del producto
function validarNombreProducto(nombre) {
    // Expresión regular para validar el nombre
    const regex = /^[a-zA-Z0-9\s]+$/; // Permitir solo letras, números y espacios
    return regex.test(nombre);
}

// Evento para validar el formulario de modificación
document.querySelector('form[action="../controlador/CRUDproductos.php"]').addEventListener('submit', function(event) {
    const nombre = document.getElementById('nombreModificar').value;

    if (!validarNombreProducto(nombre)) {
        alert("El nombre del producto es inválido. Solo se permiten letras, números y espacios.");
        event.preventDefault(); // Evitar que se envíe el formulario
        return;
    }

    // Puedes agregar más validaciones aquí si es necesario
});