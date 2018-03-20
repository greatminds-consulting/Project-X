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
}
