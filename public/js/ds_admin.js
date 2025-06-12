import Chart from 'chart.js/auto';
const ctx = document.getElementById('chartLaporan').getContext('2d');
const chartLaporan = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['1 Oct', '8 Oct', '15 Oct', '22 Oct'],
        datasets: [{
            label: 'Jumlah Laporan',
            data: [40, 50, 70, 90],
            borderColor: 'blue',
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
