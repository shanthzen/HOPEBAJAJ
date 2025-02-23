<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: helvetica;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Graduate Records</h2>
        <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Batch No</th>
                <th>Certificate No</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Course Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Days Attended</th>
            </tr>
        </thead>
        <tbody>
            @foreach($graduates as $index => $graduate)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $graduate->batch_no }}</td>
                <td>{{ $graduate->certificate_no }}</td>
                <td>{{ $graduate->name }}</td>
                <td>{{ $graduate->phone_number }}</td>
                <td>{{ $graduate->course_name }}</td>
                <td>{{ $graduate->start_date ? $graduate->start_date->format('d-m-Y') : '' }}</td>
                <td>{{ $graduate->end_date ? $graduate->end_date->format('d-m-Y') : '' }}</td>
                <td>{{ $graduate->total_days_attended }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
