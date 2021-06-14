<?php

class User extends CI_Model
{
    function save_signup($oauth_provider, $gender, $password, $first_name, $last_name, $email, $type, $mobile, $image_path )
    {
        $user = $this->check($email);
        $result = NULL;
        if ($user) {
            return false;
        } else {
            $query = "INSERT INTO `users`(`oauth_provider`,`password`,`type`,`email`) VALUES ('$oauth_provider', '$password', '$type', '$email')";
            $this->db->query($query);
            $user_id = $this->db->insert_id();
            if ($user_id) {
                if ($type == "seller") {
                    $result = $this->create_seller($user_id, $gender, $first_name, $last_name, $mobile, $image_path );
                } else if ($type == "buyer") {
                    $result = $this->create_buyer($user_id, $gender, $first_name, $last_name, $mobile, $image_path );
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        if ($result) {
            return $result;
        } else {
            //delete the user from users table;
            return false;
        }
    }

    private function create_seller($user_id, $gender, $first_name, $last_name, $mobile, $image)
    {
        $q = "INSERT INTO `seller`(`user_id`,`gender`,`first_name`,`last_name`,`mobile`,`profile_image`) VALUES ('$user_id','$gender','$first_name','$last_name','$mobile','$image')";
        $this->db->query($q);
        return $this->db->insert_id();
    }
    
    private function create_buyer($user_id, $gender, $first_name, $last_name, $mobile, $image)
    {
        $q = "INSERT INTO `buyer`(`user_id`,`gender`,`first_name`,`last_name`,`mobile`,`profile_image`) VALUES ('$user_id','$gender','$first_name','$last_name','$mobile','$image')";
        $this->db->query($q);
        return $this->db->insert_id();
    }

    function check($email)
    {
        $q = "select * from users where email='$email'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    function check_credentials($email, $password)
    {
        $q = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    function get_id($email)
    {
        $q = "SELECT id from users where email='$email'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    function get_role($email)
    {
        $q = "SELECT type from users where email='$email'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }
//   profile data 
    function profile_data($email)
    {
        $q = "SELECT * from users where email= '$email' ";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function seller_data($user_id)
    {
        $q = "SELECT * FROM seller where user_id='$user_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    public function buyer_data($user_id)
    {
        $q = "SELECT * FROM buyer where user_id='$user_id'";
        $query = $this->db->query($q);
        $result = $query->result();
        return $result;
    }

    function update_seller_profile($first_name, $last_name, $gender, $mobile, $user_id, $image_path)
    {
        $q = "UPDATE seller SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', mobile='$mobile'  WHERE user_id='$user_id' ";
        $query = $this->db->query($q);
        return $query;
    }

    function update_buyer_profile($first_name, $last_name, $gender, $mobile, $user_id, $image_path)
    {
        $q = "UPDATE buyer SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', mobile='$mobile'  WHERE user_id='$user_id' ";
        $query = $this->db->query($q);
        return $query;
    }
}
