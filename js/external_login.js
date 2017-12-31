(function ($) {
    $(function () {
        var $role_section = $(".options_section.role_settings");
        var $roles = $(".roles", $role_section);
        var hidden_roles_input_selector = ".exlog_custom_roles";

        var external_role_name_prefix = $roles.attr("data-exlog-external-role-prefix");
        var wordpress_role_name_prefix = $roles.attr("data-exlog-wordpress-role-prefix");

        function update_roles_data() {
            var roles_data = [];
            $(".role", $role_section).each(function () {
                var $this = $(this);
                roles_data.push({
                    "external_role_value": $(".external_role", $this).attr("value"),
                    "wordpress_role_value": $(".wordpress_role", $this).attr("value"),
                    "wordpress_role_name": $(".wordpress_role", $this).attr("name"),
                    "external_role_name": $(".external_role", $this).attr("name")
                })
            });

            var input_ready_roles = window.exlog.json_to_input(roles_data);
            $(hidden_roles_input_selector, $role_section).attr("value", input_ready_roles);
        }

        function watchRoleTextInputs() {
            $(".external_role", $role_section)
                .change(function () {
                    var value = $(this).attr("value");
                    var slugged_value = window.exlog.slugify($(this).attr("value"));
                    var slugged_external_role = external_role_name_prefix + slugged_value;
                    $(this).attr("name", slugged_external_role);
                    update_roles_data();
                });

            $(".wordpress_role", $role_section).change(function () {
                var external_role_value = $(this).parent().find(".external_role").attr("value");
                var slugged_value = window.exlog.slugify(external_role_value);
                var slugged_wordpress_role = wordpress_role_name_prefix + slugged_value;
                $(this).attr("name", slugged_wordpress_role);
                update_roles_data();
            });
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

        update_roles_data();
        watchRoleTextInputs();
    })
}(jQuery));
