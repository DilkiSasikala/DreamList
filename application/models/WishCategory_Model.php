<?php

class WishCategory_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //Get categories
    public function get_wishcategory() {
        $query = $this->db->get("wish_category");
        return $query->result_array();
    }

//    //Get one category
//    public function get_onecategory($id){
//        $this->db->select('category_type');
//        $this->db->from('wish_category');
//        $this->db->where('id', $id);
////        $query = $this->db->get_where("wish_category", array("id" => $id));
////        return $query->result();
//        return $this->db->get()->row()->category_type;
//    }


}