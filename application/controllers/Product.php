<?php

class Product extends CI_Controller
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
        $this->load->model('User');
        $this->load->model('Shop');
        $this->load->model('Items');
    }

    public function addProduct($id = NULL)
    {
        $data = new stdClass();
        $data->update_mode = false;
        if ($id) {
            $product = $this->Items->getOneById($id);
            if ($product) {
                $data->details = $this->Items->getOneById($id);
                $data->update_mode = true;
            }
        }
        $this->template->load('default_layout', 'content', 'tools/addproduct', $data);
    }

    public function save_product()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('avalibility', 'Avalibility', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $uploaded_image = $this->input->post('uploaded_image');
            $user_id = $this->session->userdata('id');
            $email = $this->session->userdata('email');
            $title = $this->input->post('title');
            $price = $this->input->post('price');
            $avalibility = $this->input->post('avalibility');
            $description = $this->input->post('description');
            $image_path = $this->image($email, $data, $uploaded_image);
            $add = $this->Items->add($user_id, $image_path, $title, $price, $avalibility, $description);
            if ($add) {
                $data->status = TRUE;
                $data->title = "Success";
                $data->message = "Product added successfully";
                $data->page = "/product/adminProduct";
            } else {
                $data->status = FALSE;
                $data->title = "Success";
                $data->message = "Something went wrong";
            }
        }
        echo json_encode($data);
    }


    public function adminProduct()
    {
        $data = new stdClass();
        $user_id = $this->session->userdata('id');
        $data->adminproducts = $this->Items->admin($user_id);
        $this->template->load('default_layout', 'content', 'tools/adminproduct', $data);
    }

    public function byone($id = NULL)
    {
        $data = new stdClass();
        $data->details = $this->Items->getOneById($id);
        $this->template->load('default_layout', 'content', 'tools/product', $data);
    }

    public function update()
    {
        $data = new stdClass();
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('avalibility', 'Avalibility', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $title = $this->input->post('title');
            $price = $this->input->post('price');
            $avalibility = $this->input->post('avalibility');
            $description = $this->input->post('description');
            $product_id = $this->input->post('id');
            $update = $this->Items->updateById($product_id, $title, $price, $avalibility, $description);
            if ($update) {
                $data->status = TRUE;
                $data->title = "Success";
                $data->message = "Product updated successfully";
                $data->page = "/product/addproduct/$product_id";
            } else {
                $data->status = FALSE;
                $data->title = "Success";
                $data->message = "Something went wrong";
            }
        }
        echo json_encode($data);
    }

    public function delete($product_id = NULL)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata('id');
        $is_product = $this->Items->validate_product($product_id, $user_id);
        $uploaded_image = $this->input->post('uploaded_image');
        if ($is_product) {
            $delete = $this->Items->delete($product_id, $user_id);
            if ($delete) {
                if ($uploaded_image) {
                    unlink('static/images/products/' . $uploaded_image);
                }
                $data->status = 2;
                $data->title = "Confirmation";
                $data->message = "Are you sure, To deleto that product";
                $data->page = "/product/adminProduct";
            } else {
                $data->status = FALSE;
                $data->title = "Success";
                $data->message = "Something went wrong";
            }
        } else {
            $data->status = FALSE;
            $data->title = "Info";
            $data->message = "Listen pussy cat, yahi patak ke chod dege Nikal maderchod";
        }
        echo json_encode($data);
    }

    private function image($email, $data, $uploaded_image): string
    {
        $file_name = explode('@', $email);
        $image = $file_name[0];
        $image_path = '';
        $config['upload_path'] = './static/images/products';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $image;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image')) {
            $data->status = FALSE;
            $data->message = $this->upload->display_errors();
        } else {
            $product = $this->upload->data();
            $image_path = $product['file_name'];
        }
        if ($image_path) {
            if ($uploaded_image) {
                unlink('static/images/products/' . $uploaded_image);
            }
        }
        return $image_path;
    }
}
