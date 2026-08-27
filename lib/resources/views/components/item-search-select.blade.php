@props(['item' => null, 'label', 'searchUrl', 'placeholder', 'modelKey', 'usePrev' => false, 'useValue' => false, 'hiddenKeys' => [] ])
<div class="issue-reader-field">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="select-search-input{{$modelKey}}">
        {{$label}}
    </label>

    <div class="select-search-wrapper relative">
        <input id="select-search-input{{$modelKey}}"
            type="text"
            @if($useValue)
            name="model{{$modelKey}}"
            @endif
            class="disabled:cursor-not-allowed @if($useValue) @error($modelKey) border-red-300 @enderror @endif select-search-input block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 @error("selected_id$modelKey") border-red-300 @enderror"
            autocomplete="off"
            @disabled($item && !$usePrev)
            data-search-url="{{$searchUrl}}"
            placeholder="{{$placeholder}}"
            value="{{$item?->searchValue ?? request("model$modelKey") ?? '' }}"
        >

        <div class="select-search-results hidden absolute z-30 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-48 overflow-y-auto"></div>
        <input
            type="hidden"
            name="selected_id{{$modelKey}}"
            class="selected-id"
            value="@if($useValue && request("model$modelKey")){{request("selected_id$modelKey") ?? ''}}@else{{$item?->id ?? ''}}@endif"
        >
        @if($useValue)
            @foreach($hiddenKeys as $k)
            <input
                type="hidden"
                name="{{$k}}"
                class="hidden-search-value hidden hidden-key-{{$k}}" data-key="{{$k}}"
                value="@if(request("model$modelKey")){{request($k)}}@endif"
            >
            @endforeach
        @endif

    </div>
    @error("selected_id$modelKey")
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
