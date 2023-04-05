<?php
function my_custom_button_options_page()
{
    add_options_page(
        'My Custom Button Settings',
        'My Custom Button',
        'manage_options',
        'my-custom-button',
        'my_custom_button_options_page_html'
    );
}
add_action('admin_menu', 'my_custom_button_options_page');

function my_custom_button_settings_init()
{
    register_setting('my_custom_button_options', 'my_custom_button_text');
    register_setting('my_custom_button_options', 'my_custom_button_color');
    register_setting('my_custom_button_options', 'my_custom_button_text_color');
    register_setting('my_custom_button_options', 'my_custom_button_link');
    register_setting('my_custom_button_options', 'my_custom_button_border_radius');
}
add_action('admin_init', 'my_custom_button_settings_init');

function my_custom_button_options_page_html()
{
?>
    <div class="wrap">
        <h1>My Custom Button Settings</h1>
        <form action="options.php" method="post">
            <?php settings_fields('my_custom_button_options'); ?>
            <?php do_settings_sections('my_custom_button_options'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="my_custom_button_text"><?php _e('Button Text', 'my_custom_button'); ?></label></th>
                    <td><input type="text" name="my_custom_button_text" id="my_custom_button_text" value="<?php echo esc_attr(get_option('my_custom_button_text')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="my_custom_button_color"><?php _e('Button Background Color', 'my_custom_button'); ?></label></th>
                    <td><input type="text" class="my-color-field" name="my_custom_button_color" id="my_custom_button_color" value="<?php echo esc_attr(get_option('my_custom_button_color')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="my_custom_button_text_color"><?php _e('Button Text Color', 'my_custom_button'); ?></label></th>
                    <td><input type="text" class="my-color-field" name="my_custom_button_text_color" id="my_custom_button_text_color" value="<?php echo esc_attr(get_option('my_custom_button_text_color')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="my_custom_button_link"><?php _e('Button Link', 'my_custom_button'); ?></label></th>
                    <td><input type="text" name="my_custom_button_link" id="my_custom_button_link" value="<?php echo esc_attr(get_option('my_custom_button_link')); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="my_custom_button_border_radius"><?php _e('Button Link', 'my_custom_button'); ?></label></th>
                    <td><input type="text" name="my_custom_button_border_radius" id="my_custom_button_border_radius" value="<?php echo esc_attr(get_option('my_custom_button_border_radius')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
