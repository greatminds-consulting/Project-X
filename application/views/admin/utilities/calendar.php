<?php init_head(); ?>
<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url('assets/plugins/switchery/css/switchery.min.css'); ?>" rel="stylesheet" type="text/css" media="screen">
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body" style="overflow-x: auto;">

						<?php $this->load->view('admin/utilities/calendar_filters'); ?>
                        <div id="myCalendar" class="full-height"></div>
                        <div class="quickview-wrapper calendar-event" id="calendar-event">
                            <div class="view-port clearfix" id="eventFormController">
                                <div class="view bg-white">
                                    <div class="scrollable">
                                        <div class="p-l-30 p-r-30 p-t-20">
                                            <a class="pg-close text-master link pull-right" data-toggle="quickview" data-toggle-element="#calendar-event" href="#"></a>
                                            <h4 id="event-date">&amp;</h4>
                                            <div class="m-b-20">
                                                <i class="fa fa-clock-o"></i>
                                                <span id="lblfromTime"></span> to
                                                <span id="lbltoTime"></span>
                                            </div>
                                        </div>
                                        <div class="p-t-15">
                                            <input id="eventIndex" name="eventIndex" type="hidden">
                                            <div class="form-group-attached">
                                                <div class="form-group form-group-default ">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" id="txtEventName" name="" placeholder="event name">
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-sm-9">
                                                        <div class="form-group form-group-default">
                                                            <label>Location</label>
                                                            <input type="text" class="form-control" id="txtEventLocation" placeholder="name of place" name="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group form-group-default">
                                                            <label>Code</label>
                                                            <input type="text" class="form-control" id="txtEventCode" name="lastName">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="form-group form-group-default">
                                                        <label>Note</label>
                                                        <textarea class="form-control" placeholder="description" id="txtEventDesc"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row clearfix cursor">
                                                    <div class="form-group form-group-default" data-navigate="view" data-view-port="#eventFormController" data-view-animation="push-parrallax">
                                                        <label>Alerts</label>
                                                        <div class="p-t-10">
                                                            <span class="pull-right p-r-10 p-b-5"><i class="pg-arrow_right"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-l-30 p-r-30 p-t-30">
                                            <button id="eventSave" class="btn btn-warning btn-cons">Save Event</button>
                                            <button id="eventDelete" class="btn btn-white"><i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="view bg-white">
                                    <div class="navbar navbar-default navbar-sm">
                                        <div class="navbar-inner">
                                            <a href="javascript:;" class="inline action p-l-10 link text-master" data-navigate="view" data-view-port="#eventFormController" data-view-animation="push-parrallax">
                                                <i class="pg-arrow_left"></i>
                                            </a>
                                            <div class="view-heading">
                                                <span class="font-montserrat text-uppercase fs-13">Alerts</span>
                                            </div>
                                            <a href="#" class="inline action p-r-10 pull-right link text-master">
                                                <i class="pg-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <p class="p-l-30 p-r-30 p-t-30"> This is a Demo</p>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php init_tail(); ?>
<!-- BEGIN VENDOR JS -->
<!--<script src="--><?php //echo base_url('assets/plugins/jquery/jquery-1.11.1.min.js'); ?><!--"></script>-->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/interactjs/interact.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/moment/moment-with-locales.min.js'); ?>"></script>
<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="<?php echo base_url('assets/pages/js/pages.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/pages/js/pages.calendar.js'); ?>"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="<?php echo base_url('assets/js/calendar.js'); ?>"></script>

<!-- END PAGE LEVEL JS -->
</body>
</html>
