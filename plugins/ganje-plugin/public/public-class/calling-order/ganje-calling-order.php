<?php



class Gnaje_Calling_Order
{
    /**
     * Added AWOOC_Front_End.
     *
     * @since 2.0.0
     * @var object AWOOC_Front_End $front_end
     */
    public $front_end;

    private static $instance = null;
    private $setting;


    public function __construct()
    {
        $this->get_Settings();
        $this->load_dependencies();

    }

    public function get_Settings()
    {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Gnaje_Calling_Order();
        }
        return self::$instance;
    }

    private function load_dependencies()
    {
        /**
         * Front end
         */
        require GNJ_PATH . '/public/public-class/calling-order/includes/ganje-template-functions.php';
        require GNJ_PATH . '/public/public-class/calling-order/includes/class-ganje-front-end.php';
        $this->front_end = new Ganje_Front_End();
        if(is_admin()) {
            require GNJ_PATH . '/public/public-class/calling-order/includes/class-ganje-admin-meta-box.php';
        }

        /**
         * Ajax
         */
        require GNJ_PATH . '/public/public-class/calling-order/includes/class-ganje-ajax.php';

    }
}
Gnaje_Calling_Order::getInstance();
