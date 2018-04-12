<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_201 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {

        // Venues - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `details` text,
  `phone` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `featured_image` varchar(256) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `wheelchairaccess` CHAR(3) NULL,
  `carramp` CHAR(3) NULL,
  `amenities` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Image Gallery - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueimagegallery` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `image` varchar(512) DEFAULT NULL,
              `venue_id` int(11) DEFAULT NULL,`datecreated` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Opening Hours - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueopeninghours` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `venue_id` int(11) DEFAULT NULL,
              `monday` varchar(64) DEFAULT NULL,
              `tuesday` varchar(64) DEFAULT NULL,
              `wednesday` varchar(64) DEFAULT NULL,
              `thursday` varchar(64) DEFAULT NULL,
              `friday` varchar(64) DEFAULT NULL,
              `saturday` varchar(64) DEFAULT NULL,
              `sunday` varchar(64) DEFAULT NULL,`datetime` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Rooms - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenuerooms` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `venue_id` int(11) DEFAULT NULL,
              `name` varchar(256) DEFAULT NULL,
              `specifications` varchar(512) DEFAULT NULL,
              `ceiling_height` varchar(64) DEFAULT NULL,
              `foyer_area` varchar(64) DEFAULT NULL,
              `balcony_area` varchar(64) DEFAULT NULL,
              `total_area` varchar(64) DEFAULT NULL,
              `capacity` varchar(64) DEFAULT NULL,
              `theater_min` varchar(64) DEFAULT NULL,
              `theater_max` varchar(64) DEFAULT NULL,
              `ushape_min` varchar(64) DEFAULT NULL,
              `ushape_max` varchar(64) DEFAULT NULL,
              `cabaret_min` varchar(64) DEFAULT NULL,
              `cabaret_max` varchar(64) DEFAULT NULL,
              `cocktail_min` varchar(64) DEFAULT NULL,
              `cocktail_max` varchar(64) DEFAULT NULL,
              `dinner_min` varchar(64) DEFAULT NULL,
              `dinner_max` varchar(64) DEFAULT NULL,
              `dinner_dance_min` varchar(64) DEFAULT NULL,
              `dinner_dance_max` varchar(64) DEFAULT NULL,
              `datecreated` datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Table Templates - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbltemplates` (
              `templateid` int(11) NOT NULL AUTO_INCREMENT,
              `type` mediumtext,
              `slug` varchar(100) DEFAULT NULL,
              `name` mediumtext,`active` tinyint(4) DEFAULT NULL,
              `order` int(11) DEFAULT NULL,
              `plaintext` int(11) DEFAULT NULL,
              `message` text,
              PRIMARY KEY (`templateid`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $menu = get_option('setup_menu_active');
        $menu = json_decode($menu, 1);
        $finalMenu = array();

        foreach($menu['setup_menu_active'] as $key=>$menuItems) {
            $finalMenu[] = $menuItems;
            if ($key == 1) {
                $finalMenu[] = array (
                    'name' => 'venues',
                    'url' => '#',
                    'permission' => 'is_admin',
                    'icon' => '',
                    'id' => 'venues',
                    'children' =>
                        array (
                            0 =>
                                array (
                                    'name' => 'Venues',
                                    'url' => 'venues',
                                    'permission' => '',
                                    'icon' => '',
                                    'id' => 'venue',
                                ),
                            1 =>
                                array (
                                    'name' => 'Rooms',
                                    'url' => 'rooms',
                                    'permission' => '',
                                    'icon' => '',
                                    'id' => 'rooms',
                                ),
                        ),
                );
            }
        }
        $order = count($finalMenu);
        $finalMenu[] = array (
            'name' => 'templates',
            'permission' => 'is_admin',
            'url' => 'templates',
            'id' => 'templates',
            'order' => $order
        );
        $menu['setup_menu_active'] = $finalMenu;
        update_option('setup_menu_active', json_encode($menu));


        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating  - You are using version 2.0.1</h4>
        <p>
        This window will reload automaticaly in 10 seconds and will try to clear your browser/cloudflare cache, however its recomended to clear your browser cache manually.
        </p>
        </div>
        </div>
        <script>
        setTimeout(function(){
            window.location.reload();
        },10000);
        </script>');

    }

}
