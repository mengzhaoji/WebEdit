<?php require('../src/db.php');if($_REQUEST['t']!=$t)exit;
header('Content-Type: application/json');
define('DIR','../'.dirname($_REQUEST['loc']).'/');define('TMP_DIR','../'.dirname($_REQUEST['loc']).'/');

function setTempName($value){global $tmp;$tmp=$value==0?mt_rand().'.tmp':$value;}
function uploadFile(){global $tmp;$tmpPath=TMP_DIR.$tmp;
	if(file_exists($tmpPath)&&filesize($tmpPath)===false)return ['error'=>1];
	$fileData=file_get_contents('php://input');
	if($fileData===false)return ['error'=>1];$handle=fopen($tmpPath,'a');
	if($handle===false) return ['error'=>1];
	$rv=fwrite($handle,$fileData);fclose($handle);
	if($rv===false)return ['error'=>1];return ['id'=>$tmp];}
function abortUpload(){global $tmp;return unlink(TMP_DIR.$tmp)?[]:['error'=>1];}
function finishUpload($finalName){global $tmp;$dstPath=DIR.$finalName;
	return @rename(TMP_DIR.$tmp,$dstPath)?['fileName'=>$finalName]:['error'=>1];}
function postUnsupported($files){global $tmp;if(empty($files))$files=$_FILES['uplFile'];
	if(empty($files)){return ['error'=>1];}$name=$files['name'];
	$size=$files['size'];$tmp=$files['tmp_name'];
	if(filesize($tmp)===false){return ['error'=>1];}$dstPath=DIR.$name;
	return move_uploaded_file($tmp,$dstPath)?['fileName'=>$finalName]:['error'=>1];}
function main($a,$tmpName,$real,$files){global $tmp;setTempName($tmpName);switch($a){
	case 'upload': return uploadFile();
	case 'abort': return abortUpload();
	case 'finish': return finishUpload($real);
	case 'simple': return postUnsupported($files);
	case 'help': return ['error'=>1];
	default: return ['error'=>1];}}

$tmp=isset($_REQUEST['id'])?$_REQUEST['id']:null;
$a=isset($_REQUEST['a'])?$_REQUEST['a']:'help';
$real=isset($_REQUEST['name'])?preg_replace('/["\'<>#?]/u','',$_REQUEST['name']):null;
$files=null;if(!empty($_FILES['file'])&&$a==='help'){$files=$_FILES['file'];$a='simple';}
$response=main($a,$tmp,$real,$files);echo json_encode($response);