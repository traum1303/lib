<nav class="relative bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('books.index') }}" class="text-lg font-semibold text-gray-900">
                    📚 Библиотека
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    @foreach($menu['items'] as $key => $item)
                        <a href="{{route($item['route'].'.index')}}" class="px-3 py-2 rounded-md text-sm font-medium {{ $pageLabel === $item['route'] ? $menu['classes']['selected'] : $menu['classes']['default'] }}">
                            {{$item['label']}}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="sm:hidden">
                <button
                    type="button"
                    id="nav-toggle"
                    class="p-2 rounded-md text-gray-500 hover:bg-gray-100"
                    aria-label="Открыть меню"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden sm:hidden pb-3 space-y-1">
            @foreach($menu['items'] as $key => $item)
                <a href="{{route($item['route'].'.index')}}" class="block px-3 py-2 rounded-md text-sm font-medium {{$pageLabel === $item['route'] ? $menu['classes']['selected'] : $menu['classes']['default'] }}">
                    {{$item['label']}}
                </a>
            @endforeach
        </div>
    </div>
</nav>
