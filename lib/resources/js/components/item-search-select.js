$(function () {

    let debounceTimer = null;

    $(document).on('input', '.select-search-input', function () {
        const $input = $(this);
        const $wrapper = $input.closest('.select-search-wrapper');
        const $results = $wrapper.find('.select-search-results');
        const $hiddenId = $wrapper.find('.selected-id');
        const query = $input.val().trim();
        const searchUrl = $input.data('search-url');
        $hiddenId.val('');
        $wrapper.find('.hidden-search-value').each(function () {
            $(this).val('')
        });

        clearTimeout(debounceTimer);

        if (query.length < 3) {

            $results.addClass('hidden').empty();
            return;
        }

        debounceTimer = setTimeout(function () {
            $.get(searchUrl, { query: query })
                .done(function (html) {
                    $results.html(html).removeClass('hidden');
                })
                .fail(function () {
                    $results
                        .html('<div class="px-3 py-2 text-sm text-red-500">Ошибка поиска</div>')
                        .removeClass('hidden');
                });
        }, 300);
    });

    $(document).on('click', '.search-item', function () {
        const $item = $(this);
        const $wrapper = $item.closest('.select-search-wrapper');
        const $input = $wrapper.find('.select-search-input');
        const $results = $wrapper.find('.select-search-results');
        const $hiddenId = $wrapper.find('.selected-id');
        const $hiddenVal = $wrapper.find('.hidden-search-value');
        $input.val($item.data('value'));
        $hiddenId.val($item.data('id'));
        $results.addClass('hidden').empty();

        $hiddenVal.each(function () {
            $(this).val($item.data('hidden-' + $(this).data('key')))
        });
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('.select-search-wrapper').length) {
            $('.select-search-results').addClass('hidden');
        }
    });
});
