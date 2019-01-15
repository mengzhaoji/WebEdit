<?php require('../src/db.php');if($_REQUEST['t']!=$t)exit;

if(isset($_POST['a'])&&$_POST['a']==0)file_put_contents('../src/db.php','<?php $u=\''.addslashes($u).'\';$p=\''.addslashes($p).'\';$t=\''.$t.'\';$sgt=\''.$sgt.'\';$d='.($_POST['i']?0:1).';',2);

elseif($_POST['a']==1){$sgt=$_POST['i']?sha1(uniqid()):'';file_put_contents('../src/db.php','<?php $u=\''.addslashes($u).'\';$p=\''.addslashes($p).'\';$t=\''.$t.'\';$sgt=\''.$sgt.'\';$d='.$d.';',2);die('["'.$sgt.'"]');}

elseif($_POST['a']==2)file_put_contents('../src/db.php','<?php $u=\''.addslashes(password_hash($_POST['u'],1)).'\';$p=\''.addslashes(password_hash($_POST['p'],1)).'\';$t=\''.$t.'\';$sgt=\''.$sgt.'\';$d='.$d.';',2);

elseif($_GET['a']==3){function zip($f,$as){$zip=new ZipArchive();$zip->open($as,1);
$iter=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($f));
foreach($iter as $e) {$dir=str_replace($f,'',$e->getPath()).'/';
 if($e->isDir()){$zip->addEmptyDir($dir);}elseif($e->isFile())
	{$zip->addFile($e->getPath().'/'.$e->getFilename(),$dir.$e->getFilename());}}
$zip->close();}
$backup='Backup_'.date('Y-m-d',time());
$dir=dirname($_SERVER['SCRIPT_NAME']);$dir=($dir=='/'?'':$dir).'/';
zip(str_repeat('../',substr_count($dir,'/')-1),$backup.'.zip');
header('Content-Type: '.mime_content_type($backup.'.zip'));
header('Content-Disposition: attachment; filename="'.$backup.'.zip"');
readfile($backup.'.zip');unlink($backup.'.zip');exit;}

echo 1;