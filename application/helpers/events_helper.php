<?php

/**
 * Default eventmanager tabs
 * @param  mixed $event_manager_id eventmanager id to format the url
 * @return array
 */
function get_eventmanager_tabs_admin($event_manager_id)
{
    $eventmanager_tabs = array(
        array(
            'name'=>'eventmanager_overview',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_overview'),
            'icon'=>'fa fa-th',
            'lang'=>_l('eventmanager_overview'),
            'visible'=>true,
            'order'=>1,
        ),
//        array(
//            'name'=>'eventmanager_tasks',
//            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_tasks'),
//            'icon'=>'fa fa-check-circle',
//            'lang'=>_l('tasks'),
//            'visible'=>true,
//            'order'=>2,
//            'linked_to_customer_option'=>array('view_tasks'),
//        ),
        array(
            'name'=>'eventmanager_timesheets',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_timesheets'),
            'icon'=>'fa fa-clock-o',
            'lang'=>_l('eventmanager_timesheets'),
            'visible'=>true,
            'order'=>3,
            'linked_to_customer_option'=>array('view_timesheets'),
        ),
        array(
            'name'=>'eventmanager_milestones',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_milestones'),
            'icon'=>'fa fa-rocket',
            'lang'=>_l('eventmanager_milestones'),
            'visible'=>true,
            'order'=>4,
            'linked_to_customer_option'=>array('view_milestones'),
        ),
        array(
            'name'=>'eventmanager_files',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_files'),
            'icon'=>'fa fa-files-o',
            'lang'=>_l('eventmanager_files'),
            'visible'=>true,
            'order'=>5,
            'linked_to_customer_option'=>array('upload_files'),
        ),
        array(
            'name'=>'eventmanager_discussions',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_discussions'),
            'icon'=>'fa fa-commenting',
            'lang'=>_l('eventmanager_discussions'),
            'visible'=>true,
            'order'=>6,
            'linked_to_customer_option'=>array('open_discussions'),
        ),
        array(
            'name'=>'eventmanager_gantt',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_gantt'),
            'icon'=>'fa fa-line-chart',
            'lang'=>_l('eventmanager_gant'),
            'visible'=>true,
            'order'=>7,
            'linked_to_customer_option'=>array('view_gantt'),
        ),
        array(
            'name'=>'eventmanager_tickets',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_tickets'),
            'icon'=>'fa fa-life-ring',
            'lang'=>_l('eventmanager_tickets'),
            'visible'=>(get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member(),
            'order'=>8,
        ),
        array(
            'name'=>"sales",
            'url'=>'#',
            'icon'=>'',
            'lang'=>_l('sales_string'),
            'visible'=>(has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own')) || (has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own')) || (has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own')),
            'order'=>9,
            'dropdown'=>array(
                array(
                    'name'=>'eventmanager_invoices',
                    'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_invoices'),
                    'icon'=>'fa fa-sun-o',
                    'lang'=>_l('eventmanager_invoices'),
                    'visible'=>has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own'),
                    'order'=>1,
                ),
                array(
                    'name'=>'eventmanager_estimates',
                    'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_estimates'),
                    'icon'=>'fa fa-sun-o',
                    'lang'=>_l('estimates'),
                    'visible'=>has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own'),
                    'order'=>2,
                ),
                array(
                    'name'=>'eventmanager_expenses',
                    'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_expenses'),
                    'icon'=>'fa fa-sort-amount-asc',
                    'lang'=>_l('eventmanager_expenses'),
                    'visible'=>has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own'),
                    'order'=>3,
                ),
                array(
                    'name'=>'eventmanager_credit_notes',
                    'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_credit_notes'),
                    'icon'=>'fa fa-sort-amount-asc',
                    'lang'=>_l('credit_notes'),
                    'visible'=>has_permission('credit_notes', '', 'view') || has_permission('credit_notes', '', 'view_own'),
                    'order'=>3,
                ),
            ),
        ),
        array(
            'name'=>'eventmanager_notes',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_notes'),
            'icon'=>'fa fa-clock-o',
            'lang'=>_l('eventmanager_notes'),
            'visible'=>true,
            'order'=>10,
        ),
        array(
            'name'=>'eventmanager_activity',
            'url'=>admin_url('eventmanager/view/'.$event_manager_id.'?group=event_activity'),
            'icon'=>'fa fa-exclamation',
            'lang'=>_l('eventmanager_activity'),
            'visible'=>has_permission('events', '', 'create'),
            'order'=>11,
            'linked_to_customer_option'=>array('view_activity_log'),
        ),
    );

    $eventmanager_tabs = do_action('eventmanager_tabs_admin', $eventmanager_tabs);

    usort($eventmanager_tabs, function ($a, $b) {
        return $a['order'] - $b['order'];
    });
return $eventmanager_tabs;
}

/**
 * Get project status by passed project id
 * @param  mixed $id project id
 * @return array
 */
