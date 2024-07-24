<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title !== "" ? $title : 'Animal System'}}</title>
    <link href="{{ asset('/build/assets/app-83f76dfa.css') }}" rel="stylesheet">
    <script src="{{ asset('/build/assets/app-a5991337.js') }}"></script>
    @vite('resources/css/app.css')

    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="">

<?php $array = array('title' => 'Veterinary Dashboard'); ?>
<x-nav :data="$array" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<div class="flex flex-col bg-gradient-to-t from-gray-900 to-white p-5">

<div class="flex flex-col md:flex-row justify-between mt-10">
        <!-- Species Chart -->
        <div class="w-full md:w-1/2 p-2">
            <canvas id="speciesChart"></canvas>
        </div>
        <!-- Line Chart -->
        <div class="w-full md:w-1/1 p-2">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow mb-32">
        <div class="container mx-auto py-8" style="padding: 0;">
            <!-- Cards Section -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-4">
                <!-- Card 1: Total Patients -->
                <div class="bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg shadow-lg p-6 text-white flex items-center">
                    <i class="fas fa-paw text-4xl mr-4"></i>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Total Patients</h2>
                        <p class="text-3xl">{{ $patientCount }}</p>
                    </div>
                </div>
                <!-- Card 2: Appointments Today -->
                <div class="bg-gradient-to-br from-green-400 to-blue-500 rounded-lg shadow-lg p-6 text-white flex items-center">
                    <i class="far fa-calendar-check text-4xl mr-4"></i>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Appointments Today</h2>
                        <p class="text-3xl">{{ $appointmentsCountToday }}</p>
                    </div>
                </div>
                <!-- Card 3: Total Rooms or Cages -->
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg shadow-lg p-6 text-white flex items-center">
                    <i class="fas fa-boxes text-4xl mr-4"></i>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Temporary Users</h2>
                        <p class="text-3xl">{{ $temporaryUsersCount }}</p>
                    </div>
                </div>
                <!-- Card 4: Total Staff -->
                <div class="bg-gradient-to-br from-pink-400 to-red-500 rounded-lg shadow-lg p-6 text-white flex items-center">
                    <i class="fas fa-users text-4xl mr-4"></i>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Admin Users</h2>
                        <p class="text-3xl">{{ $adminUsersCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

<script>
// Retrieve species counts from PHP and convert it to JavaScript object
const speciesCounts = {!! json_encode($speciesCounts) !!};

// Extract labels and data from species counts
const labels = speciesCounts.map(item => item.species.name); // Assuming species has a 'name' attribute
const data = speciesCounts.map(item => item.count);

// Define ColorBrewer colors for the chart
const colors = [
    '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', 
    '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'
];

// Doughnut Chart Configuration for Species Distribution
const speciesDistributionConfig = {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            label: 'Species Distribution',
            data: data,
            backgroundColor: colors,
            hoverOffset: 4
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'left', // Position legend on the right side
                labels: {
                    color: 'rgb(28, 31, 36)', // Change label font color to white
                    font: {
                        size: 12 // Adjust font size
                    }
                }
            }
        }
    }
};

    // Create Doughnut Chart for Species Distribution
    var speciesChartCtx = document.getElementById('speciesChart').getContext('2d');
    var speciesChart = new Chart(speciesChartCtx, speciesDistributionConfig);


    // Define common color
    const commonColor = 'rgba(19, 16, 56, 0.89)';

    // Line Chart Configuration
    const lineConfig = {
    type: 'line',
    data: {
        labels: {!! json_encode($appointmentsByMonth->keys()) !!}, // Extract month names as labels
        datasets: [{
            label: 'Appointments by Month',
            data: {!! json_encode($appointmentsByMonth->values()) !!}, // Extract appointment counts as data
            borderColor: 'rgb(28, 31, 36)', //guhit
            backgroundColor: 'rgb(129, 142, 163)', //tuldok
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Months',
                    color: commonColor
                },
                ticks: {
                    color: commonColor
                },
                grid: {
                    color: commonColor
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Number of Appointments',
                    color: commonColor
                },
                ticks: {
                    color: commonColor
                },
                grid: {
                    color: 'rgb(31, 32, 43)'
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: 'rgb(28, 31, 36)',
                }
            }
        }
    }
};

// Create Line Chart
var lineCtx = document.getElementById('lineChart').getContext('2d');
var lineChart = new Chart(lineCtx, lineConfig);
</script>
































