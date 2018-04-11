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

    public function add_openingHours($postData,$venue_id) {
        $data['monday_from']            = $postData['monday_from'];
        $data['monday_to']              = $postData['monday_to'];
        $data['tuesday_from']           = $postData['tuesday_from'];
        $data['tuesday_to']             = $postData['tuesday_to'];
        $data['wednesday_from']         = $postData['wednesday_from'];
        $data['wednesday_to']           = $postData['wednesday_to'];
        $data['thursday_from']          = $postData['thursday_from'];
        $data['thursday_to']            = $postData['thursday_to'];
        $data['friday_from']            = $postData['friday_from'];
        $data['friday_to']              = $postData['friday_to'];
        $data['saturday_from']          = $postData['saturday_from'];
        $data['saturday_to']            = $postData['saturday_to'];
        $data['sunday_from']            = $postData['sunday_from'];
        $data['sunday_to']              = $postData['sunday_to'];
        $data['venue_id']               = $venue_id;
        $this->db->insert('tblvenueopeninghours', $data);
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

    public function update_openingHours($postData,$venueid) {
        $data['monday_from']            = $postData['monday_from'];
        $data['monday_to']              = $postData['monday_to'];
        $data['tuesday_from']           = $postData['tuesday_from'];
        $data['tuesday_to']             = $postData['tuesday_to'];
        $data['wednesday_from']         = $postData['wednesday_from'];
        $data['wednesday_to']           = $postData['wednesday_to'];
        $data['thursday_from']          = $postData['thursday_from'];
        $data['thursday_to']            = $postData['thursday_to'];
        $data['friday_from']            = $postData['friday_from'];
        $data['friday_to']              = $postData['friday_to'];
        $data['saturday_from']          = $postData['saturday_from'];
        $data['saturday_to']            = $postData['saturday_to'];
        $data['sunday_from']            = $postData['sunday_from'];
        $data['sunday_to']              = $postData['sunday_to'];
        $data['venue_id']               = $venueid;
        $this->db->where('venue_id',$venueid);
        $this->db->update('tblvenueopeninghours',$data);
        return true;
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

    public function getamenities($amenity = '') {
        $this->db->select('*');
        if ($amenity) {
            $this->db->where('active', 1);
        }
        $this->db->from('tblvenueamenities');
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }
    public function getlayouts($layout = '') {
        $this->db->select('*');
        if ($layout) {
            $this->db->where('active', 1);
        }
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

    public function update_layout($data) {
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

    public function getareas() {
        $this->db->select('tblvenueareas.name as area_name,tblvenueareas.active as area_active,tblvenueareas.layout_minimum as layout_minimum,,tblvenueareas.layout_maximum as layout_maximum,tblvenueareas.id as area_id,tblvenuelayouts.*');
        $this->db->from('tblvenueareas');
        $this->db->join('tblvenuelayouts','tblvenuelayouts.id=tblvenueareas.layout_id','left');
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }

    public function getareadetails($id) {
        $this->db->select('*');
        $this->db->from('tblvenueareas');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $data = $query->result_array();
        return  $data;
    }

    public function add_area($postData) {
        $data['name']               = $postData['name'];
        $data['active'] = 1;
        $this->db->insert('tblvenueareas', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Area Added [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function add_area_layouts($postData, $areaId) {
        if ($postData['layout']) {
            foreach ($postData['layout'] as $layoutKey => $layoutValue) {
                    if (!$layoutValue) {
                        continue;
                    }
                    $data['area_id'] = $areaId;
                    $data['layout_id'] = $layoutValue;
                    $data['layout_min'] = $postData['layout_minimum'][$layoutKey];
                    $data['layout_max'] = $postData['layout_maximum'][$layoutKey];
                    $this->db->insert('tblvenueareaslayout', $data);
                    $this->db->insert_id();
            }
            return true;
        }
        return false;
    }
    public function add_area_amenities($dataFields,$areaId) {
        foreach ($dataFields as $dataField) {
            $data['active'] = 1;
            $data['area_id'] = $areaId;
            $data['amenity_id'] = $dataField;
            $this->db->insert('tblvenueareaamenities', $data);
            $this->db->insert_id();
        }
        return true;
    }

    public function get_area_layout_by_area_id($id) {
        $this->db->select('*');
        $this->db->from('tblvenueareaslayout');
        $this->db->where('area_id',$id);
        $query = $this->db->get();
        $layouts = $query->result_array();
        return $layouts;
    }

    public function get_area_amenity_by_area_id($id) {
        $this->db->select('amenity_id');
        $this->db->from('tblvenueareaamenities');
        $this->db->where('area_id',$id);
        $query = $this->db->get();
        $amenities = $query->result_array();
        $return = array();
        foreach ($amenities as $amenity) {
          $return[$amenity['amenity_id']] = true;
        }
        return $return;
    }

    public function update_area($postData) {
        $data['name']               = $postData['name'];
        $data['layout_id']          = $postData['layout'];
        $data['layout_minimum']     = $postData['layout_minimum'];
        $data['layout_maximum']     = $postData['layout_maximum'];
        $data['active'] = 1;
        $data['id'] = $postData['venue_area_id'];
        $this->db->where('id',$data['id']);
        $this->db->update('tblvenueareas',$data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function update_area_amenities($dataFields, $areaId) {
        $this->db->where('area_id', $areaId);
        $this->db->delete('tblvenueareaamenities');
        if ($dataFields) {
            foreach ($dataFields as $dataField) {
                $data['active'] = 1;
                $data['area_id'] = $areaId;
                $data['amenity_id'] = $dataField;
                $this->db->insert('tblvenueareaamenities', $data);
                $this->db->insert_id();
            }
        }
        return true;
    }
     public function update_area_layouts($postData, $areaId) {
         $this->db->where('area_id', $areaId);
         $this->db->delete('tblvenueareaslayout');
         if ($postData['layout']) {
             foreach ($postData['layout'] as $layoutKey => $layoutValue) {
                 if (!$layoutValue) {
                     continue;
                 }
                 $data['area_id'] = $areaId;
                 $data['layout_id'] = $layoutValue;
                 $data['layout_min'] = $postData['layout_minimum'][$layoutKey];
                 $data['layout_max'] = $postData['layout_maximum'][$layoutKey];
                 $this->db->insert('tblvenueareaslayout', $data);
                 $this->db->insert_id();
             }
             return true;
         }
         return false;
     }

    public function get_area_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('tblvenueareas')->row();
    }

    public function area_mark_as($areaId, $enabled) {
        $this->db->where('id', $areaId);
        $this->db->update('tblvenueareas', array('active'=>$enabled));
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function deleteArea($id) {
        $this->db->where('id', $id);
        $this->db->delete('tblvenueareas');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('area_id', $id);
            $this->db->delete('tblvenueareaslayout');
            $this->db->where('area_id', $id);
            $this->db->delete('tblvenueareaamenities');
            logActivity('Venue Area Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
}
