<?php
require_once('config.php');
require_once('classes/Verification.php');


function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}
$verification=new Verification();
if (is_get_request()) {
    // sanitize the email & activation code
    $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
    $activation_code = filter_input(INPUT_GET, 'activation_code', FILTER_SANITIZE_STRING);


        $user = $verification->find_unverified_user($activation_code, $email);
        // print_r($user);
        // print_r($verification->activate_user($user['id']));
        // if user exists and activate the user successfully
        if ($user && $verification->activate_user($user['id'])) {
                    
            header("Location: ".$base_url."users/login.php");
            exit();
        }
    
        die($user);
}


// redirect to the register page in other cases
redirect_with_message(
    'users/register.php',
    'The activation link is not valid, please register again.',
);
?>