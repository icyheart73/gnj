<?php
class Ganje_Compare{
    private static $instance = null;
    private $setting;
    public function __construct() {

    }
    public function get_Settings() {
        global $GanjeSetting;
        $this->setting = $GanjeSetting;
    }
    public static function getInstance() {
        if (self::$instance == null)  {
            self::$instance = new Ganje_Compare();
        }
        return self::$instance;
    }
}
Ganje_Compare::getInstance();
