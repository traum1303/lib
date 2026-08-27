@props(['items', 'label', 'searchUrl', 'placeholder'])
<div class="w-full">
    <label for="search-input" class="block text-sm font-medium text-gray-700 mb-1">{{$label}}</label>

    <div id="search-wrapper" class="relative">
        <input
            type="text"
            id="search-input"
            autocomplete="off"
            data-search-url="{{$searchUrl}}"
            placeholder="{{$placeholder}}"
            class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('searched_ids') border-red-300 @enderror"
        >
        <div id="search-results" class="hidden absolute z-20 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-56 overflow-y-auto">
        </div>
    </div>

    <div id="selected-items" class="mt-3 flex flex-wrap gap-2">
        @foreach ($items as $item)
            <span class="item-tag inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 text-sm px-3 py-1 rounded-full" data-id="{{ $item->id }}">
                {{ $item->searchValue }}
                <button type="button" class="remove-search-item-tag text-indigo-400 hover:text-indigo-600 leading-none">
                    &times;
                </button>
                <input type="hidden" name="searched_ids[]" value="{{ $item->id }}">
            </span>
        @endforeach
    </div>

    @error('searched_ids')
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
@push('scripts')
    @vite('resources/js/components/item-search.js')
@endpush
