<?php

class Order extends CI_Model
{
    public function place_order($user_id, $product_id, $total)
    {
        $q = "INSERT into `orders`( `user_id`, `product_id`,`grand_total`,`status`) VALUES ('$user_id','$product_id','$total','placed')";
        $this->db->query($q);
        return $this->db->insert_id();
    }
    public function findAll($user_id)
    {
        $q = "SELECT * from `orders` where user_id='$user_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function cancel_order($user_id, $product_id)
    {
        $q = "UPDATE `orders` SET status='cancelled' where user_id='$user_id' AND product_id='$product_id'";
        $query = $this->db->query($q);
        return $query;
        
    }
}
