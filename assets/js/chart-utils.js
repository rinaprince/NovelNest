import Chart from 'chart.js/auto';

export const prepareChartData = (users) => {
    const initialsCount = {};

    users.forEach(user => {
        const initial = user.nom.charAt(0).toUpperCase();
        if (initialsCount[initial]) {
            initialsCount[initial]++;
        } else {
            initialsCount[initial] = 1;
        }
    });

    return {
        labels: Object.keys(initialsCount),
        datasets: [{
            label: 'Usuarios por Inicial',
            data: Object.values(initialsCount),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(0, 255, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(0, 255, 255, 1)'
            ],
            borderWidth: 1
        }]
    };
};

export const renderChart = (data) => {
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Usuarios por inicial'
                }
            }
        }
    });
};