@include('partials.header')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <title>Animal Health Monitor</title>
    <style>
    .vital {
        margin-bottom: 20px;
        height: 200px;
        border: 1px solid #ccc;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 10px;
    }

    .vital:hover {
        transform: translateY(-5px);
    }

    .consult-button {
        text-align: center;
    }

    /* Add background to charts */
    canvas {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
     .row {
        margin-bottom: 20px;
    }
</style>

</head>
<body>
    <div class="container mt-5">
         <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">{{ $animal->name }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="vital">
                    <h2>Heart Rate</h2>
                    <p id="heart-rate-vital">Loading...</p>
                </div>
            </div>
            <div class="col-md-10">
                <div class="container-sm">
                    <canvas id="chart-heart-rate" width="800" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="vital">
                    <h2>Respiratory Rate</h2>
                    <p id="respiratory-rate-vital">Loading...</p>
                </div>
            </div>
            <div class="col-md-10">
                <div class="container-sm">
                    <canvas id="chart-respiratory-rate" width="800" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="vital">
                    <h2>Core Temperature</h2>
                    <p id="core-temp-vital">Loading...</p>
                </div>
            </div>
            <div class="col-md-10">
                <div class="container-sm">
                    <canvas id="chart-core-temp" width="800" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="consult-button mb-3">
                    @if(Auth::user()->category === 'Temporary User')
                        <button type="button" onclick="window.location.href='/consultation/{{ $animal->id }}'" class="btn btn-primary">Consult</button>
                    @elseif(Auth::user()->category === 'Admin User')
                        <a href="/animal/{{ $animal->id }}" class="btn btn-primary">Consult</a>
                    @endif
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-streaming"></script>

 <script>
    const heartRateThresholdHigh = {{ $thresholds['heartRateHighAlarm'] }};
    const coreTempThresholdHigh = {{ $thresholds['coreTempHighAlarm'] }};
    const respiratoryRateThresholdHigh = {{ $thresholds['respiratoryRateHighAlarm'] }};
    const heartRateThresholdLow = {{ $thresholds['heartRateLowAlarm'] }};
    const coreTempThresholdLow = {{ $thresholds['coreTempLowAlarm'] }};
    const respiratoryRateThresholdLow = {{ $thresholds['respiratoryRateLowAlarm'] }};

    console.log("Thresholds:", {
        heartRateThresholdHigh,
        coreTempThresholdHigh,
        respiratoryRateThresholdHigh,
        heartRateThresholdLow,
        coreTempThresholdLow,
        respiratoryRateThresholdLow
    });
 let alarmTriggered = {
        ecg: false,
        coreTemp: false,
        respiratoryRate: false
    };

    document.addEventListener('DOMContentLoaded', function () {
        var esp32 = "{{ $animal->esp32 }}"; 
        var animalId = "{{ $animal->id }}"; 
        var animalName = "{{ $animal->name }}";
        console.log(animalId);
          console.log(animalName);
        var apiUrl = "/api/ongoing/" + esp32;

        var heartRateChart, coreTempChart, respiratoryRateChart;

        function initCharts() {
            var heartRateCtx = document.getElementById('chart-heart-rate').getContext('2d');
            var coreTempCtx = document.getElementById('chart-core-temp').getContext('2d');
            var respiratoryRateCtx = document.getElementById('chart-respiratory-rate').getContext('2d');

            heartRateChart = new Chart(heartRateCtx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Heart Rate',
                        borderColor: 'red',
                        data: []
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'realtime',
                            realtime: {
                                duration: 20000,
                                refresh: 1000,
                                delay: 2000,
                                onRefresh: function(chart) {
                                    fetchDataAndUpdateUI(chart, 'ecg');
                                        fetchDataAndUpdateUI(chart, 'bpm');
                                }
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            coreTempChart = new Chart(coreTempCtx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Core Temperature',
                        borderColor: 'blue',
                        data: []
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'realtime',
                            realtime: {
                                duration: 20000,
                                refresh: 1000,
                                delay: 2000,
                                onRefresh: function(chart) {
                                    fetchDataAndUpdateUI(chart, 'coreTemp');
                                }
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            respiratoryRateChart = new Chart(respiratoryRateCtx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Respiratory Rate',
                        borderColor: 'green',
                        data: []
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'realtime',
                            realtime: {
                                duration: 20000,
                                refresh: 1000,
                                delay: 2000,
                                onRefresh: function(chart) {
                                    fetchDataAndUpdateUI(chart, 'respiratoryRate');
                                }
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function fetchDataAndUpdateUI(chart, type) {
            axios.get(apiUrl)
                .then(response => {
                    const data = response.data;
                    console.log("Data received:", data);

                    let value;
                    if (data && data.length > 0) {
                        const latestData = data[data.length - 1];
                        value = latestData[type] || 0;
                    } else {
                        value = 0;
                    }

                    chart.data.datasets.forEach(dataset => {
                        dataset.data.push({
                            x: Date.now(),
                            y: value
                        });
                    });

                    updateVitals(type, value);
                    checkThresholds(type, value);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);

                    chart.data.datasets.forEach(dataset => {
                        dataset.data.push({
                            x: Date.now(),
                            y: 0
                        });
                    });

                    updateVitals(type, 0);
                    checkThresholds(type, 0);
                });
        }
      
        function updateVitals(type, value) {
            if (type === 'bpm') {
                document.getElementById("heart-rate-vital").innerText = "Heart Rate: " + value;
            } else if (type === 'coreTemp') {
                document.getElementById("core-temp-vital").innerText = "Core Temperature: " + value;
            } else if (type === 'respiratoryRate') {
                document.getElementById("respiratory-rate-vital").innerText = "Respiratory Rate: " + value;
            }
        }

         function checkThresholds(type, value) {
        
                let alertMessage = '';
                let alertSound = '';

                if (type === 'ecg') {
                    if (value > heartRateThresholdHigh) {
                        alertMessage = 'Heart Rate is too high!';
                        alertSound = '/sounds/alarm.mp3';
                    } else if (value < heartRateThresholdLow) {
                        alertMessage = 'Heart Rate is too low!';
                        alertSound = '/sounds/alarm.mp3';
                    }
                } else if (type === 'coreTemp') {
                    if (value > coreTempThresholdHigh) {
                        alertMessage = 'Core Temperature is too high!';
                        alertSound = '/sounds/alarm.mp3';
                    } else if (value < coreTempThresholdLow) {
                        alertMessage = 'Core Temperature is too low!';
                        alertSound = '/sounds/alarm.mp3';
                    }
                } else if (type === 'respiratoryRate') {
                    if (value > respiratoryRateThresholdHigh) {
                        alertSound = '/sounds/alarm.mp3';
                    } else if (value < respiratoryRateThresholdLow) {
                        alertSound = '/sounds/alarm.mp3';
                    }
                }

                if (alertSound) {
                    // Set the alarm flag to true to prevent duplicate insertion
                    alarmTriggered[type] = true;

                    // Play sound and save alarm data
                    playSound(alertSound);
                    saveAlarmDataToDatabase(animalId, animalName, type, value); 
                }
         
        }

        function playSound(src) {
            var audio = new Audio(src);
            audio.play();
        }
  function saveAlarmDataToDatabase(animalId, animalName, type, value) {
       value = String(value);
            const alarmData = {
                animal_id: animalId,
                name: animalName,
                type: type,
                value: value,
                timestamp: new Date().toISOString() // Convert to ISO string format
            };

            // Log the data being sent
            console.log('Sending alarm data:', alarmData);

            axios.post('/api/alarm-data', alarmData)
                .then(response => {
                    console.log(response.data.message);
                })
                .catch(error => {
                    console.error('Error saving alarm data:', error);
                });
        }



        initCharts();
    });
</script>


@include('partials.footer')