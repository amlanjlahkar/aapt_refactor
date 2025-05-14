<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Step {{ $step }}: Document Upload">
            <form
                id="document_info"
                class="grid grid-cols-2 gap-6 rounded-md p-6 pb-0"
                method="POST"
                action="{{ route('user.efiling.register.step' . $step . '.attempt', compact('step', 'case_file_id')) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="col-span-2 flex flex-col gap-2.5">
                    <div
                        class="mb-2 flex flex-row gap-1.5 text-xl font-semibold"
                    >
                        {{-- <p>Upload Documents</p> --}}
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
                                (only PNG, JPG or PDF file is supported, max 5MB)
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
                            accept=".jpg,.jpeg,.png,.pdf"
                            multiple
                        />
                    </label>
                </div>
            </form>
            <div class="flex justify-end p-6">
                <button
                    form="document_info"
                    type="submit"
                    class="w-1/5 cursor-pointer items-end rounded bg-blue-500 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-600"
                >
                    Save & Proceed ({{ $step }}/5)
                </button>
            </div>
            {{--
                <div
                class="item-center w-full rounded-br rounded-bl bg-gray-700 p-2"
                >
                <p class="text-center text-sm font-medium text-gray-300 italic">
                Note: Labels marked with asterisk("
                <span class="text-red-400">*</span>
                ") are required fields
                </p>
                </div>
            --}}
        </x-user.container>
    </main>
    @include('partials.footer-alt')

    <script>
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
    </script>
</x-layout>
