<div class="row">
	<div class="col-md-8">
		<?php echo form_open_multipart('suppliers/profile',array('autocomplete'=>'off')); ?>
		<?php echo form_hidden('profile',true); ?>
		<div class="panel_s">
			<div class="panel-body">
				<h4 class="no-margin"><?php echo _l('clients_profile_heading'); ?></h4>
			</div>
		</div>
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="email"><?php echo _l('clients_email'); ?></label>
							<input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email',$supplier->email); ?>">
							<?php echo form_error('email'); ?>
						</div>
						<div class="form-group">
							<label for="businessname"><?php echo _l('businessname'); ?></label>
							<input type="text" class="form-control" name="businessname" id="businessname" value="<?php echo set_value('businessname',$supplier->businessname); ?>">
							<?php echo form_error('businessname'); ?>
						</div>
						<div class="form-group">
							<label for="abn"><?php echo _l('abn'); ?></label>
							<input type="text" class="form-control" name="abn" id="abn" value="<?php echo $supplier->abn; ?>">
						</div>
                        <div class="form-group">
							<label for="acn"><?php echo _l('acn'); ?></label>
							<input type="text" class="form-control" name="acn" id="acn" value="<?php echo $supplier->acn; ?>">
						</div>
                        <div class="form-group">
							<label for="address1"><?php echo _l('address1'); ?></label>
                            <textarea name="address1" id="address1" class="form-control" ><?php echo $supplier->address1; ?></textarea>
						</div>
                        <div class="form-group">
							<label for="address2"><?php echo _l('address2'); ?></label>
                            <textarea name="address2" id="address2" class="form-control" ><?php echo $supplier->address2; ?></textarea>
						</div>
                        <div class="form-group">
							<label for="suburb"><?php echo _l('suburb'); ?></label>
                            <input type="text" class="form-control" name="suburb" id="suburb" value="<?php echo $supplier->suburb; ?>">
						</div>
                        <div class="form-group">
							<label for="state"><?php echo _l('state'); ?></label>
                            <input type="text" class="form-control" name="state" id="state" value="<?php echo $supplier->state; ?>">
						</div>
                        <div class="form-group">
							<label for="state"><?php echo _l('postcode'); ?></label>
                            <input type="text" class="form-control" name="postcode" id="postcode" value="<?php echo $supplier->postcode; ?>">
						</div>
                        <div class="form-group">
							<label for="state"><?php echo _l('country'); ?></label>
                            <input type="text" class="form-control" name="country" id="country" value="<?php echo $supplier->country; ?>">
						</div>
						<?php echo render_custom_fields( 'suppliers',get_contact_user_id(),array('show_on_client_portal'=>1)); ?>
					</div>
					<div class="row p15">
						<div class="col-md-12 text-right mtop20">
							<div class="form-group">
								<button type="submit" class="btn btn-info"><?php echo _l('clients_edit_profile_update_btn'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
	<div class="col-md-4">
		<div class="panel_s">
			<div class="panel-body">
				<h4 class="no-margin">	<?php echo _l('clients_edit_profile_change_password_heading'); ?></h4>
			</div>
		</div>
		<div class="panel_s">
			<div class="panel-body">
				<?php echo form_open('suppliers/profile'); ?>
				<?php echo form_hidden('change_password',true); ?>
				<div class="form-group">
					<label for="oldpassword"><?php echo _l('clients_edit_profile_old_password'); ?></label>
					<input type="password" class="form-control" name="oldpassword" id="oldpassword">
					<?php echo form_error('oldpassword'); ?>
				</div>
				<div class="form-group">
					<label for="newpassword"><?php echo _l('clients_edit_profile_new_password'); ?></label>
					<input type="password" class="form-control" name="newpassword" id="newpassword">
					<?php echo form_error('newpassword'); ?>
				</div>
				<div class="form-group">
					<label for="newpasswordr"><?php echo _l('clients_edit_profile_new_password_repeat'); ?></label>
					<input type="password" class="form-control" name="newpasswordr" id="newpasswordr">
					<?php echo form_error('newpasswordr'); ?>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-info btn-block"><?php echo _l('clients_edit_profile_change_password_btn'); ?></button>
				</div>
				<?php echo form_close(); ?>
			</div>
			<?php if($contact->last_password_change !== NULL){ ?>
			<div class="panel-footer">
				<?php echo _l('clients_profile_last_changed_password',time_ago($contact->last_password_change)); ?>
			</div>
			<?php } ?>
		</div>
	</div>

</div>
