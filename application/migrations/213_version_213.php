<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_213 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Venue Custom Fields In Items
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblsuppliers` (
              `supplierid` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(100)  DEFAULT NULL,`password` varchar(256)  DEFAULT NULL,`businessname` varchar(128) DEFAULT NULL,
              `abn` varchar(64) DEFAULT NULL,`acn` varchar(64) DEFAULT NULL,`address1` text DEFAULT NULL,
              `address2` text DEFAULT NULL,`suburb` varchar(64) DEFAULT NULL,`state` varchar(64) DEFAULT NULL,`postcode` varchar(64) DEFAULT NULL,
              `country` varchar(128) DEFAULT NULL,`last_ip` varchar(40) DEFAULT NULL,
              `last_login` datetime DEFAULT NULL,`last_activity` datetime DEFAULT NULL,
              `last_password_change` datetime DEFAULT NULL, `new_pass_key` varchar(32) DEFAULT NULL,`new_pass_key_requested` datetime DEFAULT NULL,
              `active` tinyint(1) NOT NULL DEFAULT '1',`is_delete` tinyint(1) NOT NULL DEFAULT '0',
              PRIMARY KEY (`supplierid`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

        $this->db->query("ALTER TABLE `tblitems` ADD COLUMN `stockinhand` INT NULL AFTER `group_id`, ADD COLUMN `type` VARCHAR(32) NULL AFTER `stock in hand`, ADD COLUMN `created_by` INT NULL AFTER `type`");

        add_option('supplier_default_theme','supplier_navarra');

        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.1.3</h4>
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
