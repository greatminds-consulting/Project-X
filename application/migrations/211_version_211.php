<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_211 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        // Venue Custom Fields Mapping
        $this->db->query("CREATE TABLE `tblvenues_in`( `id` INT NOT NULL AUTO_INCREMENT, `venue_id` INT, `type` VARCHAR(32), `type_id` INT, PRIMARY KEY (`id`) ); ");

        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.1.1</h4>
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
