<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Venues_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_venues($data)
    {
        $this->db->insert('tblvenues', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function add_openingHours($data1)
    {
        $this->db->insert('tblvenueopeninghours', $data1);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function add_galleryImages($dataimage )
    {
        $this->db->insert('tblvenueimagegallery', $dataimage);
        $insert_id = $this->db->insert_id();

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblvenues');
        if ($this->db->affected_rows() > 0) {
            // Delete the values
            $this->db->where('venue_id', $id);
            $this->db->delete('tblvenueopeninghours');
            $this->db->where('venue_id', $id);
            $this->db->delete('tblvenueimagegallery');
            $this->db->where('venue_id', $id);
            $this->db->delete('tblvenuerooms');
            logActivity('Custom Field Deleted [' . $id . ']');
            return true;
        }

        return false;
    }

    public function getdetails($id)
    {
        $this->db->select('tblvenues.*,tblvenueopeninghours.*');
        $this->db->from('tblvenues');
        $this->db->join('tblvenueopeninghours','tblvenues.id=tblvenueopeninghours.venue_id','left');
        $this->db->where('tblvenues.id',$id);
        $query=$this->db->get();
        $data= $query->row();
        return $data;
    }

    public function gallery($id)
    {
        $this->db->select('*');
        $this->db->from('tblvenueimagegallery');
        $this->db->where('venue_id',$id);
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }

    public function update_venues($data,$venueid)
    {
        $this->db->where('id',$venueid);
        $this->db->update('tblvenues',$data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function update_openingHours($data1,$venueid)
    {
        $this->db->where('venue_id',$venueid);
        $this->db->update('tblvenueopeninghours',$data1);

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function deleteimage($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblvenueimagegallery');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getamenities()
    {
        $this->db->select('*');
        $this->db->from('tblvenueamenities');
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }
    public function getlayouts()
    {
        $this->db->select('*');
        $this->db->from('tblvenuelayouts');
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }

    /**
     * Add amenities
     * @param mixed $data All $_POST data
     * @return boolean
     */
    public function add_amenities($data) {
        $data['active'] = 1;
        if (isset($data['amenity_id'])) {
            unset($data['amenity_id']);
        }
        $this->db->insert('tblvenueamenities', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Amenity Added [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_amenities($data)
    {
        $data['id'] = $data['amenity_id'];
        unset($data['amenity_id']);
        $this->db->where('id', $data['id']);
        $this->db->update('tblvenueamenities', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Amenity Updated [ID: ' . $data['amenity_id'] . ']');
            return true;
        }
        return false;
    }

    public function get_venue_amenity_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('tblvenueamenities')->row();
    }

    public function mark_as($templateId, $enabled) {
        $this->db->where('id', $templateId);
        $this->db->update('tblvenueamenities', array('active'=>$enabled));
        return $this->db->affected_rows() > 0 ? true : false;
    }

    /**
     * Add layout
     * @param mixed $data All $_POST data
     * @return boolean
     */
    public function add_layout($data) {
        $data['active'] = 1;
        if (isset($data['layout_id'])) {
            unset($data['layout_id']);
        }
        $this->db->insert('tblvenuelayouts', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Layout Added [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_layout($data)
    {
        $data['id'] = $data['layout_id'];
        unset($data['layout_id']);
        $this->db->where('id', $data['id']);
        $this->db->update('tblvenuelayouts', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Layout Updated [ID: ' . $data['layout_id'] . ']');
            return true;
        }
        return false;
    }

    public function get_venue_layout_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('tblvenuelayouts')->row();
    }

    public function layout_mark_as($templateId, $enabled) {
        $this->db->where('id', $templateId);
        $this->db->update('tblvenuelayouts', array('active'=>$enabled));
        return $this->db->affected_rows() > 0 ? true : false;
    }
}