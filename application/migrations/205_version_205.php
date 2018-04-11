<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_205 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Venues Area - alteration

        $this->db->query("CREATE TABLE `tblitems_packages` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(50) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");

        $this->db->query("ALTER TABLE `tblitems` ADD COLUMN `package_id` INT NULL AFTER `group_id`;");

        // Venues Area Layout - new feature
        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.0.5</h4>
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
