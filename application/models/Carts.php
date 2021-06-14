<?php

class Carts extends CI_Model
{
    public function add($user_id, $product_id, $shop_id, $quantity)
    {
        $check_cart = $this->check($user_id, $product_id);
        if ($check_cart) {
            $q = "UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$product_id ";
            $query = $this->db->query($q);
            return $query;
        } else {
            $q = "INSERT INTO `cart` ( `user_id`, `product_id`, `shop_id`, `quantity`, `created_at`, `last_updated_at`) VALUES ( '$user_id', '$product_id', '$shop_id', '$quantity', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
            $this->db->query($q);
            return $this->db->insert_id();
        }
    }

    public function check($user_id, $product_id)
    {
        $q = "SELECT cart_id from cart where user_id=$user_id AND product_id=$product_id";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function data($user_id)
    {
        $q = "SELECT * from cart where user_id=$user_id";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function decCart($user_id, $product_id)
    {
        $q = "UPDATE cart SET quantity = quantity - 1 WHERE user_id=$user_id AND product_id=$product_id ";
        $query = $this->db->query($q);
        return $query;
    }

    public function removeItem($user_id, $product_id)
    {
        $q = "DELETE FROM `cart` WHERE `cart`.`user_id` = $user_id AND `cart`.`product_id`=$product_id;";
        $query = $this->db->query($q);
        return $query;
    }
    
    public function for_checkout($product_id, $user_id)
    {
        $q = "SELECT * from cart where product_id=$product_id and user_id=$user_id";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }
    
}
