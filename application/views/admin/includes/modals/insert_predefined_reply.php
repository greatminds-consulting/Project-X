<div class="modal fade" id="insert_predefined_reply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					<?php echo _l('ticket_insert_predefined_reply_heading'); ?>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<?php if(count($predefined_replies) > 0){ ?>
						<ul class="list-group predefined_replies">
							<?php foreach($predefined_replies as $predefined_reply){ ?>
							<li class="list-group-item">
								<a class="bold" href="<?php echo admin_url('tickets/predefined_reply/'.$predefined_reply['id']); ?>" target="_blank">
									<i class="fa fa-file-text-o"></i>
									<?php echo $predefined_reply['name']; ?>
								</a>
								<a href="#" class="pull-right">
									<i class="fa fa-plus add_predefined_reply"></i>
								</a>
								<div class="hide message">
									<?php echo $predefined_reply['message']; ?>
								</div>
							</li>
							<?php } ?>
						</ul>
						<?php } else { ?>
						<p class="no-margin"><?php echo _l('no_predefined_replies_found'); ?></p>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<?php echo _l('close'); ?>
				</button>
			</div>
		</div>
	</div>
</div>


