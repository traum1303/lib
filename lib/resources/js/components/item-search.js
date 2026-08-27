$(function () {
    const $input = $('#search-input');
    const $results = $('#search-results');
    const $selected = $('#selected-items');

    if ($input.length === 0) {
        return;
    }

    const searchUrl = $input.data('search-url');
    let debounceTimer = null;

    function getSelectedIds() {
        return $selected.find('.search-item-tag').map(function () {
            return String($(this).data('id'));
        }).get();
    }

    function renderResults(html) {
        $results.html(html).removeClass('hidden');
    }

    function addItemTag(id, value) {
        if (getSelectedIds().includes(String(id))) {
            return;
        }

        const $tag = $('<span>')
            .addClass('search-item-tag inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 text-sm px-3 py-1 rounded-full')
            .attr('data-id', id)
            .text(value + ' ');

        $('<button>')
            .attr('type', 'button')
            .addClass('remove-search-item-tag text-indigo-400 hover:text-indigo-600 leading-none')
            .html('&times;')
            .appendTo($tag);

        $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'searched_ids[]')
            .val(id)
            .appendTo($tag);

        $selected.append($tag);
    }

    $input.on('input', function () {
        const query = $(this).val().trim();

        clearTimeout(debounceTimer);

        if (query.length < 3) {
            $results.addClass('hidden').empty();
            return;
        }

        debounceTimer = setTimeout(function () {
            $.get(searchUrl, { query: query, exclude: getSelectedIds() })
                .done(function (html) {
                    renderResults(html);
                })
                .fail(function () {
                    $results
                        .html('<div class="px-3 py-2 text-sm text-red-500">Ошибка поиска</div>')
                        .removeClass('hidden');
                });
        }, 300);
    });

    $results.on('click', '.search-item', function () {
        const id = $(this).data('id');
        const value = $(this).data('value');

        addItemTag(id, value);

        $input.val('');
        $results.addClass('hidden').empty();
    });

    $selected.on('click', '.remove-search-item-tag', function () {
        $(this).closest('.search-item-tag').remove();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#search-wrapper').length) {
            $results.addClass('hidden');
        }
    });
});
