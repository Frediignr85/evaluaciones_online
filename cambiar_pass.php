<?php
include ("_core.php");
function initial(){
	//permiso del script
	$sql=_query("SELECT password FROM tblusuario WHERE id_usuario='$_SESSION[id_usuario]'");
	$row=_fetch_array($sql);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true">&times;</button>
	<h4 class="modal-title">Cambiar Contraseña</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
					<div class="form-group">
						<label class="control-label">Contraseña actual</label>
							<input type="password" name="oldpass" id="oldpass" class="form-control col-lg-10" value="">
							<input type="hidden" id="bdpass" name="bdpass" value="<?php echo $row["password"];?>">
					</div>
					<div class="form-group">
						<br>
					</div>
					<div class="form-group">
						<label class="control-label">Contraseña nueva</label>
							<input type="password" name="newpass" id="newpass" class="form-control col-lg-10" value="">
					</div>
				
			</div>
		</div>
</div>
</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btn_save">Guardar</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>	
<!--/modal-footer -->
	<script type="text/javascript">
		$("#btn_save").click(function(){
			if($("#newpass").val()!="" && $("#oldpass").val()!="")
			{	
				senddata();
			}
			else
			{
				display_notify("Error","Complete todos los datos");
			}
		});
	function senddata(){
			var pass = $("#bdpass").val();
			var pass1 = $("#oldpass").val();
			var pass2 = $("#newpass").val();
			var ajaxdata = {"process":"change_pwd",
							"bdpass" : pass,
							"oldpass" : pass1,
							"newpass" : pass2
							}
			$.ajax({
				type:'POST',
				url:"cambiar_pass.php",
				data: ajaxdata,			
				dataType: 'json',
				success: function(datax)
				{	
					if(datax.typeinfo == "success" )
					{
						display_notify(datax.typeinfo, "Contraseña cambiada con exito!!!");
						setInterval("reload1();", 1000);		
					}else{
						
						display_notify(datax.typeinfo, "La contraseña actual no es correcta");
						$("#oldpass").val("");
						$("#newpass").val("");
						} 	
				}		
				});
	}
	function reload1()
	{
		location.href = "logout.php";
	}
	</script>
<?php
}
function change_pass() {
	$id_user=$_SESSION["id_usuario"];
	$pass = $_POST["bdpass"];
	$pass1 = MD5($_POST["oldpass"]);
	$pass2 = MD5($_POST["newpass"]);
	if($pass == $pass1)
	{
		$table = 'tblusuario';
	    $form_data = array (
	    'password' => $pass2
	    );   	
       	    
  $where_clause = "id_usuario='" . $id_user . "'";
  $updates = _update ( $table, $form_data, $where_clause );
    if($updates)
    {
      $xdatos['typeinfo']='success';
      $xdatos['msg']='Contraseña modificada con exito ';
      $xdatos['process']='edited';
    } 
    else
    {
      $xdatos['typeinfo']='error';
      $xdatos['msg']='Contraseña no pudo ser modificada';
    }
    }
    else
    {
    	$xdatos ['typeinfo'] = 'error';
    	$xdatos ['msg'] = 'La contraseña actual ingresada no es correcta';
    }                    
    $xdatos ['psw1'] = $pass; 
    $xdatos ['psw2'] = $pass1; 
  echo json_encode($xdatos);
}
if (! isset ( $_REQUEST ['process'] )) {
	initial();
} else {
	if (isset ( $_REQUEST ['process'] )) {
		switch ($_REQUEST ['process']) {
			case 'change' :
				initial();
				break;
			case 'change_pwd' :
				change_pass();
				break;
		}
	}
}

?>
