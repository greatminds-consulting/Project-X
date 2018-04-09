<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_202 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {

        // Leads - new feature

         $this->db->query(" CREATE TABLE `tblleadstaffs` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
          `staff_id` int(11) DEFAULT NULL,
          `lead_id` int(11) DEFAULT NULL,
          `datecreated` datetime DEFAULT NULL,
          PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");


        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating  - You are using version 2.0.2</h4>
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
