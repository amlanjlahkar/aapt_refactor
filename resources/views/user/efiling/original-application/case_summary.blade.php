<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Case File Summary</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                line-height: 1.6;
            }

            .container {
                margin: 80px;
                margin-bottom: 0;
            }

            .header-container {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }

            .header-content {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .logo {
                height: 112px;
                object-fit: contain;
            }

            .title-section {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .title-assamese {
                font-size: 24px;
                font-weight: 600;
                font-family: 'Noto Sans Bengali', sans-serif;
            }

            .title-english {
                font-size: 24px;
                font-weight: 500;
            }

            .subtitle {
                font-size: 20px;
                font-weight: 500;
            }

            .main-content {
                margin: 80px;
                margin-top: 40px;
                display: flex;
                flex-direction: column;
                gap: 40px;
            }

            .ref-number {
                font-size: 24px;
                font-weight: 600;
            }

            .ref-number-value {
                color: #dc2626;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #000;
            }

            .table th,
            .table td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            .table-header {
                background-color: #d1d5db;
                font-size: 24px;
                font-weight: 600;
            }

            .font-medium {
                font-weight: 500;
            }

            .text-uppercase {
                text-transform: uppercase;
            }

            .link {
                color: #1d4ed8;
                text-decoration: underline;
            }

            .note {
                /* padding: 0 208px; */
                text-align: center;
                color: #6b7280;
                font-style: italic;
            }

            .flex-row {
                display: flex;
                flex-direction: row;
                gap: 8px;
            }

            @media print {
                body {
                    font-size: 12px;
                }
                .container {
                    margin: 20px;
                }
                .main-content {
                    margin: 20px;
                    margin-top: 10px;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="header-content">
                    <img
                        src="{{ asset('images/india_emblem.png') }}"
                        alt="India Emblem"
                        class="logo"
                    />
                    <div class="title-section">
                        <h2 class="title-assamese">
                            অসম প্ৰশাসনিক আৰু পেঞ্চন ন্যায়াধিকৰণ
                        </h2>
                        <h2 class="title-english">
                            Assam Administrative and Pension Tribunal
                        </h2>
                        <h3 class="subtitle">Guwahati, Assam</h3>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="main-content">
                <h2 class="ref-number">
                    Reference No.
                    <span class="ref-number-value text-uppercase">
                        {{ $case_file->ref_number }}
                    </span>
                </h2>

                <!-- Case Info -->
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="table-header">
                                Case Details
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <span class="font-medium">Case Type</span>
                                :
                                <span class="text-uppercase">
                                    {{ $case_file->case_type }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="font-medium">Subject</span>
                                : {{ $case_file->subject }}
                            </td>
                            <td>
                                <span class="font-medium">Bench</span>
                                :
                                <span class="text-uppercase">
                                    {{ $case_file->bench }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="font-medium">Filed By</span>
                                : {{ $case_file->filed_by }}
                            </td>
                            <td>
                                <span class="font-medium">Filing Date</span>
                                : {{ $case_file->filing_date }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="font-medium">Filing ID</span>
                                : {{ $case_file->filing_number }}
                            </td>
                            <td>
                                <span class="font-medium">
                                    Legal Aid Required
                                </span>
                                :
                                {{ $case_file->legal_aid == 1 ? 'Yes' : 'No' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Petitioners Info -->
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="table-header">
                                Petitioner(s) Info
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case_file->petitioners as $pet)
                            <tr>
                                <td colspan="2">
                                    <span class="font-medium">
                                        Petitioner Type
                                    </span>
                                    :
                                    <span class="text-uppercase">
                                        {{ $pet->pet_type }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-medium">
                                        Email Address
                                    </span>
                                    : {{ $pet->pet_email }}
                                </td>
                                <td>
                                    <span class="font-medium">Phone No.</span>
                                    : {{ $pet->pet_phone }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="font-medium">Address</span>
                                    : {{ $pet->pet_address }}
                                </td>
                            </tr>

                            @if ($pet->pet_type == 'Individual')
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's Name
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's Age
                                        </span>
                                        : {{ $pet->pet_age }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's State
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_state }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's District
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_district }}
                                        </span>
                                    </td>
                                </tr>
                            @elseif ($pet->pet_type == 'Organization')
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's Ministry
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_ministry }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's Department
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_department }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's Contact Person
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_contact_person }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Petitioner's Designation
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $pet->pet_designation }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Respondents Info -->
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="table-header">
                                Respondents Info
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case_file->respondents as $res)
                            <tr>
                                <td colspan="2">
                                    <span class="font-medium">
                                        Respondent Type
                                    </span>
                                    :
                                    <span class="text-uppercase">
                                        {{ $res->res_type }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-medium">
                                        Email Address
                                    </span>
                                    : {{ $res->res_email }}
                                </td>
                                <td>
                                    <span class="font-medium">Phone No.</span>
                                    : {{ $res->res_phone }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="font-medium">Address</span>
                                    : {{ $res->res_address }}
                                </td>
                            </tr>

                            @if ($res->res_type == 'Individual')
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's Name
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's Age
                                        </span>
                                        : {{ $res->res_age }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's State
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_state }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's District
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_district }}
                                        </span>
                                    </td>
                                </tr>
                            @elseif ($res->res_type == 'Organization')
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's Ministry
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_ministry }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's Department
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_department }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's Contact Person
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_contact_person }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-medium">
                                            Respondent's Designation
                                        </span>
                                        :
                                        <span class="text-uppercase">
                                            {{ $res->res_designation }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Document Info -->
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="table-header">
                                Documents Uploaded
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($case_file->documents) || $case_file->documents->count() == 0)
                            <tr>
                                <td colspan="2">No documents found</td>
                            </tr>
                        @else
                            @foreach ($case_file->documents as $doc)
                                <tr>
                                    @if (! empty($doc->document))
                                        <td colspan="2">
                                            <span class="font-medium">
                                                Document
                                            </span>
                                            : {{ $doc->document }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <!-- Payment Info -->
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" class="table-header">
                                Payment Info
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case_file->payment as $pay)
                            <tr>
                                <td colspan="2">
                                    <span class="font-medium">
                                        Payment Mode
                                    </span>
                                    :
                                    <span class="text-uppercase">
                                        {{ $pay->payment_mode }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-medium">
                                        Amount Paid (in ₹)
                                    </span>
                                    : {{ $pay->amount }}
                                </td>
                                <td>
                                    <span class="font-medium">
                                        Payment Reference No.
                                    </span>
                                    :
                                    <span class="text-uppercase">
                                        {{ $pay->ref_no }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="font-medium">
                                        Date of Payment
                                    </span>
                                    : {{ $pay->ref_date }}
                                </td>
                                <td>
                                    <span class="font-medium">
                                        Transaction ID
                                    </span>
                                    :
                                    <span class="text-uppercase">
                                        {{ $pay->transaction_id }}
                                    </span>
                                </td>
                            </tr>
                            <!-- <tr> -->
                            <!--     <td colspan="2"> -->
                            <!--         <div class="flex-row"> -->
                            <!--             <span class="font-medium"> -->
                            <!--                 Payment Receipt: -->
                            <!--             </span> -->
                            <!--             <a -->
                            <!--                 href="{{ asset('storage/' . $pay->payment_receipt) }}" -->
                            <!--                 target="_blank" -->
                            <!--                 class="link" -->
                            <!--             > -->
                            <!--                 View receipt -->
                            <!--             </a> -->
                            <!--         </div> -->
                            <!--     </td> -->
                            <!-- </tr> -->
                        @endforeach
                    </tbody>
                </table>

                <div>
                    <p class="note">
                        Note: This is a system-generated receipt and does not
                        require any signature. Please retain this document for
                        your records. If you have any questions or require
                        further assistance, kindly contact our support team
                        through the official channels.
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>
