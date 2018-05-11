<h4 class="customer-profile-group-heading"><?php echo _l('eventmanager'); ?></h4>
<div class="row">
    <?php
    $_where = '';
    if(!has_permission('events','','view')){
        $_where = 'id IN (SELECT event_manager_id FROM tbleventmembers WHERE staff_id='.get_staff_user_id().')';
    }
    ?>
    <?php foreach($eventmanager_statuses as $status){ ?>
        <div class="col-md-5ths total-column">
            <div class="panel_s">
                <div class="panel-body">
                    <h3 class="text-muted _total">
                        <?php $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id']. ' AND clientid='.$client->userid; ?>
                        <?php echo total_rows('tbleventmanager',$where); ?>
                    </h3>
                    <span style="color:<?php echo $status['color']; ?>"><?php echo $status['name']; ?></span>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php if(isset($client)){ ?>
    <?php if(has_permission('events','','create')){ ?>
        <a href="<?php echo admin_url('eventmanager/event?customer_id='.$client->userid); ?>" class="btn btn-info mbot25<?php if($client->active == 0){echo ' disabled';} ?>"><?php echo _l('new_eventmanager'); ?></a>
    <?php }
    $table_data = array(
        '#',
        _l('eventmanager_name'),
        array(
            'name'=>_l('eventmanager_customer'),
            'th_attrs'=>array('class'=>'not_visible')
        ),
        _l('tags'),
        _l('eventmanager_start_date'),
        _l('eventmanager_deadline'),
        _l('eventmanager_members'),
    );
    if(has_permission('events','','create') || has_permission('events','','edit')){
        array_push($table_data,_l('eventmanager_billing_type'));
    }
    array_push($table_data, _l('eventmanager_status'));
    $custom_fields = get_custom_fields('eventmanager',array('show_on_table'=>1));
    foreach($custom_fields as $field){
        array_push($table_data,$field['name']);
    }

    $table_data = do_action('eventmanager_table_columns',$table_data);

    array_push($table_data, _l('options'));

    render_datatable($table_data,'eventmanager-single-client');
}
?>
