<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rooms_model extends CRM_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getVenues()
    {
        $query = $this->db->get('tblvenues');
        $data = $query->result_array();
        return  $data;
    }
    public function add_rooms($data)
    {
        $this->db->insert('tblvenuerooms', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblvenuerooms');
        if ($this->db->affected_rows() > 0) {
          logActivity('Custom Field Deleted [' . $id . ']');
             return true;
        }

        return false;
    }
    public function getdetails($id)
    {
        $this->db->select('tblvenuerooms.*,tblvenues.name as venue_name');
        $this->db->from('tblvenuerooms');
        $this->db->join('tblvenues','tblvenues.id=tblvenuerooms.venue_id');
        $this->db->where('tblvenuerooms.id',$id);
        $query=$this->db->get();
        $data= $query->row();
        return $data;
    }
    public function update_rooms($data,$roomid)
    {
        $this->db->where('id',$roomid);
        $this->db->update('tblvenuerooms',$data);
        if ($this->db->affected_rows() > 0) {
           return true;
        }

        return false;

    }
    public function NotusedVenues()
    {
        $this->db->select('tblvenues.*');
        $this->db->from('tblvenues');
        $this->db->where('`tblvenues.id` NOT IN (SELECT venue_id FROM `tblvenuerooms`)');
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }


}