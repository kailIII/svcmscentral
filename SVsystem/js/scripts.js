// SVCMS JS SCRPTS
// RAFAEL

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}





function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}





function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function BW_reload() {location.reload();}










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