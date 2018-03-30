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

        $data['contracts'] = $this->templates_model->get(array(
            'type' => 'contracts'
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


    /* Add New template */
    public function new_template() {
        $data['title']     = _l('add_new_template');
        $this->load->view('admin/templates/new_template', $data);
    }

    public function add_template() {
        $data['name']           = $this->input->post('name');
        $data['message']        = $this->input->post('message[0]');
        $data['type']           = $this->input->post('type');
        $data['active']         = 1;
        $this->templates_model->add_template($data);
        redirect(admin_url('templates'));
    }

    /* Edit template */
    public function template($id) {
        if (!has_permission('templates', '', 'view')) {
            access_denied('templates');
        }
        if (!$id) {
            redirect(admin_url('templates'));
        }
        if ($this->input->post()) {
            if (!has_permission('templates', '', 'edit')) {
                access_denied('templates');
            }
            $data = $this->input->post();
            $tmp = $this->input->post(null,false);
            foreach($data['message'] as $key=>$contents){
                $data['message'][$key] = $tmp['message'][$key];
            }
            $success = $this->templates_model->update($data, $id);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('template')));
            }
            redirect(admin_url('templates'));
        }
        $data['template']               = $this->templates_model->get_template_by_id($id);
        $title                          = $data['template']->name;
        $data['title']                  = $title;
        $this->load->view('admin/templates/template', $data);
    }

    public function disable($id) {
        if (has_permission('templates','','edit')) {
            $template = $this->templates_model->get_template_by_id($id);
            $this->templates_model->mark_as($template->templateid,0);
        }
        redirect(admin_url('templates'));
    }

    public function enable($id) {
        if (has_permission('templates','','edit')) {
            $template = $this->templates_model->get_template_by_id($id);
            $this->templates_model->mark_as($template->templateid,1);
        }
        redirect(admin_url('templates'));
    }

    public function enable_by_type($type){
        if (has_permission('templates','','edit')) {
            $this->templates_model->mark_as_by_type($type,1);
        }
        redirect(admin_url('templates'));
    }

    public function disable_by_type($type){
        if (has_permission('templates','','edit')) {
            $this->templates_model->mark_as_by_type($type,0);
        }
        redirect(admin_url('templates'));
    }

    public function list_templates($type = 'proposals') {
        $proposals = $this->templates_model->get(array(
            'type' => $type,
            'active' => 1
        ));
        $proposalArray = array();
        foreach ($proposals as $proposal) {
            $proposalArray[] = array(
                'title' => $proposal['name'],
                'content' => $proposal['message']
            );
        }
        $data['proposalArray'] = $proposalArray;
        $this->load->view('admin/templates/list_templates',$data);
    }

    public function delete($id) {
        if (!$id) {
            redirect(admin_url('templates'));
        }
        $response = $this->templates_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('Deleted Template Successfully'));
        } else {
            set_alert('warning', _l('Some error occured'));
        }
        redirect(admin_url('templates'));
    }

}
