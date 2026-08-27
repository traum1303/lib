@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Список выдач книг</h1>
            <button type="button" data-type="empty" class="issue-modal-open w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Выдать книгу
            </button>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <p class="font-medium mb-1">Выдача не оформлена из-за возникших ошибок:</p>
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
        <div class="sm:flex grid gap-3">
            <div class="overflow-x-auto">
                <form method="GET" action="{{ route('issues.index') }}" class=" max-w-full h-fit flex-none bg-white border border-gray-200 rounded-lg shadow-sm p-4 grid grid-cols-1 gap-4">
                    @include('components.item-search-select', [
                        'item' => null,
                        'label' => 'Название книги',
                        'searchUrl' => route('search.books'),
                        'placeholder' => 'Поиск по названию и ISBN...',
                        'modelKey' => '_book',
                        'useValue' => true,
                        'usePrev' => true,
                        'hiddenKeys' => ['book_name', 'book_isbn']
                    ])
                    @include('components.item-search-select', [
                        'item' => $bookIssue?->reader ?? null,
                        'label' => 'Читатель',
                        'searchUrl' => route('search.readers'),
                        'placeholder' => 'Поиск по читателю...',
                        'modelKey' => '_reader',
                        'useValue' => true,
                        'usePrev' => true,
                        'hiddenKeys' => ['reader_name']
                    ])
                    <div>
                        <label for="issued_from" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Дата выдачи с
                        </label>
                        <input
                            type="date"
                            name="issued_from"
                            id="issued_from"
                            value="{{ request('issued_from') }}"
                            class="p-3 block w-full rounded-md border-gray-300 shadow-sm text-sm
                    focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label for="issued_to" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Дата выдачи по
                        </label>
                        <input
                            type="date"
                            name="issued_to"
                            id="issued_to"
                            value="{{ request('issued_to') }}"
                            class="p-3 block w-full rounded-md border-gray-300 shadow-sm text-sm
                    focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>
                    <div>
                        <label for="return_from" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Дата возврата с
                        </label>
                        <input
                            type="date"
                            name="return_from"
                            id="return_from"
                            value="{{ request('return_from') }}"
                            class="p-3 block w-full rounded-md border-gray-300 shadow-sm text-sm
                    focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label for="return_to" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Дата возврата по
                        </label>
                        <input
                            type="date"
                            name="return_to"
                            id="return_to"
                            value="{{ request('return_to') }}"
                            class="p-3 block w-full rounded-md border-gray-300 shadow-sm text-sm
                    focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>

                    <div>
                        <label for="status" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">
                            Статус
                        </label>
                        <select
                            name="status"
                            id="status"
                            class="p-3 block w-full rounded-md border-gray-300 shadow-sm text-sm
                    focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Все статусы</option>
                            @foreach (\App\Enums\BookIssueStatus::cases() as $s)
                                <option value="{{ $s->value }}" @selected(\App\Enums\BookIssueStatus::fromRequest(request('status')) === $s)>
                                    {{ $s->toText() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 mt-4">
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                        >
                            Применить
                        </button>

                        @if (request()->anyFilled(['selected_id_book', 'selected_id_reader', 'book_name', 'book_isbn', 'reader_name', 'issued_from', 'issued_to', 'return_from', 'return_to', 'status']))
                            <a href="{{ route('issues.index') }}" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-700 border border-gray-300 hover:bg-gray-50">
                                Сбросить
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="flex-1 overflow-hidden rounded-lg border border-gray-200 shadow-sm bg-white sm:max-w-3/4 max-w-full">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Книга</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Читатель</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата выдачи</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата возвращения</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($issues as $issue)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-blue-900">
                                #{{ $issue->id }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $issue->book->name }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $issue->reader->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $issue->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $issue->return_to->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 font-mono">
                                {{ $issue->status->toText() }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button type="button" class="issue-modal-open" data-type="issue" data-id="{{$issue->id}}">
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
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
                                Выдачи не найдены.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="mt-6">
            {{ $issues->links('components/paginator') }}
        </div>
    </div>
    <div id="issue-modal-target" class="issue-modal fixed inset-0 z-50 hidden items-center justify-center">
        <div class="issue-modal-backdrop absolute inset-0 bg-black/40"></div>
    </div>
@endsection
@push('scripts')
    @vite('resources/js/components/issue-book-modal.js')
    @vite('resources/js/components/item-search-select.js')
@endpush
