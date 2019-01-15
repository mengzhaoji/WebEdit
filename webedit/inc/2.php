<?php if(!$auth)exit;?><button onclick="save();" style="float:right;">Save</button><h1>Menu</h1>
<style>#menu{list-style:none;padding:0 0 0 0;margin:0;width:intrinsic;}
#menu:empty:before{content:'No items';}
#menu li,#add{padding:.5em;min-width:17em;box-shadow:0 0 5px #0008;}
#menu .gh{opacity:.6;border:1px dashed #888;}
#menu li{margin:1em;cursor:move;border:1px solid #<?=$d?'EEE':'555'?>;}
#menu li button{margin-left:2em;transform:translateY(-.3em);background:none;border:0;
	font-weight:bold;}
#menu li div:not(.v){display:none;} #menu .del{color:#F00;float:right;}</style>

<div id="add"><input type="text" id="add1" placeholder="Title"> - <select id="add2" onchange="this.nextSibling.nextSibling.placeholder=!this.selectedIndex?'Filename':'URL';this.nextSibling.style.display=this.selectedIndex==2?'none':'initial';"><option>Menu site</option><option>Link</option><option>None</option></select><input type="text" id="add3" placeholder="Filename"><button onclick="if($('add1').value!='')add($('add1'),$('add2'),$('add3'));else alert('Please set a title');">+</button></div>

<ul id="menu"><?php require('src/menu.php');?></ul>

<script>function sortable(rootEl){var dragEl;
 function dragOver(evt){evt.preventDefault();evt.dataTransfer.dropEffect='move';
	var t=evt.target;
	if(t&&t!==dragEl&&[].slice.call(dragEl.querySelectorAll('*')).indexOf(t)==-1&&t.nextSibling&&(t.nodeName=='LI'))t.parentNode.insertBefore(dragEl,t.nextSibling||t);}
 function dragEnd(evt){evt.preventDefault();dragEl.classList.remove('gh');
	rootEl.removeEventListener('dragover',dragOver,0);
	rootEl.removeEventListener('dragend',dragEnd,0);}
 rootEl.addEventListener('dragstart',function(evt){
	dragEl=evt.target;evt.dataTransfer.effectAllowed='move';
	evt.dataTransfer.setData('Text',dragEl.textContent);
	rootEl.addEventListener('dragover',dragOver,0);
	rootEl.addEventListener('dragend',dragEnd,0);dragEl.classList.add('gh');});
 sanitize();}sortable($('menu'));

function sanitize(){$('#menu li').forEach(function(e){e.draggable=true;
 e.innerHTML='<span>'+e.innerHTML+'</span>';
 e.insertAdjacentHTML('beforeend','<button style="float:right;" onclick="this.nextSibling.classList.toggle(\'v\');this.innerHTML=this.innerHTML==\'Edit\'?\'Done\':\'Edit\';if(this.innerHTML==\'Done\'){var c=this.parentNode.children[0],d=c.innerHTML;c.outerHTML=\'<input type=&quot;text&quot;>\';this.parentNode.querySelector(\'input\').value=d;}else{var c=this.parentNode.querySelector(\'input\'),d=c.value;c.outerHTML=\'<span>\'+d+\'</span>\';}">Edit</button><div><hr><a class="del" onclick="if(confirm(\'Do you really want to delete this item?\'))this.parentNode.parentNode.outerHTML=\'\';">Delete</a><select onchange="this.nextSibling.nextSibling.placeholder=!this.selectedIndex?\'Filename in <?=$dir?>self/\':\'URL\';this.nextSibling.nextSibling.style.display=this.selectedIndex==2?\'none\':\'initial\';"><option>Menu site</option><option>Link</option><option>None</option></select><br><input type="text" placeholder="Filename"></div>');

 if(e.hasAttribute('onclick')){
  if(~e.getAttribute('onclick').search('page')){e.querySelector('select').selectedIndex=0;
	e.querySelector('input').value=e.getAttribute('onclick').replace(/^.*'(.*?)'.*$/iu,'$1');
  }else if(~e.getAttribute('onclick').search('link')){
	e.querySelector('select').selectedIndex=1;
	e.querySelector('input').value=e.getAttribute('onclick').replace(/^.*'(.*?)'.*$/iu,'$1');}
 }else{e.querySelector('select').selectedIndex=2;
	e.querySelector('input').style.display='none';}
 e.removeAttribute('onclick');});
}

function normalize(){$('#menu li').forEach(function(e){e.removeAttribute('draggable');
 if(e.querySelector('select').selectedIndex!=2){
	var x=e.querySelector('div input').value;e.setAttribute('onclick',e.querySelector('select').selectedIndex?'link(\''+x+'\');':'page(5,{i:\''+x+'\'});');}
 e.innerHTML=e.children[0].nodeName=='SPAN'?e.children[0].innerHTML:e.children[0].value;
});}

function add(t,m,i){$('menu').insertAdjacentHTML('beforeend','<li draggable="true"><span>'+t.value+'</span><button style="float:right;" onclick="this.nextSibling.classList.toggle(\'v\');this.innerHTML=this.innerHTML==\'Edit\'?\'Done\':\'Edit\';if(this.innerHTML==\'Done\'){var c=this.parentNode.children[0],d=c.innerHTML;c.outerHTML=\'<input type=&quot;text&quot;>\';this.parentNode.querySelector(\'input\').value=d;}else{var c=this.parentNode.querySelector(\'input\'),d=c.value;c.outerHTML=\'<span>\'+d+\'</span>\';}">Edit</button><div><hr><a class="del" onclick="if(confirm(\'Do you really want to delete this item?\'))this.parentNode.parentNode.outerHTML=\'\';">Delete</a><select onchange="this.nextSibling.nextSibling.placeholder=!this.selectedIndex?\'Filename\':\'URL\';this.nextSibling.nextSibling.style.display=this.selectedIndex==2?\'none\':\'initial\';"><option>Menu site</option><option>Link</option><option>None</option></select><br><input type="text" placeholder="Filename"></div></li>');
$('#menu li:last-child')[0].querySelector('select').selectedIndex=m.selectedIndex;
$('#menu li:last-child')[0].querySelector('input').style.display=m.selectedIndex==2?'none':'initial';
$('#menu li:last-child')[0].querySelector('input').value=i.value;
t.value='';m.selectedIndex=0;i.value='';}

function save(){normalize();if(xhr(2,{i:$('menu').innerHTML})==='1'){alert('Settings saved');page(2);}else alert('Error');sanitize();}</script>