<div class="modal fade" id="insert_knowledge_base_link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo _l('ticket_kb_link_heading'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<?php $groups = get_all_knowledge_base_articles_grouped(); ?>
						<?php if(count($groups) > 0){ ?>
						<?php foreach($groups as $group){ ?>
						<div class="col-md-12">
							<h4 class="bold"><i class="fa fa-folder"></i> <?php echo $group['name']; ?></h4>
							<ul class="list-unstyled articles_list list-group">
								<?php foreach($group['articles'] as $article) { ?>
								<li class="list-group-item">
									<i class="fa fa-file-text-o"></i> <a href="<?php echo site_url('knowledge_base/'.$article['slug']); ?>" target="_blank"><?php echo $article['subject']; ?></a>
									<a href="#" onclick="insert_ticket_knowledgebase_link(<?php echo $article['articleid']; ?>); return false;">
										<i class="fa fa-plus pull-right"></i>
									</a>
								</li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
						<?php } else { ?>
						<p class="no-margin"><?php echo _l('kb_no_articles_found'); ?></p>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
			</div>
		</div>
	</div>
</div>

