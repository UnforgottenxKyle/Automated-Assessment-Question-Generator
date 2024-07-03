<?php
ob_start();
ini_set('date.timezone','Asia/Manila');
date_default_timezone_set('Asia/Manila');
session_start();

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');
$db = new DBConnection;
$conn = $db->conn;
//eror 
ini_set('display_errors', 1);
error_reporting(E_ALL);
// google api
require_once 'plugins/google-api-php-client/vendor/autoload.php';

// mailing requires
require_once 'plugins/phpmailer/vendor/autoload.php';
require_once 'plugins/oauth2-google/vendor/autoload.php';
require_once 'plugins/PHPWord/vendor/autoload.php';

$gClient = new Google_Client();
$gClient->setApplicationName('caps');
$gClient->setClientId(G_CLIENT_ID);
$gClient->setClientSecret(G_CLIENT_SECRET);
$gClient->setScopes(['email','profile']); 
$google_oauthV2 = new Google\Service\Oauth2($gClient);
$gClient->setRedirectUri(base_url.'users');


function redirect($url=''){
	if(!empty($url))
	echo '<script>location.href="'.base_url .$url.'"</script>';
}
function validate_image($file){
    if(strpos($file, 'https://lh3.googleusercontent.com/') === 0){
        return $file;
    }
	else if(!empty($file)){
			// exit;
        $ex = explode("?",$file);
        $file = $ex[0];
        $ts = isset($ex[1]) ? "?".$ex[1] : '';
		if(is_file(base_app.$file)){
			return base_url.$file.$ts;
		}else{
			return base_url.'dist/img/no-image-available.png';
		}
	}else{
		return base_url.'dist/img/no-image-available.png';
	}
}
function format_num($number = '' , $decimal = ''){
    if(is_numeric($number)){
        $ex = explode(".",$number);
        $decLen = isset($ex[1]) ? strlen($ex[1]) : 0;
        if(is_numeric($decimal)){
            return number_format($number,$decimal);
        }else{
            return number_format($number,$decLen);
        }
    }else{
        return "Invalid Input";
    }
}
function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}
global $gClient;
ob_end_flush();
?>