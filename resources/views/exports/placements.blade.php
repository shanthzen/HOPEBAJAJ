<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Placements Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 5px;
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
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HOPE Foundation - Placements Report</h1>
        <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Batch No</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Company Name</th>
                <th>Designation</th>
                <th>Salary (LPA)</th>
                <th>Joining Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($placements as $index => $placement)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $placement->batch_no }}</td>
                <td>{{ $placement->name }}</td>
                <td>{{ $placement->phone_number }}</td>
                <td>{{ $placement->company_name }}</td>
                <td>{{ $placement->designation }}</td>
                <td style="white-space: nowrap;">{{ $placement->salary }}</td>
                <td>{{ $placement->joining_date ? $placement->joining_date->format('d-m-Y') : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Placements: {{ $placements->count() }}</p>
    </div>
</body>
</html>
