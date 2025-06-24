<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Causelist - {{ $date->format('d-m-Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 14px;
            margin: 5px 0;
        }
        .header h3 {
            font-size: 12px;
            margin: 5px 0;
        }
        .judge-info {
            text-align: center;
            margin: 15px 0;
        }
        .court-details {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 8px 4px;
        }
        td {
            padding: 6px 4px;
            text-align: left;
        }
        .sl-no {
            text-align: center;
            width: 5%;
        }
        .case-no {
            width: 20%;
        }
        .purpose {
            width: 15%;
        }
        .petitioner {
            width: 25%;
        }
        .respondent {
            width: 25%;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ASSAM ADMINISTRATIVE AND PENSION TRIBUNAL</h1>
        <h2>LIST OF CASES TO BE HEARD ON {{ strtoupper($date->format('d-m-Y')) }}</h2>
        <h3>Daily List</h3>
    </div>

    <div class="judge-info">
        <strong>HON'BLE MR.JUSTICE {{ strtoupper($judge->judge_name ?? 'HK SARMA') }}</strong>
    </div>

    <div class="court-details">
        <div><strong>Court No: {{ $courtNo }}</strong></div>
        <div><strong>Time: {{ $time }}</strong></div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="sl-no">Sl.</th>
                <th class="case-no">Case No</th>
                <th class="purpose">Purpose</th>
                <th class="petitioner">Petitioner</th>
                <th class="respondent">Respondent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cases as $index => $case)
                <tr>
                    <td class="sl-no">{{ $index + 1 }}</td>
                    <td class="case-no">
                        {{ $case->caseFile->case_type ?? 'Original Application' }}/{{ $case->caseFile->case_number ?? $case->id }}/{{ $date->format('Y') }}
                    </td>
                    <td class="purpose">
                        {{ $case->purpose->purpose_name ?? 'FOR ADMISSION' }}
                    </td>
                    <td class="petitioner">
                        {{ $case->caseFile->petitioner_name ?? 'ABC' }}
                    </td>
                    <td class="respondent">
                        {{ $case->caseFile->respondent_name ?? 'XYZ' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dy. REGISTRAR/Joint REGISTRAR/SECTION OFFICER/REGISTRAR</p>
    </div>
</body>
</html>