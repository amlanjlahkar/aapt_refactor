@php
    $isPdf = $isPdf ?? false;
@endphp

@if (!$isPdf)
<x-layout title="Notice Preview | Admin">
    @include('partials.header')
    <main class="grow bg-gray-100 p-0">
@endif

<!-- PDF Document Container -->
<div style="width: 100%; max-width: 210mm; margin: 0 auto; background: white; padding: 0;">
    <div style="padding: 30px; font-family: 'Times New Roman', serif; color: black; line-height: 1.4;">

        <!-- Header Section -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 16px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin: 0 0 5px 0;">
                ASSAM ADMINISTRATIVE AND PENSION TRIBUNAL
            </h1>
            <h2 style="font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0;">
                GUWAHATI
            </h2>
        </div>

        <!-- Document Details -->
        <div style="margin-bottom: 25px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="font-weight: bold; width: 150px; padding: 2px 0;">Dispatch No.</td>
                    <td style="padding: 2px 0;">Registered with A/D</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 150px; padding: 2px 0;">Case No.:</td>
                    <td style="padding: 2px 0;">O.A./{{ $notice->case->case_reg_no ?? '1' }}/{{ $notice->case->case_reg_year ?? date('Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 150px; padding: 2px 0;">Dated:</td>
                    <td style="padding: 2px 0;">{{ \Carbon\Carbon::parse($notice->created_at)->format('d/m/Y') }}</td>
                </tr>
            </table>
        </div>

        <!-- Parties -->
        <div style="margin: 30px 0; text-align: center;">
            <div style="font-weight: bold; margin-bottom: 8px; font-size: 14px;">
                {{ $notice->case->petitioners->first()?->pet_name ?? 'ABC' }}
            </div>
            <div style="text-align: center; margin: 10px 0; font-weight: bold; font-size: 14px;">
                VS
            </div>
            <div style="font-weight: bold; margin-bottom: 20px; font-size: 14px;">
                {{ $notice->case->respondents->first()?->res_name ?? 'XYZ' }}
            </div>
        </div>

        <!-- Advocates -->
        <div style="margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="font-weight: bold; width: 180px; padding: 2px 0;">Petitioner Advocate:</td>
                    <td style="padding: 2px 0;">{{ $notice->case->petitioner_advocate ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; width: 180px; padding: 2px 0;">Respondent Advocate:</td>
                    <td style="padding: 2px 0;">{{ $notice->case->respondent_advocate ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Notice Body -->
        <div style="margin-bottom: 40px;">
            <div style="font-weight: bold; margin-bottom: 15px;">To,</div>
            <div style="margin-left: 20px; margin-bottom: 5px;">
                (1) {{ $notice->case->respondents->first()?->res_name ?? 'XYZ' }}
            </div>
            <div style="margin-left: 40px; margin-bottom: 25px;">
                {{ $notice->case->respondents->first()?->res_address ?? 'Sibsagar' }}
            </div>

            <div style="text-align: justify; line-height: 1.6; margin-bottom: 15px;">
                <p style="margin: 0 0 15px 0;">
                    Take notice that the above mentioned application has been listed for admission as well as hearing for 
                    interim in this Tribunal on <strong>{{ \Carbon\Carbon::parse($notice->hearing_date)->format('d/m/Y') }} at {{ $notice->hearing_time ?? '10:30 AM' }}</strong>. 
                    You may appear before the Court on the said date either in person or through an advocate duly appointed by you for this purpose.
                </p>

                <p style="margin: 0;">
                    Also take notice that in default of your appearance on the date fixed the case will be heard ex-parte.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: right; margin-top: 60px;">
            <div style="margin-bottom: 5px;">(By order of Tribunal)</div>
            <div style="font-weight: bold;">Registrar</div>
        </div>

    </div>
</div>

@if (!$isPdf)
        <!-- Download Button -->
        <div style="text-align: center; padding: 20px;">
            <a href="{{ route('admin.internal.notices.download', $notice->id) }}"
               style="padding: 10px 20px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 5px;">
                Download PDF
            </a>
        </div>
    </main>
    @include('partials.footer-alt')
</x-layout>
@endif