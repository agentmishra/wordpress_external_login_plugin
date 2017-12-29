(function ($) {
    $(function () {
        var $role_section = $(".options_section.role_settings");
        var $roles = $(".roles", $role_section);

        $(".add_button", $role_section).click(function () {
            var $new_item = $(".role", $role_section)
                .first()
                .clone()
                .appendTo($roles);

            $(".external_role", $new_item)
                .attr("readonly", false)
                .attr("value", "");
            $(".description", $new_item).remove();
        });
    })
}(jQuery));
