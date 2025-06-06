<div class="flex items-center justify-between gap-5">
    {{-- Sort By {{{1 --}}
    <h2 class="text-2xl font-semibold">
        Total Case Count :
        <span class="text-red-500">{{ $case_count }}</span>
    </h2>

    <div class="flex gap-6">
        <div
            x-data="{
                open: false,
                close() {
                    this.open = false
                },
                toggle() {
                    this.open = this.open ? this.close() : true
                },
            }"
            class="relative"
        >
            <div class="flex items-center gap-3">
                <p class="font-medium text-gray-700">Sort By :</p>
                <button
                    type="button"
                    @click="toggle()"
                    class="flex gap-2 cursor-pointer rounded-sm border border-gray-300 bg-gray-100 px-4 py-2 text-gray-700 shadow-sm shadow-gray-200 hover:border-gray-300 hover:bg-gray-200 focus:ring-1 focus:ring-blue-600 focus:outline-none"
                >
                    {{ $columns[$currentColumn] }}
                    <x-fas-sort-down class="w-2.5 h-5 text-gray-600" />
                </button>
            </div>

            <div
                x-show="open"
                @click.prevent.outside="close()"
                style="display: none; min-width: 200px"
                class="absolute right-0 z-10 mt-2 rounded-sm border border-gray-300 bg-gray-100 shadow-sm shadow-gray-200"
            >
                @foreach ($columns as $col => $label)
                    <div class="hover:bg-gray-200">
                        <button
                            @click="$wire.orderBy('{{ $col }}')"
                            class="cursor-pointer px-4 py-2 text-left"
                        >
                            {{ $label }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- 1}}} --}}
        {{-- Sort order {{{1 --}}
        <div
            x-data="{
                open: false,
                close() {
                    this.open = false
                },
                toggle() {
                    this.open = this.open ? this.close() : true
                },
            }"
            class="relative"
        >
            <div class="flex items-center gap-3">
                <p class="font-medium text-gray-700">Sorting Order :</p>
                <button
                    type="button"
                    @click="toggle()"
                    class="flex cursor-pointer gap-2 rounded-sm border border-gray-300 bg-gray-100 px-4 py-2 text-gray-700 shadow-sm shadow-gray-200 hover:border-gray-300 hover:bg-gray-200 focus:ring-1 focus:ring-blue-600 focus:outline-none"
                >
                    {{ $sortOrders[$currentOrder] }}
                    <x-fas-sort-down class="w-2.5 h-5 text-gray-600" />
                </button>
            </div>

            <div
                x-show="open"
                @click.prevent.outside="close()"
                style="display: none"
                class="absolute right-0 z-10 mt-2 rounded-sm border border-gray-300 bg-gray-100 shadow-sm shadow-gray-200"
            >
                @foreach ($sortOrders as $order => $label)
                    <div class="text-gray-700 hover:bg-gray-200">
                        <button
                            @click="$wire.orderBy('{{ $currentColumn }}', '{{ $order }}')"
                            class="cursor-pointer px-4 py-2 text-left"
                        >
                            {{ $label }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- 1}}} --}}
</div>
