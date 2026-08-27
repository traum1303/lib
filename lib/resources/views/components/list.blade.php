@props(['items', 'limit' => 3])

@if ($items->isEmpty())
    <span class="text-gray-400 text-xs">— не указано —</span>
@else
    <div class="list" data-limit="{{ $limit }}">
        <div class="list-visible flex flex-wrap gap-1">
            @foreach ($items->take($limit) as $item)
                <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">
                    {{ $item->value }}
                </span>
            @endforeach
        </div>

        @if ($items->count() > $limit)
            <div class="list-hidden hidden flex-wrap gap-1 mt-1">
                @foreach ($items->slice($limit) as $item)
                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">
                        {{ $item->value }}
                    </span>
                @endforeach
            </div>

            <button type="button" class="list-toggle mt-1 text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                Ещё {{ $items->count() - $limit }}
            </button>
        @endif
    </div>
@endif
