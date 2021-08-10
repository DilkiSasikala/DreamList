<?php

class Priority_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //Get priorities
    public function get_priority() {
        $query = $this->db->get("priority");
        return $query->result_array();
    }

//    //Get one priority
//    public function get_onepriority($id){
//        $this->db->select('priority_type');
//        $this->db->from('priority');
//        $this->db->where('id', $id);
////        $query = $this->db->get_where("wish_category", array("id" => $id));
////        return $query->result();
//        return $this->db->get()->row()->priority_type;
//    }
}
