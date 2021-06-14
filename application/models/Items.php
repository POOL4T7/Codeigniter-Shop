<?php

class Items extends CI_Model
{
    public function add($user_id, $image_path, $title, $price, $avalibility, $description)
    {
        $q = "INSERT into `products`(`user_id`, `title`, `image_path`, `price`, `avalibility`, `description`) VALUES('$user_id', '$title', '$image_path', '$price', '$avalibility', '$description') ";
        $this->db->query($q);
        return true;
    }

    public function admin($user_id)
    {
        $q = "SELECT * from `products` WHERE user_id=$user_id";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function allproducts()
    {
        $q = "SELECT * from `products`";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function getOneById($id)
    {
        $q = "SELECT * from `products` WHERE product_id='$id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function updateById($product_id, $title, $price, $avalibility, $description)
    {
        $q = "UPDATE `products` SET title='$title', price='$price', avalibility='$avalibility', description='$description' WHERE product_id='$product_id' ";
        $query = $this->db->query($q);
        return $query;
    }

    public function delete($product_id, $user_id)
    {
        $q = "DELETE FROM `products` WHERE product_id='$product_id' AND user_id='$user_id'";
        $query = $this->db->query($q);
        return $query;
    }

    public function validate_product($product_id, $user_id)
    {
        $q = "SELECT * from `products` WHERE user_id='$user_id' AND product_id='$product_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function  count_all()
    {
        $query = $this->db->get("products");
        return $query->num_rows();
    }

    public function get_products($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('products');
        if ($search) {
            $keyword = $search['keyword'];
            if ($keyword) {
                $this->db->where("title LIKE '%$keyword%'");
            }
        }
        if ($count) {
            return $this->db->count_all_results();
        } else {
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            }
        }
        return array();
    }
}
