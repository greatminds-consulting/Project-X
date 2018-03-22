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
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueareas`( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(256), `layout_id` INT, `layout_minimum` INT, `layout_maximum` INT, PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Areas Amenities - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueareaamenities`( `id` INT NOT NULL AUTO_INCREMENT, `area_id` INT, `amenity_id` INT, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Amenities - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenueamenities`( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(256), PRIMARY KEY (`id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        // Venues Layouts - new feature
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblvenuelayouts`( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(256), PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

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
                                    'url' => 'venues/area',
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
        <h4 class="bold">Hi! Thanks for updating Perfex CRM - You are using version 2.0.1</h4>
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
