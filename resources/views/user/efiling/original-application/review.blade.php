<x-layout title="Application Filing">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="
            background-image: url('{{ asset('images/supreme_court.jpg') }}');
        "
    >
        <x-user.container header="Review Form">
            <div class="m-6 mb-0 flex flex-col">
                {{-- Case Info --}}
                <div class="flex flex-col">
                    <x-user.btn.edit-case-sec
                        heading="Case Details"
                        step="1"
                        :case_file="$case_file"
                    />
                    <div
                        class="mb-6 grid grid-cols-2 rounded-sm bg-gray-200 p-2"
                    >
                        <p class="col-span-2 p-2">
                            <span class="font-medium">Case Type</span>
                            : {{ $case_file->case_type }}
                        </p>

                        <hr class="col-span-2 mt-2 mb-2 w-full text-gray-300" />

                        <p class="p-2">
                            <span class="font-medium">Subject</span>
                            : {{ $case_file->subject }}
                        </p>
                        <p class="p-2">
                            <span class="font-medium">Bench</span>
                            : {{ $case_file->bench }}
                        </p>
                        <p class="p-2">
                            <span class="font-medium">Filed By</span>
                            : {{ $case_file->filed_by }}
                        </p>
                        <p class="p-2">
                            <span class="font-medium">Filing Date</span>
                            : {{ $case_file->filing_date }}
                        </p>
                        <p class="p-2">
                            <span class="font-medium">Filing No.</span>
                            : {{ $case_file->filing_number }}
                        </p>
                        <p class="p-2">
                            <span class="font-medium">Legal Aid Required</span>
                            : {{ $case_file->legal_aid == 1 ? 'Yes' : 'No' }}
                        </p>
                    </div>
                </div>
                {{-- Petitioners Info --}}
                <div class="flex flex-col">
                    <x-user.btn.edit-case-sec
                        heading="Petitioner(s) Info"
                        step="2"
                        :case_file="$case_file"
                    />

                    @foreach ($case_file->petitioners as $pet)
                        <div
                            class="mb-6 grid grid-cols-2 rounded-sm bg-gray-200 p-2"
                        >
                            <p class="col-span-2 p-2">
                                <span class="font-medium">Petitioner Type</span>
                                : {{ $pet->pet_type }}
                            </p>

                            <hr
                                class="col-span-2 mt-2 mb-2 w-full text-gray-300"
                            />

                            <p class="p-2">
                                <span class="font-medium">Email Address</span>
                                : {{ $pet->pet_email }}
                            </p>
                            <p class="p-2">
                                <span class="font-medium">Phone No.</span>
                                : {{ $pet->pet_phone }}
                            </p>
                            <p class="col-span-2 p-2">
                                <span class="font-medium">Address</span>
                                : {{ $pet->pet_address }}
                            </p>

                            <hr
                                class="col-span-2 mt-2 mb-2 w-full text-gray-300"
                            />

                            @if ($pet->pet_type == 'Individual')
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's Name
                                    </span>
                                    : {{ $pet->pet_name }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's Age
                                    </span>
                                    : {{ $pet->pet_age }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's State
                                    </span>
                                    : {{ $pet->pet_state }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's District
                                    </span>
                                    : {{ $pet->pet_district }}
                                </p>
                            @elseif ($pet->pet_type == 'Organization')
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's Ministry
                                    </span>
                                    : {{ $pet->pet_ministry }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's Department
                                    </span>
                                    : {{ $pet->pet_department }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's Contact Person
                                    </span>
                                    : {{ $pet->pet_contact_person }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Petitioner's Designation
                                    </span>
                                    : {{ $pet->pet_designation }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Respondents Info --}}
                <div class="flex flex-col">
                    <x-user.btn.edit-case-sec
                        heading="Respondet(s) Info"
                        step="3"
                        :case_file="$case_file"
                    />
                    @foreach ($case_file->respondents as $res)
                        <div
                            class="mb-6 grid grid-cols-2 rounded-sm bg-gray-200 p-2"
                        >
                            <p class="col-span-2 p-2">
                                <span class="font-medium">Respondent Type</span>
                                : {{ $res->res_type }}
                            </p>

                            <hr
                                class="col-span-2 mt-2 mb-2 w-full text-gray-300"
                            />

                            <p class="p-2">
                                <span class="font-medium">Email Address</span>
                                : {{ $res->res_email }}
                            </p>
                            <p class="p-2">
                                <span class="font-medium">Phone No.</span>
                                : {{ $res->res_phone }}
                            </p>
                            <p class="col-span-2 p-2">
                                <span class="font-medium">Address</span>
                                : {{ $res->res_address }}
                            </p>

                            <hr
                                class="col-span-2 mt-2 mb-2 w-full text-gray-300"
                            />

                            @if ($res->res_type == 'Individual')
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's Name
                                    </span>
                                    : {{ $res->res_name }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's Age
                                    </span>
                                    : {{ $res->res_age }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's State
                                    </span>
                                    : {{ $res->res_state }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's District
                                    </span>
                                    : {{ $res->res_district }}
                                </p>
                            @elseif ($res->res_type == 'Organization')
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's Ministry
                                    </span>
                                    : {{ $res->res_ministry }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's Department
                                    </span>
                                    : {{ $res->res_department }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's Contact Person
                                    </span>
                                    : {{ $res->res_contact_person }}
                                </p>
                                <p class="p-2">
                                    <span class="font-medium">
                                        Respondent's Designation
                                    </span>
                                    : {{ $res->res_designation }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Document Info --}}
                <div class="flex flex-col">
                    <x-user.btn.edit-case-sec
                        heading="Document(s) Uploaded"
                        step="4"
                        :case_file="$case_file"
                    />
                    @if (! empty($case_file->documents))
                        <div
                            class="mb-6 grid grid-cols-1 rounded-sm bg-gray-200 p-2"
                        >
                            <p class="p-2">No documents found</p>
                        </div>
                    @else
                        @foreach ($case_file->documents as $doc)
                            @if (! empty($doc->document_path))
                                <div
                                    class="mb-6 grid grid-cols-2 rounded-sm bg-gray-200 p-2"
                                >
                                    <p class="col-span-2 p-2">
                                        <span class="font-medium">
                                            Document
                                        </span>
                                        : {{ $doc->document_path }}
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                {{-- Payment Info --}}
                <div class="flex flex-col">
                    <x-user.btn.edit-case-sec
                        heading="Payment Info"
                        step="5"
                        :case_file="$case_file"
                    />
                    @foreach ($case_file->payment as $pay)
                        <div
                            class="mb-6 grid grid-cols-2 rounded-sm bg-gray-200 p-2"
                        >
                            <p class="col-span-2 p-2">
                                <span class="font-medium">Payment Mode</span>
                                : {{ $pay->payment_mode }}
                            </p>

                            <hr
                                class="col-span-2 mt-2 mb-2 w-full text-gray-300"
                            />

                            <p class="p-2">
                                <span class="font-medium">
                                    Amount Paid (in ₹)
                                </span>
                                : {{ $pay->amount ? $pay->amount : 'Not provided' }}
                            </p>
                            <p class="p-2">
                                <span class="font-medium">
                                    Payment Reference No.
                                </span>
                                : {{ $pay->ref_no ? $pay->ref_no : 'Not provided' }}
                            </p>
                            <p class="p-2">
                                <span class="font-medium">Date of Payment</span>
                                : {{ $pay->ref_date ? $pay->ref_date : 'Not provided' }}
                            </p>
                            <p class="p-2">
                                <span class="font-medium">Transaction ID</span>
                                : {{ $pay->transaction_id ? $pay->transaction_id : 'Not provided' }}
                            </p>

                            <hr
                                class="col-span-2 mt-2 mb-2 w-full text-gray-300"
                            />

                            <p class="col-span-2 p-2">
                                <span class="flex flex-row gap-2">
                                    <span class="font-medium">
                                        Payment Receipt :
                                    </span>
                                    <a
                                        href="{{ asset('storage/' . $pay->payment_receipt) }}"
                                        target="_blank"
                                        class="underline"
                                    >
                                        <span
                                            class="flex flex-row items-center gap-1.5"
                                        >
                                            <x-fas-hand-point-right
                                                class="h-4 w-4"
                                            />
                                            view uploaded receipt
                                        </span>
                                    </a>
                                </span>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end p-6">
                <form
                    action="{{ route('user.efiling.submit', ['case_file_id' => $case_file->id]) }}"
                    method="POST"
                >
                    @csrf
                    <button
                        class="cursor-pointer rounded bg-blue-500 px-6 py-2 font-semibold text-white shadow-sm hover:bg-blue-600"
                        type="submit"
                    >
                        Confirm & Submit
                    </button>
                </form>
            </div>
        </x-user.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
