import $ from 'jquery';
window.$ = window.jQuery = $;
$(function () {
    $('#nav-toggle').on('click', function () {
        $('#mobile-menu').toggleClass('hidden');
    });
    $(document).on('click', '.list-toggle', function () {
        const $button = $(this);
        const $wrapper = $button.closest('.list');
        const $hidden = $wrapper.find('.list-hidden');
        const isExpanded = $button.data('expanded') === true || $button.data('expanded') === 'true';

        if (isExpanded) {
            $hidden.slideUp(150, function () {
                $hidden.removeClass('flex').addClass('hidden');
            });
            $button.text($button.data('collapsed-text'));
            $button.data('expanded', false);
        } else {
            if (!$button.data('collapsed-text')) {
                $button.data('collapsed-text', $button.text());
            }

            $hidden.removeClass('hidden').addClass('flex').hide().slideDown(150);
            $button.text('Скрыть');
            $button.data('expanded', true);
        }
    });
});
