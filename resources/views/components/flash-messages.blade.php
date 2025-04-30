<div>
    @session('success')
        <div
            id="alert-success"
            class="mb-4 rounded border-l-4 border-green-500 bg-green-100 p-4 text-green-700 shadow"
            role="alert"
        >
            <div class="flex items-center">
                <div class="py-1">
                    <svg
                        class="mr-4 h-6 w-6 text-green-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium">{{ $value }}</p>
                </div>
            </div>
        </div>
    @endsession

    @session('error')
        <div
            id="alert-error"
            class="mb-4 rounded border-l-4 border-red-500 bg-red-100 p-4 text-red-700 shadow"
            role="alert"
        >
            <div class="flex items-center">
                <div class="py-1">
                    <svg
                        class="mr-4 h-6 w-6 text-red-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                        ></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium">{{ $value }}</p>
                </div>
            </div>
        </div>
    @endsession
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('#success-alert, #error-alert')

        alerts.forEach((alert) => {
            setTimeout(function () {
                alert.style.transition = 'opacity 1s'
                alert.style.opacity = 0
                setTimeout(function () {
                    alert.style.display = 'none'
                }, 1000)
            }, 5000)
        })
    })
</script>
