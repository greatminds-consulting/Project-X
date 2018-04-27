<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Invoice_items extends Admin_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('invoice_items_model');
        $this->load->model('venues_model');
    }

    /* List all available items */
    public function index($id = '')
    {
        if (!has_permission('items', '', 'view')) {
            access_denied('Invoice Items');
        }

        $this->load->model('taxes_model');
        $data['taxes']          = $this->taxes_model->get();
        $data['items_groups']   = $this->invoice_items_model->get_groups();
        $data['items_packages'] = $this->invoice_items_model->get_packages();
        $data['venues'] = $this->venues_model->getvenues();
        $data['item_venues'] = $this->venues_model->get_type_details_from_venue_map($id, 'Items');

        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $data['title'] = _l('invoice_items');
        $this->load->view('admin/invoice_items/manage', $data);
    }

    public function table(){
        if (!has_permission('items', '', 'view')) {
            ajax_access_denied();
        }
        $this->app->get_table_data('invoice_items');
    }
    /* Edit or update items / ajax request /*/
    public function manage()
    {
        if (has_permission('items', '', 'view')) {
            if ($this->input->post()) {
                $data = $this->input->post();
                if ($data['itemid'] == '') {
                    if (!has_permission('items', '', 'create')) {
                        header('HTTP/1.0 400 Bad error');
                        echo _l('access_denied');
                        die;
                    }
                    $id      = $this->invoice_items_model->add($data);
                    $success = false;
                    $message = '';
                    if ($id) {
                        handle_contact_item_image_upload($id);
                        $success = true;
                        $message = _l('added_successfully', _l('invoice_item'));
                    }
                    echo json_encode(array(
                        'success' => $success,
                        'message' => $message,
                        'item' => $this->invoice_items_model->get($id)
                    ));
                } else {
                    $id      = $data['itemid'];
                    $updated          = false;
                    if (!has_permission('items', '', 'edit')) {
                        header('HTTP/1.0 400 Bad error');
                        echo _l('access_denied');
                        die;
                    }
                    $success = $this->invoice_items_model->edit($data);
                    $message = '';
                    if ($success) {
                        $message = _l('updated_successfully', _l('invoice_item'));
                    }
                    if (handle_contact_item_image_upload($id) && !$updated) {
                        $message = _l('updated_successfully', _l('contact'));
                        $success = true;
                    }
                    echo json_encode(array(
                        'success' => $success,
                        'message' => $message
                    ));
                }
            }
        }
    }

    public function add_group()
    {
        if ($this->input->post() && has_permission('items', '', 'create')) {
            $this->invoice_items_model->add_group($this->input->post());
            set_alert('success', _l('added_successfully', _l('item_group')));
        }
    }

    public function add_package()
    {
        if ($this->input->post() && has_permission('items', '', 'create')) {
            $this->invoice_items_model->add_package($this->input->post());
            set_alert('success', _l('added_successfully', _l('new_item_package')));
        }
    }

    public function update_group($id)
    {
        if ($this->input->post() && has_permission('items', '', 'edit')) {
            $this->invoice_items_model->edit_group($this->input->post(), $id);
            set_alert('success', _l('updated_successfully', _l('item_group')));
        }
    }

    public function update_package($id)
    {
        if ($this->input->post() && has_permission('items', '', 'edit')) {
            $this->invoice_items_model->edit_package($this->input->post(), $id);
            set_alert('success', _l('updated_successfully', _l('item_package')));
        }
    }

    public function delete_group($id)
    {
        if (has_permission('items', '', 'delete')) {
            if ($this->invoice_items_model->delete_group($id)) {
                set_alert('success', _l('deleted', _l('item_group')));
            }
        }
        redirect(admin_url('invoice_items?groups_modal=true'));
    }

    public function delete_package($id)
    {
        if (has_permission('items', '', 'delete')) {
            if ($this->invoice_items_model->delete_package($id)) {
                set_alert('success', _l('deleted', _l('item_package')));
            }
        }
        redirect(admin_url('invoice_items?packages_modal=true'));
    }

    /* Delete item*/
    public function delete($id)
    {
        if (!has_permission('items', '', 'delete')) {
            access_denied('Invoice Items');
        }

        if (!$id) {
            redirect(admin_url('invoice_items'));
        }

        $response = $this->invoice_items_model->delete($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('invoice_item_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('invoice_item')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('invoice_item_lowercase')));
        }
        redirect(admin_url('invoice_items'));
    }

    public function search(){
        if($this->input->post() && $this->input->is_ajax_request()){
            echo json_encode($this->invoice_items_model->search($this->input->post('q')));
        }
    }

    /* Get item by id / ajax */
    public function get_item_by_id($id)
    {
        if ($this->input->is_ajax_request()) {
            $item                   = $this->invoice_items_model->get($id);

            $item->item_packages = $this->invoice_items_model->get_item_packages($id, true);
            $item->long_description = nl2br($item->long_description);
            $item->item_image=$item->item_image;
            $item->stock = nl2br($item->stockinhand);
            $item->custom_fields_html = render_custom_fields('items',$id,array(),array('items_pr'=>true));
            $item->venues = $this->venues_model->getvenues();
            $item->item_venues = $this->venues_model->get_type_details_from_venue_map($id, 'Items');
            $item->custom_fields = array();
            $cf = get_custom_fields('items');

            foreach($cf as $custom_field) {
                $val = get_custom_field_value($id,$custom_field['id'],'items_pr');
                if($custom_field['type'] == 'textarea') {
                    $val = clear_textarea_breaks($val);
                }
                $custom_field['value'] = $val;
                $item->custom_fields[] = $custom_field;
            }
            echo json_encode($item);
        }
    }

    /* Get item by id / ajax */
    public function get_package_by_id($id)
    {
        if ($this->input->is_ajax_request()) {
            $items                   = $this->invoice_items_model->get('', $id);
            $return = array();
            foreach ($items as $item) {
                $item['venues'] = $this->venues_model->get_type_details_from_venue_map($item['itemid'] , 'Items');
                $item['long_description'] = nl2br($item['long_description']);
                $item['custom_fields_html'] = render_custom_fields('items',$item['itemid'],array(),array('items_pr'=>true));
                $item['custom_fields'] = array();

                $cf = get_custom_fields('items');

                foreach($cf as $custom_field) {
                    $val = get_custom_field_value($item['itemid'],$custom_field['id'],'items_pr');
                    if($custom_field['type'] == 'textarea') {
                        $val = clear_textarea_breaks($val);
                    }
                    $custom_field['value'] = $val;
                    $item['custom_fields'][] = $custom_field;
                }
                $return[] = $item;
            }

            echo json_encode($return);
        }
    }
}
