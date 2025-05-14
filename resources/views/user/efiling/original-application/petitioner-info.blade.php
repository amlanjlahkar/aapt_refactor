<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Step {{ $step }}: Petitioner Information">
            <form
                id="petitioner_info"
                class="grid grid-cols-2 gap-6 rounded-md p-6 pb-0"
                method="POST"
                action="{{ route('user.efiling.register.step' . $step . '.attempt', compact('step', 'case_file_id')) }}"
            >
                @csrf
                <div class="col-span-2 flex w-1/3 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="pet_type">
                        Petitioner Type
                        <span class="text-red-400">*</span>
                    </label>
                    <select
                        required
                        id="pet_type"
                        name="pet_type"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>
                            Select petitioner type
                        </option>
                        <option
                            value="Individual"
                            {{ old('pet_type') == 'Individual' ? 'selected' : '' }}
                        >
                            Individual
                        </option>
                        <option
                            value="Organization"
                            {{ old('pet_type') == 'Organization' ? 'selected' : '' }}
                        >
                            Organization
                        </option>
                    </select>
                </div>

                <div
                    class="col-span-2 grid hidden grid-cols-2 gap-6"
                    id="pet_individual_fields"
                >
                    <div class="flex flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="pet_name">
                            Name
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            required
                            name="pet_name"
                            type="text"
                            placeholder="Petitioner name"
                            value="{{ old('pet_name') }}"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="pet_age">
                            Age
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            required
                            type="text"
                            minlength="2"
                            maxlength="3"
                            name="pet_age"
                            placeholder="Petitioner age"
                            value="{{ old('pet_age') }}"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="pet_state">
                            State
                        </label>
                        <select
                            required
                            name="pet_state"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select state
                            </option>
                            <option value="Assam" selected>Assam</option>
                        </select>
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="pet_district">
                            District
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="pet_district"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select district
                            </option>
                            <option
                                value="Barpeta"
                                {{ old('pet_district') == 'Barpeta' ? 'selected' : '' }}
                            >
                                Barpeta
                            </option>
                            <option
                                value="Kamrup(Metro)"
                                {{ old('pet_district') == 'Kamrup(Metro)' ? 'selected' : '' }}
                            >
                                Kamrup(Metro)
                            </option>
                            <option
                                value="Nalbari"
                                {{ old('pet_district') == 'Nalabari' ? 'selected' : '' }}
                            >
                                Nalbari
                            </option>
                        </select>
                    </div>
                </div>

                <div
                    class="col-span-2 grid hidden grid-cols-2 gap-6"
                    id="pet_organization_fields"
                >
                    <div class="flex flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="pet_ministry">
                            Ministry
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="pet_ministry"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select ministry
                            </option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                            <option value="">Option 3</option>
                        </select>
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label
                            class="text-xl font-semibold"
                            for="pet_department"
                        >
                            Department
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="pet_department"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select department
                            </option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                            <option value="">Option 3</option>
                        </select>
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label
                            class="text-xl font-semibold"
                            for="pet_contact_person"
                        >
                            Contact Person
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            required
                            type="text"
                            name="pet_contact_person"
                            placeholder="Contact person name"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label
                            class="text-xl font-semibold"
                            for="pet_designation"
                        >
                            Contact Person Designation
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="pet_designation"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select designation
                            </option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                            <option value="">Option 3</option>
                        </select>
                    </div>
                </div>

                <div class="flex min-w-1/4 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="pet_phone">
                        Phone No.
                        <span class="text-red-400">*</span>
                    </label>
                    <input
                        required
                        type="text"
                        minlength="10"
                        maxlength="10"
                        name="pet_phone"
                        placeholder="Petitioner phone no."
                        value="{{ old('pet_phone') }}"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="flex min-w-1/4 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="pet_email">
                        Email
                        <span class="text-red-400">*</span>
                    </label>
                    <input
                        required
                        type="email"
                        name="pet_email"
                        placeholder="Petitioner email address"
                        value="{{ old('pet_email') }}"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="colspan-2 flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="pet_address">
                        Address
                        <span class="text-red-400">*</span>
                    </label>
                    <textarea
                        required
                        name="pet_address"
                        rows="4"
                        cols="10"
                        placeholder="Petitioner address"
                        class="w-full resize rounded-sm border border-gray-400 p-4"
                    ></textarea>
                </div>
            </form>
            <div class="flex justify-end p-6">
                <button
                    form="petitioner_info"
                    type="submit"
                    class="w-1/5 cursor-pointer items-end rounded bg-blue-500 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-600"
                >
                    Save & Proceed ({{ $step }}/5)
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
        document.addEventListener('DOMContentLoaded', function () {
            const pet_type = document.getElementById('pet_type')
            const pet_ind_div = document.getElementById('pet_individual_fields')
            const pet_org_div = document.getElementById(
                'pet_organization_fields'
            )

            // Get all form inputs
            const individualInputs =
                pet_ind_div.querySelectorAll('input, select')
            const organizationInputs =
                pet_org_div.querySelectorAll('input, select')

            // Function to toggle required attribute
            function toggleRequiredAttributes(selectedType) {
                // First, remove required from all fields
                individualInputs.forEach((input) => {
                    input.required = false
                })

                organizationInputs.forEach((input) => {
                    input.required = false
                })

                // Then add required attribute back only to visible fields
                if (selectedType === 'Individual') {
                    individualInputs.forEach((input) => {
                        input.required = true
                    })
                } else if (selectedType === 'Organization') {
                    organizationInputs.forEach((input) => {
                        input.required = true
                    })
                }
            }

            // Toggle visibility and required attributes on change
            pet_type.addEventListener('change', (event) => {
                const selectedType = event.target.value

                pet_ind_div.classList.add('hidden')
                pet_org_div.classList.add('hidden')

                if (selectedType === 'Individual') {
                    pet_ind_div.classList.remove('hidden')
                } else if (selectedType === 'Organization') {
                    pet_org_div.classList.remove('hidden')
                }

                // Update required attributes
                toggleRequiredAttributes(selectedType)
            })

            // Handle form submission
            document
                .getElementById('petitioner_info')
                .addEventListener('submit', function (event) {
                    const selectedType = pet_type.value

                    // Make sure the required attributes are set correctly before submission
                    toggleRequiredAttributes(selectedType)
                })

            // Initialize with empty state (no required fields)
            toggleRequiredAttributes('')
        })
    </script>
</x-layout>
