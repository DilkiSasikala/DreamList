<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Wishlist extends \Restserver\Libraries\REST_Controller {

    //Constructor
    public function __construct()
    {
        parent::__construct();
        //Load user model
        $this->load->model('User_Model');
        $this->load->model('Wishlist_Model');
    }

    //Get wish list
    public function wishlist_get($user_id) {

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        $valid_token = $this->authorization_token->validateToken();

        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {
            if(empty($user_id) OR is_null($user_id)) {
                $response_message = array(
                    "status" => FALSE,
                    "message" => "Invalid user id"
                );
                //code 401
                $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
            } else {
                $wishlist = $this->Wishlist_Model->get_wishlist($user_id);
                if ($wishlist) {
                    //code 200
                    $this->response($wishlist, REST_Controller::HTTP_OK);
                } else {
                    $response_message = array(
                        "status" => "No wishlist"
                    );
                    //code 404
                    $this->response($response_message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            $response_message = array(
                "status" => FALSE,
                "message" => "Error receiving wish category list"
            );
            //code 401
            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    //Add wishlist
    public function wishlist_post() {

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        $valid_token = $this->authorization_token->validateToken();

        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {

            $this->form_validation->set_data([
                'item_name' => $this->post('item_name'),
                'item_url' => $this->post('item_url'),
                'price' => $this->post('price')
            ]);

            //Form validations
            $this->form_validation->set_rules('item_name', 'Item', 'trim|required');
            $this->form_validation->set_rules('item_url', 'Url', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');

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
                    "user_id" => $this->post("user_id"),
                    "wish_category_id" => $this->post("wish_category_id"),
                    "priority_id" => $this->post("priority_id"),
                    "item_name" => $this->post("item_name"),
                    "item_url" => $this->post("item_url"),
                    "price" => $this->post("price")
                );
                $response_output = $this->Wishlist_Model->add_wishlist($data);
                if($response_output) {
                    $response_message = array(
                        "status" => true,
                        "message" => "Wish list added successfully",
                        "id" => $response_output
                    );
                    //code 200
                    $this->response($response_message, REST_Controller::HTTP_OK);
                } else {
                    $response_message = array(
                        "status" => FALSE,
                        "message" => "Error!! Wish list not created"
                    );
                    //code 500
                    $this->response($response_message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

        } else {
            $response_message = array(
                "status" => FALSE,
                "message" => "You are not authorised to add wishlist"
            );
            //code 401
            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }



    //Edit wish list
    public function updateList_put() {

        // Load Authorization Token Library
        $this->load->library('Authorization_Token');

        $valid_token = $this->authorization_token->validateToken();

        if ($valid_token['status'] === TRUE AND !empty($valid_token)) {

            $this->form_validation->set_data([
                'item_name' => $this->put('item_name'),
                'item_url' => $this->put('item_url'),
                'price' => $this->put('price')
            ]);

//            echo $this->input->method();
            //Form validations
            $this->form_validation->set_rules('item_name', 'Item', 'required');
            $this->form_validation->set_rules('item_url', 'Url', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');

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
                    "id" => $this->put('id'),
                    "user_id" => $this->put("user_id"),
                    "wish_category_id" => $this->put("wish_category_id"),
                    "priority_id" => $this->put("priority_id"),
                    "item_name" => $this->put("item_name"),
                    "item_url" => $this->put("item_url"),
                    "price" => $this->put("price")
                );

                $response_output = $this->Wishlist_Model->update_wishlist($data);
//                $this->Wishlist_Model->update_wishlist($data);

                if($response_output) {
                    $response_message = array(
                        "status" => true,
                        "message" => "Wish list edited successfully"
                    );
                    //code 200
                    $this->response($response_message, REST_Controller::HTTP_OK);
                } else {
                    $response_message = array(
                        "status" => FALSE,
                        "message" => "Error!! Wish list not edited"
                    );
                    //code 500
                    $this->response($response_message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                }

            }

        } else {
            $response_message = array(
                "status" => FALSE,
                "message" => "You are not authorised to add wishlist"
            );
            //code 401
            $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
        }


    }

    //Delete wishlist
    public function deleteList_delete($id) {

            // Load Authorization Token Library
            $this->load->library('Authorization_Token');

            $valid_token = $this->authorization_token->validateToken();

            if ($valid_token['status'] === TRUE AND !empty($valid_token)) {

                if(empty($id) OR is_null($id)) {
                    $response_message = array(
                        "status" => FALSE,
                        "message" => "Invalid id"
                    );
                    //code 401
                    $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
                } else{
//                    $response_output = $this->Wishlist_Model->delete_wishlist($id);
                    $this->Wishlist_Model->delete_wishlist($id);
//                    echo $this->input->method();
//                    if(!empty($response_output) AND $response_output > 0) {
                        $response_message = array(
                            "status" => true,
                            "message" => "Wish list deleted successfully"
                        );
                        //code 200
                        $this->response($response_message, REST_Controller::HTTP_OK);
//                    } else {
//                        $response_message = array(
//                            "status" => FALSE,
//                            "message" => "Error!! Wish list not deleted"
//                        );
//                        //code 500
//                        $this->response($response_message, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
//                    }

                }
            } else {
                $response_message = array(
                    "status" => FALSE,
                    "message" => "You are not authorised to delete wishlist"
                );
                //code 401
                $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
            }

    }

    //Get wish list for sharing
    public function shareList_get($user_id) {

            if(empty($user_id) OR is_null($user_id)) {
                $response_message = array(
                    "status" => FALSE,
                    "message" => "There's no user available!"
                );
                //code 401
                $this->response($response_message, REST_Controller::HTTP_UNAUTHORIZED);
            } else {
                $wishlist = $this->Wishlist_Model->get_wishlist($user_id);
                if ($wishlist) {
                    //code 200
                    $this->response($wishlist, REST_Controller::HTTP_OK);
                } else {
                    $response_message = array(
                        "status" => "No wishlist"
                    );
                    //code 404
                    $this->response($response_message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
    }


}