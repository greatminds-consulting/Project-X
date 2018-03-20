<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rooms extends Admin_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        //$this->load->library('upload');
        $this->load->model('rooms_model');

    }
    public function index() {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('room_fields');
        }
        $data['title']      = _l('Rooms');
        $this->load->view('admin/rooms/manage', $data);
    }
    public function room() {
        $data['title']      = _l('Add new room');
        $data['venues']     = $this->rooms_model->NotusedVenues();
        $this->load->view('admin/rooms/room' , $data);
    }
    public function add_rooms($id = '')
    {
        $data['venue_id']           = $this->input->post('venueName');
        $data['name']               = $this->input->post('roomName');
        $data['specifications']     = $this->input->post('specifications');
        $data['ceiling_height']     = $this->input->post('ceilingHeight');
        $data['foyer_area']         = $this->input->post('foyerArea');
        $data['balcony_area']       = $this->input->post('balconyArea');
        $data['total_area']         = $this->input->post('totalArea');
        $data['capacity']           = $this->input->post('capacity');
        $data['theater_min']        = $this->input->post('theaterMin');
        $data['theater_max']        = $this->input->post('theaterMax');
        $data['ushape_min']         = $this->input->post('ushapemin');
        $data['ushape_max']         = $this->input->post('ushapemax');
        $data['cabaret_min']        = $this->input->post('carbaretMin');
        $data['cabaret_max']        = $this->input->post('carbaretMax');
        $data['cocktail_min']       = $this->input->post('cocktailmin');
        $data['cocktail_max']       = $this->input->post('cocktailmax');
        $data['dinner_min']         = $this->input->post('dinnermin');
        $data['dinner_max']         = $this->input->post('dinnermax');
        $data['dinner_dance_min']   = $this->input->post('DinnerDancemin');
        $data['dinner_dance_max']   = $this->input->post('DinnerDancemax');
        $data['datecreated']        = date("Y/m/d");
        if($id =='') {
            $roomsdetails               = $this->rooms_model->add_rooms($data);
            if ($roomsdetails!='') {

                set_alert('success', _l('Rooms Added', _l('room_field')));
            }
            else {
                set_alert('warning', _l('Problem room adding', _l('room_field_lowercase')));
            }
        } else {
            $roomsdetails               = $this->rooms_model->update_rooms($data,$id);
            if ($roomsdetails == true) {
                set_alert('success', _l('updated rooms', _l('room_field')));
            } else {
                set_alert('warning', _l('problem_updating', _l('room_field_lowercase')));
            }
        }

        redirect(admin_url('rooms'));
    }
    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('rooms'));
        }
        $response = $this->rooms_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('room_field')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('room_field_lowercase')));
        }
        redirect(admin_url('rooms'));
    }
    public function edit($id)
    {
        $data['title']      = _l('Rooms');
        $data['roomdetails']=$this->rooms_model->getdetails($id);
        $data['venues']     = $this->rooms_model->getVenues();
        $this->load->view('admin/rooms/edit' , $data);
    }
}