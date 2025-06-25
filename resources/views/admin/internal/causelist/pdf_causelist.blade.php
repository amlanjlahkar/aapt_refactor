<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Causelist - Court {{ $causelist->bench->court_no ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: normal;
        }
        
        .header h3 {
            margin: 0 0 15px 0;
            font-size: 12px;
            font-weight: normal;
        }
        
        .judge-info {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 12px;
        }
        
        .court-details {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .court-details div {
            margin-bottom: 3px;
        }
        
        .cases-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .cases-table th,
        .cases-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            font-size: 11px;
        }
        
        .cases-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .serial-no {
            width: 8%;
            text-align: center;
        }
        
        .case-number {
            width: 22%;
        }
        
        .purpose {
            width: 20%;
        }
        
        .petitioner {
            width: 25%;
        }
        
        .respondent {
            width: 25%;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ASSAM ADMINISTRATIVE AND PENSION TRIBUNAL</h1>
        <h2>LIST OF CASES TO BE HEARD ON {{ \Carbon\Carbon::parse($causelist->causelist_date)->format('d-m-Y') }}</h2>
        <h3>{{ ucfirst($causelist->causelist_type) }} List</h3>
    </div>

    <div class="judge-info">
        HON'BLE {{ strtoupper($causelist->bench->judge->judge_name ?? 'NO JUDGE ASSIGNED') }}
    </div>

    <div class="court-details">
        <div>Court No: {{ $causelist->bench->court_no ?? 'N/A' }}</div>
        <div>Time: 10:30 AM</div>
    </div>

    @if($cases->isNotEmpty())
        <table class="cases-table">
            <thead>
                <tr>
                    <th class="serial-no">Sl.</th>
                    <th class="case-number">Case No</th>
                    <th class="purpose">Purpose</th>
                    <th class="petitioner">Petitioner</th>
                    <th class="respondent">Respondent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cases as $case)
                    <tr>
                        <td class="serial-no">{{ $case->serial_no }}</td>
                        <td class="case-number">
                            @if($case->caseFile && $case->caseFile->case_type && $case->caseFile->case_reg_no && $case->caseFile->case_reg_year)
                                {{ $case->caseFile->case_type }}/{{ $case->caseFile->case_reg_no }}/{{ $case->caseFile->case_reg_year }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="purpose">
                            {{ strtoupper($case->purpose->purpose_name ?? 'N/A') }}
                        </td>
                        <td class="petitioner">
                            @if($case->caseFile && $case->caseFile->petitioners->isNotEmpty())
                                {{ strtoupper($case->caseFile->petitioners->pluck('pet_name')->implode(', ')) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="respondent">
                            @if($case->caseFile && $case->caseFile->respondents->isNotEmpty())
                                {{ strtoupper($case->caseFile->respondents->pluck('res_name')->implode(', ')) }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 50px;">
            <h3>No Cases Found</h3>
            <p>No cases found for this causelist.</p>
        </div>
    @endif

    <div class="footer">
        Dy. REGISTRAR/Joint REGISTRAR/SECTION OFFICER/REGISTRAR
    </div>
</body>
</html>