<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_204 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Venues Area - alteration
        $this->db->query("ALTER TABLE `tblvenueareas` DROP COLUMN `layout_id`, DROP COLUMN `layout_minimum`,DROP COLUMN `layout_maximum` ;");

        // Venues Area Layout - new feature
        $this->db->query("CREATE TABLE `tblvenueareaslayout`( `id` INT NOT NULL AUTO_INCREMENT, `area_id` INT, `layout_id` INT, `layout_min` INT, `layout_max` INT, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating Perfex CRM - You are using version 2.0.4</h4>
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
