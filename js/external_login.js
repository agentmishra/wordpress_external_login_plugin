(function ($) {
    $(function () {
        var $role_section = $(".options_section.role_settings");
        var $roles = $(".roles", $role_section);
        var hidden_roles_input_selector = ".exlog_custom_roles";

        function watchRoleTextInputs() {
            $(".external_role", $role_section)
                .change(function () {
                    var value = $(this).attr("value");
                    var slugged_value = window.exlog.slugify($(this).attr("value"));
                    $(this).attr("name", "exlog_role_" + slugged_value);
                    update_roles_data();
                });

            $(".wordpress_role", $role_section).change(update_roles_data);


            function update_roles_data() {
                var roles_data = [];
                $(".role", $role_section).each(function () {
                    var external_role_text = $(".external_role", $(this)).attr("value");
                    var wordpress_role = $(".wordpress_role", $(this)).attr("value");
                    roles_data.push({
                        "external_role": external_role_text,
                        "wordpress_role": wordpress_role
                    })
                });

                var input_ready_roles = window.exlog.json_to_input(roles_data);
                $(hidden_roles_input_selector, $role_section).attr("value", input_ready_roles);
            }
        }

        $(".add_button", $role_section).click(function () {
            var $new_item = $(".role", $role_section)
                .first()
                .clone()
                .appendTo($roles);

            $(".external_role", $new_item)
                .attr("readonly", false)
                .attr("value", "");
            $(".description", $new_item).remove();

            watchRoleTextInputs();
        });

        watchRoleTextInputs();
    })
}(jQuery));
