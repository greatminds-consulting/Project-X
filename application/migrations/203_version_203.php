<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_203 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Venues - alteration
        $this->db->query("ALTER TABLE `tblvenues` DROP COLUMN `details`, DROP COLUMN `amenities`, ADD COLUMN `suburb` VARCHAR(16) NULL AFTER `carramp`, ADD COLUMN `state` VARCHAR(128) NULL AFTER `suburb`, ADD COLUMN `postcode` VARCHAR(16) NULL AFTER `state`;");

        // Venues Areas - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueareas`( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(256), `layout_id` INT, `layout_minimum` INT, `layout_maximum` INT,`active` tinyint(4) DEFAULT NULL, PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Areas Amenities - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueareaamenities`( `id` INT NOT NULL AUTO_INCREMENT, `area_id` INT, `amenity_id` INT,`active` tinyint(4) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Amenities - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueamenities`( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(256), `active` tinyint(4) DEFAULT NULL,PRIMARY KEY (`id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Layouts - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenuelayouts`( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(256),`active` tinyint(4) DEFAULT NULL, PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venue Opening hours  - alteration
        $this->db->query("ALTER TABLE `tblvenueopeninghours` ADD COLUMN `monday_from` VARCHAR(64) NULL AFTER `venue_id`, CHANGE `monday` `monday_to` VARCHAR(64) CHARSET utf8 COLLATE utf8_general_ci NULL, ADD COLUMN `tuesday_from` VARCHAR(64) NULL AFTER `monday_to`, CHANGE `tuesday` `tuesday_to` VARCHAR(64) CHARSET utf8 COLLATE utf8_general_ci NULL, ADD COLUMN `wednesday_from` VARCHAR(64) NULL AFTER `tuesday_to`, CHANGE `wednesday` `wednesday_to` VARCHAR(64) CHARSET utf8 COLLATE utf8_general_ci NULL, ADD COLUMN `thursday_from` VARCHAR(64) NULL AFTER `wednesday_to`, CHANGE `thursday` `thursday_to` VARCHAR(64) CHARSET utf8 COLLATE utf8_general_ci NULL, ADD COLUMN `friday_from` VARCHAR(64) NULL AFTER `thursday_to`, CHANGE `friday` `friday_to` VARCHAR(64) CHARSET utf8 COLLATE utf8_general_ci NULL, ADD COLUMN `saturday_from` VARCHAR(64) NULL AFTER `friday_to`, CHANGE `saturday` `saturday_to` VARCHAR(64) CHARSET utf8 COLLATE utf8_general_ci NULL, ADD COLUMN `sunday_from` VARCHAR(64) NULL AFTER `saturday_to`, CHANGE `sunday` `sunday_to` VARCHAR(64) ;");

        $menu = get_option('setup_menu_active');
        $menu = json_decode($menu, 1);
        $finalMenu = array();

        foreach($menu['setup_menu_active'] as $key=>$menuItems) {
            if ($menuItems['id'] == 'venues') {
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
                            2 =>
                                array (
                                    'name' => 'Area',
                                    'url' => 'venues/areas',
                                    'permission' => '',
                                    'icon' => '',
                                    'id' => 'rooms',
                                ),
                            3 =>
                                array (
                                    'name' => 'Settings',
                                    'url' => 'venues/settings',
                                    'permission' => '',
                                    'icon' => '',
                                    'id' => 'rooms',
                                ),
                        ),
                );
            } else {
                $finalMenu[] = $menuItems;
            }

        }
        $menu['setup_menu_active'] = $finalMenu;
        update_option('setup_menu_active', json_encode($menu));


        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating Perfex CRM - You are using version 2.0.3</h4>
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
