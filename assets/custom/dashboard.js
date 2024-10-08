

$(document).ready(function() {
    $.ajax({
        url: base_url+'admin/get_statisc_support', // Replace with the path to your server-side endpoint
        method: 'GET', // Or 'POST' if you're sending data to the server
        dataType: 'json',
        success: function(response) {
            var ctx = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.labels, // Data from the server
                    datasets: [{
                        label: 'تكرارات الطرود',
                        data: response.data, // Data from the server
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', status, error);
        }
    });

    $.ajax({
        url: base_url+'admin/get_statisc_supplier', // Replace with your server endpoint
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Prepare data for the chart
            var labels = response.labels; // e.g., ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
            var data = response.data; // e.g., [12, 19, 3, 5, 2, 3]

            var ctx = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# الديون', // Change label as needed
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch data:', error);
        }
    });

    $.ajax({
        url: base_url+'admin/get_statisc_association', // Replace with your server endpoint
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Prepare data for the chart
            var labels = response.labels; // e.g., ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
            var data = response.data; // e.g., [12, 19, 3, 5, 2, 3]

            var ctx = document.getElementById('doughnutChart').getContext('2d');
            var doughnutChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'مبالغ مستحقة من المانحين',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch data:', error);
        }
    });
});
