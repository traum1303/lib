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
                <div class="flex items-center gap-4">
                    <img class="size-12 rounded-full" src="{{asset($author->pic)}}" alt="{{$author->full_name}}">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ $author->full_name }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <h2 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        Книги
                    </h2>

                    @if ($author->books->isNotEmpty())
                        <div class="flex flex-wrap gap-1">
                            @foreach ($author->books as $book)
                                <span class="inline-block rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                    {{ $book->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">— книги не указаны —</p>
                    @endif
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <form method="POST" action="{{route('authors.destroy', $author)}}" class="w-full sm:w-auto inline-flex items-center justify-center ">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Удалить автора
                    </button>
                </form>
                <a href="{{route('authors.edit', $author)}}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Изменить автора
                </a>
            </div>
        </div>

    </div>
@endsection
