@include('partials.header')
<?php $array = array('title' => 'Student System'); ?>
<x-nav :data="$array" />
<x-messages/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitored Patients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .card {
            background: linear-gradient(45deg, #001f3f, #003366); /* Navy blue gradient */
            border-radius: 30px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.2); /* Increased box shadow */
            width: 1000px; /* Increased width */
            padding: 60px; /* Increased padding */
            margin: 0 30px; /* Increased margin */
            text-align: center;
            color: #fff;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px); /* Increased transform */
        }

        .card h2 {
            margin-top: 0;
            font-size: 36px; /* Increased font size */
        }

        .card p {
            font-size: 24px; /* Increased font size */
            margin-bottom: 40px; /* Increased margin */
        }

        .btn {
            background-color: #fff;
            color: #333;
            border: none;
            padding: 20px 40px; /* Increased padding */
            border-radius: 16px; /* Increased border radius */
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #e0e0e0;
        }

        .button-group {
            display: flex;
            justify-content: center;
        }

        .button-group button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Patient 1</h2>
    @foreach ($monitoringsCard1 as $monitoring)
    <div>
        <p>Animal Name: {{ strtoupper($monitoring->name) }}</p>
        <div class="button-group">
            <form id="viewForm_1" action="{{ route('ongoing', ['animal' => $monitoring->animal_id]) }}" method="POST">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $monitoring->animal_id }}">
                <button type="submit" class="btn btn-primary">View</button>
            </form>
            @if(Auth::user()->category === 'Admin User')
                <form id="disconnectForm_1" action="{{ route('disconnect') }}" method="GET">
                    @csrf
                    <input type="hidden" name="animal_id" value="{{ $monitoring->animal_id }}">
                    <button type="button" class="btn btn-danger" onclick="disconnectAnimal(1)">Disconnect</button>
                </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <h2>Patient 2</h2>
    @foreach ($monitoringsCard2 as $monitoring)
    <div>
        <p>Animal Name: {{ strtoupper($monitoring->name) }}</p>
        <div class="button-group">
            <form id="viewForm_2" action="{{ route('ongoing', ['animal' => $monitoring->animal_id]) }}" method="POST">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $monitoring->animal_id }}">
                <button type="submit" class="btn btn-primary">View</button>
            </form>
            @if(Auth::user()->category === 'Admin User')
                <form id="disconnectForm_2" action="{{ route('disconnect') }}" method="GET">
                    @csrf
                    <input type="hidden" name="animal_id" value="{{ $monitoring->animal_id }}">
                    <button type="button" class="btn btn-danger" onclick="disconnectAnimal(2)">Disconnect</button>
                </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <h2>Patient 3</h2>
    @foreach ($monitoringsCard3 as $monitoring)
    <div>
        <p>Animal Name: {{ strtoupper($monitoring->name) }}</p>
        <div class="button-group">
            <form id="viewForm_3" action="{{ route('ongoing', ['animal' => $monitoring->animal_id]) }}" method="POST">
                @csrf
                <input type="hidden" name="animal_id" value="{{ $monitoring->animal_id }}">
                <button type="submit" class="btn btn-primary">View</button>
            </form>
            @if(Auth::user()->category === 'Admin User')
                <form id="disconnectForm_3" action="{{ route('disconnect') }}" method="GET">
                    @csrf
                    <input type="hidden" name="animal_id" value="{{ $monitoring->animal_id }}">
                    <button type="button" class="btn btn-danger" onclick="disconnectAnimal(3)">Disconnect</button>
                </form>
            @endif
        </div>
    </div>
    @endforeach
</div>


<script>
    function disconnectAnimal(patientId) {
        // Submit the corresponding disconnect form based on patientId
        document.getElementById('disconnectForm_' + patientId).submit();
    }
</script>


@include('partials.footer')
