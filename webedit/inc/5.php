<?php if(!$auth)exit;if(file_exists('site/'.$_POST['i']))require('site/'.$_POST['i']);else echo '<code>File site/'.$_POST['i'].' does not exists</code>';