<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('EMAIL_TEMPLATE_SEND', true);
class Templates_model extends CRM_Model {

    private $attachment = array();
    private $client_email_templates;
    private $staff_email_templates;
    private $rel_id;
    private $rel_type;

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->client_email_templates = get_client_email_templates_slugs();
        $this->staff_email_templates  = get_staff_email_templates_slugs();
    }

    /**
     * @param  $where
     * @return array
     * Get email template by type
     */
    public function get($where = array()) {
        $this->db->where($where);
        return $this->db->get('tbltemplates')->result_array();
    }

    /**
     * @param  integer
     * @return object
     * Get email template by id
     */
    public function get_template_by_id($id) {
        $this->db->where('templateid', $id);
        return $this->db->get('tbltemplates')->row();
    }

    /**
     * @param resource
     * @param string
     * @param string (mime type)
     * @return none
     * Add attachment to property to check before an email is send
     */
    public function add_attachment($attachment) {
        $this->attachment[] = $attachment;
    }

    /**
     * @return none
     * Clear all attachment properties
     */
    private function clear_attachments() {
        $this->attachment = array();
    }

    public function set_rel_id($rel_id) {
        $this->rel_id = $rel_id;
    }

    public function set_rel_type($rel_type) {
        $this->rel_type = $rel_type;
    }

    public function get_rel_id() {
        return $this->rel_id;
    }

    public function get_rel_type() {
        return $this->rel_type;
    }

    /**
     * Create new  template
     */
    public function add_template($data) {
        $this->db->insert('tbltemplates', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return false;
    }

    /**
     * Update  template
     */
    public function update($data) {
        $affectedRows = 0;
        foreach ($data['message'] as $id => $val)   {
            $main_id = $id;
            $_data              = array();
            $_data['message']   = $data['message'][$id];
            $_data['name']      = $data['name'];
            $_data['type']      = $data['type'];
            $_data['message']   = $data['message'][$id];
            $this->db->where('templateid', $id);
            $this->db->update('tbltemplates', $_data);
            if ($this->db->affected_rows() > 0) {
                $affectedRows++;
            }
        }
        $main_template = $this->get_template_by_id($main_id);
        if ($affectedRows > 0 && $main_template) {
            logActivity('Template Updated [' . $main_template->name . ']');

            return true;
        }
        return false;
    }

    /**
     * Change template to active/inactive
     * @param  string $templateId    template id
     * @param  mixed $enabled enabled or disabled / 1 or 0
     * @return boolean
     */
    public function mark_as($templateId, $enabled) {
        $this->db->where('templateid', $templateId);
        $this->db->update('tbltemplates', array('active'=>$enabled));
        return $this->db->affected_rows() > 0 ? true : false;
    }

    /**
     * Change template to active/inactive
     * @param  string $type    template type
     * @param  mixed $enabled enabled or disabled / 1 or 0
     * @return boolean
     */
    public function mark_as_by_type($type,$enabled) {
        $this->db->where('type', $type);
        $this->db->update('tbltemplates', array('active'=>$enabled));
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function delete($id) {
        $this->db->where('templateid', $id);
        $this->db->delete('tbltemplates');
        if ($this->db->affected_rows() > 0) {
            logActivity('Template Deleted [' . $id . ']');
            return true;
        }
        return false;
    }

}
