<?php

class Shop extends CI_Model
{
    public function already($seller_id)
    {
        $q = "SELECT * FROM shop WHERE seller_id='$seller_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function addshop($seller_id, $name, $location, $type, $description)
    {
        $q = "INSERT INTO `shop`(`seller_id`,`shop_name`, `location`,`type`, `description`) VALUES( '$seller_id', '$name', '$location', '$type', '$description')";
        $this->db->query($q);
        return $this->db->insert_id();
    }

    public function seller_id($user_id)
    {
        $q = "SELECT id from `seller` WHERE user_id='$user_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }
    public function shop_id($seller_id)
    {
        $q = "SELECT id from `shop` WHERE seller_id='$seller_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function getShopBySeller_id($seller_id)
    {
        $q = "SELECT * from `shop` where seller_id= '$seller_id' ";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function getShopById($shop_id, $seller_id)
    {
        $q = "SELECT * from `shop` where id= '$shop_id' AND seller_id='$seller_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function updateShopById($seller_id, $name, $location, $type, $description, $image_path)
    {
        $q = "UPDATE `shop` SET `shop_name`='$name', `location`='$location', `type`='$type', `description`='$description' ,`shop_image`='$image_path'  WHERE  `seller_id`='$seller_id'";
        $query = $this->db->query($q);
        return $query;
    }
    public function getsellerByProductid($product_id)
    {
        $q = "SELECT user_id from `products` where product_id= '$product_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result[0]->user_id;
    }
}
