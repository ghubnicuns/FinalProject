// Product Inventory Bar Chart
const productChartCtx = document.getElementById('productChart').getContext('2d');
new Chart(productChartCtx, {
    type: 'bar',
    data: {
        labels: productNames,
        datasets: [{
            label: 'Product Quantity',
            data: productQuantities,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `Qty: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Low Stock Bar Chart
const lowStockChartCtx = document.getElementById('lowStockChart').getContext('2d');
new Chart(lowStockChartCtx, {
    type: 'bar',
    data: {
        labels: lowStockNames,
        datasets: [{
            label: 'Low Stock (≤ 20)',
            data: lowStockQuantities,
            backgroundColor: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `Qty: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Monthly Sales Line Chart
const salesChartCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesChartCtx, {
    type: 'line',
    data: {
        labels: salesMonths,
        datasets: [{
            label: 'Total Sales (₱)',
            data: salesTotals,
            fill: true,
            backgroundColor: 'rgba(75, 192, 192, 0.3)',
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.3,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => '₱' + value
                }
            }
        }
    }
});
