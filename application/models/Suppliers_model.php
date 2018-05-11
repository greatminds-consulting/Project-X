<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Suppliers_model extends CRM_Model {

    public function __construct() {
        parent::__construct();
    }


    public function getSupplierProfile($id) {
        $this->db->select('*');
        $this->db->from('tblsuppliers');
        $this->db->where('tblsuppliers.supplierid',$id);
        $query=$this->db->get();
        $data= $query->row();
        return $data;
    }

    /**
     * Update supplier data
     * @param  array  $data           $_POST data
     * @param  mixed  $id             contact id
     * @return mixed
     */
    public function update_supplier($data, $id) {
        $affectedRows = 0;
        $hook_data = do_action('before_update_supplier', array('data'=>$data, 'id'=>$id));
        $data = $hook_data['data'];
        $data['last_activity'] = date('Y-m-d H:i:s');
        $this->db->where('supplierid', $id);
        $this->db->update('tblsuppliers', $data);
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }
        if ($affectedRows > 0) {
            logActivity('Supplier Updated');
            return true;
        }
        return false;
    }


    public function change_supplier_password($data)
    {
        $hook_data['data'] = $data;
        $hook_data         = do_action('before_contact_change_password', $hook_data);
        $data              = $hook_data['data'];

        // Get current password
        $this->db->where('supplierid', get_supplier_user_id());
        $supplier = $this->db->get('tblsuppliers')->row();
        $this->load->helper('phpass');
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        if (!$hasher->CheckPassword($data['oldpassword'], $supplier->password)) {
            return array(
                'old_password_not_match' => true,
            );
        }
        $update_data['password']             = $hasher->HashPassword($data['newpasswordr']);
        $update_data['last_password_change'] = date('Y-m-d H:i:s');
        $this->db->where('supplierid', get_supplier_user_id());
        $this->db->update('tblsuppliers', $update_data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Supplier Password Changed');
            return true;
        }
        return false;
    }
}
