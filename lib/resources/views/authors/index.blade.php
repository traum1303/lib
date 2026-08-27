@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Список авторов</h1>
            <a href="{{route('authors.create')}}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Создать автора
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ФИО</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Книги</th>
                    <th class="px-4 py-3"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse ($authors as $author)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-blue-900">
                            <a href="{{route('authors.show', $author->id)}}">
                                #{{ $author->id }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 flex gap-1 items-center">
                            <img class="size-6 rounded-full" src="{{asset($author->pic)}}" alt="{{$author->fullName}}">
                            <span>{{ $author->fullName }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @include('components.list', ['items' => $author->books, 'limit'=>2])
                        </td>

                        <td class="px-4 py-3 text-right">
                            <a href="{{route('authors.show', $author->id)}}">
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
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                            Авторы не найдены.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $authors->links('components/paginator') }}
        </div>
    </div>
@endsection
