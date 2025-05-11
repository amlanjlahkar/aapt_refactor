<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Step {{ $step }}: Respondent Information">
            <form
                id="respondent_info"
                class="grid grid-cols-2 gap-6 rounded-md p-6 pb-0"
                method="POST"
                action="{{ route('user.efiling.register.step' . $step . '.attempt', compact('step', 'case_file_id')) }}"
            >
                @csrf
                <div class="col-span-2 flex w-1/3 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="res_type">
                        Respondent Type
                    </label>
                    <select
                        required
                        id="res_type"
                        name="res_type"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>
                            Select respondent type
                        </option>
                        <option value="individual">Individual</option>
                        <option value="organization">Organization</option>
                    </select>
                </div>

                <div
                    class="col-span-2 grid hidden grid-cols-2 gap-6"
                    id="res_individual_fields"
                >
                    <div class="flex flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="res_name">
                            Name
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            required
                            name="res_name"
                            type="text"
                            placeholder="Respondent name"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="res_age">
                            Age
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            required
                            type="text"
                            minlength="2"
                            maxlength="3"
                            name="res_age"
                            placeholder="Respondent age"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="res_state">
                            State
                        </label>
                        <select
                            required
                            name="res_state"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select state
                            </option>
                            <option value="assam">Assam</option>
                            <option value="null">Option 2</option>
                        </select>
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="res_district">
                            District
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="res_district"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="" disabled selected>
                                Select district
                            </option>
                            <option value="null">Option 1</option>
                            <option value="null">Option 2</option>
                        </select>
                    </div>
                </div>

                <div
                    class="col-span-2 grid hidden grid-cols-2 gap-6"
                    id="res_organization_fields"
                >
                    <div class="flex flex-col gap-2.5">
                        <label class="text-xl font-semibold" for="res_ministry">
                            Ministry
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="res_ministry"
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
                            for="res_department"
                        >
                            Department
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="res_department"
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
                            for="res_contact_person"
                        >
                            Contact Person
                            <span class="text-red-400">*</span>
                        </label>
                        <input
                            required
                            type="text"
                            name="res_contact_person"
                            placeholder="Contact person name"
                            class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    <div class="flex min-w-1/4 flex-col gap-2.5">
                        <label
                            class="text-xl font-semibold"
                            for="res_designation"
                        >
                            Contact Person Designation
                            <span class="text-red-400">*</span>
                        </label>
                        <select
                            required
                            name="res_designation"
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
                    <label class="text-xl font-semibold" for="res_phone">
                        Phone No.
                        <span class="text-red-400">*</span>
                    </label>
                    <input
                        required
                        type="text"
                        minlength="10"
                        maxlength="10"
                        name="res_phone"
                        placeholder="Respondent phone no."
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="flex min-w-1/4 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="res_email">
                        Email
                        <span class="text-red-400">*</span>
                    </label>
                    <input
                        required
                        type="email"
                        name="res_email"
                        placeholder="Respondent email address"
                        class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <div class="colspan-2 flex flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="res_address">
                        Address
                        <span class="text-red-400">*</span>
                    </label>
                    <textarea
                        required
                        name="res_address"
                        rows="4"
                        cols="10"
                        placeholder="Respondent address"
                        class="w-full resize rounded-sm border border-gray-400 p-4"
                    ></textarea>
                </div>
            </form>
            <div class="flex justify-end p-6">
                <button
                    form="respondent_info"
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
        const res_type = document.getElementById('res_type')
        const res_ind_div = document.getElementById('res_individual_fields')
        const res_org_div = document.getElementById('res_organization_fields')
        res_type.addEventListener('change', () => {
            const selectedType = event.target.value

            res_ind_div.classList.add('hidden')
            res_org_div.classList.add('hidden')

            if (selectedType === 'individual') {
                res_ind_div.classList.remove('hidden')
            } else if (selectedType === 'organization') {
                res_org_div.classList.remove('hidden')
            }
        })

        document.addEventListener('DOMContentLoaded', function () {
            const res_type = document.getElementById('res_type')
            const res_ind_div = document.getElementById('res_individual_fields')
            const res_org_div = document.getElementById(
                'res_organization_fields'
            )

            // Get all form inputs
            const individualInputs =
                res_ind_div.querySelectorAll('input, select')
            const organizationInputs =
                res_org_div.querySelectorAll('input, select')

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
                if (selectedType === 'individual') {
                    individualInputs.forEach((input) => {
                        input.required = true
                    })
                } else if (selectedType === 'organization') {
                    organizationInputs.forEach((input) => {
                        input.required = true
                    })
                }
            }

            // Toggle visibility and required attributes on change
            res_type.addEventListener('change', (event) => {
                const selectedType = event.target.value

                res_ind_div.classList.add('hidden')
                res_org_div.classList.add('hidden')

                if (selectedType === 'individual') {
                    res_ind_div.classList.remove('hidden')
                } else if (selectedType === 'organization') {
                    res_org_div.classList.remove('hidden')
                }

                // Update required attributes
                toggleRequiredAttributes(selectedType)
            })

            // Handle form submission
            document
                .getElementById('respondent_info')
                .addEventListener('submit', function (event) {
                    const selectedType = res_type.value

                    // Make sure the required attributes are set correctly before submission
                    toggleRequiredAttributes(selectedType)
                })

            // Initialize with empty state (no required fields)
            toggleRequiredAttributes('')
        })
    </script>
</x-layout>
