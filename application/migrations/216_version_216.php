<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_216 extends CI_Migration
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
            $menu['aside_menu_active'][] = array(
                'name' => 'Event Manager',
                'url'=> 'eventmanager',
                'permission' => '',
                'icon' => 'fa fa-bars',
                'id' => 'eventmanager'
            );
        }
        $menu = json_encode($menu);
        update_option('aside_menu_active',$menu);

        // eventactivity
        $this->db->query("CREATE TABLE `tbleventactivity`( `id` INT(11) NOT NULL AUTO_INCREMENT, `event_manager_id` INT(11), `staff_id` INT(11), `contact_id` INT(11), `fullname` VARCHAR(100), `visible_to_customer` INT(11), `description_key` VARCHAR(500), `additional_data` TEXT, `dateadded` DATETIME, PRIMARY KEY (`id`) ); ");
        // eventdiscussion comments
        $this->db->query("CREATE TABLE `tbleventdiscussioncomments`( `id` INT(11) NOT NULL AUTO_INCREMENT, `discussion_id` INT(11) NOT NULL, `discussion_type` VARCHAR(100) NOT NULL, `parent` INT(11), `created` DATETIME NOT NULL, `modified` DATETIME, `content` TEXT, `staff_id` INT(11) NOT NULL, `contact_id` INT(11) NOT NULL, `fullname` VARCHAR(300), `file_name` VARCHAR(300), `file_mime_type` VARCHAR(70), PRIMARY KEY (`id`) ); ");
        // eventdiscussion
        $this->db->query("CREATE TABLE `tbleventdiscussions`( `id` INT(11) NOT NULL AUTO_INCREMENT, `event_manager_id` INT(11) NOT NULL, `subject` VARCHAR(500) NOT NULL, `description` TEXT NOT NULL, `show_to_customer` TINYINT(1) NOT NULL, `datecreated` DATETIME NOT NULL, `last_activity` DATETIME, `staff_id` INT(11), `contact_id` INT(11), PRIMARY KEY (`id`) ); ");
        // eventfiles
        $this->db->query("CREATE TABLE `tbleventfiles`( `id` INT(11) NOT NULL AUTO_INCREMENT, `file_name` MEDIUMTEXT NOT NULL, `subject` VARCHAR(500), `description` TEXT, `filetype` VARCHAR(50), `dateadded` DATETIME NOT NULL, `last_activity` DATETIME, `event_manager_id` INT(11) NOT NULL, `visible_to_customer` TINYINT(1), `staffid` INT(11) NOT NULL, `contact_id` INT(11) NOT NULL, `external` VARCHAR(40), `external_link` TEXT, `thumbnail_link` TEXT, PRIMARY KEY (`id`) ); ");
        // eventmembers
        $this->db->query("CREATE TABLE `tbleventmembers`( `id` INT(11) NOT NULL AUTO_INCREMENT, `event_manager_id` INT(11) NOT NULL, `staff_id` INT(11) NOT NULL, PRIMARY KEY (`id`) ); ");
        // eventnotes
        $this->db->query("CREATE TABLE `tbleventnotes`( `id` INT(11) NOT NULL AUTO_INCREMENT, `event_manager_id` INT(11) NOT NULL, `content` TEXT NOT NULL, `staff_id` INT(11) NOT NULL, PRIMARY KEY (`id`) ); ");
        // eventmanager
        $this->db->query("CREATE TABLE `tbleventmanager`( `id` INT(11) NOT NULL AUTO_INCREMENT, `name` VARCHAR(600) NOT NULL, `description` TEXT, `status` INT(11) NOT NULL, `clientid` INT(11) NOT NULL, `billing_type` INT(11) NOT NULL, `start_date` DATE NOT NULL, `deadline` DATE, `eventmanager_created` DATE NOT NULL, `date_finished` DATETIME, `progress` INT(11), `progress_from_tasks` INT(11) NOT NULL, `eventmanager_cost` DECIMAL(15,2), `eventmanager_rate_per_hour` DECIMAL(15,2), `estimated_hours` DECIMAL(15,2), `addedfrom` INT(11) NOT NULL, `is_delete` TINYINT(1), PRIMARY KEY (`id`) ); ");
        // eventsettings
        $this->db->query("CREATE TABLE `tbleventsettings`( `id` INT(11) NOT NULL AUTO_INCREMENT, `event_manager_id` INT(11) NOT NULL, `name` VARCHAR(100) NOT NULL, `value` TEXT NOT NULL, PRIMARY KEY (`id`) ); ");
        // pinnedevents
        $this->db->query("CREATE TABLE `tblpinnedevents`( `id` INT(11) NOT NULL AUTO_INCREMENT, `event_manager_id` INT(11) NOT NULL, `staff_id` INT(11) NOT NULL, PRIMARY KEY (`id`) ); ");
        // alter tblexpenses
        $this->db->query("ALTER TABLE `tblexpenses` ADD COLUMN `event_manager_id` INT(11) NULL AFTER `addedfrom`; ");
        // alter tblmilestone
        $this->db->query("ALTER TABLE `tblmilestones` ADD COLUMN `event_manager_id` INT(11) NOT NULL AFTER `datecreated`; ");
        // alter tblcontacts
        $this->db->query("ALTER TABLE `tblcontacts` ADD COLUMN `eventmanager_emails` TINYINT(1) DEFAULT 1 NOT NULL AFTER `is_delete`; ");
        // alter tbltickets
        $this->db->query("ALTER TABLE `tbltickets` ADD COLUMN `event_manager_id` INT(11) DEFAULT 0 NOT NULL AFTER `assigned`; ");
        // alter tblinvoices
        $this->db->query("ALTER TABLE `tblinvoices` ADD COLUMN `event_manager_id` INT(11) DEFAULT 0 NOT NULL AFTER `is_delete`;");
        // alter tblpermissions
        $this->db->query("INSERT INTO `tblpermissions` ( `name`, `shortname`) VALUES ('events', 'events');");
        // alter tblestimates
        $this->db->query("ALTER TABLE `tblestimates` ADD COLUMN `event_manager_id` INT(11) DEFAULT 0 NOT NULL AFTER `acceptance_ip`; ");

        if (file_exists(FCPATH.'pipe.php')) {
            @chmod(FCPATH.'pipe.php', 0755);
        }
        update_option('update_info_message', '<div class="col-md-12">
        <div class="alert alert-success bold">
        <h4 class="bold">Hi! Thanks for updating CRM - You are using version 2.1.6</h4>
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
