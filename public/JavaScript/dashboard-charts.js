document.addEventListener('DOMContentLoaded', function () {
    // Gráfico de Ventas Mensuales
    var ventasCtx = document.getElementById('ventasChart').getContext('2d');
    var ventasChart = new Chart(ventasCtx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Ventas Mensuales',
                data: [12000, 19000, 15000, 22000, 18000, 25000],
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Ventas (S/.)'
                    }
                }
            }
        }
    });

    // Gráfico de Tipos de Pedidos
    var pedidosCtx = document.getElementById('pedidosChart').getContext('2d');
    var pedidosChart = new Chart(pedidosCtx, {
        type: 'pie',
        data: {
            labels: ['Dine-in', 'Delivery', 'Para Llevar'],
            datasets: [{
                data: [45, 30, 25],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
});