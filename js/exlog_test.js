(function ($) {
    $(function () {
        var $modal = $(".exlog_modal");
        var $loader = $(".exlog_loader_container");
        var $modal_content_container = $(".exlog_test_results_inner_container", $modal);


        $(".exlog_close_button", $modal).click(function () {
            $modal.hide();
            $modal_content_container.text("");
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
                url: "/wp-admin/admin-ajax.php",
                data: data,
                success: function (data) {
                    $loader.hide();
                    $modal_content_container.append(data);
                }
            });
        })

    });
}(jQuery));
