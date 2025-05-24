<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                background-color: #e5e7eb;
                color: #1f2937;
            }
            .container {
                margin: 0.5rem;
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
                border-radius: 0.375rem;
                background-color: white;
                padding: 1.2rem;
                color: #1f2937;
            }
            h1 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: -0.1rem;
            }
            a.button {
                width: fit-content;
                border-radius: 0.375rem;
                background-color: #374151;
                padding: 0.5rem 1rem;
                font-weight: 500;
                color: #f3f4f6;
                text-decoration: none;
                display: inline-block;
            }
            a.button:hover {
                background-color: #4b5563;
            }
            hr {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 1rem 0;
            }
            .small-text {
                font-size: 0.875rem;
                color: #4b5563;
            }
            .link-text {
                color: #2563eb;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>User Email Verification</h1>
            <p>
                Please verify your email address by clicking the button below.
            </p>
            <a href="#" class="button">Verify Email Address</a>

            <p>
                If you didn't attempt to create an account on Assam APT portal,
                no further action is required.
            </p>

            <p>
                Regards,
                <br />
                {{-- {{ env('MAIL_FROM_NAME') }} --}}
                Assam Administrative and Pension Tribunal
            </p>

            <hr />

            <p class="small-text">
                If you're having trouble clicking the "Verify Email Address"
                button, copy and paste the URL below into your web browser:
                <a href="{{ $url }}" class="link-text">{{ $url }}</a>
            </p>
        </div>
    </body>
</html>
