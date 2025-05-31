<x-layout title="Department Roles | Admin">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <x-admin.container header="Create Department User">
            <a
                href="{{ route('admin.internal.dept.roles.index') }}"
                class="flex w-1/12 flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 p-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
            >
                <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                <p>Back</p>
            </a>

            <form
                method="POST"
                action="{{ route('admin.internal.dept.roles.store') }}"
                class="mt-5 grid grid-cols-2 gap-5"
            >
                @csrf
                <div class="w-1/2">
                    <label
                        for="role"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Role Name
                    </label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        placeholder="Enter role name"
                        value="{{ old('role') }}"
                        class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="permissions"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Select Permissions
                    </label>
                    <div
                        class="flex flex-col items-start justify-start gap-2 rounded-sm border border-gray-300 p-2.5"
                    >
                        @foreach ($permissions as $perm)
                            <div class="flex justify-center gap-2">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $perm->name }}"
                                />
                                <label>{{ $perm->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <!-- <input -->
                    <!--     type="email" -->
                    <!--     id="email" -->
                    <!--     name="email" -->
                    <!--     placeholder="Enter user email" -->
                    <!--     value="{{ old('email') }}" -->
                    <!--     class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" -->
                    <!--     required -->
                    <!-- /> -->
                </div>
                <button
                    type="submit"
                    class="col-span-2 cursor-pointer rounded bg-blue-500 px-4 py-2 font-semibold text-white hover:bg-blue-600"
                >
                    Submit
                </button>
            </form>
        </x-admin.container>
    </main>
    @include('partials.footer-alt')
    @stack('scripts')
</x-layout>
