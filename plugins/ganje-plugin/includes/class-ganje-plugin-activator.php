<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.ganje-wp.ir
 * @since      1.0.0
 *
 * @package    Ganje_Plugin
 * @subpackage Ganje_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ganje_Plugin
 * @subpackage Ganje_Plugin/includes
 * @author     Ganje <Ganje@gmail.com>
 */
class Ganje_Plugin_Activator
{

    public function __construct()
    {
        $this->wishlist_table_creator();
    }

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {

    }

    public static function wishlist_table_creator()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;

        ob_start(); ?>

        DROP TABLE IF EXISTS <?php echo $wpdb->prefix; ?>gd_mylist;
        CREATE TABLE <?php echo $wpdb->prefix; ?>gd_mylist (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `item_id` varchar(15) DEFAULT NULL COMMENT 'post and pages',
        `user_id` varchar(15) DEFAULT NULL,
        `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `item_id` (`item_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

        <?php

        $sql = ob_get_clean();
        dbDelta($sql);
    }

}
