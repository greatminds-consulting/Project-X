<ul>
    <?php
    $total = 0;
    foreach($result as $data){
     if(count($data['result']) > 0){
         $total++;
         ?>
         <li role="separator" class="divider"></li>
         <li class="dropdown-header"><?php echo $data['search_heading']; ?></li>
         <?php } ?>
         <?php foreach($data['result'] as $_result){
            $output = '';
            switch($data['type']){
                case 'clients':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                            <div>
                                '.staff_profile_image($_result['userid'], array(
                'staff-profile-image-small'
                )).'
                            </div>
                         </div>

                         <div class="p-l-10 inline p-t-5">
                            <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('clients/client/'.$_result['userid']).'">'.$_result['company'] .'</a></h5>
                            <p class="hint-text">'.$data['search_heading'].'</p>
                         </div>';

                break;
                case 'contacts':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                        <div>
                             '.staff_profile_image($_result['userid'], array(
                        'staff-profile-image-small'
                    )).'
                        </div>
                     </div>

                     <div class="p-l-10 inline p-t-5">
                        <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('clients/client/'.$_result['userid'].'?contactid='.$_result['id']).'">'.$_result['firstname'] .' ' . $_result['lastname'] .' <small>'.get_company_name($_result['userid']).'</small></a></h5>
                        <p class="hint-text">'.$data['search_heading'].'</p>
                     </div>';
                break;
                case 'staff':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                    <div>
                        <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                    </div>
                 </div>

                 <div class="p-l-10 inline p-t-5">
                    <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('staff/member/'.$_result['staffid']).'">'.$_result['firstname']. ' ' . $_result['lastname'] .'</a></h5>
                   <p class="hint-text">'.$data['search_heading'].'</p>
                 </div>';
                break;
                case 'tickets':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('tickets/ticket/'.$_result['ticketid']).'">#'.$_result['ticketid'].' - '.$_result['subject'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';

                    break;
                case 'surveys':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
             </div>

             <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('surveys/survey/'.$_result['surveyid']).'">'.$_result['subject'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
             </div>';

                break;
                case 'knowledge_base_articles':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('knowledge_base/article/'.$_result['articleid']).'">'.$_result['subject'].'</a></h5>
               <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                 break;
                case 'leads':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="fa fa-tty"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="#" onclick="init_lead('.$_result['id'].');return false;">'.$_result['name'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'tasks':
                $task_link = 'init_task_modal('.$_result['id'].'); return false;';
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="fa fa-tasks menu-icon"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="#" onclick="'.$task_link.'">'.$_result['name'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'contracts':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="fa fa-file"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('contracts/contract/'.$_result['id']).'">'.$_result['subject'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'invoice_payment_records':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('payments/payment/'.$_result['paymentid']).'">#'.$_result['paymentid'].'<span class="pull-right">'.date('Y',strtotime($_result['date'])).'</span></a></h5>
               <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'invoices':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('invoices/list_invoices/'.$_result['invoiceid']).'">'.format_invoice_number($_result['invoiceid']).'<span class="pull-right">'.date('Y',strtotime($_result['date'])).'</span></a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'credit_note':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('credit_notes/list_credit_notes/'.$_result['credit_note_id']).'">'.format_credit_note_number($_result['credit_note_id']).'<span class="pull-right">'.date('Y',strtotime($_result['date'])).'</span></a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'estimates':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('estimates/list_estimates/'.$_result['estimateid']).'">'.format_estimate_number($_result['estimateid']).'<span class="pull-right">'.date('Y',strtotime($_result['date'])).'</span></a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'expenses':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('expenses/list_expenses/'.$_result['expenseid']).'">'.$_result['category_name']. ' - ' ._format_number($_result['amount']).'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'proposals':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('proposals/list_proposals/'.$_result['id']).'">'.format_proposal_number($_result['id']) .' - ' . $_result['subject'] .'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'goals':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('goals/goal/'.$_result['id']).'">'.$_result['subject'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'custom_fields':
                $rel_data   = get_relation_data($_result['fieldto'], $_result['relid']);
                $rel_values = get_relation_values($rel_data, $_result['fieldto']);
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a class="pull-left" href="' . $rel_values['link'] . '">' . $rel_values['name'] .'<span class="pull-right">'._l($_result['fieldto']).'</span></a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
                case 'invoice_items':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('invoices/list_invoices/'.$_result['rel_id']).'">'.format_invoice_number($_result['rel_id']).'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                $output .= '<br />';
                $output .= '<small>'.$_result['description'].'</small>';
                break;
                case 'estimate_items':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="pg-layouts2"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('estimates/list_estimates/'.$_result['rel_id']).'">'.format_estimate_number($_result['rel_id']).'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                $output .= '<br />';
                $output .= '<small>'.$_result['description'].'</small>';
                break;
                case 'projects':
                $output='<div class="thumbnail-wrapper d48 circular bg-success text-white inline m-t-10">
                <div>
                    <span class="icon-thumbnail"><i class="fa fa-bars menu-icon"></i></span>
                </div>
                </div>

                <div class="p-l-10 inline p-t-5">
                <h5 class="m-b-5"><span class="semi-bold result-name"><a href="'.admin_url('projects/view/'.$_result['id']).'">'.$_result['name'].'</a></h5>
                <p class="hint-text">'.$data['search_heading'].'</p>
                </div>';
                break;
            }
            ?>
            <li><?php echo $output; ?></li>
            <?php } ?>
            <?php } ?>
            <?php if($total == 0){ ?>
                <li class="padding-5 text-center"><?php echo _l('not_results_found'); ?></li>
                <?php } ?>
<!--            </ul>-->
