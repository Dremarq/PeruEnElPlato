function showSection(section) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.section');
    sections.forEach(sec => {
        sec.style.display = 'none';
    });

    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(section);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }
}
//clientes crud//
function editarCliente(cliente) {
    // Encuentra la fila correspondiente al cliente
    const filas = document.querySelectorAll('#lista-clientes tr');
    filas.forEach(fila => {
        const nombreCliente = fila.cells[0].innerText;
        if (nombreCliente === cliente) {
            // Obtiene los valores actuales
            const dni = fila.cells[1].innerText;
            const correo = fila.cells[2].innerText;
            const telefono = fila.cells[3].innerText;

            // Crea un formulario para editar
            const nuevoNombre = prompt("Editar Nombre de Cliente:", nombreCliente);
            const nuevoDNI = prompt("Editar DNI:", dni);
            const nuevoCorreo = prompt("Editar Correo:", correo);
            const nuevoTelefono = prompt("Editar Teléfono:", telefono);

            // Si el usuario no cancela, actualiza la fila
            if (nuevoNombre && nuevoDNI && nuevoCorreo && nuevoTelefono) {
                fila.cells[0].innerText = nuevoNombre;
                fila.cells[1].innerText = nuevoDNI;
                fila.cells[2].innerText = nuevoCorreo;
                fila.cells[3].innerText = nuevoTelefono;
            }
        }
    });
}
// Función para borrar un cliente
function borrarCliente(cliente) {
    const filas = document.querySelectorAll('#lista-clientes tr');
    filas.forEach(fila => {
        const nombreCliente = fila.cells[0].innerText;
        if (nombreCliente === cliente) {
            if (confirm('¿Estás seguro de que deseas borrar a ' + cliente + '?')) {
                fila.remove(); // Elimina la fila de la tabla
                alert(cliente + ' ha sido borrado.');
            }
        }
    });
}
/////////////////////////////////////////////
// Empleados crud //
function editarEmpleado(empleado) {
    // Encuentra la fila correspondiente al empleado
    const filas = document.querySelectorAll('#lista-empleados tr');
    filas.forEach(fila => {
        const nombreEmpleado = fila.cells[0].innerText;
        if (nombreEmpleado === empleado) {
            // Obtiene los valores actuales
            const dni = fila.cells[1].innerText;
            const correo = fila.cells[2].innerText;
            const telefono = fila.cells[3].innerText;

            // Crea un formulario para editar
            const nuevoNombre = prompt("Editar Nombre de Empleado:", nombreEmpleado);
            const nuevoDNI = prompt("Editar DNI:", dni);
            const nuevoCorreo = prompt("Editar Correo:", correo);
            const nuevoTelefono = prompt("Editar Teléfono:", telefono);

            // Si el usuario no cancela, actualiza la fila
            if (nuevoNombre && nuevoDNI && nuevoCorreo && nuevoTelefono) {
                fila.cells[0].innerText = nuevoNombre;
                fila.cells[1].innerText = nuevoDNI;
                fila.cells[2].innerText = nuevoCorreo;
                fila.cells[3].innerText = nuevoTelefono;
            }
        }
    });
}
// Función para borrar un empleado
function borrarEmpleado(empleado) {
    const filas = document.querySelectorAll('#lista-Empleados tr');
    filas.forEach(fila => {
        const nombreEmpleado = fila.cells[0].innerText;
        if (nombreEmpleado === empleado) {
            if (confirm('¿Estás seguro de que deseas borrar a ' + empleado + '?')) {
                fila.remove(); // Elimina la fila de la tabla
                alert(empleado + ' ha sido borrado.');
            }
        }
    });
}
// Función para agregar un nuevo empleado
function agregarEmpleado(event) {
    event.preventDefault(); // Evita que el formulario se envíe de la forma tradicional

    // Obtiene los valores del formulario
    const nombre = document.getElementById('nombre-empleado').value;
    const dni = document.getElementById('dni-empleado').value;
    const telefono = document.getElementById('telefono-empleado').value;
    const codigo = document.getElementById('codigo-empleado').value;

    // Crea una nueva fila en la tabla de empleados
    const nuevaFila = document.createElement('tr');
    nuevaFila.innerHTML = `
        <td>${nombre}</td>
        <td>${dni}</td>
        <td>${telefono}</td>
        <td>${codigo}</td>
        <td>
            <button onclick="editarEmpleado('${nombre}')">Editar</button>
            <button onclick="borrarEmpleado('${nombre}')">Borrar</button>
        </td>
    `;

    // Agrega la nueva fila al cuerpo de la tabla
    document.getElementById('lista-empleados').appendChild(nuevaFila);

    // Limpia el formulario
    document.getElementById('form-agregar-empleado').reset();
}