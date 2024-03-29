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
        $data['title']      = _l('Venues');
        $this->load->view('admin/venues/manage', $data);
    }

    public function venue($id = '') {
        if($id != '') {

            $data['venuedetails']   = $this->venues_model->getdetails($id);
            $data['gallery']        = $this->venues_model->gallery($id);
            $data['title']          = _l('Edit Venue');
        }
        else {
            $data['title']      = _l('Add venue');
        }
        $this->load->view('admin/venues/venue' , $data);
    }
    public function add_venues($id = '')
    {
        $venueid                    = $id;
        $data['name']               = $this->input->post('name');
        $data['address1']           = $this->input->post('addressOne');
        $data['address2']           = $this->input->post('addressTwo');
        $data['phone']              = $this->input->post('phone');
        $data['email']              = $this->input->post('email');
        $data['suburb']             = $this->input->post('suburb');
        $data['postcode']           = $this->input->post('postcode');
        $data['state']              = $this->input->post('state');
        $data['datecreated']        = date("Y/m/d");
        $data['wheelchairaccess']   = $this->input->post('wheelchair');
        $data['carramp']            = $this->input->post('carramp');
        $config['upload_path']      = './uploads/venues/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
        {
            array('error' => $this->upload->display_errors());
        }
        else
        {
            array('upload_data' => $this->upload->data());
        }
        $fetured                        =   $_FILES['image']['name'];
        if(  $fetured  !='') {
            $data['featured_image']     =   $fetured;
        }
        if( $id!='' ) {
            $updatevenues               = $this->venues_model->update_venues($data,$venueid);
            $openingHours               = $this->venues_model->update_openingHours($this->input->post(),$venueid);
        } else {
            $venueId                    = $this->venues_model->add_venues($data);
            $openingHours               = $this->venues_model->add_openingHours($this->input->post(),$venueId);
        }
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
        for($i=0; $i<$cpt; $i++){
            $_FILES['userfile']['name']         = $files['userfile']['name'][$i];
            $_FILES['userfile']['type']         = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name']     = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error']        = $files['userfile']['error'][$i];
            $_FILES['userfile']['size']         = $files['userfile']['size'][$i];
            $configgallery['upload_path']       = './uploads/venues/gallery/';
            $configgallery['allowed_types']     = 'gif|jpg|png|jpeg';
            $configgallery['max_size']          = '2000000';
            $configgallery['remove_spaces']     = true;
            $configgallery['overwrite']         = false;
            $configgallery['max_width']         = '';
            $configgallery['max_height']        = '';
            $this->load->library('upload', $configgallery);
            $this->upload->initialize($configgallery);
            $this->upload->do_upload();
            $upload_data = $this->upload->data();
            $galleryimage          =  $upload_data['file_name'];
            if($galleryimage !='')
            {
                $dataimage['image']     =   $galleryimage;
            }
            if($id!='') {
                $dataimage['venue_id']  =   $id;
            } else {
                $dataimage['venue_id']  =   $venueId;
            }
            $dataimage['datecreated']   =   date("Y/m/d");
            if ($galleryimage !='' ) {
                $uploadgallery          =   $this->venues_model->add_galleryImages($dataimage);
            }
        }

        if($id!=''){

            if ($updatevenues   == true ||$uploadgallery    ==  true || $openingHours ==    true) {
                set_alert('success', _l('Updated venues', _l('venue_field')));
            }
            else
            {
                set_alert('warning', _l('problem_updatingg', _l('venue_field_lowercase')));

            }
        }
        else {
            if ($venueId!='') {
                set_alert('success', _l('Added venues', _l('venue_field')));
            }
            else
            {
                set_alert('warning', _l('problem_adding', _l('venue_field_lowercase')));

            }
        }
        redirect(admin_url('venues'));
    }
    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('venues'));
        }
        $response = $this->venues_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('venue_field')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('venue_field_lowercase')));
        }
        redirect(admin_url('venues'));
    }

    public function imagedelete()
    {
        $id                 =   $this->input->post('imageid');
        $deleteimage        =   $this->venues_model->deleteimage($id);
        if ($deleteimage== true) {
            echo "true";
        }
        else {
            echo "false";
        }
    }
    public function settings() {
        $data['title']                = _l('venue_settings');
        $data['amenities']            = $this->venues_model->getamenities();
        $data['layouts']              = $this->venues_model->getlayouts();
        $this->load->view('admin/venues/settings' , $data);
    }
    public function amenities() {
        if ($this->input->post()) {
            if (!$this->input->post('amenity_id')) {
                $id = $this->venues_model->add_amenities($this->input->post());
                echo json_encode(array(
                    'success'=>$id ? true : false,
                    'message'=>$id ? _l('added_successfully', _l('new_amenity')) : '',
                    'id'=>$id,
                    'name'=>$this->input->post('name'),
                    'type' => 'add'
                ));
            } else {
                $success = $this->venues_model->update_amenities($this->input->post());
                $message = _l('updated_successfully', _l('amenity'));
                echo json_encode(array('success' => $success,'message' => $message,'type' => 'edit','id' => $this->input->post('amenity_id'),'name' => $this->input->post('name')  ));
            }
        }
    }
    public function areas() {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('areas');
        }
        $data['title']            = _l('venue_area');
        $this->load->view('admin/venues/areas' , $data);
    }

    public function amenitiesDisable($id) {
        $venueAmenity = $this->venues_model->get_venue_amenity_by_id($id);
        $this->venues_model->mark_as($venueAmenity->id,0);
        redirect(admin_url('venues/settings'));
    }

    public function amenitiesEnable($id) {
        $venueAmenity = $this->venues_model->get_venue_amenity_by_id($id);
        $this->venues_model->mark_as($venueAmenity->id,1);
        redirect(admin_url('venues/settings'));
    }

    public function layoutDisable($id) {
        $venueLayout = $this->venues_model->get_venue_layout_by_id($id);
        $this->venues_model->layout_mark_as($venueLayout->id,0);
        redirect(admin_url('venues/settings'));
    }

    public function layoutEnable($id) {
        $venueLayout = $this->venues_model->get_venue_layout_by_id($id);
        $this->venues_model->layout_mark_as($venueLayout->id,1);
        redirect(admin_url('venues/settings'));
    }

    public function layout() {
        if ($this->input->post()) {
            if (!$this->input->post('layout_id')) {
                $id = $this->venues_model->add_layout($this->input->post());
                echo json_encode(array(
                    'success'=>$id ? true : false,
                    'message'=>$id ? _l('added_successfully', _l('new_layout')) : '',
                    'id'=>$id,
                    'name'=>$this->input->post('name'),
                    'type' => 'add'
                ));
            } else {
                $success = $this->venues_model->update_layout($this->input->post());
                $message = _l('updated_successfully', _l('layout'));
                echo json_encode(array('success' => $success,'message' => $message,'type' => 'edit','id' => $this->input->post('layout_id'),'name' => $this->input->post('name')  ));
            }
        }
    }

    public function area($id = '') {
        if($id != '') {
            $data['details']         = $this->venues_model->getareadetails($id);
            $data['area_amenities'] = $this->venues_model->get_area_amenity_by_area_id($id);
            $data['area_layouts'] = $this->venues_model->get_area_layout_by_area_id($id);
            $data['title']          = _l('Edit Area');
        }
        else {
            $data['title']      = _l('Add Area');
        }
        $data['layouts']              = $this->venues_model->getlayouts(true);
        $data['amenities']            = $this->venues_model->getamenities(true);
        $this->load->view('admin/venues/area' , $data);
    }

    public function add_areas() {
        if (!$this->input->post('venue_area_id')) {
            $areaId = $this->venues_model->add_area($this->input->post());
            if ($this->input->post('amenity')) {
                $this->venues_model->add_area_amenities($this->input->post('amenity'),$areaId);
            }
            if ($this->input->post('layout')) {
                $this->venues_model->add_area_layouts($this->input->post(),$areaId);
            }
            if ($areaId) {
                set_alert('success', _l('Added Area Successfully', _l('venue_field')));
            }
        } else {
            $this->venues_model->update_area_amenities($this->input->post('amenity'),$this->input->post('venue_area_id'));
            $this->venues_model->update_area_layouts($this->input->post(),$this->input->post('venue_area_id'));
            if ($this->venues_model->update_area($this->input->post())) {
                set_alert('success', _l('Updated Area Successfully', _l('venue_field')));
            }
        }
        redirect(admin_url('venues/areas'));
    }

    public function areaDisable($id) {
        $area = $this->venues_model->get_area_by_id($id);
        $this->venues_model->area_mark_as($area->id,0);
        redirect(admin_url('venues/areas'));
    }

    public function areaEnable($id) {
        $area = $this->venues_model->get_area_by_id($id);
        $this->venues_model->area_mark_as($area->id,1);
        redirect(admin_url('venues/areas'));
    }

    public function areaDelete($id) {
        if (!$id) {
            redirect(admin_url('venues/areas'));
        }
        $response = $this->venues_model->deleteArea($id);
        if ($response == true) {
            set_alert('success', _l('Deleted Area Successfully'));
        } else {
            set_alert('warning', _l('Some error occured'));
        }
        redirect(admin_url('venues/areas'));
    }


}
