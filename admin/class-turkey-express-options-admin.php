<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    TurkeyExpressOptions
 * @subpackage TurkeyExpressOptions/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TurkeyExpressOptions
 * @subpackage TurkeyExpressOptions/admin
 * @author     Your Name <email@example.com>
 */
class TurkeyExpressOptions_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $TurkeyExpressOptions    The ID of this plugin.
     */
    private $TurkeyExpressOptions;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $TurkeyExpressOptions       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($TurkeyExpressOptions, $version)
    {

        $this->TurkeyExpressOptions = $TurkeyExpressOptions;
        $this->version = $version;

        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_filter('atbdp_form_custom_widgets', array($this, 'turkeyExpressCustomAddListingFields'));
        add_filter('atbdp_listing_type_settings_field_list', array($this, 'turkeyExpressCustomAllListingsFields'));
        add_filter( 'directorist_search_form_widgets', array( $this, 'turkeyExpressCustomSearchFields' ) );
        add_filter( 'directorist_listing_header_layout', array( $this, 'turkeyExpressSingleHeaderFields' ) );
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in TurkeyExpressOptions_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The TurkeyExpressOptions_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->TurkeyExpressOptions, plugin_dir_url(__FILE__) . 'css/turkey-express-options-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in TurkeyExpressOptions_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The TurkeyExpressOptions_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->TurkeyExpressOptions, plugin_dir_url(__FILE__) . 'js/turkey-express-options-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Turkey Express Options',
            'Turkey Express Options',
            'manage_options',
            'turkey-express-options',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('turkeyExpressOptions');
?>
        <div class="wrap">
            <h1>Turkey Express Custom Options</h1>
            <form method="post" action="options.php" class="turkeyExpressOptions">
                <?php
                // This prints out all hidden setting fields
                settings_fields('turkeyExpressOptionsGroup');
                do_settings_sections('turkeyExpressSettings');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'turkeyExpressOptionsGroup', // Option group
            'turkeyExpressOptions', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'turkeyExpressOptions', // ID
            'Turkey Express Settings', // Title
            array($this, 'print_section_info'), // Callback
            'turkeyExpressSettings' // Page
        );

        add_settings_field(
            'whatsAppToolTipText', // ID
            'WhatsApp Floating Icon ToolTip Text', // Title 
            array($this, 'whatsAppToolTipText_callback'), // Callback
            'turkeyExpressSettings', // Page
            'turkeyExpressOptions' // Section           
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();
        if (isset($input['whatsAppToolTipText']))
            $new_input['whatsAppToolTipText'] = sanitize_text_field($input['whatsAppToolTipText']);
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Customize the options below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function whatsAppToolTipText_callback()
    {
        printf(
            '<input type="text" id="whatsAppToolTipText" name="turkeyExpressOptions[whatsAppToolTipText]" value="%s" />',
            isset($this->options['whatsAppToolTipText']) ? esc_attr($this->options['whatsAppToolTipText']) : ''
        );
    }
    public function turkeyExpressCustomAddListingFields($fields)
    {
        $custom_field_meta_key_field = apply_filters('directorist_custom_field_meta_key_field_args', array(
            'type'  => 'hidden',
            'label' => esc_html__('Key', 'turkeyExpress'),
            'value' => 'custom-radio',
            'rules' => array(
                'unique'   => true,
                'required' => true,
            ),
        ));

        $fields['turkey-express-badge'] = array(
            'label' => 'TurkeyExpress: Badge',
            'icon' => 'la la-id-badge',
            'options' => [
                'type' => [
                    'type'  => 'hidden',
                    'value' => 'radio',
                ],
                'label' => [
                    'type'  => 'text',
                    'label' => __('Badge Text', 'turkeyExpress'),
                    'value' => 'Badge Text',
                ],
                'field_key' => array_merge($custom_field_meta_key_field, [
                    'value' => 'turkey-express-badge',
                ]),
                'placeholder' => [
                    'type'  => 'text',
                    'label' => __( 'Badge Description', 'turkeyExpress' ),
                    'value' => '',
                ],
                'options' => [
                    'type' => 'multi-fields',
                    'label' => __('Options', 'turkeyExpress'),
                    'add-new-button-label' => __('Add Option', 'turkeyExpress'),
                    'options' => [
                        'option_value' => [
                            'type'  => 'text',
                            'label' => __('Option Value', 'turkeyExpress'),
                            'value' => '',
                        ],
                        'option_label' => [
                            'type'  => 'text',
                            'label' => __('Option Label', 'turkeyExpress'),
                            'value' => '',
                        ],
                    ]
                ],
                'description' => [
                    'type'  => 'color',
                    'label' => __('Badge Background Color', 'turkeyExpress'),
                    'value' => '#FFFFFF',
                ],
                'only_for_admin' => [
                    'type'  => 'toggle',
                    'label'  => __('Only For Admin Use', 'turkeyExpress'),
                    'value' => true,
                ],
            ]
        );
        return $fields;
    }

    public function turkeyExpressCustomAllListingsFields($fields)
    {
        $turkey_express_badge = array(
            'type'    => "list-item",
            'label'   => __( "Turkey Express: Badge", "turkeyExpress" ),
            'icon'    => 'la la-id-badge',
            'hook'    => "turkey-express-badge",
            'show_if' => array(
                'where'      => "submission_form_fields.value.fields",
                'conditions' => array(
                    array( 'key' => '_any.widget_name', 'compare' => '=', 'value' => 'turkey-express-badge' ),
                ),
            ),
        );
    
        foreach ( $fields as $key => $value ) {
    
            if ( 'listings_card_grid_view' == $key ) {
    
                /* (With thumbnail) Registered widgets for Grid layout */
    
                $custom_widgets = array(
                    'turkey-express-badge' => $turkey_express_badge,
                );
    
                // Registers custom widgets.
                foreach ( $custom_widgets as $widget_key => $widget_value ) {
                    $fields[$key]['card_templates']['grid_view_with_thumbnail']['widgets'][$widget_key] = $widget_value;
                }
    
                // Inserted widgets in placeholder.
    
                array_push( $fields[$key]['card_templates']['grid_view_with_thumbnail']['layout']['thumbnail']['top_right']['acceptedWidgets'], 'turkey-express-badge' );
                array_push( $fields[$key]['card_templates']['grid_view_with_thumbnail']['layout']['thumbnail']['top_left']['acceptedWidgets'], 'turkey-express-badge' );
            }
    
            if ( 'listings_card_list_view' === $key ) {
    
                /* (With thumbnail) Registered widgets for List layout */
    
                $custom_widgets = array(
                    'turkey-express-badge' => $turkey_express_badge,
                );
                // Registers custom widgets.
                foreach ( $custom_widgets as $widget_key => $widget_value ) {
                    $fields[$key]['card_templates']['list_view_with_thumbnail']['widgets'][$widget_key] = $widget_value;
                }
    
                // Inserted widgets in placeholder.
    
                array_push( $fields[$key]['card_templates']['list_view_with_thumbnail']['layout']['thumbnail']['top_right']['acceptedWidgets'], 'turkey-express-badge' );
            }
        }
    
        return $fields;
    }

    public function turkeyExpressCustomSearchFields( $fields ) {
		$turkey_express_badge = array(
			'options' => [
                'label' => [
                    'type'  => 'text',
                    'label'  => __( 'Label', 'directorist' ),
                    'value' => 'Tag',
                ],
                'required' => [
                    'type'  => 'toggle',
                    'label'  => __( 'Required', 'directorist' ),
                    'value' => false,
                ],
            ]
		);

		$widget_names = array(
			'turkey-express-badge' => $turkey_express_badge
		);

		// Registers custom widgets.
		foreach ( $widget_names as $widget_key => $widget_value ) {
			$fields['available_widgets']['widgets'][$widget_key] = $widget_value;
		}

		return $fields;
	}

    public function turkeyExpressSingleHeaderFields( $fields ) {

			$fields['widgets']['turkey-express-badge'] = array(
				'type' => "list-item",
                'label' => __( "Badge", "directorist" ),
                'icon' => 'uil uil-text-fields',
                'show_if' => [
                    'where' => "submission_form_fields.value.fields",
                    'conditions' => [
                        ['key' => '_any.widget_name', 'compare' => '=', 'value' => 'turkey-express-badge'],
                    ],
                ],
			);

			array_push( $fields['layout']['listings_header']['quick_info']['acceptedWidgets'],
				'turkey-express-badge' );
		
		return $fields;
	}
}
