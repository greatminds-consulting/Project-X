<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supplier extends Admin_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model');
    }

    /* List all supplier members */
    public function index()
    {
        if (!has_permission('supplier', '', 'view')) {
            access_denied('supplier');
        }
        if ($this->input->is_ajax_request()) {
          $test=  $this->app->get_table_data('supplier');

        }
        $data['title'] = _l('supplier');
        $this->load->view('admin/supplier/manage', $data);
    }

    /* Add new supplier or edit existing */
    public function member($id = '')
    {

        if ($this->input->post()) {
            $data = $this->input->post();

            if ($id == '') {
                $id = $this->supplier_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('supplier')));
                    redirect(admin_url('supplier/member/' . $id));
                }
          } else {
                 $response = $this->supplier_model->update($data, $id);
                if (isset($response) == true) {
                    set_alert('success', _l('updated_successfully', _l('supplier')));
                }
                redirect(admin_url('supplier/member/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('supplier_member_lowercase'));
        } else {
            $member                    = $this->supplier_model->get($id);
            if (!$member) {
                blank_page('Supplier Not Found', 'danger');
            }
            $data['member']            = $member;
            $title                     = $member->businessname;
            $data['supplier_permissions'] = $this->supplier_model->get_supplier_permissions($id);
        }
        $data['supplier_permissions'] = get_supplier_permissions();
        $data['title']       = $title;
        $this->load->view('admin/supplier/member', $data);
    }

    function delete($id = '')
    {
        if(!is_admin()) {
            if(is_admin($this->input->post('id'))) {
                die( 'Busted, you can\'t delete administrators' );
            }
        }
        $success = $this->supplier_model->delete($id);
            if ($success=='true') {
                set_alert('success', _l('deleted', _l('staff')));
            } else {
                set_alert('warning', _l('problem_deleting','Supplier'));
            }


        redirect(admin_url('supplier'));
    }

    public function change_supplier_status($id, $status)
    {
        if (has_permission('staff', '', 'edit')) {
            if ($this->input->is_ajax_request()) {
                $this->supplier_model->change_supplier_status($id, $status);
            }
        }
    }
}
