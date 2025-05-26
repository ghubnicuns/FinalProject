// salesChart.js

const ctx = document.getElementById('salesChart').getContext('2d');

// Format months nicely, e.g. "2025-05" → "May 2025"
function formatMonthLabel(ym) {
  const [year, month] = ym.split('-');
  const date = new Date(year, month - 1);
  return date.toLocaleString('default', { month: 'short', year: 'numeric' });
}

const labels = salesMonths.map(formatMonthLabel);

const data = {
  labels: labels,
  datasets: [{
    label: 'Sales (₱)',
    data: salesTotals,
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    tension: 0.3,
    pointRadius: 5,
    pointHoverRadius: 7,
    borderWidth: 3
  }]
};

const config = {
  type: 'line',
  data: data,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
        labels: {
          font: {
            size: 14,
            weight: 'bold'
          }
        }
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            return `₱ ${context.parsed.y.toFixed(2)}`;
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function(value) {
            return `₱${value}`;
          }
        },
        title: {
          display: true,
          text: 'Total Sales'
        }
      },
      x: {
        title: {
          display: true,
          text: 'Month'
        }
      }
    }
  }
};

const salesChart = new Chart(ctx, config);
