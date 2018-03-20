<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Templates extends Admin_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('templates_model');
    }

    /* List all templates */
    public function index() {
        if (!has_permission('templates', '', 'view')) {
            access_denied('templates');
        }
        $data['proposals'] = $this->templates_model->get(array(
            'type' => 'proposals'
        ));
        $data['title']     = _l('templates');
        $data['hasPermissionEdit'] = has_permission('templates','','edit');
        $this->load->view('admin/templates/email_templates', $data);
    }

    /**
     * @param  integer
     * @return object
     * Get template by id
     */
    public function get_template_by_id($id) {
        $this->db->where('templateid', $id);
        return $this->db->get('tbltemplates')->row();
    }

}
