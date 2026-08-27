@props(['bookIssue'=>null, 'book'=>null])
<div class="issue-modal-backdrop absolute inset-0 bg-black/40"></div>
<div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900">
            Выдача книги
        </h2>
        <button type="button" class="issue-modal-close text-gray-400 hover:text-gray-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route($bookIssue ? 'issues.update' : 'issues.store', $bookIssue?->id) }}" class="issue-modal-form">
        @csrf
        @if($bookIssue) @method('PUT') @endif
        <div class="px-6 py-4 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                @include('components.item-search-select', [
                    'item' => $bookIssue?->book ?? $book ?? null,
                    'label' => 'Книга',
                    'searchUrl' => route('search.books'),
                    'placeholder' => 'Введите название или ISBN книги...',
                    'modelKey' => '_book'
                ])
                @include('components.item-search-select', [
                    'item' => $bookIssue?->reader ?? null,
                    'label' => 'Читатель',
                    'searchUrl' => route('search.readers'),
                    'placeholder' => 'Введите ФИО читателя...',
                    'modelKey' => '_reader'
                ])
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Статус выдачи
                </label>
                <select name="status" class="issue-status-select block w-full p-3 rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach (\App\Enums\BookIssueStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected($status === $bookIssue?->status)>
                            {{ $status->toText() }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Дата выдачи
                    </label>
                    <input
                        type="date"
                        name="issued_at"
                        value="{{ $bookIssue?->issuedAt ?? now()->toDateString() }}"
                        class="block w-full p-3 rounded-md border-gray-300 shadow-sm text-sm
                            focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('issued_at')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Дата возврата
                    </label>
                    <input
                        type="date"
                        name="return_to"
                        value="{{ $bookIssue?->returnTo ?? '' }}"
                        class="block w-full p-3 rounded-md border-gray-300 shadow-sm text-sm
                            focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('return_to')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3 rounded-b-lg">
            @if($bookIssue)
                <button
                type="button"
                class="return-issue-modal-btn px-4 py-2 rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700"
            >
                Оформить возврат
            </button>
            @endif
            <button
                type="submit"
                class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
            >
                @if($bookIssue) Сохранить @else Выдать @endif
            </button>
            <button
                type="button"
                class="issue-modal-close px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100"
            >
                Отмена
            </button>
        </div>
    </form>
    @if($bookIssue)
        @include('components.confirm-return-issue-modal', ['bookIssue' => $bookIssue])
    @endif
</div>
