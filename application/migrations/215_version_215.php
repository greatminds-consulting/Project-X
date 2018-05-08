<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_215 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up() {

        $menu = get_option('aside_menu_active');
        $menu = json_decode($menu, 1);
        if(is_array($menu)){
            $i = 0;
            foreach($menu['aside_menu_active'] as $key => $item){
                if($item['id'] == 'reports') {
                    $menu['aside_menu_active'][$key]['children'][] = array(
                        'name' => 'Incoming Report',
                        'url'=> 'reports/incoming_leads',
                        'permission' => '',
                        'icon' => '',
                        'id' => 'incoming_leads'
                    );
                }
            }
        }
        $menu = json_encode($menu);
        update_option('aside_menu_active',$menu);

        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }

        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.1.5</h4>
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
