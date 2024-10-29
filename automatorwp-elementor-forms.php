<?php
/**
 * Plugin Name:           AutomatorWP - Elementor integration
 * Plugin URI:            https://wordpress.org/plugins/automatorwp-elementor-forms-integration/
 * Description:           Connect AutomatorWP with Elementor Forms.
 * Version:               1.0.6
 * Author:                AutomatorWP
 * Author URI:            https://automatorwp.com/
 * Text Domain:           automatorwp-elementor-forms
 * Domain Path:           /languages/
 * Requires at least:     4.4
 * Tested up to:          5.9
 * License:               GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package               AutomatorWP\Elementor_Forms
 * @author                AutomatorWP
 * @copyright             Copyright (c) AutomatorWP
 */

final class AutomatorWP_Elementor_Forms_Integration {

    /**
     * @var         AutomatorWP_Elementor_Forms_Integration $instance The one true AutomatorWP_Elementor_Forms_Integration
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      AutomatorWP_Elementor_Forms_Integration self::$instance The one true AutomatorWP_Elementor_Forms_Integration
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new AutomatorWP_Elementor_Forms_Integration();

            if( ! self::$instance->pro_installed() ) {

                self::$instance->constants();
                self::$instance->includes();
                self::$instance->load_textdomain();

            }

            self::$instance->hooks();
        }

        return self::$instance;
    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {
        // Plugin version
        define( 'AUTOMATORWP_ELEMENTOR_FORMS_VER', '1.0.6' );

        // Plugin file
        define( 'AUTOMATORWP_ELEMENTOR_FORMS_FILE', __FILE__ );

        // Plugin path
        define( 'AUTOMATORWP_ELEMENTOR_FORMS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'AUTOMATORWP_ELEMENTOR_FORMS_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            // Triggers
            require_once AUTOMATORWP_ELEMENTOR_FORMS_DIR . 'includes/triggers/submit-form.php';
            // Anonymous Triggers
            require_once AUTOMATORWP_ELEMENTOR_FORMS_DIR . 'includes/triggers/anonymous-submit-form.php';

            // Includes
            require_once AUTOMATORWP_ELEMENTOR_FORMS_DIR . 'includes/functions.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {

        add_action( 'automatorwp_init', array( $this, 'register_integration' ) );

        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }

    /**
     * Registers this integration
     *
     * @since 1.0.0
     */
    function register_integration() {

        automatorwp_register_integration( 'elementor', array(
            'label' => 'Elementor',
            'icon'  => plugin_dir_url( __FILE__ ) . 'assets/elementor.svg',
        ) );

    }

    /**
     * Plugin admin notices.
     *
     * @since  1.0.0
     */
    public function admin_notices() {

        if ( ! $this->meets_requirements() && ! defined( 'AUTOMATORWP_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'AutomatorWP - Elementor requires %s and %s in order to work. Please install and activate them.', 'automatorwp-elementor-forms' ),
                        '<a href="https://wordpress.org/plugins/automatorwp/" target="_blank">AutomatorWP</a>',
                        '<a href="https://wordpress.org/plugins/elementor/" target="_blank">Elementor</a>'
                    ); ?>
                </p>
            </div>

            <?php define( 'AUTOMATORWP_ADMIN_NOTICES', true ); ?>

        <?php elseif ( $this->pro_installed() && ! defined( 'AUTOMATORWP_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php echo __( 'You can uninstall AutomatorWP - Elementor Integration because you already have the pro version installed and includes all the features of the free version.', 'automatorwp-elementor-forms-integration' ); ?>
                </p>
            </div>

            <?php define( 'AUTOMATORWP_ADMIN_NOTICES', true ); ?>

        <?php endif;

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( ! class_exists( 'AutomatorWP' ) ) {
            return false;
        }

        if ( ! defined( 'ELEMENTOR_VERSION' ) && ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
            return false;
        }

        return true;

    }

    /**
     * Check if the pro version of this integration is installed
     *
     * @since  1.0.0
     *
     * @return bool True if pro version installed
     */
    private function pro_installed() {

        if ( ! class_exists( 'AutomatorWP_Elementor_Forms' ) ) {
            return false;
        }

        return true;

    }

    /**
     * Internationalization
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function load_textdomain() {

        // Set filter for language directory
        $lang_dir = AUTOMATORWP_ELEMENTOR_FORMS_DIR . '/languages/';
        $lang_dir = apply_filters( 'automatorwp_elementor_forms_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'automatorwp-elementor-forms' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'automatorwp-elementor-forms', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/automatorwp-elementor-forms/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/automatorwp-elementor-forms/ folder
            load_textdomain( 'automatorwp-elementor-forms', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/automatorwp-elementor-forms/languages/ folder
            load_textdomain( 'automatorwp-elementor-forms', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'automatorwp-elementor-forms', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true AutomatorWP_Elementor_Forms_Integration instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \AutomatorWP_Elementor_Forms_Integration The one true AutomatorWP_Elementor_Forms_Integration
 */
function AutomatorWP_Elementor_Forms_Integration() {
    return AutomatorWP_Elementor_Forms_Integration::instance();
}
add_action( 'plugins_loaded', 'AutomatorWP_Elementor_Forms_Integration' );
