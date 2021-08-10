<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class WishCategory extends \Restserver\Libraries\REST_Controller {

    //Constructor
    public function __construct()
    {
        parent::__construct();
        //Load user model
        $this->load->model('WishCategory_Model');
    }

    //Get all wish categories
    public function category_get(){

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        $valid_token = $this->authorization_token->validateToken();

        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {
            $category = $this->WishCategory_Model->get_wishcategory();
            //code 200
            $this->response($category, REST_Controller::HTTP_OK);
        } else {
            $response_message = array(
                "status" => FALSE,
                "message" => "Error receiving wish category list"
            );
            //code 401
            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
//
//    public function oneCategory_get($id){
//        // Load Authorization Token Library
//        $this->load->library('Authorization_Token');
//
//        $valid_token = $this->authorization_token->validateToken();
//
//        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {
//            $category = $this->WishCategory_Model->get_onecategory($id);
//            //code 200
//            $this->response($category, REST_Controller::HTTP_OK);
//        } else {
//            $response_message = array(
//                "status" => FALSE,
//                "message" => "Error receiving wish category"
//            );
//            //code 401
//            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
//        }
//
//    }


}