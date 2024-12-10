
  // Inicializamos el carrito como un array vacío
  let carrito = [];

  // Función para agregar un plato al carrito
  function agregarAlCarrito(id, nombre, precio) {
    // Buscamos si el plato ya está en el carrito
    const platoExistente = carrito.find(plato => plato.id === id);
    
    if (platoExistente) {
      // Si ya está en el carrito, incrementamos la cantidad
      platoExistente.cantidad += 1;
    } else {
      // Si no está en el carrito, lo añadimos como un nuevo elemento
      carrito.push({
        id: id,
        nombre: nombre,
        precio: parseFloat(precio),
        cantidad: 1
      });
    }
    actualizarCarrito();
  }

  // Función para actualizar el contenido del carrito en el modal
  function actualizarCarrito() {
    const carritoList = document.getElementById('carrito-list');
    const totalElement = document.getElementById('total');
    carritoList.innerHTML = ''; // Limpiamos la lista del carrito

    let total = 0;

    carrito.forEach(plato => {
      // Creamos un elemento para cada plato en el carrito
      const li = document.createElement('li');
      li.className = 'list-group-item d-flex justify-content-between align-items-center';
      li.innerHTML = `
        ${plato.nombre} - s/.${(plato.precio * plato.cantidad).toFixed(2)} 
        <span>
          <button class="btn btn-sm btn-danger quitar-carrito" data-id="${plato.id}">-</button>
          x${plato.cantidad}
        </span>
      `;
      carritoList.appendChild(li);

      total += plato.precio * plato.cantidad; // Sumamos el precio total
    });

    totalElement.textContent = `Total: s/.${total.toFixed(2)}`;
  }

  // Evento para manejar el botón "Agregar al carrito"
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('agregar-carrito')) {
      const id = e.target.getAttribute('data-id');
      const nombre = e.target.closest('li').textContent.split(' - ')[0].trim();
      const precio = e.target.closest('li').textContent.split('s/.')[1].trim();
      agregarAlCarrito(id, nombre, precio);
    }
  });

  // Evento para manejar el botón "Quitar del carrito"
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('quitar-carrito')) {
      const id = e.target.getAttribute('data-id');
      carrito = carrito.filter(plato => {
        if (plato.id === id) {
          if (plato.cantidad > 1) {
            plato.cantidad -= 1;
            return true;
          }
          return false;
        }
        return true;
      });
      actualizarCarrito();
    }
  });

  // Evento para abrir el carrito modal
  document.getElementById('ver-carrito').addEventListener('click', function() {
    const carritoModal = new bootstrap.Modal(document.getElementById('carritoModal'));
    carritoModal.show();
  });

  // Evento para realizar la compra (puedes personalizar esta parte)
  document.getElementById('comprar').addEventListener('click', function() {
    if (carrito.length > 0) {
        // Guardar el carrito en la sesión
        fetch('guardar_carrito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(carrito)
        }).then(response => {
            if (response.ok) {
                window.location.href = 'pagos.php'; 
            } else {
                alert('Error al guardar el carrito. Intenta de nuevo.');
            }
        });
    } else {
        alert('Tu carrito está vacío');
    }
});