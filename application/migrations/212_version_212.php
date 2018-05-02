<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_212 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Venue Custom Fields In Items
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblitemsvenue` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `itemid` int(11) NOT NULL,
              `rel_id` int(11) NOT NULL,
              `rel_type` varchar(20) NOT NULL,
              `venue_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.1.2</h4>
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
