<x-layout>
    @include('partials.header')
    @include('partials.navbar')
    <main
        class="flex grow items-center justify-start bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <div class="m-12 grid grid-cols-2 gap-10 p-5">
            <div
                class="h-fit rounded border-2 border-gray-300 bg-gray-50/90 p-5 drop-shadow-xl"
            >
                <h1 class="text-2xl font-semibold">About AAPT</h1>
                <hr class="mt-3 mb-3 w-1/3 border text-yellow-500" />
                <p>
                    Administrative tribunals in India are specialized
                    quasi-judicial bodies established to resolve disputes
                    arising from administrative decisions, particularly in
                    government service matters including recruitment, promotion,
                    and pension issues. The Central Administrative Tribunal
                    (CAT), established under the Administrative Tribunals Act of
                    1985, operates across multiple benches nationwide and has
                    successfully implemented a Case Information System (CIS) for
                    digital case management. CAT Delhi's CIS application serves
                    as a comprehensive web-based platform that streamlines
                    administrative dispute resolution through efficient case
                    management processes. The Assam Administrative Tribunal
                    currently handles various administrative disputes, but the
                    increasing volume and complexity of pension-related cases
                    necessitated the creation of a specialized mechanism - the
                    Assam Administrative and Pension Tribunal (AAPT).
                </p>

                <p />
            </div>

            <div
                class="rounded border-2 border-gray-500 bg-gray-800 p-5 drop-shadow-xl"
            >
                <h2
                    class="mb-4 text-center text-2xl font-semibold text-gray-100"
                >
                    Case Statistics
                </h2>
                <div class="flex justify-center">
                    <canvas id="caseChart" width="300" height="300"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center">
                        <div class="mr-2 h-4 w-4 rounded bg-blue-500"></div>
                        <span class="text-sm text-gray-100">
                            Total Cases:
                            <strong>50</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <div class="mr-2 h-4 w-4 rounded bg-red-400"></div>
                        <span class="text-sm text-gray-100">
                            Pending Cases:
                            <strong>12</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <div class="mr-2 h-4 w-4 rounded bg-green-400"></div>
                        <span class="text-sm text-gray-100">
                            Completed Cases:
                            <strong>17</strong>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <div class="mr-2 h-4 w-4 rounded bg-orange-400"></div>
                        <span class="text-sm text-gray-100">
                            Defective Cases:
                            <strong>21</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        const ctx = document.getElementById('caseChart').getContext('2d')
        const caseChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Completed Cases', 'Defective Cases', 'Pending Cases'],
                datasets: [
                    {
                        data: [17, 21, 12],
                        backgroundColor: [
                            '#4ade80', // Lighter green for completed
                            '#fb923c', // Lighter orange for defective
                            '#F87171', // Lighter red for pending
                        ],
                        borderColor: ['#22c55e', '#f97316', '#EF4444'],
                        borderWidth: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            color: '#cbd5e1',
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce(
                                    (a, b) => a + b,
                                    0
                                )
                                const percentage = (
                                    (context.raw / total) *
                                    100
                                ).toFixed(1)
                                return (
                                    context.label +
                                    ': ' +
                                    context.raw +
                                    ' (' +
                                    percentage +
                                    '%)'
                                )
                            },
                        },
                    },
                },
            },
        })
    </script>
</x-layout>