function get_eventmanager_status_by_id($id)
{
    $CI = &get_instance();
    if (!class_exists('eventmanager_model')) {
        $CI->load->model('eventmanager_model');
    }

    $statuses = $CI->eventmanager_model->get_eventmanager_statuses();

    $status = array(
        'id'=>0,
        'bg_color'=>'#333',
        'text_color'=>'#333',
        'name'=>'[Status Not Found]',
        'order'=>1,
    );

    foreach ($statuses as $s) {
        if ($s['id'] == $id) {
            $status = $s;
            break;
        }
    }

    return $status;
}

/**
 * Return logged in user pinned projects
 * @return array
 */
function get_user_pinned_eventmanager()
{
    $CI = &get_instance();
    $CI->db->select('tbleventmanager.id, tbleventmanager.name, tbleventmanager.clientid, ' . get_sql_select_client_company());
    $CI->db->join('tbleventmanager', 'tbleventmanager.id=tblpinnedevents.event_manager_id');
    $CI->db->join('tblclients', 'tblclients.userid=tbleventmanager.clientid');
    $CI->db->where('tblpinnedevents.staff_id', get_staff_user_id());
    $eventmanager = $CI->db->get('tblpinnedevents')->result_array();
    $CI->load->model('eventmanager_model');
    $i        = 0;
    foreach ($eventmanager as $event) {
        $eventmanager[$i]['progress'] = $CI->eventmanager_model->calc_progress($event['id']);
        $i++;
    }

    return $eventmanager;
}


/**
 * Get project name by passed id
 * @param  mixed $id
 * @return string
 */
function get_eventmanager_name_by_id($id)
{
    $CI =& get_instance();
    $eventmanager = $CI->object_cache->get('eventmanager-name-data-'.$id);

    if(!$eventmanager){
        $CI->db->select('name');
        $CI->db->where('id', $id);
        $$eventmanager = $CI->db->get('tbleventmanager')->row();
        $CI->object_cache->add('eventmanager-name-data-'.$id,$eventmanager);
    }

    if ($eventmanager) {
        return $eventmanager->name;
    }

    return '';
}

/**
 * Return project milestones
 * @param  mixed $project_id project id
 * @return array
 */
function get_eventmanager_milestones($event_manager_id) {
    $CI = &get_instance();
    $CI->db->where('event_manager_id', $event_manager_id);
    $CI->db->order_by('milestone_order', 'ASC');
    return $CI->db->get('tblmilestones')->result_array();
}

/**
 * Get project client id by passed project id
 * @param  mixed $id project id
 * @return mixed
 */
function get_eventmanager_id_by_eventmanager_id($id)
{
    $CI =& get_instance();
    $CI->db->select('clientid');
    $CI->db->where('id', $id);
    $eventmanager = $CI->db->get('tbleventmanager')->row();
    if ($eventmanager) {
        return $eventmanager->clientid;
    }

    return false;
}

/**
 * Check if customer has project assigned
 * @param  mixed $customer_id customer id to check
 * @return boolean
 */
function customer_has_eventmanager($customer_id)
{
    $totalCustomerEvents= total_rows('tbleventmanager', 'clientid='.$customer_id);

    return ($totalCustomerEvents > 0 ? true : false);
}

/**
 * Get projcet billing type
 * @param  mixed $project_id
 * @return mixed
 */
function get_eventmanager_billing_type($event_manager_id)
{
    $CI =& get_instance();
    $CI->db->where('id', $event_manager_id);
    $eventmanager = $CI->db->get('tbleventmanager')->row();
    if ($eventmanager) {
        return $eventmanager->billing_type;
    }

    return false;
}

/**
 * Translated jquery-comment language based on app languages
 * This feature is used on both admin and customer area
 * @return array
 */
function get_eventmanager_discussions_language_array()
{
    $lang = array(
        'discussion_add_comment' => _l('discussion_add_comment'),
        'discussion_newest' => _l('discussion_newest'),
        'discussion_oldest' => _l('discussion_oldest'),
        'discussion_attachments' => _l('discussion_attachments'),
        'discussion_send' => _l('discussion_send'),
        'discussion_reply' => _l('discussion_reply'),
        'discussion_edit' => _l('discussion_edit'),
        'discussion_edited' => _l('discussion_edited'),
        'discussion_you' => _l('discussion_you'),
        'discussion_save' => _l('discussion_save'),
        'discussion_delete' => _l('discussion_delete'),
        'discussion_view_all_replies' => _l('discussion_view_all_replies'),
        'discussion_hide_replies' => _l('discussion_hide_replies'),
        'discussion_no_comments' => _l('discussion_no_comments'),
        'discussion_no_attachments' => _l('discussion_no_attachments'),
        'discussion_attachments_drop' => _l('discussion_attachments_drop'),
    );

    return $lang;
}
