(function ($) {
    $(function () {
        $("input.exlog_test_connection").click(function () {
            var data = {
                'action': 'exlog_test_connection',
                'test_results': 10
            };

            $.ajax({
                type: "GET",
                url: "/wp-admin/admin-ajax.php",
                data: data,
                success: function (data) {
                    var $options_page = $(".exlog_options_page");
                    $options_page.append(data);
                    $(".exlog_close_button", $options_page).click(function () {
                        $(this).parent().remove();
                    })
                }
            });
        })

    });
}(jQuery));
