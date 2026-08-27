@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <a href="{{ route('books.index') }}"
           class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            К списку книг
        </a>

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <p class="font-medium mb-1">Исправьте ошибки:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ $book->name }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $book->publish_year }} год
                        </p>
                    </div>

                    @if ($book->is_issued)
                        <span class="shrink-0 inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700">
                            Выдана
                        </span>
                    @else
                        <span class="shrink-0 inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700">
                            Доступна
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        Авторы
                    </h2>

                    @if ($book->authors->isNotEmpty())
                        <div class="flex flex-wrap gap-1">
                            @foreach ($book->authors as $author)
                                <span class="inline-block rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                    {{ $author->full_name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">— автор не указан —</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            ISBN
                        </h2>
                        <p class="text-sm text-gray-900 font-mono">
                            {{ $book->isbn }}
                        </p>
                    </div>

                    <div>
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Год издания
                        </h2>
                        <p class="text-sm text-gray-900">
                            {{ $book->publish_year }}
                        </p>
                    </div>

                    <div class="col-span-2">
                        <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Количество
                        </h2>
                        <p class="text-sm text-gray-900">
                            {{ $book->total}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <form method="POST" action="{{route('books.destroy', $book)}}" class="w-full sm:w-auto inline-flex items-center justify-center ">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Удалить книгу
                    </button>
                </form>
                <a href="{{route('books.edit', $book)}}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Изменить книгу
                </a>
                @if (!$book->is_issued)
                    <button type="button" data-type="book" data-id="{{$book->id}}" class="issue-modal-open w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Выдать книгу
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div id="issue-modal-target" class="issue-modal fixed inset-0 z-50 hidden items-center justify-center">
        <div class="issue-modal-backdrop absolute inset-0 bg-black/40"></div>
    </div>
@endsection
@if (!$book->is_issued)
    @push('scripts')
        @vite('resources/js/components/issue-book-modal.js')
        @vite('resources/js/components/item-search-select.js')
    @endpush
@endif
