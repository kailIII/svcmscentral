<?php session_start();

$profile = 'admin'; /////////////// perfil requerido
include("../../SVsystem/config/setup.php"); ////////setup
include("../../SVsystem/class/clases.php");
include("../../SVsystem/class/paginas.php");

include("security.php");

$tool = new tools('db');
////////paginacion

 $TOTAL = $tool->simple_db("select count(*) from pago ");
 
  $dataempre = $tool->simple_db("select * from preferencias");
 
   //////////datos de la empresa
  $nombre_empresa = $dataempre['nombre_empresa'];
  $url_empresa = $dataempre['url_empresa'];
  unset($dataempre); ////liberando memoria


 if(isset($_REQUEST['cuenta'])) $cuenta = $_REQUEST['cuenta']; else $cuenta = 20;
 if(isset($_REQUEST['desde'])) 	$desde = $_REQUEST['desde']; else $desde = 0;

///////////////
	if(isset($_REQUEST['id'])){

			$tool->query("update pago set estatus = '{$_REQUEST['accion']}' where id = {$_REQUEST['id']} ");

			if($_REQUEST['accion']==1){

				$var = 'Aprobado';

				$dat4 = $tool->simple_db("SELECT DISTINCT
						  c.nombre,
						  c.email,
						  date_format(o.fecha,'%d/%m/%Y') as fechap,
						  o.monto as montop,
                          o.ntransacc as numerop,
						  o.comentario as conceptop,
						  (select banco from pago_datos where id = o.dato_id) as bancop,
						  (SELECT preferencias.subject_pay_confirm_admin FROM preferencias) AS etitulo,
						  (SELECT preferencias.pay_confirm_admin FROM preferencias) AS emensaje
						FROM
						  pago o
						  INNER JOIN cliente c ON (o.cliente_id = c.id)
						WHERE
						  o.id = {$_REQUEST['id']} AND
						  c.activo = 1");


			}else{



				$dat4 = $tool->simple_db("SELECT DISTINCT
						  c.nombre,
						  c.email,
						  date_format(o.fecha,'%d/%m/%Y') as fechap,
						  o.monto as montop,
                          o.ntransacc as numerop,
						  o.comentario as conceptop,
						  (select banco from pago_datos where id = o.dato_id) as bancop,
						  (SELECT preferencias.subject_pay_deny_admin FROM preferencias) AS etitulo,
						  (SELECT preferencias.pay_deny_admin FROM preferencias) AS emensaje
						FROM
						  pago o
						  INNER JOIN cliente c ON (o.cliente_id = c.id)
						WHERE
						  o.id = {$_REQUEST['id']} AND
						  c.activo = 1");


						$var = 'Rechazado';


			}

			$estatus_pago = $var;
			$nombre_email = $dat4['nombre'];
  			$email_send = $dat4['email'];
			$fechap = $dat4['fechap'];
			$montop = number_format($dat4['montop'],2);
			$conceptop = $dat4['conceptop'];
			$bancop = $dat4['bancop'];
			$numerop = $dat4['numerop'];


			  $original  = array('$estatus_pago', '$nombre_email', '$email_send', '$fechap', '$montop', '$conceptop', '$bancop', '$numerop', '$nombre_empresa', '$url_empresa');
			  $reemplazo = array($estatus_pago, $nombre_email, $email_send, $fechap, $montop, $conceptop, $bancop, $numerop, $nombre_empresa, $url_empresa);

			  $email_subject = str_replace($original, $reemplazo, $dat4['etitulo']);
			  $email_content = str_replace($original, $reemplazo, $dat4['emensaje']);
			  
			  $email_content = utf8_encode($email_content); ///error de charset
			  
			  
			  
			  					 /////////manda email cliente
								  	$dataemail = $tool->array_query2("select nombre_empresa,soporte_email from preferencias");
								    $headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= "From: $dataemail[0] <$dataemail[1]>" . "\r\n" .
								 	"Reply-To: $dataemail[1]" . "\r\n";
										  
									  mail($email_send,$email_subject,$email_content,$headers);

				//include('../productos/email.php');

			$tool->javaviso("Pago {$_REQUEST['id']} ha sido $var","main.php");

	}else if(isset($_REQUEST['borrar'])){


			$tool->query("delete from pago where id = {$_REQUEST['borrar']} ");
			$tool->javaviso("Pago {$_REQUEST['borrar']} ha sido borrado","main.php");

	}

/////////////filtros

 if(isset($_REQUEST['iduser'])) $filtro3 = " where p.cliente_id = '{$_REQUEST['iduser']}' ";

$query = "SELECT
	  c.nombre,
	  c.email,
	  p.id,
	  c.id as id2,
	  p.modo,
	  p.monto,
	  p.ntransacc,
	  p.estatus,
	  p.comentario,
	  (select concat(nombre,' - ',ncuenta,' - ',banco) from pago_datos where id = p.dato_id) as dest,
	  DATE_FORMAT(p.fecha,'%d/%m/%Y') as fecha
	FROM
	  pago p
	  INNER JOIN cliente c ON (p.cliente_id = c.id)
	  $filtro3
	  
	  ";

	  if(!empty($_REQUEST['orden1'])) $_SESSION['ORD1'] = $_REQUEST['orden1'];

	   if(empty($_SESSION['ORD1'])) $_SESSION['ORD1'] = 'id';

	  if(!empty($_REQUEST['orden2'])) $_SESSION['ORD2'] = $_REQUEST['orden2']; else if(empty($_SESSION['ORD2'])) $_SESSION['ORD2'] = "DESC";

$query.= " order by {$_SESSION['ORD1']} {$_SESSION['ORD2']} limit $desde,$cuenta ";

//////////////////////


	$tool->query($query);





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>M&oacute;dulo de Pagos</title>
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

function GP_AdvOpenWindow(theURL,winName,ft,pw,ph,wa,il,aoT,acT,bl,tr,trT,slT,pu) { //v3.08
  // Copyright(c) George Petrov, www.dmxzone.com member of www.DynamicZones.com
  var rph=ph,rpw=pw,nlp,ntp,lp=0,tp=0,acH,otH,slH,w=480,h=340,d=document,OP=(navigator.userAgent.indexOf("Opera")!=-1),IE=d.all&&!OP,IE5=IE&&window.print,NS4=d.layers,NS6=d.getElementById&&!IE&&!OP,NS7=NS6&&(navigator.userAgent.indexOf("Netscape/7")!=-1),b4p=IE||NS4||NS6||OP,bdyn=IE||NS4||NS6,olf="",sRes="";
  imgs=theURL.split('|'),isSL=imgs.length>1;aoT=aoT&&aoT!=""?true:false;
  var tSWF='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" ##size##><param name=movie value="##file##"><param name=quality value=high><embed src="##file##" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" ##size##></embed></object>'
  var tQT='<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" ##size##><param name="src" value="##file##"><param name="autoplay" value="true"><param name="controller" value="true"><embed src="##file##" ##size## autoplay="true" controller="true" pluginspage="http://www.apple.com/quicktime/download/"></embed></object>'
  var tIMG=(!IE?'<a href="javascript:'+(isSL?'nImg()':'window.close()')+'">':'')+'<img id=oImg name=oImg '+((NS4||NS6||NS7)?'onload="if(isImg){nW=pImg.width;nH=pImg.height}window.onload();" ':'')+'src="##file##" border="0" '+(IE?(isSL?'onClick="nImg()"':'onClick="window.close()"'):'')+(IE&&isSL?' style="cursor:pointer"':'')+(!NS4&&isSL?' onload="show(\\\'##file##\\\',true)"':'')+'>'+(!IE?'</a>':'')
  var tMPG='<OBJECT classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,02,902" ##size## type="application/x-oleobject"><PARAM NAME="FileName" VALUE="##file##"><PARAM NAME="animationatStart" VALUE="true"><PARAM NAME="transparentatStart" VALUE="true"><PARAM NAME="autoStart" VALUE="true"><PARAM NAME="showControls" VALUE="true"><EMBED type="application/x-mplayer2" pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/" SRC="##file##" ##size## AutoStart=true></EMBED></OBJECT>'
  omw=aoT&&IE5;bl=bl&&bl!=""?true:false;tr=IE&&tr&&isSL?tr:0;trT=trT?trT:1;ph=ph>0?ph:100;pw=pw>0?pw:100;
  re=/\.(swf)/i;isSwf=re.test(theURL);re=/\.(gif|jpg|png|bmp|jpeg)/i;isImg=re.test(theURL);re=/\.(avi|mov|rm|rma|wav|asf|asx|mpg|mpeg)/i;isMov=re.test(theURL);isEmb=isImg||isMov||isSwf;
  if(isImg&&NS4)ft=ft.replace(/resizable=no/i,'resizable=yes');if(b4p){w=screen.availWidth;h=screen.availHeight;}
  if(wa&&wa!=""){if(wa.indexOf("center")!=-1){tp=(h-ph)/2;lp=(w-pw)/2;ntp='('+h+'-nWh)/2';nlp='('+w+'-nWw)/2'}if(wa.indexOf("bottom")!=-1){tp=h-ph;ntp=h+'-nWh'} if(wa.indexOf("right")!=-1){lp=w-pw;nlp=w+'-nWw'}
    if(wa.indexOf("left")!=-1){lp=0;nlp=0} if(wa.indexOf("top")!=-1){tp=0;ntp=0}if(wa.indexOf("fitscreen")!=-1){lp=0;tp=0;ntp=0;nlp=0;pw=w;ph=h}
    ft+=(ft.length>0?',':'')+'width='+pw;ft+=(ft.length>0?',':'')+'height='+ph;ft+=(ft.length>0?',':'')+'top='+tp+',left='+lp;
  } if(IE&&bl&&ft.indexOf("fullscreen")!=-1&&!aoT)ft+=",fullscreen=1";
  if(omw){ft='center:no;'+ft.replace(/lbars=/i,'l=').replace(/(top|width|left|height)=(\d+)/gi,'dialog$1=$2px').replace(/=/gi,':').replace(/,/gi,';')}
  if (window["pWin"]==null) window["pWin"]= new Array();var wp=pWin.length;pWin[wp]=(omw)?window.showModelessDialog(imgs[0],window,ft):window.open('',winName,ft);
  if(pWin[wp].opener==null)pWin[wp].opener=self;window.focus();
  if(b4p){ if(bl||wa.indexOf("fitscreen")!=-1){pWin[wp].resizeTo(pw,ph);pWin[wp].moveTo(lp,tp);}
    if(aoT&&!IE5){otH=pWin[wp].setInterval("window.focus();",50);olf='window.setInterval("window.focus();",50);'}
  } sRes='\nvar nWw,nWh,d=document,w=window;'+(bdyn?';dw=parseInt(nW);dh=parseInt(nH);':'if(d.images.length == 1){var di=d.images[0];dw=di.width;dh=di.height;\n')+
    'if(dw>0&&dh>0){nWw=dw+'+(IE?12:NS7?15:NS6?14:0)+';nWh=dh+'+(IE?32:NS7?50:NS6?1:0)+';'+(OP?'w.resizeTo(nWw,nWh);w.moveTo('+nlp+','+ntp+')':(NS4||NS6?'w.innerWidth=nWw;w.innerHeight=nWh;'+(NS6?'w.outerWidth-=14;':''):(!omw?'w.resizeTo(nWw,nWh)':'w.dialogWidth=nWw+"px";w.dialogHeight=nWh+"px"')+';eh=dh-d.body.clientHeight;ew=dw-d.body.clientWidth;if(eh!=0||ew!=0)\n'+
  	(!omw?'w.resizeTo(nWw+ew,nWh+eh);':'{\nw.dialogWidth=(nWw+ew)+"px";\nw.dialogHeight=(nWh+eh)+"px"}'))+(!omw?'w.moveTo('+nlp+','+ntp+')'+(!(bdyn)?'}':''):'\nw.dialogLeft='+nlp+'+"px";w.dialogTop='+ntp+'+"px"\n'))+'}';
  var iwh="",dwh="",sscr="",sChgImg="";tRep=".replace(/##file##/gi,cf).replace(/##size##/gi,(nW>0&&nH>0?'width=\\''+nW+'\\' height=\\''+nH+'\\'':''))";
  var chkType='re=/\\.(swf)$/i;isSwf=re.test(cf);re=/\\.(mov)$/i;isQT=re.test(cf);re=/\\.(gif|jpg|png|bmp|jpeg)$/i;isImg=re.test(cf);re=/\.(avi|rm|rma|wav|asf|asx|mpg|mpeg)/i;isMov=re.test(cf);';
  var sSize='tSWF=\''+tSWF+'\';\ntQT=\''+tQT+'\';tIMG=\''+tIMG+'\';tMPG=\''+tMPG+'\'\n'+"if (cf.substr(cf.length-1,1)==']'){var bd=cf.lastIndexOf('[');if(bd>0){var di=cf.substring(bd+1,cf.length-1);var da=di.split('x');nW=da[0];nH=da[1];cf=cf.substring(0,bd)}}"+chkType;
  if(isEmb){if(isSL) {
      sChgImg=(NS4?'var l = document.layers[\'slide\'];ld=l.document;ld.open();ld.write(nHtml);ld.close();':IE?'document.all[\'slide\'].innerHTML = nHtml;':NS6?'var l=document.getElementById(\'slide\');while (l.hasChildNodes()) l.removeChild(l.lastChild);var range=document.createRange();range.setStartAfter(l);var docFrag=range.createContextualFragment(nHtml);l.appendChild(docFrag);':'');
      sscr='var pImg=new Image(),slH,ci=0,simg="'+theURL+'".split("|");'+
      'function show(cf,same){if(same){di=document.images[0];nW=di.width;nH=di.height}'+sRes+'}\n'+
      'function nImg(){if(slH)window.clearInterval(slH);nW=0;nH=0;cf=simg[ci];'+sSize+'document.title=cf;'+
      (tr!=0?';var fi=IElem.filters[0];fi.Apply();IElem.style.visibility="visible";fi.transition='+(tr-1)+';fi.Play();':'')+
      'if (nW==0&&nH==0){if(isImg){nW=pImg.width;nH=pImg.height}else{nW='+pw+';nH='+ph+'}}'+
      (bdyn?'nHtml=(isSwf?tSWF'+tRep+':isQT?tQT'+tRep+':isImg?tIMG'+tRep+':isMov?tMPG'+tRep+':\'\');'+sChgImg+';':'if(document.images)document["oImg"].src=simg[ci];')+
      sRes+';ci=ci==simg.length-1?0:ci+1;cf=simg[ci];re=/\\.(gif|jpg|png|bmp|jpeg)$/i;isImg=re.test(cf);if(isImg)pImg.src=cf;'+
      (isSL?(!NS4?'if(ci>1)':'')+'slH=window.setTimeout("nImg()",'+slT*1000+')}':'');
    } else {sscr='var re,pImg=new Image(),nW=0,nH=0,nHtml="",cf="'+theURL+'";'+chkType+'if(isImg)pImg.src=cf;\n'+
      'function show(){'+sSize+';if (nW==0&&nH==0){if(isImg){;nW=pImg.width;nH=pImg.height;if (nW==0&&nH==0){nW='+pw+';nH='+ph+'}}else{nW='+pw+';nH='+ph+
      '}};nHtml=(isSwf?tSWF'+tRep+':isQT?tQT'+tRep+':isImg?tIMG'+tRep+':isMov?tMPG'+tRep+':\'\');document.write(nHtml)};'}
    pd = pWin[wp].document;pd.open();pd.write('<html><'+'head><title>'+imgs[0]+'</title><'+'script'+'>'+sscr+'</'+'script>'+(!NS4?'<STYLE TYPE="text/css">BODY {margin:0;border:none;padding:0;}</STYLE>':'')+'</head><body '+(NS4&&isSL?'onresize=\'ci--;nImg()\' ':'')+'onload=\''+olf+(isSL?';nImg()':sRes)+'\' bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">');
    if(rpw>0){iwh='width="'+rpw+'" ';dwh='width:'+rpw} if(rph>0){iwh+='height="'+rph+'"';dwh+='height:'+rph}
    if(tr!=0) pd.write('<span id=IElem Style="Visibility:hidden;Filter:revealTrans(duration='+trT+');width:100%;height=100%">');
    if(isSL&&bdyn) {pd.write(NS4?'<layer id=slide></layer>':'<span id=slide></span>')} else {pd.write('<'+'script>show()'+'</'+'script>')}
    if(tr!=0) pd.write('</span>');pd.write('</body></html>');pd.close();
  }else {if(!omw)pWin[wp].location.href=imgs[0];}
  if((acT&&acT>0)||(slT&&slT>0&&isSL)){if(pWin[wp].document.body)pWin[wp].document.body.onunload=function(){if(acH)window.clearInterval(acH);if(slH)window.clearInterval(slH)}}
  if(acT&&acT>0)acH=window.setTimeout("pWin["+wp+"].close()",acT*1000);if(slT&&slT>0&&isSL)slH=window.setTimeout("if(pWin["+wp+"].nImg)pWin["+wp+"].nImg()",slT*1000);
  if(pu&&pu!=""){pWin[wp].blur();window.focus()} else pWin[wp].focus();document.MM_returnValue=(il&&il!="")?false:true;
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


</head>

<body>

<?php // include ("../n-encabezado.php")?>
<div id="ncuerpo" style="width:100%; margin:0; padding:0; top:0;">
<?php //include ("../n-include-mensajes.php")?>
<div id="ncontenedor" style="width:97%; margin:0 auto;">
<div id="nnavbar" style="width:100%;"><a href="javascript:window.close();" class="especial" style="background-color:#C00; color:#fff;">[x]Cerrar Ventana</a></div>




<div id="ntitulo">Reportes de Pago</div>
<div id="ninstrucciones"><p>
En este m&oacute;dulo usted podr&aacute; visualizar, negar, aprobar y borrar los reportes
                de pago (reportes de dep&oacute;sito bancario o transferencia) realizados por los usuarios de su sitio web. <a href="javascript:;" onClick="MM_openBrWindow('../help/pagos.php','','scrollbars=yes,resizable=yes,width=700,height=550')"><img src="../icon/icon-info.gif" width="16" height="16" border="0" align="absmiddle"></a></p>
</div>


<div id="ncontenido">





<div id="nbloque">
<div id="nbotonera">
<form name="form1" method="post" action="">
              Ver
                 <?php

	 $r21[0] = "20 registros"; $r22[0] = "20";
	 $r21[1] = "50 registros"; $r22[1] = "50";
	  $r21[2] = "100 registros"; $r22[2] = "100";

	 echo $tool->combo_array("cuenta",$r21,$r22,false,false,"submit();",'',false,false,"form-box")?>
                &nbsp; Ordenar por:
                <?php

	 $i21[0] = "antiguedad"; $i22[0] = "id";
	 $i21[1] = "nombre"; $i22[1] = "nombre";

	 echo $tool->combo_array ("orden1",$i21,$i22,false,$_SESSION['ORD1'],"submit();",'',false,false,"form-box")?>
                En
                orden
                <?php

	 $o21[0] = "Decreciente";$o22[0] = "DESC";
	 $o21[1] = "Creciente";$o22[1] = "ASC";

	 echo $tool->combo_array ("orden2",$o21,$o22,false,$_SESSION['ORD2'],"submit();",'',false,false,"form-box")?>
                &nbsp; <a href="#" onClick="GP_AdvOpenWindow('pagos-printable.php','','fullscreen=no,toolbar=no,location=no,status=no,menubar=yes,scrollbars=yes,resizable=no,channelmode=no,directories=no',900,590,'center','ignoreLink','',0,'',0,1,5,'');return document.MM_returnValue">Versi&oacute;n
                Imprimible <img src="../icon/icon-print.gif" width="16" height="14" border="0"></a>
               </form> 
</div>






    <?php
	while ($row = mysql_fetch_assoc($tool->result)) {

	if($row['estatus']>0) $numero = '2'; else $numero = '';

	?>

<!--loop pagos NUEVOS-->
<div id="mens-mensaje-container" class="mens-mensaje-container<?php echo $numero ?>">
<div class="mens-mensaje-imgborrar">
<!--ACCIONES. -->

<?php if($row['estatus']==0){ ?>
<a href="main.php?id=<?php echo $row['id'] ?>&accion=2" class="instruccion" style="cursor:pointer;">
<img src="../icon/botonsito-negar-pago.jpg" width="15" height="15" border="0"><span class="derecha">Rechazar Reporte de Pago</span></a>

<a href="main.php?id=<?php echo $row['id'] ?>&accion=1" class="instruccion" style="cursor:pointer;">
<img src="../icon/botonsito-confirmar-pago.jpg" width="15" height="15" border="0"><span class="derecha">Confirmar / Aceptar Pago</span></a>


<?php }else if($row['estatus']==2){?>
<a href="javascript:;" class="instruccion"><img src="../icon/botonsito-negar-pago-done.jpg" width="15" height="15" border="0"><span class="derecha">Este pago ha sido previamente rechazado.</span></a>
 

<?php }else if($row['estatus']==1){ ?>
<a href="javascript:;" class="instruccion"><img src="../icon/botonsito-confirmar-pago-done.jpg" width="15" height="15" border="0"><span class="derecha">Este pago fue previamente aprobado.</span></a>
 

<?php } ?>



<a href="main.php?borrar=<?php echo $row['id'] ?>" class="instruccion"  style="cursor:pointer;"><img src="../icon/botonsito-borrar-mensajes.jpg" width="15" height="15" border="0"><span class="derecha">Borrar Reporte de Pago</span></a>

<!--END ACCIONES-->
</div>



<div class="mens-mensaje-fecha"><?php echo $row['fecha'] ?></div>
<div class="mens-mensaje-titulo"><?php echo $row['nombre'] ?> <a href="#" onClick="GP_AdvOpenWindow('../usuarios/detallec.php?ide=<?php echo $row['id2']  ?>','','fullscreen=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,channelmode=no,directories=no',600,590,'center','ignoreLink','',0,'',0,1,5,'');return document.MM_returnValue" class="instruccion" style="cursor:pointer;"><img src="../icon/icon-lupa.gif" width="16" height="16" border="0" align="absmiddle"><span>Ver detalles de este usuario</span></a>


<a href="../opciones-sm.php?esolo=<?php echo $row['email']; ?>" class="instruccion" style="cursor:pointer;" ><img src="../icon/icon-mail.gif" width="16" height="16" border="0"  align="absmiddle"><span>Enviar Email a este usuario</span></a>


</div>
<div style="margin:5px 10px; font-size:13px; background-color:#fff;" >
<strong>Concepto del pago:</strong> <?php echo $row['comentario'] ?><br>
<strong>Destinatario:</strong> <?php echo $row['dest']?><br>
<strong>Monto (BsF.):</strong> <?php echo number_format($row['monto'],2); ?><br>
<strong>N&uacute;mero de Transacci&oacute;n:</strong><?php echo $row['ntransacc'] ?><br>
 <strong>Modo de Pago:</strong> <?php echo $row['modo'] ?>
<!--loop pagos YA REVISADOS. es decir: aprobados o desaprobados-->
<br>
</div>
</div>

<?php } ?>












<!-- termina nbloque -->
</div>

<div id="npaginacion">

<?php paginas($TOTAL,$cuenta,$desde,"pagos-printable.php"); ?>
</div>










<!-- termina ncontenido -->
</div>


</div>
</div>
















































































</body>
</html>
<?php $tool->cerrar(); ?>