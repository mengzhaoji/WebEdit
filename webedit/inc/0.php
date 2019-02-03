<?php if(!$auth)exit;clearstatcache();?><h1>Files</h1>
<style>#files{border:1px solid #<?=$d?'DDD':'444'?>;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;cursor:default;}
#files ul{list-style:none;padding:0 0 0 1em;margin:0;} #files > ul{padding:0 0 1em 0;}
#files > ul:before{content:'/';display:block;padding:.2em .5em;background:#<?=$d?'DDD':'222'?>;border-bottom:1px solid #<?=$d?'DDD':'444'?>;}
#files ul,#files li{box-sizing:border-box;}
#files li{padding:.2em 0 .2em .2em;} #files li:focus{outline:0;background:#<?=$d?'EEE':'444'?>;}
#files small{float:right;} #files .date{min-width:9em;}
#files .act{display:none;width:8em;}
#files li:hover > .act,#files li:focus > .act{display:inline-block;}
#files ul:not(:first-child),#files li:not(:first-child){border-top:1px solid #<?=$d?'DDD':'444'?>;}
#files ul ul:not(.show){display:none;} #files span:not(.name){display:block;}
#files img:not(.icon){margin:2px 4px;cursor:pointer;transform:rotate(-90deg);
	transition:transform .2s ease;} #files img.r {transform:rotate(0) !important;}
