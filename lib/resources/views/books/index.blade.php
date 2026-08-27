@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Список книг</h1>
            <a href="{{route('books.create')}}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Создать книгу
            </a>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-lg border border-gray-200 shadow-sm bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Авторы</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Год издания</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse ($books as $book)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-blue-900">
                            <a href="{{route('books.show', $book)}}">
                                #{{ $book->id }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $book->name }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @forelse ($book->authors as $author)
                                <a href="{{route('authors.show', $author)}}" class="block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full mr-1 mb-1 hover:bg-indigo-50 hover:text-indigo-700 ">
                                    {{ $author->full_name }}
                                </a>
                            @empty
                                <span class="text-gray-400 text-xs">— автор не указан —</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $book->publish_year }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 font-mono">
                            {{ $book->isbn }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if ($book->is_issued)
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700">
                                    Выдана
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700">
                                     Доступна ({{$book->total}})
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{route('books.show', $book)}}">
                                <svg
                                    class="h-6 w-6 fill-none text-indigo-600 hover:text-white hover:fill-indigo-700"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"
                                    />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
                            Книги не найдены.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $books->links('components/paginator') }}
        </div>
    </div>
@endsection
