<?php require('../src/db.php');if($_POST['t']!=$t)exit;
file_put_contents('../src/menu.php',$_POST['i'],2);echo 1;