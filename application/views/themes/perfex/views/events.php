<div class="panel_s">
    <div class="panel-body">
        <h4 class="no-margin"><?php echo _l('clients_my_eventmanager'); ?></h4>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <div class="row mbot15">
            <div class="col-md-12">
                <h3 class="text-success no-mtop"><?php echo _l('eventmanager_summary'); ?></h3>
            </div>
            <?php
            $where = array('clientid'=>get_client_user_id());
            foreach($eventmanager_statuses as $status){ ?>
                <div class="col-md-2 border-right">
                    <?php $where['status'] = $status['id']; ?>
                    <h3 class="bold"><a href="<?php echo site_url('clients/eventmanager/'.$status['id']); ?>"><?php echo total_rows('tbleventmanager',$where); ?></a></h3>
            <span style="color:<?php echo $status['color']; ?>">
            <?php echo $status['name']; ?>
                </div>
            <?php } ?>
        </div>
        <hr />
        <table class="table dt-table" data-order-col="2" data-order-type="desc">
            <thead>
            <tr>
                <th><?php echo _l('eventmanager_name'); ?></th>
                <th><?php echo _l('eventmanager_start_date'); ?></th>
                <th><?php echo _l('eventmanager_deadline'); ?></th>
                <th><?php echo _l('eventmanager_billing_type'); ?></th>
                <?php
                $custom_fields = get_custom_fields('eventmanager',array('show_on_client_portal'=>1));
                foreach($custom_fields as $field){ ?>
                    <th><?php echo $field['name']; ?></th>
                <?php } ?>
                <th><?php echo _l('eventmanager_status'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($eventmanagers as $eventmanager){ ?>
                <tr>
                    <td><a href="<?php echo site_url('clients/eventmanager/'.$eventmanager['id']); ?>"><?php echo $eventmanager['name']; ?></a></td>
                    <td data-order="<?php echo $eventmanager['start_date']; ?>"><?php echo _d($eventmanager['start_date']); ?></td>
                    <td data-order="<?php echo $eventmanager['deadline']; ?>"><?php echo _d($eventmanager['deadline']); ?></td>
                    <td>
                        <?php
                        if($eventmanager['billing_type'] == 1){
                            $type_name = 'eventmanager_billing_type_fixed_cost';
                        } else if($eventmanager['billing_type'] == 2){
                            $type_name = 'eventmanager_billing_type_eventmanager_hours';
                        } else {
                            $type_name = 'eventmanager_billing_type_eventmanager_task_hours';
                        }
                        echo _l($type_name);
                        ?>
                    </td>
                    <?php foreach($custom_fields as $field){ ?>
                        <td><?php echo get_custom_field_value($eventmanager['id'],$field['id'],'eventmanager'); ?></td>
                    <?php } ?>
                    <td>
                        <?php
                        $status = get_eventmanager_status_by_id($eventmanager['status']);
                        echo '<span class="label inline-block" style="color:'.$status['color'].';border:1px solid '.$status['color'].'">'.$status['name'].'</span>';
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
