<?php require('../src/db.php');if($_REQUEST['t']!=$t)exit;

function delDir($d){if(is_dir($d))$h=opendir($d);if(!$h)return 0;
while($f=readdir($h))if($f!='.'&&$f!='..')
 is_dir($d.'/'.$f)?delDir($d.'/'.$f):@unlink($d.'/'.$f);
closedir($h);rmdir($d);return 1;}

if(isset($_POST['a'])&&$_POST['a']==0&&$_POST['f']!=$_POST['n']){
 if(is_dir('../'.$_POST['n']))delDir('../'.$_POST['n']);
 rename('../'.$_POST['f'],'../'.$_POST['n']);}

else if($_POST['a']==1&&file_exists('../'.$_POST['l']))is_dir('../'.$_POST['l'])?delDir('../'.$_POST['l']):unlink('../'.$_POST['l']);

else if($_GET['a']==2&&file_exists('../'.$_GET['l'])){mkdir('tmp');
$isdir=is_dir('../'.$_GET['l']);if($isdir){
function zip($f,$as){$zip=new ZipArchive();$zip->open($as,1);
 $iter=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($f));
 foreach($iter as $e) {$dir=str_replace($f,'',$e->getPath()).'/';
  if($e->isDir()){$zip->addEmptyDir($dir);}elseif($e->isFile())
	{$zip->addFile($e->getPath().'/'.$e->getFilename(),$dir.$e->getFilename());}}
 $zip->close();}}
$name=basename($_GET['l']).($isdir?'.zip':'');
if($isdir)zip('../'.$_GET['l'],'tmp/'.$name);else copy('../'.$_GET['l'],'tmp/'.$name);
header('Content-Type: '.mime_content_type('tmp/'.$name));
header('Content-Disposition: attachment; filename="'.$name.'"');readfile('tmp/'.$name);
unlink('tmp/'.$name);rmdir('tmp');exit;}

else if($_POST['a']==3)mkdir('../'.$_POST['i']);

echo 1;