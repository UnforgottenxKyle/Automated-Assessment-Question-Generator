<?php
require_once(__DIR__ . '/../config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

Class Verification extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
    function phpmailer_init(){
        $provider = new Google([
            'clientId'     => G_CLIENT_ID,
            'clientSecret' => G_CLIENT_SECRET,
            'redirectUri'  => 'http://localhost/caps/users/',
        ]);

        $mail = new PHPMailer(true);

        try {
            // mail config
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com'; 
            $mail->Username = 'grifin4kyle@gmail.com';  # edit the email 
            $mail->Password = 'farh fiep qzbi dkkr' ;   # edit with the app password generated
            $mail->Port = 465;                  
            $mail->SMTPSecure = "ssl";
            // emailer details
            $mail->setFrom('grifin4kyle@gmail.com', 'Automated Assessment Paper Generator Support'); # edit the email here too 
        } catch (Exception $e) {
            die("Error initializing PHPMailer. Details: " . $e->getMessage());
        }
        return $mail;
    }

    function send_activation_email(string $email, string $activation_code, string $user): void
    {

        $activation_link = base_url . "verification.php?email=$email&activation_code=$activation_code";

        $mail = $this->phpmailer_init(); 
        $mail->addAddress($email,$user);

        $mail->isHTML(true);
        $mail->Subject = 'Please activate your account';
        $mail->Body = $this->body_message($activation_link,$user, ["We hope this message finds you well. We're excited to welcome you to our community!",
    "To take full advantage of your account, kindly click on the following button to activate it"]);

        $mail->send();
    }

    function send_changepass_email()
    {
        $resp = array('status' => 'failed', 'msg' => 'An error occurred.');

		extract($_POST);

        $stmt = $this->conn->prepare("SELECT * from registered_user_list where email = ?");
        $stmt->bind_param('s',$email);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			if ($res['verified'] == 0 and $res['register_from']==0){
				$resp['status'] = 'failed';
				$resp['msg'] = 'Your Account is not verified.';
			}
			elseif($res['status'] == 1){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = 'Your Account has been blocked.';
			}
			
		}else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'Email doesnt exist.';
        }

        if ($resp['status'] === 'success') {
            try {
                $password_code = $this->generate_activation_code();
        
                $stmt = $this->conn->prepare("UPDATE `registered_user_list` SET password_code = ? WHERE id = ?");
                $stmt->bind_param('si', $password_code, $res['id']);
                $stmt->execute();
        
                if ($stmt->affected_rows > 0) {
                    $password_link = base_url . "changepassword.php?email=$email&password_code=$password_code&id=".$res['id'];
                
                    $mail = $this->phpmailer_init(); 
                    $mail->addAddress($email);
        
                    $mail->isHTML(true);
                    $mail->Subject = 'Resetting password';
                    $mail->Body = $this->body_message($password_link,$res['lastname'], ["There was recently a request to change the password on your account.",
                    "If you don't want to change your password, just ignore this message.",
                    "If you requested this password change, please click the button below to set a new password:"]);
        
                    $mail->send();
                    $resp['msg'] = 'Email Sent! Please check your Email for the link';
                } else {
                    
                    $resp['status'] = 'failed';
                    $resp['msg'] = 'Error updating password code in the database.';
                }
        
                $stmt->close(); 
            } catch (Exception $e) {
                $resp['status'] = 'failed';
                $resp['msg'] = "Error sending Email. Details: " . $e->getMessage();
                die("Error sending Email. Details: " . $e->getMessage());
            }
        }
        return json_encode($resp);

    }
    

    function activate_user(int $user_id): bool
    {
        $sql = "UPDATE registered_user_list
                SET verified = 1,
                    verified_at = CURRENT_TIMESTAMP,
                    activation_code = NULL 
                WHERE id={$user_id}";

        $save = $this->conn->query($sql);
        $this->settings->set_flashdata('success','Account activated Successfully');
				
        return $save;

    }

    function find_unverified_user(string $activation_code, string $email)
    {
    
        $sql = "SELECT id, activation_code
                FROM registered_user_list
                WHERE verified = 0 AND `email` ='{$email}'";
        $userResult = $this->conn->query($sql);

        if ($userResult) {
            $user = $userResult->fetch_assoc();
            if ($activation_code=== $user['activation_code']) {
                return $user;
            }
        }
    
        return null;
    }
    function find_user(string $password_code, string $email)
    {
    
        $sql = "SELECT id, password_code
                FROM registered_user_list
                WHERE verified = 1 AND `email` ='{$email}'";
        $userResult = $this->conn->query($sql);

        if ($userResult) {
            $user = $userResult->fetch_assoc();
            if ($password_code=== $user['password_code']) {
                return $user;
            }
        }
    
        return null;
    }

    function generate_activation_code(): string
    {
        return bin2hex(random_bytes(16));
    }
    function body_message($activation_link,$user,$messages){
        $messagesHTML = implode('', array_map(function ($message) {
            return "<p>{$message}</p>";
        }, $messages));
        return "
        <html>
        <head>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    line-height: 1.6;
                    background-color: #f5f5f5;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #007bff;
                }
                p {
                    margin-bottom: 15px;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
                .button-p{
                    text-align: center;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #FFFFFF !important;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }
                .button:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Hello $user,</h1>
                
                {$messagesHTML}
                <p class='button-p'><a href='$activation_link' class='button'>Activate Now</a></p>
                <p>or use this link:</p>
                <p>$activation_link</p>
                <p>If you have any questions or need assistance, feel free to reach out to our support team. We're here to help!</p>
                <p>Thank you for choosing our Automated Assessment Paper Generator</p>
                <p>Best regards,<br>
                The Automated Assessment Paper Generator Team</p>
            </div>
        </body>
        </html>
    ";
    }
}
$verification = new Verification();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'send_changepass_email':
		echo $verification->send_changepass_email();
	break;
	default:
		break;
}
?>
