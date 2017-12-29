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

            watchRoleTextInputs();
        });

        function watchRoleTextInputs() {
            $(".external_role", $role_section)
                .change(function () {
                    var value = $(this).attr("value");
                    //DO I WANT TO ALLOW SPACES HERE??????????????????????????????
                    $(this).attr("name", "exlog_role_" + $(this).attr("value"));
                    update_roles_data();
                });

            $(".wordpress_role", $role_section).change(update_roles_data);


            function update_roles_data() {
                var roles_data = [];
                $(".role", $role_section).each(function () {
                    var external_role = $(".external_role", $(this)).attr("value");
                    var wordpress_role = $(".wordpress_role", $(this)).attr("value");
                    roles_data.push({
                        "external_role": external_role,
                        "wordpress_role": wordpress_role
                    })
                });
                console.log(roles_data);
            }

        }
    })
}(jQuery));
