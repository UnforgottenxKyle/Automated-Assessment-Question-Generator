<?php
require_once('../config.php');
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login(){
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
	 	$password = md5($password);
		$stmt->bind_param('ss',$username,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			foreach($result->fetch_array() as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function login_ruser(){
		global $gClient;
		extract($_POST);

		if (isset($_GET['code'])) {
			$register_from=1;
			$gClient->setRedirectUri(base_url.'classes/Login.php?f=login_ruser');
			$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
			if (isset($token['access_token'])) {
				$gClient->setAccessToken($token['access_token']);
				$google_oauthV2 = new Google_Service_Oauth2($gClient);
				$googleData = $google_oauthV2->userinfo->get();
				$userData['email'] = !empty($googleData['email'])?$googleData['email']:''; 
				
				$stmt = $this->conn->prepare("SELECT * from registered_user_list where email = ? and delete_flag = 0 and register_from = 1 ");
				$stmt->bind_param('s',$userData['email']);
				
			}
			else{
				$resp['status'] = 'failed';
				$resp['msg'] = 'Access Token does not exist';
			}
		}
		else{
			$stmt = $this->conn->prepare("SELECT * from registered_user_list where email = ? and `password` = ? and delete_flag = 0 and register_from = 0");
			$password = md5($password);
			$stmt->bind_param('ss',$email,$password);
			$register_from=0;
		}
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			if ($res['verified'] == 0 and $register_from==0){
				$resp['status'] = 'failed';
				$resp['msg'] = 'Your Account is not verified. Please check your emails for verification link';
			}
			elseif($res['status'] == 1){
				foreach($res as $k => $v){
					$this->settings->set_userdata($k,$v);
				}
				$this->settings->set_userdata('login_type',2);
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = 'Your Account has been blocked.';
			}
		}else{
		$resp['status'] = 'failed';
		$resp['msg'] = 'Incorrect Email or Password';
		}
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		
		if ($register_from==1) {
			header("Location: " . base_url . "users/");
			exit(); 
		}
		return json_encode($resp);
	}
	public function logout_ruser(){
		if($this->settings->sess_des()){
			redirect('users');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'login_ruser':
		echo $auth->login_ruser();
		break;
	case 'logout_ruser':
		echo $auth->logout_ruser();
		break;
	default:
		echo $auth->index();
		break;
}

