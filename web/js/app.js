(function($) {
    $('.actions form button[type=submit]').on('click', function() {
        return confirm('Please confirm?');
    });
})(jQuery);