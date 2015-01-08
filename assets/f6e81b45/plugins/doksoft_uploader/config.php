<?php
$config['BaseUrl'] = preg_replace('/(uploader\.php.*)/', 'userfiles/', '/images/'); // Absolute path to upload folder via HTTP. For example: http://yoursite.com/tinymce/plugins/doksoft_uploader/userfiles/ 
$config['BaseDir'] = $_SERVER['DOCUMENT_ROOT'].'/images/'; // final userfiles (absolute or relative) Dir path. Like in "/var/www/tinymce/doksoft_uploader/userfiles/"

$config['Images'] = Array(
		'maxWidth' => 1600,
		'maxHeight' => 1200,
		'quality' => 80);

$config['ResizedImages'] = Array(
		'maxWidth' => 640,
		'maxHeight' => 480,
		'quality' => 80);

$config['Thumbnails'] = Array(
		'maxWidth' => 200,
		'maxHeight' => 140,
		'quality' => 80);
		

$config['ResourceType']['Files'] = Array(
		'maxSize' => 0, // maxSize in bytes, 0 for any
		'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip');

$config['ResourceType']['Images'] = Array(
		'maxSize' => 16*1024*1024, // maxSize in bytes, 0 for any
		'allowedExtensions' => 'bmp,gif,jpeg,jpg,png');


if (substr($config['BaseUrl'], -1) !== '/')
	$config['BaseUrl'] .= '/';
if (substr($config['BaseDir'], -1) !== '/' && substr($config['BaseDir'], -1) !== '\\')
	$config['BaseDir'] .= '/';
		
?>