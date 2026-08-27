@forelse ($items as $item)
    <div
        class="search-item px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 cursor-pointer"
        data-id="{{ $item->id }}"
        @foreach($item->hiddenValues as $k => $v)
        data-hidden-{{$k}}="{{$v}}"
        @endforeach
        data-value="{{ $item->searchValue }}"
    >
        {{ $item->searchValue }}
    </div>
@empty
    <div class="px-3 py-2 text-sm text-gray-400">
        Ничего не найдено
    </div>
@endforelse
