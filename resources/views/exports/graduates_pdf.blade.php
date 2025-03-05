<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            width: 30%;
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Graduate Details</h2>
    
    @foreach($graduates as $graduate)
    <div class="section-title">Basic Information</div>
    <table>
        <tr>
            <th>Batch No</th>
            <td>{{ $graduate->batch_no }}</td>
        </tr>
        <tr>
            <th>Certificate No</th>
            <td>{{ $graduate->certificate_no }}</td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td>{{ $graduate->name }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $graduate->phone_number }}</td>
        </tr>
    </table>

    <div class="section-title">Course Information</div>
    <table>
        <tr>
            <th>Course Name</th>
            <td>{{ $graduate->course_name }}</td>
        </tr>
        <tr>
            <th>Course Duration</th>
            <td>{{ $graduate->course_duration }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{ $graduate->start_date ? $graduate->start_date->format('d/m/Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>End Date</th>
            <td>{{ $graduate->end_date ? $graduate->end_date->format('d/m/Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>Total Days Attended</th>
            <td>{{ $graduate->total_days_attended }} days</td>
        </tr>
    </table>

    <div class="section-title">ID Proof Information</div>
    <table>
        <tr>
            <th>ID Type</th>
            <td>{{ $graduate->id_proof_type }}</td>
        </tr>
        <tr>
            <th>ID Number</th>
            <td>{{ $graduate->id_proof_number }}</td>
        </tr>
    </table>
    @endforeach
</body>
</html>
