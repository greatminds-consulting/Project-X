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
        $this->db->query("CREATE TABLE `tblrecyclebin`( `id` INT NOT NULL AUTO_INCREMENT, `item_id` INT NOT NULL, `item_name` VARCHAR(300), `item_type` VARCHAR(128), `dateadded` DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`) );");

        //is Delete field insertion
        $this->db->query("ALTER TABLE `tblleads` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `client_id`; ");
        $this->db->query("ALTER TABLE `tblvenues` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `postcode`; ");
        $this->db->query("ALTER TABLE `tblprojects` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `addedfrom`; ");
        $this->db->query("ALTER TABLE `tblproposals` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `acceptance_ip`; ");
        $this->db->query("ALTER TABLE `tblinvoices` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `project_id`; ");
        $this->db->query("ALTER TABLE `tblcontacts` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `project_emails`; ");
        $this->db->query("ALTER TABLE `tblclients` ADD COLUMN `is_delete` TINYINT(1) DEFAULT 0 NULL AFTER `addedfrom`; ");

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
