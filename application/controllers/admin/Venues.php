<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Venues extends Admin_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('venues_model');

    }
    public function index() {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('venue_fields');
        }
        $data['title']      = _l('venues');
        $this->load->view('admin/venues/manage', $data);
    }

}