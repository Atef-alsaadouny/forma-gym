@props(['record'])

<div class="flex items-center gap-2">
    <a
        href="{{ route('admin.attendance.show', $record) }}"
        class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium text-gym-muted hover:bg-gym-light transition-colors"
    >
        {{ __('View') }}
    </a>
    @can('update', $record)
        <a
            href="{{ route('admin.attendance.edit', $record) }}"
            class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium text-gym-primary hover:bg-gym-primary/10 transition-colors"
        >
            {{ __('Edit') }}
        </a>
        @if(!$record->checked_out_at)
            <form
                method="POST"
                action="{{ route('admin.attendance.check-out', $record) }}"
                class="inline"
            >
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium text-gym-warning hover:bg-gym-warning-bg transition-colors"
                >
                    {{ __('Check Out') }}
                </button>
            </form>
        @endif
    @endcan
    @can('delete', $record)
        <form
            method="POST"
            action="{{ route('admin.attendance.destroy', $record) }}"
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
    @endcan
</div>
