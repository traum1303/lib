$(function () {
    $(document).on('click', '.issue-modal-open', function () {
        $.get(window.issueUrl, {type: $(this).data('type'), id: $(this).data('id') })
            .done(function (html) {
                $('#issue-modal-target').html(html).removeClass('hidden').addClass('flex');
                $('body').addClass('overflow-hidden');
            })
            .fail(function (e) {
                console.log(e.responseJSON);

                $('#issue-modal-target')
                    .html('<div class="px-3 py-2 text-sm text-red-500">Ошибка поиска</div>')
                    .removeClass('hidden');
            });

    });

    $(document).on('click', '.return-issue-modal-btn', function () {
        $('#return-issue-modal-target').removeClass('hidden').addClass('flex');
        $('body').addClass('overflow-hidden');
    });

    function closeModal($modal) {
        $modal.removeClass('flex').html('').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    }

    function closeReturnModal($modal) {
        $modal.removeClass('flex').addClass('hidden');
    }

    $(document).on('click', '.issue-modal-close, .issue-modal-backdrop', function () {
        closeModal($(this).closest('.issue-modal'));
    });

    $(document).on('click', '.return-issue-modal-close, .return-issue-modal-backdrop', function () {
        closeReturnModal($(this).closest('.issue-modal'));
    });

    $(document).on('keydown', function (event) {
        if (event.key === 'Escape') {
            $('.issue-modal:not(.hidden)').each(function () {
                closeModal($(this));
            });
        }
    });

    $(document).on('click', '.issue-modal > div.relative', function (event) {
        event.stopPropagation();
    });
});
