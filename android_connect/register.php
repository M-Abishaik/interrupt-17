<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['collegename'])) {
 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
	$phone = $_POST['phone'];
	$collegename = $_POST['collegename'];
 
    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "Username already exists with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($name, $email, $phone, $collegename, $password);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["uid"];
            $response["user"]["name"] = $user["username"];
            $response["user"]["email"] = $user["usermail"];
			$response["user"]["password"] = $user["userpassword"];
			$response["user"]["phoneNumber"] = $user["userphone"];
            $response["user"]["collegeName"] = $user["usercollege"];

            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email, password, collegename or phonenumber) is missing!";
    echo json_encode($response);
}
?>