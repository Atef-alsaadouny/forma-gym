@props(['package'])

<div class="flex items-center gap-2">
    <a
        href="{{ route('admin.packages.show', $package) }}"
        class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium text-gym-muted hover:bg-gym-light transition-colors"
    >
        {{ __('View') }}
    </a>
    <a
        href="{{ route('admin.packages.edit', $package) }}"
        class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium text-gym-primary hover:bg-gym-primary/10 transition-colors"
    >
        {{ __('Edit') }}
    </a>
    <form
        method="POST"
        action="{{ route('admin.packages.destroy', $package) }}"
        onsubmit="return confirm('{{ __('Are you sure?') }}')"
        class="inline"
    >
        @csrf
        @method('DELETE')
        <button
            type="submit"
            class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium text-gym-danger hover:bg-gym-danger-bg transition-colors"
        >
            {{ __('Delete') }}
        </button>
    </form>
</div>
