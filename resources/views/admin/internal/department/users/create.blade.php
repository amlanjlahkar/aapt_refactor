<x-layout title="Department Users | Admin">
    @include('partials.header')
    <main
        class="grow bg-cover bg-center"
        style="background-image: url('{{ asset('images/gavel.jpg') }}')"
    >
        <x-admin.container header="Create Department User">
            <a
                href="{{ route('admin.internal.dept.users.index') }}"
                class="flex w-1/12 flex-row items-center justify-center gap-1.5 rounded border border-gray-300 bg-gray-100 p-2.5 font-semibold text-gray-600 shadow-sm hover:bg-gray-200"
            >
                <x-fas-arrow-left class="h-4 w-4 text-gray-600" />
                <p>Back</p>
            </a>

            <form
                method="POST"
                action="{{ route('admin.internal.dept.users.store') }}"
                class="mt-5 grid grid-cols-2 gap-5"
            >
                @csrf
                <div class="">
                    <label
                        for="name"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Name
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter user name"
                        value="{{ old('name') }}"
                        class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
                <div class="">
                    <label
                        for="email"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter user email"
                        value="{{ old('email') }}"
                        class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
                <div class="">
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Password
                        </label>
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter user password"
                        class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
                <div class="">
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Confirm Password
                        </label>
                    </div>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm user password"
                        class="w-full rounded-sm border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required
                    />
                </div>
                <div class="">
                    <label
                        for="password"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Choose Role
                    </label>
                    <select
                        required
                        name="role"
                        {{-- class="rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none" --}}
                        class="w-full rounded-sm border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                        <option value="" disabled selected>
                            Select User Role
                        </option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
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
