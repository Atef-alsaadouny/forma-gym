@props([
    'headers' => [],
    'rows' => [],
    'empty' => true,
    'emptyTitle' => __('No data found'),
    'emptyMessage' => null,
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-gym-border bg-gym-white shadow-sm']) }}>
    @if(count($headers) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gym-border">
                <thead class="bg-gym-light">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-gym-muted">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gym-border bg-gym-white">
                    @forelse($rows as $row)
                        <tr class="hover:bg-gym-inactive-bg transition-colors">
                            @foreach($row as $cell)
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gym-text">
                                    {{ $cell }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($headers) }}" class="px-6 py-12">
                                <x-empty-state
                                    :title="$emptyTitle"
                                    :message="$emptyMessage"
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="px-6 py-12">
            {{ $slot ?? '' }}
            @if($empty)
                <x-empty-state
                    :title="$emptyTitle"
                    :message="$emptyMessage"
                />
            @endif
        </div>
    @endif
</div>
