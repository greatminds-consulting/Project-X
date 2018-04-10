<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_210 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Items Package - removed
        $this->db->query("ALTER TABLE `tblitems` DROP COLUMN `package_id`; ");

        // Items Package Mapping
        $this->db->query(" CREATE TABLE `tblitems_packages_map`( `id` INT NOT NULL AUTO_INCREMENT, `item_id` INT, `package_id` INT, `active` TINYINT DEFAULT 1, PRIMARY KEY (`id`) ); ");

        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.1.0</h4>
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
