<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Authentication extends \Restserver\Libraries\REST_Controller {

    //Constructor
    public function __construct() {
        parent::__construct();
        //Load user model
        $this->load->model('User_Model');
    }

    //Authentication sign-up
    public function signup_post(){

//        header("Access-Control-Allow-Origin: *");

        $this->form_validation->set_data([
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'confirm_password' => $this->post('confirm_password'),
            'full_name' => $this->post('full_name'),
            'wishlist_name' => $this->post('wishlist_name'),
            'wishlist_description' => $this->post('wishlist_description')
        ]);

        //Form validations
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('wishlist_name', 'Wishlist Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('wishlist_description', 'Wishlist Description', 'trim|required|max_length[100]');

        if ($this->form_validation->run() == FALSE){
            $response_message = array(
                "status" => false,
                "error" => $this->form_validation->error_array(),
                "message" => validation_errors()
            );
            //code 400
            $this->response($response_message, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            //Send user data
            $data = array(
                "username" => $this->post('username'),
                "password" => password_hash($this->post('password'), PASSWORD_DEFAULT),
                "full_name" => $this->post('full_name'),
                "wishlist_name" => $this->post('wishlist_name'),
                "wishlist_description" => $this->post('wishlist_description')
            );

            $response_output = $this->User_Model->sign_up($data);

            if ($response_output["status"] == "User_exist") {
                $response_message = array(
                    "status" => "User_exist",
                    "message" => "User already exist."
                );
                //code 409
                $this->response($response_message, REST_Controller::HTTP_CONFLICT);
            } else {
                $response_message = array(
                    "status" => true,
                    "message" => "Account registered successfully"
                );
                //code 200
                $this->response($response_message, REST_Controller::HTTP_OK);
            }
        }
    }


    //Authentication login
    public function login_post(){

//        header("Access-Control-Allow-Origin: *");
        $this->form_validation->set_data([
            'username' => $this->post('username'),
            'password' => $this->post('password')
        ]);

        //Form validations
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $response_message = array(
                "status" => false,
                "error" => $this->form_validation->error_array(),
                "message" => validation_errors()
            );
            //code 400
            $this->response($response_message, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = array(
                "username" => $this->post('username'),
                "password" => $this->post('password')
            );
            $response_output = $this->User_Model->login($data);

            $status = $response_output["status"];
//            $data = $response_output["user_data"];

            if ($status == "Unregistered_user") {
                $response_message = array(
                    "status" => "Unregistered_user",
                    "message" => "User is not registered"
                );
                //code 401
                $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
            } elseif ($status == "Incorrect_password") {
                $response_message = array(
                    "status" => "Incorrect_password",
                    "message" => "Password incorrect"
                );
                //code 401
                $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
            } elseif ($status == "Login_successful") {

                // Load Authorization Token Library
                $this->load->library('Authorization_Token');

                // Generate Token
                $token_data['id'] = $response_output["user_data"]->id;
                $token_data['username'] = $response_output["user_data"]->username;
                $token_data['full_name'] = $response_output["user_data"]->full_name;
                $token_data['time'] = time();

                $user_token = $this->authorization_token->generateToken($token_data);

                $response_data = array(
                    'id' => $response_output["user_data"]->id,
                    'username' => $response_output["user_data"]->username,
                    'full_name' => $response_output["user_data"]->full_name,
                    'wishlist_name' => $response_output["user_data"]->wishlist_name,
                    'wishlist_description' => $response_output["user_data"]->wishlist_description,
                    'token' => $user_token,
                );
                $response_message = array(
                    "status" => true,
                    "message" => "User login successful",
                    "data" => $response_data
                );
                //code 200
                $this->response($response_message, REST_Controller::HTTP_OK);
            }
        }
    }


    public function user_get($id){
        $response_output = $this->User_Model->getUser($id);

        if($response_output) {
            $response_message = array(
                "status" => true,
                "message" => "User data successfully gathered",
                "data" => $response_output
            );
            //code 200
            $this->response($response_message, REST_Controller::HTTP_OK);
        } else {
            $response_message = array(
                "status" => FALSE,
                "message" => "Error getting user data!!"
            );
            //code 500
            $this->response($response_message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}