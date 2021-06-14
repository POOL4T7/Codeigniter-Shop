<?php

class Seller extends CI_Controller
{
    public function __construct()
    {
        parent::get_instance();
        parent::__construct();
        $this->load->helper('htmlpurifier');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->helper('url', 'text', 'form', 'file', 'html');
        if (!$this->session->userdata('id')) {
            redirect('/credentials/login');
        }
        $this->load->model('Shop');
    }

    public function shop($shop_id = NULL)
    {
        $data = new stdClass();
        $data->update_mode = false;
        $user_id = $this->session->userdata('id');
        $seller_id = $this->Shop->seller_id($user_id)[0]->id;
        if ($shop_id) {
            $shop = $this->Shop->getShopById($shop_id, $seller_id);
            if ($shop) {
                $data->details = $this->Shop->getShopById($shop_id, $seller_id);
                $data->update_mode = TRUE;
            }
        }
        $this->template->load('default_layout', 'content', 'Shop/shop', $data);
    }

    public function add_shop()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $user_id = $this->session->userdata('id');
            $seller_id = $this->Shop->seller_id($user_id)[0]->id;
            $already = $this->Shop->already($seller_id);
            if ($already) {
                $data->status = false;
                $data->title = 'Already registred';
                $data->message = "One shopkeeper can add only one shop";
            } else {
                $name = $this->input->post('name');
                $location = $this->input->post('location');
                $type = $this->input->post('type');
                $description = $this->input->post('description');
                $add_shop = $this->Shop->addshop($seller_id, $name, $location, $type, $description);
                if ($add_shop) {
                    $session_data = $add_shop;
                    $this->session->set_userdata('shop_id', $session_data);
                    $data->status = TRUE;
                    $data->message = "Shop added successfully";
                    $data->page = "/seller/shop";
                } else {
                    $data->status = false;
                    $data->message = "Something went wrong";
                }
            }
        }
        echo json_encode($data);
    }

    public function update_shop()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $name = $this->input->post('name');
            $location = $this->input->post('location');
            $type = $this->input->post('type');
            $description = $this->input->post('description');
            $uploaded_image = $this->input->post('uploaded_image');
            $user_id = $this->session->userdata('id');
            $email = $this->session->userdata('email');
            $seller_id = $this->Shop->seller_id($user_id)[0]->id;
            $image_path = $this->image($email, $data, $uploaded_image);
            $add_shop = $this->Shop->updateShopById($seller_id, $name, $location, $type, $description, $image_path);
            if ($add_shop) {
                $data->status = TRUE;
                $data->message = "Shop updated successfully";
            } else {
                $data->status = false;
                $data->message = "Something went wrong";
            }
        }
        echo json_encode($data);
    }

    private function image($email, $data, $uploaded_image): string
    {
        $file_name = explode('@', $email);
        $image = $file_name[0];
        $data = new stdClass();
        $image_path = '';
        $config['upload_path'] = './static/images/shops';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $image;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image')) {
            $data->status = FALSE;
            $data->message = $this->upload->display_errors();
            echo $this->upload->display_errors();
        } else {
            $product = $this->upload->data();
            $image_path = $product['file_name'];
        }
        if ($image_path) {
            if ($uploaded_image) {
                unlink('static/images/shops/' . $uploaded_image);
            }
        }
        return $image_path;
    }
}