#files .icon{height:1em;margin-right:.5em;transform:translateY(.1em);}
#files .icon.f{margin-left:1.3em;margin-right:.7em;}
.gh{opacity:.5;} .over{border:2px solid #AAA !important;}
#prog{float:right;min-width:12em;}
#prog span{transform:translateY(-.25em);line-height:.8em;margin:0 .5em;text-align:center;
	background:#888;border-radius:50%;width:1em;height:1em;}</style>

<small style="float:right;margin-left:1em;"><a onclick="newDir(prompt('Please enter the name'));"><img src="<?=$dir?>src/dir.svg" style="height:1em;"> Add</a></small><small>Use drag and drop for movement and upload. Double click to open an entry.</small><br>
<div id="files" data-url="<?=rtrim(str_repeat('../',substr_count($dir,'/')-1),'/')?>"><ul><?php function tellDir($d){global $iF,$iD,$dir,$t;
 foreach(str_replace($d.'/','',glob($d.'/*')) as $f)
 {$mod=date('Y/m/d',filemtime($d.'/'.$f));$isdir=is_dir($d.'/'.$f);
  echo '<li tabindex="-1" data-url="'.$d.'/'.$f.'" draggable="true"><small class="date">'.($mod==date('Y/m/d')?'Today':$mod).', '.date('H:i',filemtime($d.'/'.$f)).'</small><small class="act"><a title="Download" onclick="location=\''.$dir.'xhr/0.php?t='.$t.'&a=2&l=\'+encodeURIComponent(this.parentNode.parentNode.dataset.url);">⤓</a> | <a title="Rename" onclick="var name=prompt(\'Enter the new name:\',this.parentNode.parentNode.dataset.url.split(\'/\').pop());if(name){name=name.replace(/[\/<>:]/gui,\'\');if(name!=\'\'){var oldL=this.parentNode.parentNode.dataset.url,newL=this.parentNode.parentNode.parentNode.parentNode.dataset.url+\'/\'+name;if(xhr(0,{a:0,f:oldL,n:newL})===\'1\'){this.parentNode.parentNode.querySelector(\'.name\').innerHTML=name;this.parentNode.parentNode.dataset.url=newL;}else alert(\'Error\');}else alert(\'This filename is not valid\');}">a…</a> | <a title="Delete" onclick="if(confirm(\'Are you sure you want to delete this entry? This cannot be undone.\'))if(xhr(0,{a:1,l:this.parentNode.parentNode.dataset.url})===\'1\')this.parentNode.parentNode.outerHTML=\'\';else alert(\'Error\');">⌫</a>'.($isdir?'':' | <a title="Edit" onclick="page(1,{i:this.parentNode.parentNode.dataset.url});">✎</a>').'</small><span ondblclick="'.($isdir?'this.parentNode.querySelector(\'ul\').classList.toggle(\'show\');this.parentNode.querySelector(\'img:not(.icon)\').classList.toggle(\'r\');"><img src="'.$dir.'src/down.svg" onclick="this.parentNode.parentNode.querySelector(\'ul\').classList.toggle(\'show\');this.classList.toggle(\'r\');" draggable="false">':'page(1,{i:this.parentNode.dataset.url});">').'<img class="icon'.($isdir?'':' f').'" src="'.$dir.'src/d'.($isdir?'ir':'oc').'.svg" draggable="false"><span class="name">'.$f.'</span></span>';if($isdir){echo '<ul>';tellDir($d.'/'.$f);echo '</ul>';}echo '</li>';
}}tellDir(rtrim(str_repeat('../',substr_count($dir,'/')-1),'/'));?></ul></div><br>

<details><summary>File upload</summary><div><input type="file" id="uplFiles" multiple>
<input type="button" value="▶︎" id="uplSubmit" onclick="var fs=[];for(var i=0;i<$('uplFiles').files.length;i++)fs.push($('uplFiles').files[i]);upload(fs,$('files'));">
<input type="button" value="✕" id="uplCancel" onclick="abort();" style="display:none;"><br>
<small id="uplTimeSmall" style="display:none;"><span id="uplTime"></span> left …</small></div></details>

<script>function newDir(nm){if(nm){nm=nm.replace(/[\/"'<>#?:]/gu,'');if(nm!=''){
var url=$('files').dataset.url+'/'+nm,set=0;

var newDirE=document.createElement('li');newDirE.draggable=true;
newDirE.dataset.url=url;newDirE.setAttribute('tabindex','-1');
newDirE.innerHTML='<small class="date">Now</small><small class="act"><a title="Download" onclick="location=\'<?=$dir?>xhr/0.php?t=<?=$t?>&a=2&l=\'+encodeURIComponent(this.parentNode.parentNode.dataset.url);">⤓</a> | <a title="Rename" onclick="var name=prompt(\'Enter the new name:\',this.parentNode.parentNode.dataset.url.split(\'/\').pop());if(name){name=name.replace(/[\/<>:]/gui,\'\');if(name!=\'\'){var oldL=this.parentNode.parentNode.dataset.url,newL=this.parentNode.parentNode.parentNode.parentNode.dataset.url+\'/\'+name;if(xhr(0,{a:0,f:oldL,n:newL})===\'1\'){this.parentNode.parentNode.querySelector(\'.name\').innerHTML=name;this.parentNode.parentNode.dataset.url=newL;}else alert(\'Error\');}else alert(\'This filename is not valid\');}">a…</a> | <a title="Delete" onclick="if(confirm(\'Are you sure you want to delete this entry? This cannot be undone.\'))if(xhr(0,{a:1,l:this.parentNode.parentNode.dataset.url})===\'1\')this.parentNode.parentNode.outerHTML=\'\';else alert(\'Error\');">⌫</a></small><span ondblclick="this.parentNode.querySelector(\'ul\').classList.toggle(\'show\');this.parentNode.querySelector(\'img:not(.icon)\').classList.toggle(\'r\');"><img src="<?=$dir?>src/down.svg" onclick="this.parentNode.parentNode.querySelector(\'ul\').classList.toggle(\'show\');this.classList.toggle(\'r\');" draggable="false"><img class="icon" src="<?=$dir?>src/dir.svg" draggable="false"><span class="name">'+nm+'</span></span><ul></ul>';

for(let li of $('#files > ul')[0].children){
 var a=li.querySelector('.name').innerHTML,
     b=newDirE.querySelector('.name').innerHTML;
 if(a==b){
    if(confirm('This directory already exists.'))
	{li.parentNode.replaceChild(newDirE,li);set=1;break;}else return;
 }else if(a>b){li.parentNode.insertBefore(newDirE,li);set=1;break;}
}
if(!set)$('#files > ul')[0].appendChild(newDirE);

if(xhr(0,{a:3,i:url})!=='1'){newDirE.parentNode.removeChild(newDirE);alert('Error');}
}else alert('Invalid name');}}

function dragndrop(rootEl){var dragEl;
 function dragOver(evt){evt.preventDefault();evt.dataTransfer.dropEffect='move';
	var t=evt.target;
	evt.dataTransfer.dropEffect=evt.dataTransfer.types.find(x=>x=='Files')?'copy':
		'move';
	if(t.classList.contains('name'))t=t.parentNode.parentNode;
	 else if(t.nodeName=='SMALL'||t.nodeName=='SPAN'||(t.nodeName=='UL'&&t!=$('#files > ul')[0]))t=t.parentNode;
	if(t&&t!==dragEl&&(evt.dataTransfer.types.find(x=>x=='Files')||[].slice.call(dragEl.querySelectorAll('*')).indexOf(t)==-1)&&((t.nodeName=='LI'&&t.querySelector('ul'))||t.nodeName=='UL')){if($('.over')[0])$('.over')[0].classList.remove('over');t.classList.add('over');}}
 function dragLeave(evt){evt.preventDefault();evt.target.classList.remove('over');}
 function dragEnd(evt){evt.preventDefault();evt.target=dragEl.classList.remove('gh');
	if($('.over').length){var set=0,e=$('.over')[0];e.classList.remove('over');
	 if(e.nodeName=='LI')e=e.querySelector('ul');
	 if(dragEl.parentNode!=e){
		for(let li of e.children){
		 var a=li.querySelector('.name').innerHTML,
		     b=dragEl.querySelector('.name').innerHTML;
		 if(a==b){
		    if(confirm('This file already exists. Do you want to replace it?'))
			{li.parentNode.replaceChild(dragEl,li);set=1;break;}else return;
		 }else if(a>b){li.parentNode.insertBefore(dragEl,li);set=1;break;}
		}
		if(!set)e.appendChild(dragEl);
		var oldL=dragEl.dataset.url,
			newL=dragEl.parentNode.parentNode.dataset.url+'/'+
			dragEl.dataset.url.split('/').pop();
		dragEl.dataset.url=newL;
		if(xhr(0,{a:0,f:oldL,n:newL})!=='1')alert('Error');
	}}dragEl=undefined;}
 function drop(evt){evt.preventDefault();var t=evt.target;if($('.over').length)
  if(evt.dataTransfer.types.find(x=>x=='Files')){
	if(t.nodeName=='SMALL'||t.nodeName=='SPAN'||(t.nodeName=='UL'&&t!=$('#files > ul')[0]))t=t.classList.contains('name')?t.parentNode.parentNode:t.parentNode;
	t.classList.remove('over');t.querySelector('ul').classList.add('show');
	t.querySelector('img').classList.add('r');
	$('uplFiles').files=evt.dataTransfer.files,fs=[];
	for(var i=0;i<evt.dataTransfer.files.length;i++)
		fs.push(evt.dataTransfer.files[i]);
	upload(fs,event.target);}}
 rootEl.addEventListener('dragstart',function(evt){
	dragEl=evt.target;evt.dataTransfer.effectAllowed='copy';
	evt.dataTransfer.setData('DownloadURL',location.origin+
		dragEl.dataset.url.substring(2));dragEl.classList.add('gh');});
 rootEl.addEventListener('dragover',dragOver,1);
 rootEl.addEventListener('dragleave',dragLeave,1);
 rootEl.addEventListener('dragend',dragEnd,1);
 rootEl.addEventListener('drop',drop,1);
 }dragndrop($('#files > ul')[0]);
function prvDrp(e){if(e.target!=$('uplFiles')){e.preventDefault();
	e.dataTransfer.dropEffect='none';}}
addEventListener('drop',prvDrp,1);addEventListener('dragover',prvDrp,1);


function xhr2(g,p){var x=new XMLHttpRequest();x.open(p?'POST':'GET','<?=$dir?>xhr/upload.php'+g,0);
if(p!==undefined){if(p instanceof Blob)dt=p;else{var dt=new FormData();
 dt.append('t','<?=$t?>');for(d in p){dt.append(d,p[d]);}}}
x.send(dt);return x.responseText;}
function sec2all(s){var h=Math.floor(s/3600),min=Math.floor(s/60)-h*60,s=s-min*60-h*3600;
return (h!=0?h+'h ':'')+(min!=0?min+'min ':'')+(s!=0?s+'sec'+(s!=1?'s':''):'');}
var eTrg=null,uplData={loading:false,file:false,allFiles:null,allChunks:0,aborted:false,
	paused:false,id:0,pauseChunk:0,timeStart:0,totalTime:0,newEl:null};
function reset(){uplData={loading:false,file:false,allFiles:null,allChunks:0,paused:false,
	id:0,aborted:false,pauseChunk:0,timeStart:0,totalTime:0,newEl:null};
	$('uplSubmit').value='▶︎';$('uplTimeSmall').style.display='none';}
function fire(fs){if(uplData.loading===true&&uplData.paused===false)pauseUpl();
	else if(uplData.loading===true&&uplData.paused===true)resumeUpl();
	else {processFiles(fs[0]);uplData.allFiles=fs;}
	$('uplTimeSmall').style.display='block';};
function processFiles(f){
	if(!File||!FileReader||!FileList||!Blob){$('uplForm').submit();return;}
	uplData.loading=true;$('uplSubmit').value='❙❙';
	uplData.file=f;var fileSize=uplData.file.size;
	uplData.allChunks=Math.ceil(fileSize/1000000);

	var e=eTrg,set=0;
	if(e.nodeName=='SMALL'||e.nodeName=='SPAN'||e.nodeName=='UL')
		e=e.classList.contains('name')?e.parentNode.parentNode:e.parentNode;
	e=e.querySelector('ul');
	 uplData.newEl=document.createElement('li');
	 uplData.newEl.setAttribute('tabindex','-1');
	 uplData.newEl.dataset.url=e.parentNode.dataset.url+'/'+uplData.file.name;
	 uplData.newEl.innerHTML='<small class="date">Now</small><span id="prog"><progress id="uplBar" min="0" max="100"></progress><span style="display:inline-block;" onclick="abort();">×</span></span><span ondblclick="page(1,{i:this.parentNode.parentNode.dataset.url});"><img class="icon f" src="<?=$dir?>src/doc.svg" draggable="false"><span class="name">'+uplData.file.name+'</span></span>';
	for(let li of e.children){
	 var a=li.querySelector('.name').innerHTML,
	     b=uplData.file.name;
	 if(a==b){
	    if(confirm('The file "'+b+'" already exists. Do you want to replace it?'))
		{li.parentNode.replaceChild(uplData.newEl,li);set=1;break;}else
		{reset();return;}
	 }else if(a>b){li.parentNode.insertBefore(uplData.newEl,li);set=1;break;}
	}
	if(!set)e.appendChild(uplData.newEl);
	sendData(0);}
function sendData(chunk){uplData.timeStart=new Date().getTime();
	if(uplData.aborted===true)return;
	if(uplData.paused===true){uplData.pauseChunk=chunk;return;}
	var start=chunk*1000000,stop=start+1000000,reader=new FileReader();
	reader.onloadend=function(evt){if(uplData.newEl){
	 var response=JSON.parse(xhr2('?a=upload&id='+uplData.id+'&t=<?=$t?>&loc='+encodeURIComponent(uplData.newEl.dataset.url),blob));
	 if(response.error===1){error();return;}
	 if(chunk===0||uplData.id===0){uplData.id=response.id;}
	 if(chunk<uplData.allChunks){progress(chunk+1);sendData(chunk+1);} else end();
	}};
	var blob=uplData.file.slice(start,stop);
	if(reader.readAsBinaryString)reader.readAsBinaryString(blob);else 
	 reader.readAsArrayBuffer(blob);}
function end(e){var response=JSON.parse(xhr2('',{a:'finish',id:uplData.id,name:uplData.file.name,loc:uplData.newEl.dataset.url}));
	if(response.error===1){error();return;}
	$('uplSubmit').value='▶︎';if(uplData.allFiles.length)uplData.allFiles.shift();
	done(uplData.allFiles);}
function abortUpl(){if(uplData.file){uplData.aborted=true;
	$('uplCancel').style.display='none';
	var response=JSON.parse(xhr2('',{a:'abort',id:uplData.id,loc:uplData.newEl.dataset.url}));
	if(response.error===1){error();return;}
	uplData.newEl.parentNode.removeChild(uplData.newEl);reset();}}
function pauseUpl(){uplData.paused=true;$('uplSubmit').value='▶︎';
	$('uplCancel').style.display='inline-block';}
function resumeUpl(){uplData.paused=false;$('uplSubmit').value='❙❙';
	$('uplCancel').style.display='none';sendData(uplData.pauseChunk);}
function progress(p){
	var percent=Math.ceil((p/uplData.allChunks)*100),rPerc=(p/uplData.allChunks)*100;
	$('uplBar').value=rPerc;
	uplData.newEl.querySelector('.date').textContent=percent+'%';
	if(p%5===0){uplData.totalTime+=(new Date().getTime()-uplData.timeStart);
	 var timeLeft=sec2all(Math.ceil((uplData.totalTime/p)*(uplData.allChunks-p)/100));
	 $('uplTime').innerHTML=timeLeft;$('uplBar').title=timeLeft;}}
function error(){alert('Error');}
function upload(fs,e){reset();eTrg=eTrg?eTrg:e;
	if(!uplData.loading&&!uplData.paused){if(fs.length)fire(fs);}else
	alert('There is now a upload process. Try again when the upload has been finished.');}
function abort(){if(confirm('Do you really want to abort the file upload?'))
	{pauseUpl();abortUpl();}}

function done(fs){uplData.newEl.draggable=true;uplData.newEl.querySelector('.date').textContent='Now';
$('prog').outerHTML='<small class="act"><a title="Download" onclick="location=\'<?=$dir?>xhr/0.php?t=<?=$t?>&a=2&l=\'+encodeURIComponent(this.parentNode.parentNode.dataset.url);">⤓</a> | <a title="Rename" onclick="var name=prompt(\'Enter the new name:\',this.parentNode.parentNode.dataset.url.split(\'/\').pop());if(name){name=name.replace(/[\/&quot;\'<>#?:]/gu,\'\');if(name!=\'\'){var oldL=this.parentNode.parentNode.dataset.url,newL=this.parentNode.parentNode.parentNode.parentNode.dataset.url+\'/\'+name;if(xhr(0,{a:0,f:oldL,n:newL})===\'1\'){this.parentNode.parentNode.querySelector(\'.name\').innerHTML=name;this.parentNode.parentNode.dataset.url=newL;}else alert(\'Error\');}else alert(\'This filename is not valid\');}">a…</a> | <a title="Delete" onclick="if(confirm(\'Are you sure you want to delete this entry? This cannot be undone.\'))if(xhr(0,{a:1,l:this.parentNode.parentNode.dataset.url})===\'1\')this.parentNode.parentNode.outerHTML=\'\';else alert(\'Error\');">⌫</a> | <a title="Edit" onclick="page(1,{i:this.parentNode.parentNode.dataset.url});">✎</a></small>';

reset();if(fs.length){upload(fs);}else eTrg=null;}

onbeforeunload=function(){abortUpl();};</script>