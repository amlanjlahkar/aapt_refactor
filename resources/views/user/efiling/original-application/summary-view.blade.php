<x-layout>
    <header>
        <div class="m-20 mb-0 flex items-center justify-between gap-3">
            <div class="flex flex-row items-center gap-5">
                <!-- <img -->
                <!--     src="{{ asset('images/india_emblem.png') }}" -->
                <!--     alt="India Emblem" -->
                <!--     class="h-28 object-contain" -->
                <!-- /> -->
                <div class="flex flex-col gap-1.5">
                    <h2 class="font-noto-assamese text-2xl font-semibold">
                        অসম প্ৰশাসনিক আৰু পেঞ্চন ন্যায়াধিকৰণ
                    </h2>
                    <h2 class="text-2xl font-medium">
                        Assam Administrative and Pension Tribunal
                    </h2>
                    <h3 class="text-xl font-medium">Guwahati, Assam</h3>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="m-20 mt-10 flex flex-col gap-10">
            <h2 class="text-2xl font-semibold">
                Filing No.
                <span class="text-red-600">
                    @up($case_file->filing_number)
                </span>
            </h2>

            {{-- Case Info --}}
            <table class="table-auto border">
                <thead>
                    <tr class="bg-gray-300">
                        <th
                            colspan="2"
                            class="p-2 text-left text-2xl font-semibold"
                        >
                            Case Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border">
                        <td colspan="2" class="p-2">
                            <span class="font-medium">Case Type</span>
                            :
                            @up($case_file->case_type)
                        </td>
                    </tr>
                    <tr class="border">
                        <td class="border p-2">
                            <span class="font-medium">Subject</span>
                            : {{ $case_file->subject }}
                        </td>
                        <td class="p-2">
                            <span class="font-medium">Bench</span>
                            :
                            @up($case_file->bench)
                        </td>
                    </tr>
                    <tr class="border">
                        <td class="border p-2">
                            <span class="font-medium">Filed By</span>
                            : {{ $case_file->filed_by }}
                        </td>
                        <td class="border p-2">
                            <span class="font-medium">Filing Date</span>
                            : {{ $case_file->filing_date }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border p-2">
                            <span class="font-medium">Filing ID</span>
                            : {{ $case_file->filing_number }}
                        </td>
                        <td class="p-2">
                            <span class="font-medium">Legal Aid Required</span>
                            : {{ $case_file->legal_aid == 1 ? 'Yes' : 'No' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Petitioners Info --}}
            <table class="table-auto border">
                <thead>
                    <tr class="bg-gray-300">
                        <th
                            colspan="2"
                            class="p-2 text-left text-2xl font-semibold"
                        >
                            Petitioner(s) Info
                        </th>
                    </tr>
                </thead>
                @foreach ($case_file->petitioners as $pet)
                    <tbody>
                        <tr class="border">
                            <td colspan="2" class="p-2">
                                <span class="font-medium">Petitioner Type</span>
                                :
                                @up($pet->pet_type)
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2">
                                <span class="font-medium">Email Address</span>
                                : {{ $pet->pet_email }}
                            </td>
                            <td class="border p-2">
                                <span class="font-medium">Phone No.</span>
                                : {{ $pet->pet_phone }}
                            </td>
                        </tr>
                        <tr class="border">
                            <td colspan="2" class="p-2">
                                <span class="font-medium">Address</span>
                                : {{ $pet->pet_address }}
                            </td>
                        </tr>

                        @if ($pet->pet_type == 'Individual')
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's Name
                                    </span>
                                    :
                                    @up($pet->pet_name)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's Age
                                    </span>
                                    : {{ $pet->pet_age }}
                                </td>
                            </tr>
                            <tr class="border">
                                <td class="p-2">
                                    <span class="font-medium">
                                        Petitioner's State
                                    </span>
                                    :
                                    @up($pet->pet_state)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's District
                                    </span>
                                    :
                                    @up($pet->pet_district)
                                </td>
                            </tr>
                        @elseif ($pet->pet_type == 'Organization')
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's Ministry
                                    </span>
                                    :
                                    @up($pet->pet_ministry)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's Department
                                    </span>
                                    :
                                    @up($pet->pet_department)
                                </td>
                            </tr>
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's Contact Person
                                    </span>
                                    :
                                    @up($pet->pet_contact_person)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Petitioner's Designation
                                    </span>
                                    :
                                    @up($pet->pet_designation)
                                </td>
                            </tr>
                        @endif
                    </tbody>
                @endforeach
            </table>

            {{-- Respondents Info --}}
            <table class="table-auto border">
                <thead>
                    <tr class="bg-gray-300">
                        <td
                            colspan="2"
                            class="p-2 text-left text-2xl font-semibold"
                        >
                            Respondents Info
                        </td>
                    </tr>
                </thead>
                @foreach ($case_file->respondents as $res)
                    <tbody>
                        <tr class="border">
                            <td colspan="2" class="p-2">
                                <span class="font-medium">Respondent Type</span>
                                :
                                @up($res->res_type)
                            </td>
                        </tr>

                        <tr>
                            <td class="border p-2">
                                <span class="font-medium">Email Address</span>
                                : {{ $res->res_email }}
                            </td>
                            <td class="border p-2">
                                <span class="font-medium">Phone No.</span>
                                : {{ $res->res_phone }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="p-2">
                                <span class="font-medium">Address</span>
                                : {{ $res->res_address }}
                            </td>
                        </tr>

                        @if ($res->res_type == 'Individual')
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's Name
                                    </span>
                                    :
                                    @up($res->res_name)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's Age
                                    </span>
                                    : {{ $res->res_age }}
                                </td>
                            </tr>
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's State
                                    </span>
                                    :
                                    @up($res->res_state)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's District
                                    </span>
                                    :
                                    @up($res->res_district)
                                </td>
                            </tr>
                        @elseif ($res->res_type == 'Organization')
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's Ministry
                                    </span>
                                    :
                                    @up($res->res_ministry)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's Department
                                    </span>
                                    :
                                    @up($res->res_department)
                                </td>
                            </tr>
                            <tr class="border">
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's Contact Person
                                    </span>
                                    :
                                    @up($res->res_contact_person)
                                </td>
                                <td class="border p-2">
                                    <span class="font-medium">
                                        Respondent's Designation
                                    </span>
                                    :
                                    @up($res->res_designation)
                                </td>
                            </tr>
                        @endif
                    </tbody>
                @endforeach
            </table>

            {{-- Document Info --}}
            <table class="table-auto border">
                <thead>
                    <tr class="bg-gray-300">
                        <td
                            colspan="2"
                            class="p-2 text-left text-2xl font-semibold"
                        >
                            Documents Uploaded
                        </td>
                    </tr>
                </thead>
                @if (! empty($case_file->documents))
                    <tbody>
                        <tr class="border p-2">
                            <td class="p-2">No documents found</td>
                        </tr>
                    </tbody>
                @else
                    <tbody>
                        @foreach ($case_file->documents as $doc)
                            <tr class="border">
                                @if (! empty($doc->document))
                                    <td class="p-2">
                                        <span class="font-medium">
                                            Document
                                        </span>
                                        : {{ $doc->document }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>

            {{-- Payment Info --}}
            <table class="table-auto border">
                <thead>
                    <tr class="bg-gray-300">
                        <td
                            colspan="2"
                            class="p-2 text-left text-2xl font-semibold"
                        >
                            Payment Info
                        </td>
                    </tr>
                </thead>
                @foreach ($case_file->payment as $pay)
                    <tbody>
                        <tr class="border">
                            <td colspan="2" class="border p-2">
                                <span class="font-medium">Payment Mode</span>
                                :
                                @up($pay->payment_mode)
                            </td>
                        </tr>
                        <tr class="border">
                            <td class="border p-2">
                                <span class="font-medium">
                                    Amount Paid (in ₹)
                                </span>
                                : {{ $pay->amount ? $pay->amount : 'NOT PROVIDED' }}
                            </td>
                            <td class="border p-2">
                                <span class="font-medium">
                                    Payment Reference No.
                                </span>
                                :
                                @up($pay->ref_no ? $pay->ref_no : 'NOT PROVIDED')
                            </td>
                        </tr>
                        <tr class="border">
                            <td class="border p-2">
                                <span class="font-medium">Date of Payment</span>
                                : {{ $pay->ref_date ? $pay->ref_date : 'NOT PROVIDED' }}
                            </td>
                            <td class="border p-2">
                                <span class="font-medium">Transaction ID</span>
                                :
                                @up($pay->transaction_id ? $pay->transaction_id : 'NOT PROVIDED')
                            </td>
                        </tr>
                        <tr class="border">
                            <td colspan="2" class="border p-2">
                                <span class="flex flex-row gap-2">
                                    <span class="font-medium">
                                        Payment Receipt :
                                    </span>
                                    <a
                                        href="{{ asset('storage/' . $pay->payment_receipt) }}"
                                        target="_blank"
                                        class="text-blue-700 underline"
                                    >
                                        View receipt
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
            <div>
                <p class="text-sm text-gray-500 italic">
                    Note: This is a system-generated receipt and does not
                    require any signature. Please retain this document for your
                    records. If you have any questions or require further
                    assistance, kindly contact our support team through the
                    official channels.
                </p>
            </div>
        </div>
    </main>
</x-layout>
