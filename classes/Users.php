<?php
require_once('../config.php');
require_once('Verification.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}
		$check = $this->conn->query("SELECT * FROM `users` where username = '{$username}' ".(!empty($id)? " and id != '{$id}' " : ''))->num_rows;
		if($check > 0){
			return 2;
		}
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if($qry){
				$id=$this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');
				foreach($_POST as $k => $v){
					if($k != 'id'){
						if(!empty($data)) $data .=" , ";
						$this->settings->set_userdata($k,$v);
					}
				}
				if(!empty($_FILES['img']['tmp_name'])){
					if(!is_dir(base_app."uploads/avatars"))
						mkdir(base_app."uploads/avatars");
					$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
					$fname = "uploads/avatars/$id.$ext";
					$accept = array('image/jpeg','image/png');
					if(!in_array($_FILES['img']['type'],$accept)){
						$err = "Image file type is invalid";
					}
					if($_FILES['img']['type'] == 'image/jpeg')
						$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
					elseif($_FILES['img']['type'] == 'image/png')
						$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
					if(!$uploadfile){
						$err = "Image is invalid";
					}
					$temp = imagescale($uploadfile,200,200);
					if(is_file(base_app.$fname))
					unlink(base_app.$fname);
					if($_FILES['img']['type'] == 'image/jpeg')
					$upload =imagejpeg($temp,base_app.$fname);
					elseif($_FILES['img']['type'] == 'image/png')
					$upload =imagepng($temp,base_app.$fname);
					else
					$upload = false;
					if($upload){
						$this->conn->query("UPDATE `users` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
						$this->settings->set_userdata('avatar',$fname."?v=".time());
					}

					imagedestroy($temp);
				}
				return 1;
			}else{
				return 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE users set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','User Details successfully updated.');
				foreach($_POST as $k => $v){
					if($k != 'id'){
						if(!empty($data)) $data .=" , ";
						$this->settings->set_userdata($k,$v);
					}
				}
				if(!empty($_FILES['img']['tmp_name'])){
					if(!is_dir(base_app."uploads/avatars"))
						mkdir(base_app."uploads/avatars");
					$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
					$fname = "uploads/avatars/$id.$ext";
					$accept = array('image/jpeg','image/png');
					if(!in_array($_FILES['img']['type'],$accept)){
						$err = "Image file type is invalid";
					}
					if($_FILES['img']['type'] == 'image/jpeg')
						$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
					elseif($_FILES['img']['type'] == 'image/png')
						$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
					if(!$uploadfile){
						$err = "Image is invalid";
					}
					$temp = imagescale($uploadfile,200,200);
					if(is_file(base_app.$fname))
					unlink(base_app.$fname);
					if($_FILES['img']['type'] == 'image/jpeg')
					$upload =imagejpeg($temp,base_app.$fname);
					elseif($_FILES['img']['type'] == 'image/png')
					$upload =imagepng($temp,base_app.$fname);
					else
					$upload = false;
					if($upload){
						$this->conn->query("UPDATE `users` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
						$this->settings->set_userdata('avatar',$fname."?v=".time());
					}

					imagedestroy($temp);
				}

				return 1;
			}else{
				return "UPDATE users set $data where id = {$id}";
			}
			
		}
	}
	public function delete_user(){
		extract($_POST);
		$get = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array();
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(isset($get['avatar']) && is_file(base_app.$get['avatar']))
			unlink(base_app.$get['avatar']);
			return 1;
		}else{
			return false;
		}
	}
	public function save_ruser(){
		global $gClient;
		$verification = new Verification();
		if(!empty($_POST['password']))
		$_POST['password'] = md5($_POST['password']);
		else
		unset($_POST['password']);
		$register_from=0;
		if (isset($_GET['code'])) {
			
			$gClient->setRedirectUri(base_url.'classes/Users.php?f=save_ruser');
			$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
			if (isset($token['access_token'])) {
				$gClient->setAccessToken($token['access_token']);
				$google_oauthV2 = new Google_Service_Oauth2($gClient);
				$googleData = $google_oauthV2->userinfo->get();
				$_POST['lastname'] = !empty($googleData['family_name'])?$googleData['family_name']:''; 
				$_POST['firstname'] = !empty($googleData['given_name'])?$googleData['given_name']:''; 
				$_POST['email'] = !empty($googleData['email'])?$googleData['email']:''; 
				$_POST['gender'] = !empty($googleData['gender'])?$googleData['gender']:'';
				$_POST['avatar'] = !empty($googleData['picture'])?$googleData['picture']:'';
				$_POST['dob'] = '1000-10-10';
				$_POST['contact'] = '';
				// the password is randomly generated for security purposes
				// but users should not be able to update/use the password
				$_POST['password'] = bin2hex(random_bytes(16));
				$_POST['verified'] = 1;
				// users should not be able to register the same email that is registered with google
				// users should not be able to login manually to the account registered with google
				// new column on registered, to know what kind of register they did
				// data registered with google should also not be editable
			}
			$_POST['register_from'] = 1;
		}
		
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if($k === 'cpassword')
					continue;
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `registered_user_list` where `email` = '{$email}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ".(!empty($activation_code) ? " and activation_code != {$activation_code} " : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = !empty($activation_code) ? "Email already taken.":"Activation link error";
	
			if($register_from==1){
				header("Location: " . base_url . "users/register.php?error=email_taken");
				exit();
			}
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$activation_code=$verification->generate_activation_code();
			$data .= ", `activation_code`='{$this->conn->real_escape_string($activation_code)}' ";
			$sql = "INSERT INTO `registered_user_list` set {$data} ";
		}else{
			$sql = "UPDATE `registered_user_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$aid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id)){
				$this->settings->set_flashdata('success',"Account successfully created. Please check your emails for the activation link");
				$verification->send_activation_email($email,$activation_code,$lastname);
			}
			else{
				if($id == $this->settings->userdata('id') && $this->settings->userdata('login_type') == 2)
					$this->settings->set_flashdata('success'," Account successfully updated.");
				else
					$this->settings->set_flashdata('success'," Registered User Account successfully updated.");
				
				if($id == $this->settings->userdata('id') && $this->settings->userdata('login_type') == 2){
					$this->settings->set_userdata('login_type',2);
					foreach($_POST as $k =>$v){
						$this->settings->set_userdata($k,$v);
					}
					$this->settings->set_userdata('id',$aid);
				}
			}
			if(!empty($_FILES['img']['tmp_name'])){
				if(!is_dir(base_app."uploads/rusers"))
					mkdir(base_app."uploads/rusers");
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = "uploads/rusers/$aid.$ext";
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$err = "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$err = "Image is invalid";
				}
				$temp = imagescale($uploadfile,200,200);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				if($_FILES['img']['type'] == 'image/jpeg')
				$upload =imagejpeg($temp,base_app.$fname);
				elseif($_FILES['img']['type'] == 'image/png')
				$upload =imagepng($temp,base_app.$fname);
				else
				$upload = false;
				if($upload){
					$this->conn->query("UPDATE `registered_user_list` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$aid}'");
					if($id == $this->settings->userdata('id') && $this->settings->userdata('login_type') == 2){
						$this->settings->set_userdata('avatar',$fname."?v=".time());
					}
				}

				imagedestroy($temp);
			}

		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " An error occurred.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($register_from==1){
			if ($resp['status'] === 'success') {
				header("Location: " . base_url . "users/login.php");}
			else
				header("Location: " . base_url . "users/register.php");
			exit();
		}
		return json_encode($resp);
	} 
	function delete_ruser(){
		extract($_POST);
		$delete = $this->conn->query("UPDATE `registered_user_list` set delete_flag = 1 where id = '{$id}'");
		if($delete){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Registered User successfully deleted");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'save_ruser':
		echo $users->save_ruser();
	break;
	case 'delete_ruser':
		echo $users->delete_ruser();
	break;
	case 'delete_user':
		echo $users->delete_user();
	break;
	default:
		// echo $sysset->index();
		break;
}