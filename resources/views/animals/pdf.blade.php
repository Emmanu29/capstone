<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .printable {
            margin-top: 10px;
            min-height: 90vh;
           
            overflow: hidden; /* Prevent content from overflowing onto second page */
            position: relative; /* Ensure relative positioning */
        }

        .print{
            max-width: 850px;
            margin-right: auto;
            margin-left: auto;
            background-color: var(--white-color);
            padding: 70px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            min-height: 200px;
            position: relative; /* Ensure relative positioning */
        }

        hr {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .tbl {
            align-content: center;
            table-layout: fixed; /* Prevent table from expanding beyond page width */
            margin-bottom: 50px; /* Reduced margin between tables */
        }

        table {
            width: 100%;
        }

        .tbl td {
            height: 30px;
            padding-left: 7px;
        }

        .tbl,
        .tbl td,
        .tbl th {
            border-collapse: collapse;
            border: 1px solid;
        }

        .com {
            text-align: left;
        }

        .r-w {
            width: 20%;
        }

        .r-ww {
            width: 30%;
        }

        .tbl1{
            margin-bottom: 60px;
        }

        .tbl4 td {
            text-align: center;
        }

        .tbl4 th {
            width: 20%;
        }

        .tbl3 {
            height: 30px;
        }

        /* Center the table horizontally */
        #tbl1 {
            margin-left: auto;
            margin-right: auto;
        }

        /* Position the logo */
        .logo-container {
            position: absolute;
            top: 90px; /* Adjust as needed */
            right: 70px; /* Adjust as needed */
            z-index: 1; /* Ensure the logo appears above other content */
        }

        .logo-container img {
            width: 80px; /* Adjust the size of the logo */
            border-radius: 50%; /* Make the image appear as a circle */
        }

        /* Style the print button */
        .print-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Media query for printing */
        @media print {
            @page {
                margin-top: 0;
                margin-bottom: 0;
                
            }

            .printable {
                background-color: white;
                padding-top: 0;
                padding-bottom: 0;
                overflow: visible; /* Allow content overflow for printing */
            }

            .print {
                padding: 0;
                border: none;
            }

            /* Hide print button in print mode */
            .print-btn {
                display: none;
            }

            .tbl1{
                margin-top: 50px;
            }

            h1,
            hr {
                display: none;
            }

            /* Position the logo */
            .logo-container {
                position: absolute;
                top: 5px; /* Adjust as needed */
                right: 20px; /* Adjust as needed */
                z-index: 1; /* Ensure the logo appears above other content */
            }
        }
    </style>
</head>
<body>
    <div class="printable" id="prnt">
        <div class="print">
            <div class="print-container">

            <!-- Logo container -->
            <div class="logo-container">
                <img src="/images/apms.jpg" alt="Logo">
            </div>

                <table class="tbl1">
                        <tr>
                            <th colspan="2" class="com"><h2>Dapper Vet Clinic Patient Record</h2></th>
                        </tr>
                        <tr>
                            <td class="r-w">Patient Name:</td>
                            <td>{{ $animal->name }}</td>
                        </tr>
                        <tr>
                            <td class="r-w">Owner's Name:</td>
                            <td>{{$animal->owner_number}}</td>
                        </tr>                    
                </table>

                <hr>

                <table class="tbl tbl2">
                    <tr>
                        <td class="r-w">Species:</td>
                        <td>{{ $animal->species->name }}</td>
                        <td class="r-ww">Sex:</td>
                        <td>{{ $animal->sex }}</td>
                    </tr>
                    <tr>
                        <td class="r-w">Weight:</td>
                        <td>{{ $animal->weight }}</td>
                        <td class="r-ww">Owner's Name:</td>
                        <td>{{$animal->owner_name}}</td>
                    </tr>
                    <tr>
                        <td class="r-w">Age:</td>
                        <td>{{ $animal->age }}</td>
                        <td class="r-ww">Owner's Phone Number:</td>
                        <td>{{ $animal->owner_number }}</td>
                    </tr>
                </table>

                <hr>

                <table class="tbl tbl3">
                    <tr>
                        <td class="r-w">Health History:</td>
                        <td>{{$animal->health_issue}}</td>
                    </tr>
                    <tr>
                        <td class="r-w">Doctors's Notes:</td>
                        <td>{{$animal->diagnosis}}</td>
                    </tr>
                </table>

                <hr>

                <table class="tbl tbl4">
                    <tr>
                        <th>Alerts:</th>
                        <th>Normal Reading:</th>
                        <th>Alerted Reading:</th>
                        <th>Time:</th>
                    </tr>
                    <tr>
                        <th>ECG Alerts:</th>
                        <td>{{ $animal->species->heartRateLowAlarm }}</td>
                        <td>{{ $animal->species->heartRateLowAlarm }}</td>
                        <td>{{ $animal->species->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Respiratory Alerts:</th>
                        <td>{{ $animal->species->heartRateLowAlarm }}</td>
                        <td>{{ $animal->species->heartRateLowAlarm }}</td>
                        <td>{{ $animal->species->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Temperature Alerts:</th>
                        <td>{{ $animal->species->heartRateLowAlarm }}</td>
                        <td>{{ $animal->species->heartRateLowAlarm }}</td>
                        <td>{{ $animal->species->created_at }}</td>
                    </tr>
                </table>

                <table class="tbl tbl4">
                    <tr>
                        <th>Veterinarian:</th>
                        <th>Recommendation:</th>
                        <th>Diagnosis:</th>
                        <th>Date and Time:</th>
                    </tr>
                    @foreach($consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->name }}</td>
                            <td>{{ $consultation->recommendation }}</td>
                            <td>{{ $consultation->diagnosis }}</td>
                            <td>{{ $consultation->created_at }}</td>
                        </tr>
                    @endforeach
                </table>

                <!-- Table for Alarm Logs -->
                <table class="tbl tbl4">
                    <tr>
                        <th>Name:</th>
                        <th>Type:</th>
                        <th>Value:</th>
                        <th>Timestamp:</th>
                    </tr>
                    @foreach($alarmLogs as $alarmLog)
                        <tr>
                            <td>{{ $alarmLog->name }}</td>
                            <td>{{ $alarmLog->type }}</td>
                            <td>{{ $alarmLog->value }}</td>
                            <td>{{ $alarmLog->timestamp }}</td>
                        </tr>
                    @endforeach
                </table>


                

                <!-- Print button -->
            <button class="print-btn" onclick="printPage()">Print</button>
                </div>
            </div>

            </div>
</body>
</html>

<script>
    function printPage() {
        window.print();
    }
</script>