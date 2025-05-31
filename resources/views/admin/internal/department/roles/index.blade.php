<x-layout title="Department Roles | Admin">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <x-admin.container header="Department Roles">
            <div class="mb-5 flex flex-row items-center justify-start gap-3">
                <a
                    href="{{ route('admin.internal.dept.users.index') }}"
                    class="flex w-1/12 flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 p-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
                >
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <p>Back</p>
                </a>
            </div>

            <div class="mb-5 flex flex-row items-center justify-between gap-5">
                <h2 class="text-xl font-semibold">Available Roles</h2>
                <a
                    href="{{ route('admin.internal.dept.roles.create') }}"
                    class="flex w-1/6 flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 p-1.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
                >
                    <x-fas-plus class="h-4 w-4 text-gray-800" />
                    Create New Role
                </a>
            </div>

            <div>
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr class="text-left">
                            <th class="border border-gray-300 px-4 py-3">
                                Role
                            </th>
                            <th class="border border-gray-300 px-4 py-3">
                                Permission(s)
                            </th>
                            <th class="border border-gray-300 px-4 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $r)
                            <tr class="text-left hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3">
                                    {{ $r->name }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    @foreach ($r->permissions as $p)
                                        <span
                                            class="mr-2 rounded-sm border border-blue-300 bg-blue-50 p-1.5 text-sm"
                                        >
                                            {{ $p->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="border border-gray-300 px-2 py-3">
                                    <div class="grid grid-cols-3 gap-3 px-2">
                                        <a
                                            href="#"
                                            class="flex items-center justify-center gap-1.5 rounded-sm bg-blue-600 px-3.5 py-1.5 text-sm font-medium text-blue-50 shadow-md hover:bg-blue-700"
                                        >
                                            <x-fas-eye class="h-3.5 w-3.5" />
                                            View
                                        </a>
                                        <a
                                            href="#"
                                            class="flex items-center justify-center gap-1.5 rounded-sm bg-purple-600 px-3.5 py-1.5 text-sm font-medium text-purple-50 shadow-md hover:bg-purple-700"
                                        >
                                            <x-fas-pen class="h-3.5 w-3.5" />
                                            Edit
                                        </a>
                                        <a
                                            href="#"
                                            class="flex items-center justify-center gap-1.5 rounded-sm bg-red-600 px-3.5 py-1.5 text-sm font-medium text-red-50 shadow-md hover:bg-red-700"
                                        >
                                            <x-fas-xmark class="h-3.5 w-3.5" />
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $roles->links() }}
                </div>
            </div>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
</x-layout>
