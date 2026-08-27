@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">

        <a href="{{ route('books.show', $book) }}"
        class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"
        >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        К книге
        </a>

        <h1 class="text-2xl font-semibold text-gray-900 mb-6">
            Редактирование книги
        </h1>

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

        <form method="POST" action="{{ route('books.update', $book) }}" class="bg-white border border-gray-200 rounded-lg shadow-sm">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Название
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $book->name) }}"
                        class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm
                            focus:border-indigo-500 focus:ring-indigo-500
                            @error('name') border-red-300 @enderror"
                    >
                    @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="publish_year" class="block text-sm font-medium text-gray-700 mb-1">
                            Год издания
                        </label>
                        <input
                            type="number"
                            name="publish_year"
                            id="publish_year"
                            value="{{ old('publish_year', $book->publish_year) }}"
                            class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500
                                @error('publish_year') border-red-300 @enderror"
                        >
                        @error('publish_year')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">
                            ISBN
                        </label>
                        <input
                            type="text"
                            name="isbn"
                            id="isbn"
                            value="{{ old('isbn', $book->isbn) }}"
                            class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm font-mono
                                focus:border-indigo-500 focus:ring-indigo-500
                                @error('isbn') border-red-300 @enderror"
                        >
                        @error('isbn')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="total" class="block text-sm font-medium text-gray-700 mb-1">
                            Доступно количество
                        </label>
                        <input
                            type="number"
                            name="total"
                            id="total"
                            value="{{ old('total', $book->total) }}"
                            class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm font-mono
                                focus:border-indigo-500 focus:ring-indigo-500
                                @error('total') border-red-300 @enderror"
                        >
                        @error('total')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @include('components.item-search', [
                        'items' => $authors,
                        'label' => 'Авторы',
                        'searchUrl' => route('search.authors'),
                        'placeholder' => 'Введите имя или фамилию автора...'
                    ])
                </div>

            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('books.show', $book) }}" class="px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Отмена
                </a>
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Сохранить
                </button>
            </div>
        </form>
    </div>

@endsection
