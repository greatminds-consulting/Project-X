<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CRM_Model
{
    private $contact_columns;

    public function __construct()
    {
        parent::__construct();


    }

    public function add($data)
    {
        $contact_data = array();
        foreach ($this->contact_columns as $field) {
            if (isset($data[$field])) {
                $contact_data[$field] = $data[$field];
                // Phonenumber is also used for the company profile
                if ($field != 'phonenumber') {
                    unset($data[$field]);
                }
            }
        }
        // From customer profile register
        if (isset($data['permissions'])) {
            $permissions = $data['permissions'];
            unset($data['permissions']);
        }
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }
        if (isset($data['permissions'])) {
            $permissions = $data['permissions'];
            unset($data['permissions']);
        }
        if (isset($data['password'])) {
            $this->load->helper('phpass');
            $hasher                       = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
            $data['password']             = $hasher->HashPassword($data['password']);
        }

        $this->db->insert('tblsuppliers', $data);
        $userid = $this->db->insert_id();
        if ($userid) {
            if (isset($permissions) ) {
                foreach ($permissions as $permission) {
                    $this->db->insert('tblsupplierpermissions', array(
                        'userid' => $userid,
                        'permission_id' => $permission,
                    ));

            }
            }
            if (isset($custom_fields)) {
                $_custom_fields = $custom_fields;
                // Possible request from the register area with 2 types of custom fields for contact and for comapny/customer
                if (count($custom_fields) == 2) {
                    unset($custom_fields);
                    $custom_fields['customers']                = $_custom_fields['customers'];
                    $contact_data['custom_fields']['contacts'] = $_custom_fields['contacts'];
                } elseif (count($custom_fields) == 1) {
                    if (isset($_custom_fields['contacts'])) {
                        $contact_data['custom_fields']['contacts'] = $_custom_fields['contacts'];
                        unset($custom_fields);
                    }
                }
                handle_custom_fields_post($userid, $custom_fields);
            }
        }
        return $userid;
    }

    /**
     * @param  array $_POST data
     * @param  integer ID
     * @return boolean
     * Update Supplier informations
     */
    public function update($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }
        if (isset($data['permissions'])) {
            $permissions = $data['permissions'];
            unset($data['permissions']);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $this->load->helper('phpass');
            $hasher                       = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
            $data['password']             = $hasher->HashPassword($data['password']);
            $data['last_password_change'] = date('Y-m-d H:i:s');
        }
        if (isset($permissions) ) {
            $this->db->where('userid', $id);
            $this->db->delete('tblsupplierpermissions');

            foreach ($permissions as $permission) {
                $this->db->insert('tblsupplierpermissions', array(
                    'userid' => $id,
                    'permission_id' => $permission,
                ));

            }
            $affectedRows++;
        }
        $this->db->where('supplierid', $id);
        $this->db->update('tblsuppliers', $data);
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    public function get($id = '', $where = array())
    {
        $this->db->select('tblsuppliers.*');
        $this->db->join('tblcountries', 'tblcountries.country_id = tblsuppliers.country', 'left');
        $this->db->where($where);

        if (is_numeric($id)) {
            $this->db->where('tblsuppliers.supplierid', $id);
            $supplier = $this->db->get('tblsuppliers')->row();
            return $supplier;
        }
        return $this->db->get('tblsuppliers')->result_array();
    }
    public function get_supplier_permissions($id = '')
    {
        // If not id is passed get from current user
        $this->db->where('userid', $id);

        return $this->db->get('tblsupplierpermissions')->result_array();
    }

    public function delete($id)
    {
        $this->db->where('supplierid', $id);
        $this->db->delete('tblsuppliers');
        if ($this->db->affected_rows() > 0) {
            // Delete the values
            $this->db->where('userid', $id);
            $this->db->delete('tblsupplierpermissions');
            logActivity('Custom Field Deleted [' . $id . ']');
            return true;
        }

        return false;
    }

    public function change_supplier_status($id, $status)
    {
        $hook_data['id']     = $id;
        $hook_data['status'] = $status;
        $hook_data           = do_action('before_supplier_status_change', $hook_data);
        $status              = $hook_data['status'];
        $id                  = $hook_data['id'];

        $this->db->where('supplierid', $id);
        $this->db->update('tblsuppliers', array(
            'active' => $status,
        ));
        logActivity('Supplier Status Changed [SupplierID: ' . $id . ' - Status(Active/Inactive): ' . $status . ']');
    }


}
