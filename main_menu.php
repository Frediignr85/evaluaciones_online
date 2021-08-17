<?php
include_once ("_core.php");
comprobar_evaluaciones();
 $sql_empresa=_query("SELECT * FROM tblempresa");
	$array_empresa=_fetch_array($sql_empresa);
	$nombre_empresa=$array_empresa['nombre'];
	$telefono=$array_empresa['telefono1'];
	$logo_empresa=$array_empresa['logo'];

	
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> 
					<span>
                    	<img alt="image" style="width:100%; margin-left:-3px;" id='logo_menu' class="logo" src="<?php echo "./".$logo_empresa; ?>" style="width:120%; margin-left:-12%;">
                    </span>
                </div>
                <div class="logo-element">
                    SG
                </div>
            </li>
        	 <!--li-->
            <!--a href="index.html"><i class="fa fa-archive"></i> <span class="nav-label">Productos</span> <span class="fa arrow"></span></a-->
            <?php
                //include_once '_core.php';
                $id_user=$_SESSION["id_usuario"];
				$admin=$_SESSION["admin"];
				$icono='fa fa-star-o';
				$sql_menus="SELECT id_menu, nombre, prioridad,icono FROM tblmenu WHERE visible='1' order by prioridad";
				$result=_query($sql_menus);
				$numrows=_num_rows($result);
				$main_lnk='dashboard.php';
				if($admin=='1')
				{
					echo  "<li class='active'>";
					echo "<a href='dashboard.php'><i class='".$icono."'></i> <span class='nav-label'>Inicio</span></a>";
					echo  "</li>";
				}
				else
				{
					echo  "<li class='active'>";
					echo "<a href='dashboard.php'><i class='".$icono."'></i> <span class='nav-label'>Inicio</span></a>";
					echo  "</li>";
				}
				for($i=0;$i<$numrows;$i++)
				{
					$row=_fetch_array($result);
					$menuname=$row['nombre'];
					$id_menu=$row['id_menu'];
					$icono=$row['icono'];
					if($admin=='1')
					{
						$sql_links="SELECT distinct tblmenu.id_menu, tblmenu.nombre as nombremenu, tblmenu.prioridad,
						tblmodulo.id_modulo, tblmodulo.nombre as nombremodulo, tblmodulo.descripcion, tblmodulo.filename, tblusuario.id_tipo_usuario
						FROM tblmenu, tblmodulo, tblusuario
						WHERE tblusuario.id_usuario='$id_user'
						AND tblusuario.id_tipo_usuario='1'
						AND tblmenu.id_menu='$id_menu'
						AND tblmenu.id_menu=tblmodulo.id_menu_MOD
						AND tblmodulo.mostrar_menu='1'
						";
					}
					else
					{
						$sql_links="
						SELECT tblmenu.id_menu, tblmenu.nombre as nombremenu, tblmenu.prioridad,
						tblmodulo.id_modulo,  tblmodulo.nombre as nombremodulo, tblmodulo.descripcion, tblmodulo.filename,
						tblusuario_modulo.id_usuario,tblusuario.id_tipo_usuario
						FROM tblmenu, tblmodulo, tblusuario_modulo, tblusuario
						WHERE tblusuario.id_usuario='$id_user'
						AND tblmenu.id_menu='$id_menu'
						AND tblusuario.id_usuario=tblusuario_modulo.id_usuario
						AND tblusuario_modulo.id_modulo=tblmodulo.id_modulo
						AND tblmenu.id_menu=tblmodulo.id_menu_MOD
						AND tblmodulo.mostrar_menu='1'
						AND tblusuario_modulo.deleted is NULL";
					}
					$result_modules=_query($sql_links);
					$numrow2 = _num_rows($result_modules);
					if(_num_rows($result_modules) > 0)
					{
						echo "<li><a href='".$main_lnk."' class='".strtolower(quitar_tildes($menuname))."'><i class='".$icono."'></i><span class='nav-label'>".$menuname."</span> <span class='fa arrow'></span></a>";
						echo " <ul class='nav nav-second-level'>";
						for($j=0;$j<$numrow2;$j++)
						{
							$row_modules=_fetch_array($result_modules);
							$lnk=strtolower($row_modules['filename']);
                  			if($lnk == "<hoja_membretada>")
                  			{
                    			$lnk = $script_esp;
                    			$extra = "target='_blank'";
                  			}
                  			else
                  			{
                    			$lnk = $lnk;
                    			$extra = "";
                  			}
							$modulo=$row_modules['nombremodulo'];
							$id_modulo=$row_modules['id_modulo'];
							echo "<li><a href='".$lnk."' $extra>".ucfirst($modulo)."</a></li>";
						}
						echo"</ul>";
						echo" </li>";
					}
				}
            ?>
        </ul>
    </div>
</nav>
<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        	<div class="navbar-header">
            	<a class="navbar-minimalize minimalize-styl-2 btn btn-white"><i class="fa fa-bars"></i> </a>
        	</div>
        	<ul class="nav navbar-top-links navbar-left">
        		<li>
        			<br>
                    <span class="m-r-sm text-muted welcome-message"><b><?php echo $nombre_empresa ?></b></span>
                </li>
        	</ul>

            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message"><b>Bienvenid@</b> <b><?php echo $_SESSION["nombre"] ?> </b></span>
                </li>
                <li>
                    <a data-toggle='modal' href='cambiar_pass.php' data-target='#viewModalpw' data-refresh='true'>
                        <i class="fa fa-lock"></i> Contraseña
                    </a>
                </li>
                
                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> Salir
                    </a>
                </li>
            </ul>

        </nav>
    </div>
	<div class='modal fade' id='viewModalpw' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
