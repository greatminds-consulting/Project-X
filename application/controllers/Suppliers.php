<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers extends Supplier_controller
{
    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<p class="text-danger alert-validation">', '</p>');
        do_action('after_suppliers_area_init', $this);
        $this->load->model('suppliers_model');
        $this->load->model('projects_model');
        $this->load->model('taxes_model');
        $this->load->model('invoice_items_model');
    }

    public function index() {
        if (!is_supplier_logged_in()) {
            redirect(site_url('suppliers/login'));
        }
        redirect(site_url('suppliers/profile'));
    }

    public function logout()
    {
        $this->load->model('authentication_model');
        $this->authentication_model->logout(false);
        do_action('after_supplier_logout');
        redirect(site_url('suppliers/login'));
    }

    public function login()
    {
        if (is_supplier_logged_in()) {
            redirect(site_url('suppliers'));
        }
        $this->form_validation->set_rules('password', _l('clients_login_password'), 'required');
        $this->form_validation->set_rules('email', _l('clients_login_email'), 'trim|required|valid_email');
        if (get_option('use_recaptcha_customers_area') == 1 && get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != '') {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');
        }
        if ($this->form_validation->run() !== false) {
            $this->load->model('Authentication_model');
            $success = $this->Authentication_model->login($this->input->post('email'), $this->input->post('password', false), $this->input->post('remember'), false,'supplier');
            if (is_array($success) && isset($success['memberinactive'])) {
                set_alert('danger', _l('inactive_account'));
                redirect(site_url('suppliers/login'));
            } elseif ($success == false) {
                set_alert('danger', _l('client_invalid_username_or_password'));
                redirect(site_url('suppliers/login'));
            }

            maybe_redirect_to_previous_url();
            do_action('after_contact_login');
            redirect(site_url('suppliers/profile'));
        }
        if (get_option('allow_registration') == 1) {
            $data['title'] = _l('clients_login_heading_register');
        } else {
            $data['title'] = _l('clients_login_heading_no_register');
        }
        $data['bodyclass'] = 'customers_login';

        $this->data        = $data;
        $this->view        = 'login';
        $this->layout();
    }

    public function profile()
    {
        if (!is_supplier_logged_in()) {
            redirect(site_url('suppliers/login'));
        }
        if ($this->input->post('profile')) {
            $this->form_validation->set_rules('email', _l('email'), 'required');
            $this->form_validation->set_rules('businessname', _l('businessname'), 'required');
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();
                // Unset the form indicator so we wont send it to the model
                unset($data['profile']);

                // For all cases
                if (isset($data['password'])) {
                    unset($data['password']);
                }
                $success = $this->suppliers_model->update_supplier($data, get_supplier_user_id());

                if ($success == true) {
                    set_alert('success', _l('clients_profile_updated'));
                }
                redirect(site_url('suppliers/profile'));
            }
        } elseif ($this->input->post('change_password')) {
            $this->form_validation->set_rules('oldpassword', _l('clients_edit_profile_old_password'), 'required');
            $this->form_validation->set_rules('newpassword', _l('clients_edit_profile_new_password'), 'required');
            $this->form_validation->set_rules('newpasswordr', _l('clients_edit_profile_new_password_repeat'), 'required|matches[newpassword]');
            if ($this->form_validation->run() !== false) {
                $success = $this->suppliers_model->change_supplier_password($this->input->post());
                if (is_array($success) && isset($success['old_password_not_match'])) {
                    set_alert('danger', _l('client_old_password_incorrect'));
                } elseif ($success == true) {
                    set_alert('success', _l('client_password_changed'));
                }
                redirect(site_url('suppliers/profile'));
            }
        }
        $data['title'] = _l('clients_profile_heading');
        $data['supplier'] = $this->suppliers_model->getSupplierProfile(get_supplier_user_id());
        $this->data    = $data;
        $this->view    = 'profile';
        $this->layout();
    }

    public function items() {
        if (!is_supplier_logged_in()) {
            redirect(site_url('suppliers/login'));
        }
        $data['items']            = $this->invoice_items_model->get(false,false,get_supplier_user_id());
        $data['title']            = _l('items');
        $this->data               = $data;
        $this->view               = 'items';
        $this->layout();
    }

    public function itemdelete($id) {
        $response = $this->invoice_items_model->delete($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('invoice_item_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('invoice_item')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('invoice_item_lowercase')));
        }
        redirect(site_url('suppliers/items'));
    }
}
