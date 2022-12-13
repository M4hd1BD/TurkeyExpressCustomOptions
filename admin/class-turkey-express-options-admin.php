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
class TurkeyExpressOptions_Admin {

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
	public function __construct( $TurkeyExpressOptions, $version ) {

		$this->TurkeyExpressOptions = $TurkeyExpressOptions;
		$this->version = $version;

		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->TurkeyExpressOptions, plugin_dir_url( __FILE__ ) . 'css/turkey-express-options-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->TurkeyExpressOptions, plugin_dir_url( __FILE__ ) . 'js/turkey-express-options-admin.js', array( 'jquery' ), $this->version, false );

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
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'turkeyExpressOptions' );
        ?>
        <div class="wrap">
            <h1>Turkey Express Custom Options</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'turkeyExpressOptionsGroup' );
                do_settings_sections( 'turkeyExpressSettings' );
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
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'turkeyExpressOptions', // ID
            'Turkey Express Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'turkeyExpressSettings' // Page
        );  

        add_settings_field(
            'whatsAppToolTipText', // ID
            'WhatsApp Floating Icon ToolTip Text', // Title 
            array( $this, 'whatsAppToolTipText_callback' ), // Callback
            'turkeyExpressSettings', // Page
            'turkeyExpressOptions' // Section           
        );      

        // add_settings_field(
        //     'title', 
        //     'Title', 
        //     array( $this, 'title_callback' ), 
        //     'turkeyExpressSettings', 
        //     'turkeyExpressOptions'
        // );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['whatsAppToolTipText'] ) )
            $new_input['whatsAppToolTipText'] = sanitize_text_field( $input['whatsAppToolTipText'] );

        // if( isset( $input['title'] ) )
        //     $new_input['title'] = sanitize_text_field( $input['title'] );

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
            isset( $this->options['whatsAppToolTipText'] ) ? esc_attr( $this->options['whatsAppToolTipText']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    // public function title_callback()
    // {
    //     printf(
    //         '<input type="text" id="title" name="turkeyExpressOptions[title]" value="%s" />',
    //         isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
    //     );
    // }
}
