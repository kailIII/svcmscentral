<?
	if(!empty($_SESSION['SERVICIO'])){
	
	
		include("../../SVsystem/config/masterconfig.php"); ////////se conecta a la base de datos central
		$tool->autoconexion();
		
		$modulos = $tool->estructura_db("SELECT 
		  s.id,
		  s.alias,
		  s.nombre,
		  s.ruta
			FROM                  
			servicio s
			where s.id in ({$_SESSION['SERVICIO']})");
			
	}	
	
	
	include("../../SVsystem/config/dbconfig.php"); ////////base de datos ocasional
	$tool->autoconexion();
  
 
   unset($_SESSION['MODULOS']); 

?>

<a href="/admin/main.php" title="ir a la página principal" class="especial2">[^] Volver al inicio</a>
<a href="/admin/opciones.php" title="opciones del sistema" class="especial">opciones</a>
<a href="../opciones-sm.php" title="enviar emails a todos los usuarios" class="especial">enviar mensaje a todos sus usuarios</a>
<a href="/admin/edit_index/editar-index.php" title="editar index o home page del web site" >editar index</a>
  


<!--MODULOS PERMITIDOS; DINAMICOS-->
<? for ($i=0;$i<count($modulos);$i++){


$_SESSION['MODULOS'][$i] = $modulos[$i]['id']; ///modulos permitidos

	if($i>0) echo '';

 ?>
 <a href="/admin/<?=$modulos[$i]['ruta'] ?>" title="<?=$modulos[$i]['nombre'] ?>"> <?=$modulos[$i]['alias'] ?></a>
<? } ?>

<?php if($_SESSION['ESADMIN']==1){ ?> <a href="/admin/backdoor/index.php" title="administracíon">admin</a><?php } ?>

<!--FIN MODULOS PERMITIDOS; DINAMICOS-->













 




