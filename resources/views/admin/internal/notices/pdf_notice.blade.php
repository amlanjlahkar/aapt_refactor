<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notice - {{ $notice->id }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            color: black;
            line-height: 1.4;
        }
        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
        }
        .header h2 {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .details-table td {
            padding: 2px 0;
        }
        .details-table .label {
            font-weight: bold;
            width: 150px;
        }
        .parties {
            margin: 30px 0;
            text-align: center;
        }
        .party-name {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .vs {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
            font-size: 14px;
        }
        .advocates-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .advocates-table td {
            padding: 2px 0;
        }
        .advocates-table .label {
            font-weight: bold;
            width: 180px;
        }
        .notice-body {
            margin-bottom: 40px;
        }
        .notice-to {
            font-weight: bold;
            margin-bottom: 15px;
        }
        .addressee {
            margin-left: 20px;
            margin-bottom: 5px;
        }
        .address {
            margin-left: 40px;
            margin-bottom: 25px;
        }
        .notice-content {
            text-align: justify;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .notice-content p {
            margin: 0 0 15px 0;
        }
        .footer {
            text-align: right;
            margin-top: 60px;
        }
        .footer div {
            margin-bottom: 5px;
        }
        .footer .registrar {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>ASSAM ADMINISTRATIVE AND PENSION TRIBUNAL</h1>
            <h2>GUWAHATI</h2>
        </div>

        <!-- Document Details -->
        <table class="details-table">
            <tr>
                <td class="label">Dispatch No.</td>
                <td>Registered with A/D</td>
            </tr>
            <tr>
                <td class="label">Case No.:</td>
                <td>O.A./{{ $notice->case->case_reg_no ?? '1' }}/{{ $notice->case->case_reg_year ?? date('Y') }}</td>
            </tr>
            <tr>
                <td class="label">Dated:</td>
                <td>{{ \Carbon\Carbon::parse($notice->created_at)->format('d/m/Y') }}</td>
            </tr>
        </table>

        <!-- Parties -->
        <div class="parties">
            <div class="party-name">
                {{ $notice->case->petitioners->first()?->pet_name ?? 'ABC' }}
            </div>
            <div class="vs">VS</div>
            <div class="party-name">
                {{ $notice->case->respondents->first()?->res_name ?? 'XYZ' }}
            </div>
        </div>

        <!-- Advocates -->
        <table class="advocates-table">
            <tr>
                <td class="label">Petitioner Advocate:</td>
                <td>{{ $notice->case->petitioner_advocate ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Respondent Advocate:</td>
                <td>{{ $notice->case->respondent_advocate ?? 'N/A' }}</td>
            </tr>
        </table>

        <!-- Notice Body -->
        <div class="notice-body">
            <div class="notice-to">To,</div>
            <div class="addressee">
                (1) {{ $notice->case->respondents->first()?->res_name ?? 'XYZ' }}
            </div>
            <div class="address">
                {{ $notice->case->respondents->first()?->res_address ?? 'Sibsagar' }}
            </div>

            <div class="notice-content">
                <p>
                    Take notice that the above mentioned application has been listed for admission as well as hearing for 
                    interim in this Tribunal on <strong>{{ \Carbon\Carbon::parse($notice->hearing_date)->format('d/m/Y') }} at {{ $notice->hearing_time ?? '10:30 AM' }}</strong>. 
                    You may appear before the Court on the said date either in person or through an advocate duly appointed by you for this purpose.
                </p>

                <p>
                    Also take notice that in default of your appearance on the date fixed the case will be heard ex-parte.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>(By order of Tribunal)</div>
            <div class="registrar">Registrar</div>
        </div>
    </div>
</body>
</html>