<x-layout title="Department Users | Admin">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <x-admin.container header="Department Users">
            <div class="mb-5 flex flex-row items-center justify-start gap-3">
                <a
                    href="{{ route('admin.internal.dept.show') }}"
                    class="flex w-1/12 flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 p-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
                >
                    <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                    <p>Back</p>
                </a>
                <a
                    href="{{ route('admin.internal.dept.roles.index') }}"
                    class="flex w-1/6 flex-row items-center justify-center gap-1.5 rounded border bg-green-600 p-2.5 font-semibold text-white shadow-sm hover:bg-green-700"
                >
                    <x-fas-user-pen class="h-4.5 w-4.5 text-white" />
                    <p>Manage Roles</p>
                </a>
            </div>

            <div class="mb-5 flex flex-row items-center justify-between gap-5">
                <h2 class="text-xl font-semibold">List of Registered Users</h2>
                <a
                    href="{{ route('admin.internal.dept.users.create') }}"
                    class="flex w-1/6 flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 p-1.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
                >
                    <x-fas-plus class="h-4 w-4 text-gray-600" />
                    Create New User
                </a>
            </div>
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-200">
                    <tr class="text-left">
                        <th class="border border-gray-300 px-4 py-3">
                            Serial No.
                        </th>
                        <th class="border border-gray-300 px-4 py-3">Name</th>
                        <th class="border border-gray-300 px-4 py-3">Email</th>
                        <th class="border border-gray-300 px-4 py-3">
                            Role(s)
                        </th>
                        <th class="border border-gray-300 px-4 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="text-left hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">
                                {{ $loop->iteration }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                {{ $user->name }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                {{ $user->email }}
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @foreach ($user->getRoleNames() as $role)
                                    <span
                                        class="mr-2 rounded-sm bg-gray-800 px-4 py-2 font-medium text-gray-200"
                                    >
                                        {{ $role }}
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
                {{ $users->links() }}
            </div>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
    @stack('scripts')
</x-layout>
