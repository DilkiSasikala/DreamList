<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Priority extends \Restserver\Libraries\REST_Controller {

    //Constructor
    public function __construct()
    {
        parent::__construct();
        //Load user model
        $this->load->model('Priority_Model');
    }

    //Get all priorities
    public function priority_get(){

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        $valid_token = $this->authorization_token->validateToken();

        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {
            $priority = $this->Priority_Model->get_priority();
            //code 200
            $this->response($priority, REST_Controller::HTTP_OK);
        } else {
            $response_message = array(
                "status" => FALSE,
                "message" => "Error receiving priority list"
            );
            //code 401
            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }



//    public function onePriority_get($id){
//        // Load Authorization Token Library
//        $this->load->library('Authorization_Token');
//
//        $valid_token = $this->authorization_token->validateToken();
//
//        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {
//            $priority = $this->Priority_Model->get_onepriority($id);
//            //code 200
//            $this->response($priority, REST_Controller::HTTP_OK);
//        } else {
//            $response_message = array(
//                "status" => FALSE,
//                "message" => "Error receiving priority"
//            );
//            //code 401
//            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
//        }
//
//    }

}