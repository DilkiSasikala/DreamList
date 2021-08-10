<?php

class User_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //Add user details
    public function sign_up($data){
        $output = array();
        $this->db->where('username', $data['username']);
        $response = $this->db->get('user');
        if ($response->num_rows() == 1) {
            $output["status"] = "User_exist";
        } else {
            $this->db->insert('user', $data);
            $output["status"] = "User_added";
            $output["user_id"] = $this->db->insert_id();
        }
        return $output;
    }

    //get login details
    public function login($data){
        $output = array();
        $this->db->where('username', $data['username']);
        $response = $this->db->get('user');
        if ($response->num_rows() != 1) {
            $output["status"] = "Unregistered_user";
        } else {
            $data_row = $response->row();
            $hash = $data_row->password;
            if (password_verify($data['password'], $hash)) {
                $output["status"] = "Login_successful";
                $output["user_data"] = $data_row;
            } else {
                $output["status"] = "Incorrect_password";
            }
        }
        return $output;
    }


    //Get user data
    public function getUser($id){
        $this->db->select('id, username, full_name, wishlist_name, wishlist_description');
        $this->db->where('id',$id);
        $query = $this->db->get('user');
        return $query->row();
    }

}