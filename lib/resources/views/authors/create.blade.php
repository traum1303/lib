@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">

        <a href="{{ route('authors.index') }}"
           class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            К списку авторов
        </a>

        <h1 class="text-2xl font-semibold text-gray-900 mb-6">
            Добавление автора
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

        <form method="POST" action="{{ route('authors.store') }}" class="bg-white border border-gray-200 rounded-lg shadow-sm">
            @csrf
            @method('POST')
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Имя
                        </label>
                        <input
                            type="text"
                            name="first_name"
                            id="first_name"
                            value="{{old('first_name')}}"
                            class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500
                                @error('first_name') border-red-300 @enderror"
                        >
                        @error('first_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="second_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Фамилия
                        </label>
                        <input
                            type="text"
                            name="second_name"
                            id="second_name"
                            value="{{old('second_name')}}"
                            class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm font-mono
                                focus:border-indigo-500 focus:ring-indigo-500
                                @error('second_name') border-red-300 @enderror"
                        >
                        @error('second_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                            Пол
                        </label>
                        <select id="gender" name="gender" class="block border-1 w-full p-3 rounded-md border-gray-300 shadow-sm text-sm font-mono
                                focus:border-indigo-500 focus:ring-indigo-500
                                @error('gender') border-red-300 @enderror">
                            @foreach (\App\Enums\Gender::cases() as $gender)
                                <option value="{{ $gender->value }}" @selected(\App\Enums\Gender::tryFrom(old('gender')) === $gender)>
                                    {{ $gender->label() }}
                                </option>
                            @endforeach
                            </select>
                        @error('gender')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @include('components.item-search', [
                    'items' => $books,
                    'label' => 'Книги',
                    'searchUrl' => route('search.books'),
                    'placeholder' => 'Введите название или ISBN книги...'
                ])
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('authors.index') }}" class="px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Отмена
                </a>
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Создать
                </button>
            </div>
        </form>
    </div>

@endsection

