<?php
 if($_SESSION['PROFILE']!=$profile){ ////valida la sesion si ha sido creada por un usuario valido!!!

 $LOGINPAGE = $_SERVER['HTTP_HOST']."/".$DIRAPP."/admin/index.php";
 session_destroy();
 $LOGINPAGE = "http://$LOGINPAGE";

 ?>

 <script language="JavaScript" type="text/javascript">

 top.location.replace('<?=$LOGINPAGE ?>');

 </script>

 <?
 
 
 die();
 
 }
?>
