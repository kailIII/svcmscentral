<?php session_start();

$profile = 'admin'; /////////////// perfil requerido
include("../../SVsystem/config/setup.php"); ////////setup
include("../../SVsystem/class/formulario.php");

include("security.php");

$tool = new formulario();
$tool->autoconexion();


		if(isset($_POST['r_link'])){	
			
			$prefi = @date('his_').$_FILES['archivo']['name'];
			
			if(!empty($_FILES['archivo2']['name'])){
			
			
			
				$prefi2 = @date('his_').$_FILES['archivo2']['name'];
				$sesubio = $tool->upload_file($_FILES['archivo2'],'../../SVsitefiles/'.$_SESSION['DIRSERVER'].'/banner/'.$prefi2,1,'image/gif,image/jpeg,image/png,image/pjpeg,image/jpg,image/pjpg');
			 	if($sesubio == false)$tool->redirect("cerrar");
			
			}else{
			
				$prefi2 = $prefi;
			
			}
	
			///////////////
	
			 $sesubio = $tool->upload_file($_FILES['archivo'],'../../SVsitefiles/'.$_SESSION['DIRSERVER'].'/banner/'.$prefi,1,'image/gif,image/jpeg,image/png,image/pjpeg,image/jpg,image/pjpg');
			 if($sesubio == false)$tool->redirect("cerrar");
			 $_POST['r_archivo'] = $prefi;
			 $_POST['r_archivover'] = $prefi2;
			
			 $tool->insert_data("r","_","banner",$_POST);	
			
			?>
						  <script language="JavaScript" type="text/JavaScript">
						   window.opener.location.reload(); window.close();
						   </script>
			<?	
			
			
		}	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Agregar Banner</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>


</head>

<body class="body-popup">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="td-titulo-popup">Agregar Banner</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
 <td><form action="" method="post" enctype="multipart/form-data" name="form1">
 <table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
   <td width="25%" class="td-form-title">Archivo</td>
   <td width="75%"><input name="archivo" type="file" class="form-box" size="50" id="archivo"></td>
  </tr>
  <tr>
    <td class="td-form-title">Archivo (mouse over)</td>
    <td><input name="archivo2" type="file" class="form-box" size="50" id="archivo2"></td>
  </tr>
  <tr>
   <td class="td-form-title">Enlace</td>
   <td><input name="r_link" type="text" class="form-box" id="r_link" value="http://" size="60"></td>
  </tr>
  <tr>
   <td class="td-form-title">Destino</td>
   <td><select name="r_target" class="form-box" id="r_target">
     <option value="_self">Misma Ventana</option>
     <option value="_blank" selected>Ventana Nueva</option>
   </select></td>
  </tr>
  <tr>
   <td class="td-form-title">Caption</td>
   <td><input name="r_caption" type="text" class="form-box" size="60" id="r_caption"></td>
  </tr>
  <tr>
   <td class="td-form-title">&nbsp;</td>
   <td><input name="Submit" type="submit" class="form-button" value="OK">&nbsp; 
   <input name="Submit2" type="button" onClick="window.close();" class="form-button" value="Cancelar"></td>
  </tr>
 </table>
 </form></td>
</tr>
<tr>
 <td>&nbsp;</td>
</tr>
</table>
</body>
</html>
<?php $tool->cerrar(); ?>
