<p><?php echo _l('eventmanager_note_private'); ?></p>
<hr />
<?php echo form_open(admin_url('eventmanager/save_note/'.$eventmanager->id)); ?>
<?php echo render_textarea('content','',$staff_notes,array(),array(),'','tinymce'); ?>
<button type="submit" class="btn btn-info"><?php echo _l('eventmanager_save_note'); ?></button>
<?php echo form_close(); ?>
