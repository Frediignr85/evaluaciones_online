
		<link rel="stylesheet" href="css/boot5.css">
		<!--
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
	-->


	<style media="screen">


	</style>
<a ><div id="floating-btn" class="floating-btn btn btn-primary"><span class="fa fa-send fa-2x"></span> </div></a>

<div id="openModal" class="modalDialog">
	<div>
		<a id="cerrar" title="Cerrar" class="close">X</a>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Buscar..." name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fa fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui id="contactos_chat" class="contacts">

						</ui>
					</div>
					<div class="card-footer"></div>
				</div></div>
				<div class="col-md-8 col-xl-6 chat">
					<div class="card">
						<div class="card-header msg_head">
							<div class="d-flex bd-highlight">
								<input id="id_chat"  type="hidden" name="" value="0">
								<div id="actual" class="img_cont">
									<img src="img/avatar.png" class="rounded-circle user_img">
									<span class="online_icon"></span>
								</div>
								<div class="user_info">
									<span id="actual_chat_name">No has seleccionado un chat</span>
									<p></p>
									<!--
									aca arriba ban el numero de mensajes
									-->
								</div>
								<div hidden class="video_cam">
									<span><i class="fa fa-video"></i></span>
									<span><i class="fa fa-phone"></i></span>
								</div>
							</div>
							<span hidden id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fa fa-user-circle"></i> View profile</li>
									<li><i class="fa fa-users"></i> Add to close friends</li>
									<li><i class="fa fa-plus"></i> Add to group</li>
									<li><i class="fa fa-ban"></i> Block</li>
								</ul>
							</div>
						</div>
						<div class="card-body msg_card_body">
							<div class="d-flex justify-content-start mb-4">
								<div class="img_cont_msg">
									<img src="img/avatar.png" class="rounded-circle user_img_msg">
								</div>
								<div class="msg_cotainer">
									Selecciona una persona y empieza
									<span class="msg_time"></span>
								</div>
							</div>






						</div>
						<div class="card-footer">
							<div class="input-group">
								<div class="input-group-append">
									<span class="input-group-text attach_btn"><i class="fa fa-paperclip"></i></span>
								</div>
								<textarea name="" class="form-control type_msg" placeholder="Escribe tu mensaje.."></textarea>
								<div class="input-group-append">
									<span class="input-group-text send_btn"><i class="fa fa-location-arrow"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="footer">


                <strong>Copyright</strong>  <a href=""  target="_blank">Html5</a> &copy; <?php echo date("Y");?>
            </div>
        </div>
    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
	<script src="js/plugins/datapicker/moment.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
     <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>


    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <!--/var/www/html_public/template/js/plugins/toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>
     <!-- jqGrid -->
    <script src="js/plugins/jqGrid/i18n/grid.locale-en.js"></script>
   <script src="js/plugins/jqGrid/jquery.jqGrid.min.js"></script>

	<!-- jeditable -->
	 <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
   <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
   <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
   <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
   <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>


    <!-- Flot -->
   <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <!--script src="js/demo/peity-demo.js"></script>-->

    <!-- GITTER -->
    <!--script src="js/plugins/gritter/jquery.gritter.min.js"></script>-->

    <!-- Sparkline -->
    <!--script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>-->

    <!-- Sparkline demo data  -->
    <!--script src="js/demo/sparkline-demo.js"></script>-->

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <!-- spinedit -->
    <script src="js/plugins/spinedit/spinedit.js"></script>

    <!--select2 -->
    <script src='js/plugins/select2/select2.js'></script>
    <!--switchery -->
    <script src='js/plugins/switchery/switchery.js'></script>
     <!--summernote -->
    <script src='js/plugins/summernote/summernote.min.js'></script>
    <!--sortable -->
	<script src='js/plugins/sortable/jquery-sortable.js'></script>
    <script src='js/plugins/upload_file/fileinput.js'></script>
    <script src='js/plugins/upload_file/fileinput_locale_es.js'></script>
	<!--numeric -->
	<script src='js/plugins/numeric/jquery.numeric.js'></script>
	<!--datepicker -->
	<script src='js/plugins/datapicker/bootstrap-datepicker.js'></script>
	<!--autocomplete bootstrap3 -->
	<script src='js/plugins/typehead/bootstrap3-typeahead.js'></script>
	<!--jasny-->
	 <script src='js/plugins/jasny/jasny-bootstrap.min.js'></script>
	<!-- Sweet alert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Blueimp -->
    <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>

	 <!--Full callendar-->
     <script src="js/plugins/fullcalendar/fullcalendar.js"></script>
     <script src="js/plugins/fullcalendar/es.js"></script>

     <!--Timepicker-->
     <script src="js/plugins/timepicker/jquery.timepicker.js"></script>

    <script type="text/javascript" src="js/plugins/fileinput/fileinput.js"></script>

    <script type="text/javascript" src="js/plugins/tour/bootstrap-tour.js"></script>
    <script type="text/javascript" src="js/plugins/ckeditor/ckeditor.js"></script>

    <!-- Functions creted by us for post messages with toastr and clean forms  -->
    <script src="js/funciones/functions_messages_clean.js"></script>
    <script src="js/funciones/funciones_asistente.js"></script>
    <script src="js/sms/checksms.js"></script>
	<script src="js/funciones/functions_chat.js"></script>



</body>

</html>
