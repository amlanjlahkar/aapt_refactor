<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Step {{ $step }}: Payment Details">
            <form
                id="payment_info"
                class="grid grid-cols-2 gap-6 rounded-md p-6 pb-0"
                method="POST"
                action="{{ route('user.efiling.register.step' . $step . '.attempt', compact('step', 'case_file_id')) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="payment_mode">
                        Payment Mode
                        <span class="text-red-400">*</span>
                    </label>
                    <select
                        required
                        name="payment_mode"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option
                            value="Demand Draft"
                            {{ old('payment_mode') == 'Demand Draft' ? 'selected' : '' }}
                        >
                            Demand Draft
                        </option>
                        <option
                            value="Indian Post"
                            {{ old('payment_mode') == 'Indian Post' ? 'selected' : '' }}
                        >
                            Indian Post
                        </option>
                        <option
                            value="Bharat Kosh"
                            {{ old('payment_mode') == 'Bharat Kosh' ? 'selected' : '' }}
                        >
                            Bharat Kosh
                        </option>
                    </select>
                </div>

                <div class="flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="amount">
                        Amount (₹)
                    </label>
                    <input
                        type="number"
                        name="amount"
                        placeholder="Enter payment amount"
                        value="{{ old('amount') }}"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="ref_no">
                        Reference No.
                    </label>
                    <input
                        type="text"
                        name="ref_no"
                        placeholder="Enter payment reference number"
                        value="{{ old('ref_no') }}"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="ref_date">
                        Payment Date
                    </label>
                    <input
                        type="date"
                        name="ref_date"
                        value="{{ old('ref_date') }}"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="col-span-2 flex flex-col gap-2.5">
                    <div
                        class="mb-2 flex flex-row gap-1.5 text-xl font-semibold"
                    >
                        <p>Upload Payment Receipt</p>
                        <span class="text-red-400">*</span>
                    </div>
                    <label
                        for="payment_receipt"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-sm border-2 border-dashed border-gray-300 bg-gray-50 p-6 hover:bg-gray-200"
                    >
                        <div
                            class="flex flex-col items-center justify-center gap-2.5 p-6 pt-0"
                        >
                            <x-fas-cloud-arrow-up
                                class="h-8 w-8 text-gray-500"
                            />
                            <p class="text-sm text-gray-500">
                                <span class="font-semibold">
                                    Click to upload
                                </span>
                            </p>
                            <p class="text-xs text-gray-500">
                                (only PDF file is supported, max 5MB)
                            </p>
                        </div>
                        <p
                            id="fileNameDisplay"
                            class="text-center text-sm text-gray-600"
                        >
                            No file selected
                        </p>
                        <input
                            id="payment_receipt"
                            name="payment_receipt"
                            type="file"
                            class="hidden"
                            accept=".pdf"
                        />
                    </label>
                </div>
            </form>
            <div class="flex justify-end p-6">
                <button
                    form="payment_info"
                    type="submit"
                    class="w-1/5 cursor-pointer items-end rounded bg-blue-500 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-600"
                >
                    Save & Review ({{ $step }}/5)
                </button>
            </div>
            <div
                class="item-center w-full rounded-br rounded-bl bg-gray-700 p-2"
            >
                <p class="text-center text-sm font-medium text-gray-300 italic">
                    Note: Labels marked with asterisk("
                    <span class="text-red-400">*</span>
                    ") are required fields
                </p>
            </div>
        </x-user.container>
    </main>
    @include('partials.footer-alt')

    <script>
        const form = document.getElementById('payment_info')
        const fileInput = document.getElementById('payment_receipt')
        const fileNameDisplay = document.getElementById('fileNameDisplay')

        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name

                this.parentElement.classList.remove('border-gray-300')
                this.parentElement.classList.add('border-blue-500')
                this.parentElement.classList.add('font-medium')
            } else {
                // Reset when no file is selected
                fileNameDisplay.textContent = 'No file selected'
                this.parentElement.classList.remove('font-medium')
                this.parentElement.classList.remove('border-blue-500')
                this.parentElement.classList.add('border-gray-300')
            }
        })

        form.addEventListener('submit', function (e) {
            if (fileInput.files.length < 1) {
                e.preventDefault()
                alert('Payment receipt must be uploaded!')
            }
        })
    </script>
</x-layout>
