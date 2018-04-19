<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers extends Supplier_controller
{
    public function __construct() {
        parent::__construct();
        $this->form_validation->set_error_delimiters('<p class="text-danger alert-validation">', '</p>');
        do_action('after_suppliers_area_init', $this);
    }

    public function index() {
        if (!is_supplier_logged_in()) {
            redirect(site_url('suppliers/login'));
        }
        $data['is_home'] = true;
        $this->load->model('reports_model');
        $data['title'] = get_supplier_company_name(get_supplier_user_id());

        $this->data    = $data;
        $this->view    = 'home';
        $this->layout();
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
        if (is_client_logged_in()) {
            redirect(site_url());
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
            redirect(site_url('suppliers'));
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

}
