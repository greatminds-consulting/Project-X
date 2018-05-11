<div class="modal fade _eventmanager_file" tabindex="-1" role="dialog" data-toggle="modal">
   <div class="modal-dialog full-screen-modal" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" onclick="close_modal_manually('._eventmanager_file'); return false;"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $file->subject; ?></h4>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-8 border-right eventmanager_file_area">
                  <?php
                     if($file->contact_id == get_contact_user_id()){ ?>
                  <?php echo render_input('file_subject','eventmanager_discussion_subject',$file->subject,'text',array('onblur'=>'update_file_data('.$file->id.','.$file->eventmanager_id.')')); ?>
                  <?php echo render_textarea('file_description','eventmanager_discussion_description',$file->description,array('onblur'=>'update_file_data('.$file->id.','.$file->eventmanager_id.')')); ?>
                  <hr />
                  <?php } else { ?>
                  <?php if(!empty($file->description)){ ?>
                  <p class="bold"><?php echo _l('eventmanager_discussion_description'); ?></p>
                  <p class="text-muted"><?php echo $file->description; ?></p>
                  <hr />
                  <?php } ?>
                  <?php } ?>
                  <?php if(!empty($file->external) && $file->external == 'dropbox'){ ?>
                  <a href="<?php echo $file->external_link; ?>" target="_blank" class="btn btn-info mbot20"><i class="fa fa-dropbox" aria-hidden="true"></i> <?php echo _l('open_in_dropbox'); ?></a><br /><br />
                  <?php } ?>
                  <?php
                     $path = EVENTMANAGER_ATTACHMENTS_FOLDER .$file->event_manager_id.'/'.$file->file_name;
                     if(is_image($path)){ ?>
                  <img src="<?php echo base_url('uploads/eventmanager/'.$file->event_manager_id.'/'.$file->file_name); ?>" class="img img-responsive">
                  <?php } else if(!empty($file->external) && !empty($file->thumbnail_link)){ ?>
                  <img src="<?php echo optimize_dropbox_thumbnail($file->thumbnail_link); ?>" class="img img-responsive">
                  <?php } else if(strpos($file->filetype,'pdf') !== false && empty($file->external)){ ?>
                  <iframe src="<?php echo base_url('uploads/eventmanager/'.$file->event_manager_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php } else if(is_html5_video($path)){ ?>
                  <video width="100%" height="100%" src="<?php echo site_url('download/preview_video?path='.protected_file_url_by_path($path).'&type='.$file->filetype); ?>" controls>
                     Your browser does not support the video tag.
                  </video>
                  <?php } else {
                     echo '<a href="'.site_url('uploads/eventmanager/'.$file->event_manager_id.'/'.$file->file_name).'" download>'.$file->file_name.'</a>';
                     echo '<p class="text-muted">'._l('no_preview_available_for_file').'</p>';
                     } ?>
               </div>
               <div class="col-md-4 eventmanager_file_discusssions_area">
                  <div id="eventmanager-file-discussion"></div>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="close_modal_manually('._eventmanager_file'); return false;"><?php echo _l('close'); ?></button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
   var discussion_id = '<?php echo $file->id; ?>';
   var discussion_user_profile_image_url = '<?php echo $discussion_user_profile_image_url; ?>';
   var current_user_is_admin = '<?php echo $current_user_is_admin; ?>';
   $('body').on('shown.bs.modal', '._eventmanager_file', function() {
     var content_height = ($('body').find('._eventmanager_file .modal-content').height() - 165);
     if($('iframe').length > 0){
       $('iframe').css('height',content_height);
     }
     $('.eventmanager_file_area,.eventmanager_file_discusssions_area').css('height',content_height);
   });
   $('body').find('._eventmanager_file').modal({show:true, backdrop:'static', keyboard:false});
</script>
