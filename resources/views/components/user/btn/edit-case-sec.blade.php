@props([
    'heading' => null,
    'step' => null,
    'case_file' => null,
])

<div class="mb-4 flex flex-row items-center justify-between">
   <h2 class="text-2xl font-semibold">{{ $heading }}</h2>
    <a
        title="Edit"
        href="{{ route('user.efiling.register.step' . $step . '.edit', ['case_file_id' => $case_file->id]) }}"
    >
        <span class="flex flex-row items-center gap-2 text-cyan-700">
            <x-fas-pen-to-square class="h-5 w-5" />
            <p class="text-xl font-medium">Edit</p>
        </span>
    </a>
</div>

