<?php

class Wishlist_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //Add items to wish list
    public function add_wishlist(array $data) {
        $this->db->insert("wish_list", $data);
        return $this->db->insert_id();
    }

    //Get all wishlist items
    public function get_wishlist($user_id) {
       $query = $this->db->get_where("wish_list", array("user_id" => $user_id));
       return $query->result_array();
    }

    //Update wishlist
    public function update_wishlist(array $data) {
//        $this->db->where("id", $data["id"], "user_id", $data["user_id"]);
//        $this->db->update('wish_list', $data, array('id' => $data["id"], "user_id", $data["user_id"]));
//        return $query->result();

        $query = $this->db->get_where("wish_list", [
            'id' => $data['id'],
            'user_id' => $data['user_id'],
        ]);

        if ($this->db->affected_rows() > 0) {
            $update_data = [
                "wish_category_id" => $data["wish_category_id"],
                "priority_id" => $data["priority_id"],
                'item_name' =>  $data['item_name'],
                'item_url' =>  $data['item_url'],
                'price' =>  $data['price'],
            ];

            return $this->db->update("wish_list", $update_data, ['id' => $query->row('id')]);
        }
        return false;
    }

    //Delete wishlist
    public function delete_wishlist($id) {
        $this->db->delete('wish_list', array('id' => $id));
//        $query = $this->db->get_where("wish_list", $id);
//
//        if ($query->num_rows() > 0) {
//           return $this->db->delete('wish_list', $id);
//        }
//        return false;
    }

}