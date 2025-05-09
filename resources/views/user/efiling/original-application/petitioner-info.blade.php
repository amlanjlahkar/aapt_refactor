<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Step {{ session('step') }}: Petitioner Information">
            <form
                id="petitioner_info"
                class="grid grid-cols-2 gap-6 rounded-md p-6 pb-0"
                method="POST"
                action="#"
            >
                @csrf
                <div class="col-span-2 flex w-1/3 flex-col gap-2.5">
                    <label class="text-xl font-semibold" for="pet_type">
                        Petitioner Type
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
                        <option value="individual">Individual</option>
                        <option value="organization">Organization</option>
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
                            <option value="assam">Assam</option>
                            <option value="null">Option 2</option>
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
                            <option value="null">Option 1</option>
                            <option value="null">Option 2</option>
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
                    Save & Proceed (2/5)
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
        const pet_type = document.getElementById('pet_type')
        const pet_ind_div = document.getElementById('pet_individual_fields')
        const pet_org_div = document.getElementById('pet_organization_fields')
        pet_type.addEventListener('change', () => {
            const selectedType = event.target.value

            pet_ind_div.classList.add('hidden')
            pet_org_div.classList.add('hidden')

            if (selectedType === 'individual') {
                pet_ind_div.classList.remove('hidden')
            } else if (selectedType === 'organization') {
                pet_org_div.classList.remove('hidden')
            }
        })
    </script>
</x-layout>
