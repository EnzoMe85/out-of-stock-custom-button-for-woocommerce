<?php
/*
Plugin Name: Out of Stock Custom Button for WooCommerce
Description: A plugin to display a customizable button when a product is out of stock (for WooCommerce). To proceed with the customization: open Settings WordPress , click on Custom Button Settings and Enjoy!
Version: 1.0
Author: Enzo Mele
Author URI: https://enzomele.it
*/

// Add the custom filter to change the availability text
add_filter('woocommerce_get_availability', 'my_custom_button_availability', 1, 2);

function my_custom_button_availability($availability, $_product)
{
    // Change In Stock Text
    if ($_product->is_in_stock()) {
        $availability['availability'] = __('In Stock!', 'woocommerce');
    }
    // Change Out of Stock Text
    if (!$_product->is_in_stock()) {
        // Get the custom button settings
        $button_text = get_option('my_custom_button_text', 'More Info');
        $button_color = get_option('my_custom_button_color', '#00B52C');
        $button_text_color = get_option('my_custom_button_text_color', 'white');
        $button_link = get_option('my_custom_button_link', '#');
        $button_border_radius = get_option('my_custom_button_border_radius', '5px');

        // Show the custom button
        $availability['availability'] = '<a class="custom-button" style="background-color: ' . $button_color . '; color: ' . $button_text_color . '; padding: 10px 20px; text-decoration: none; display: block; margin-bottom: 20px; border-radius: ' . $button_border_radius . ';" href="' . $button_link . '">' . $button_text . '</a>';
    }
    return $availability;
}

// Add the custom settings page to the admin menu
add_action('admin_menu', 'my_custom_button_menu');

function my_custom_button_menu()
{
    add_options_page('Custom Button Settings', 'Custom Button Settings', 'manage_options', 'my-custom-button', 'my_custom_button_settings');
}

// Define the custom settings fields
function my_custom_button_settings_fields()
{
    $fields = array(
        array(
            'name' => 'my_custom_button_text',
            'title' => 'Button Text',
            'type' => 'text',
            'default' => 'More Info',
        ),
        array(
            'name' => 'my_custom_button_color',
            'title' => 'Button Color',
            'type' => 'color',
            'default' => '#00B52C',
        ),
        array(
            'name' => 'my_custom_button_text_color',
            'title' => 'Button Text Color',
            'type' => 'color',
            'default' => 'white',
        ),
        array(
            'name' => 'my_custom_button_border_radius',
            'title' => 'Button Border Radius',
            'type' => 'text',
            'default' => '5px',
        ),
        array(
            'name' => 'my_custom_button_link',
            'title' => 'Button Link',
            'type' => 'text',
            'default' => 'Enter your contact link (whatsapp, telegram, etc)',
        ),
    );
    return $fields;
}

// Define the custom settings page content
function my_custom_button_settings()
{
?>
    <style>
        .wrap {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f6f6f6;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .wrap h1 {
            margin-top: 0;
            font-size: 30px;
            font-weight: bold;
            line-height: 1.3;
            color: #ef233c;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        input[type='text'],
        input[type='email'],
        input[type='password'],
        input[type='number'],
        input[type='color'] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type='color'] {
            width: auto;
            padding: 4px;
        }

        button[type='submit'],
        button[type='button'] {
            display: block;
            margin-top: 10px;
            padding: 5px 10px;
            font-size: 16px;
            color: #fff;
            background-color: #0073aa;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        button[type='submit']:hover,
        button[type='button']:hover {
            background-color: #005980;
        }

        #donate-button-container {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label[for='donate-button'] {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        #donate-button {
            margin-top: 0px;
        }
    </style>
    
    <div class="wrap">
        <h1>Custom Button Settings</h1>
        <form id="my-custom-form" method="post" action="options.php">
            <?php settings_fields('my_custom_button'); ?>
            <?php do_settings_sections('my_custom_button'); ?>
            <?php foreach (my_custom_button_settings_fields() as $field) { ?>
                <label for="<?php echo esc_attr($field['name']); ?>"><?php echo esc_html($field['title']); ?></label>
                <?php if ($field['type'] === 'color') { ?>
                    <input type="<?php echo esc_attr($field['type']); ?>" name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr(get_option($field['name'], $field['default'])); ?>" style="width: 60px;">
                <?php } else { ?>
                    <input type="<?php echo esc_attr($field['type']); ?>" name="<?php echo esc_attr($field['name']); ?>" id="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr(get_option($field['name'], $field['default'])); ?>">
                <?php } ?>
                <br>
            <?php } ?>
            <?php submit_button(); ?>

            <button type="button" onclick="resetToDefault()">Reset to Default</button><br>

            <script type="text/javascript">
                function resetToDefault() {
                    <?php foreach (my_custom_button_settings_fields() as $field) { ?>
                        document.getElementById('<?php echo esc_attr($field['name']); ?>').value = '<?php echo esc_attr($field['default']); ?>';
                    <?php } ?>
                }
            </script>
            <br>
            <div id="donate-button-container">
                <label>❤️ Buy me a Coffee ☕</label>
                <div id="donate-button"></div>
                <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
                <script>
                    PayPal.Donation.Button({
                        env: 'production',
                        hosted_button_id: '2BD6ETY97EG6G',
                        image: {
                            src: 'https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif',
                            alt: 'Donate with PayPal button',
                            title: 'PayPal - The safer, easier way to pay online!',
                        }
                    }).render('#donate-button');
                </script>
            </div>
        </form>
    </div>
<?php
}

// Save the custom settings
function my_custom_button_register_settings()
{
    foreach (my_custom_button_settings_fields() as $field) {
        register_setting('my_custom_button', $field['name']);
    }
}
add_action('admin_init', 'my_custom_button_register_settings');


// Register the uninstall function of the plugin
register_uninstall_hook(__FILE__, 'my_custom_button_delete_options');

// Function that will be executed when the plugin is uninstalled
function my_custom_button_delete_options()
{
    // Delete all options saved in the database
    delete_option('my_custom_button_text');
    delete_option('my_custom_button_color');
    delete_option('my_custom_button_text_color');
    delete_option('my_custom_button_link');
    delete_option('my_custom_button_border_radius');
    // Add more options if needed
}
