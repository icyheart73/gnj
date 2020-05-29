<?php

define( 'Ganje_PLUGIN_DIR', __DIR__ );
define( 'Ganje_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'Ganje_PLUGIN_FILE', plugin_basename( __FILE__ ) );

define( 'Ganje_PLUGIN_VER', $plugin_data['ver'] );

define( 'Ganje_PLUGIN_NAME', $plugin_data['name'] );


class Gnaje_Calling_Order{

    private static $instance = null;
    private $setting;


    public function __construct() {
        $this->get_Settings();
        $this->load_dependencies();

    }

    public function get_Settings() {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Gnaje_Calling_Order();
        }
        return self::$instance;
    }

    private function load_dependencies() {

        /**
         * Hiding field to CF7
         */
        require Ganje_PLUGIN_DIR . '/admin/admin-class/added-cf7-field.php';
        /**
         * Created form for firs install
         */
        require Ganje_PLUGIN_DIR . '/includes/admin/class-ganje-install-form.php';
    }
}
Gnaje_Calling_Order::getInstance();
