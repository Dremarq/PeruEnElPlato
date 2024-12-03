
        function abrirModalModificar(idAlmacen, idProducto, nombreProducto, stockActual, stockMinimo) {
            // Asignar los valores a los campos del modal
            document.getElementById('id_almacen').value = idAlmacen;

            document.getElementById('stock_actual_modificar').value = stockActual;
            document.getElementById('stock_minimo_modificar').value = stockMinimo;

            // Mostrar el modal
            var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
            modificarModal.show();
        }

        function eliminarProductoDeAlmacen() {
            return confirm("¿Estás seguro que deseas eliminar este producto del almacén?");
        }
    
    
        function preventNegativeValue(input) {
            if (input.value < 0) {
                input.value = 0; // Si el valor es menor a 0, se establece en 0
            }
        }

        function validateStock(stockActualInput, stockMinimoInput) {
            const stockActual = parseInt(stockActualInput.value);
            const stockMinimo = parseInt(stockMinimoInput.value);

            if (stockActual > stockMinimo) {
                alert("El stock actual no puede ser mayor que el stock mínimo. Se ajustará al stock mínimo.");
                stockActualInput.value = stockMinimo; // Ajustar el stock actual al stock mínimo
            }
        }

        // Aplicar la función a los campos de registro
        const stockActual = document.getElementById('stock_actual');
        const stockMinimo = document.getElementById('stock_minimo');

        stockActual.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActual, stockMinimo);
        });

        stockMinimo.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActual, stockMinimo);
        });

        // Aplicar la función a los campos de modificación
        const stockActualModificar = document.getElementById('stock_actual_modificar');
        const stockMinimoModificar = document.getElementById('stock_minimo_modificar');

        stockActualModificar.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActualModificar, stockMinimoModificar);
        });

        stockMinimoModificar.addEventListener('input', function() {
            preventNegativeValue(this);
            validateStock(stockActualModificar, stockMinimoModificar);
        });
   