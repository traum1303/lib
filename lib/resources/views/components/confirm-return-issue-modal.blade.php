@props(['bookIssue'])

<div id="return-issue-modal-target" class="return-issue-modal fixed inset-0 z-60 hidden items-center justify-center">
    <div class="return-issue-modal-backdrop absolute inset-0 bg-black/80"></div>

    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">
                Возврат книги
            </h2>
        </div>
        <form method="POST" action="{{ route('issues.destroy', $bookIssue->id)}}" class="return-issue-modal-form">
            @csrf
            @method('DELETE')
            <div class="px-6 py-4 space-y-4">
                Вы уверенны что хотите оформить возврат и удалить запись о выдаче?
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3 rounded-b-lg">
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Подтвердить
                </button>
                <button type="button" class="return-issue-modal-close px-4 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Отмена
                </button>
            </div>
        </form>
    </div>
</div>
