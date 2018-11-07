(function ($) {
    $(function () {
        var $modal = $(".exlog_modal");
        var $loader = $(".exlog_loader_container");
        var $modal_content_container = $(".exlog_test_results_inner_container", $modal);
        var $modal_test_results = $(".exlog_test_results", $modal);
        var $modal_error = $(".exlog_test_fail", $modal_content_container);
        var wordpressBaseUrl = $('[data-exlog-wp-base]').attr('data-exlog-wp-base');


        $(".exlog_close_button", $modal).click(function () {
            $modal_error.hide();
            $modal.hide();
            $modal_test_results.text("");
        });

        $("input.exlog_test_connection").click(function () {
            $modal.show();
            $loader.show();
            var data = {
                'action': 'exlog_test_connection',
                'test_results': 10
            };

            $.ajax({
                type: "GET",
                url: wordpressBaseUrl + "/wp-admin/admin-ajax.php",
                data: data,
                success: function (data) {
                    $modal_error.hide();
                    $loader.hide();
                    $modal_test_results.append(data);

                },
                error: function (data) {
                    $modal_error.show();
                    $loader.hide();
                }
            });
        })
    });
}(jQuery));
