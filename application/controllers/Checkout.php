<?php

use phpDocumentor\Reflection\PseudoTypes\True_;

class Checkout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('htmlpurifier');
        if (!$this->session->userdata('id')) {
            redirect('/credentials/login');
        }
        $this->load->library('form_validation');
        $this->load->model('items');
        $this->load->model('carts');
        $this->load->model('shop');
        $this->load->model('User');
        $this->load->model('order');
        $this->load->library('cart');
    }

    public function confirmation($id = null)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $email = $this->session->userdata("email");
        $product_from_cart = $this->carts->for_checkout($id, $user_id)[0];
        $data->repeat = false;
        $product = $this->items->getOneById($id)[0];
        $user = $this->User->profile_data($email);
        $data->products = $product_from_cart;
        $data->product = $product;
        $data->user = $user[0];
        $role = $this->session->userdata("role");
        if ($role == "buyer") {
            $data->profile = $this->User->buyer_data($user_id)[0];
        } else if ($role == "seller") {
            $data->profile = $this->User->seller_data($user_id)[0];
        }
        $this->template->load('default_layout', 'content', 'checkout/placeorder', $data);
    }

    public function placeorder($product_id = NUll)
    {
        $data = new stdClass();
        $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile Name', 'required|numeric|exact_length[10]');
        if ($this->form_validation->run() == FALSE) {
            $data->status = FALSE;
            $data->title = "validation error";
            $data->message = validation_errors();
        } else {
            $user_id = $this->session->userdata('id');
            $total = $this->input->post('total');
            $order_placed = $this->order->place_order($user_id, $product_id, $total);
            if ($order_placed) {
                $empty_cart = $this->carts->removeItem($user_id, $product_id);
                if ($empty_cart) {
                    $data->status = true;
                    $data->message = "Order Placed Successfully";
                    $data->page = "/";
                } else {
                    $data->status = false;
                    $data->message = "Order is not Placed, Please try after some time.. ";
                }
            } else {
                $data->status = false;
                $data->message = "Something went wrong";
            }
        }
        echo json_encode($data);
    }

    public function orders()
    {
        $data = new stdClass();
        $user_id = $this->session->userdata('id');
        $data->items = $this->order->findAll($user_id);
        $product = array();
        $i = 0;
        foreach ($data->items as $data->item) {
            $product[$i] = $this->items->getOneById($data->items[$i]->product_id);
            $i = $i + 1;
        }
        $data->products = $product;
        $this->template->load('default_layout', 'content', 'checkout/orders', $data);
    }

    public function repeat_product($id = null)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $email = $this->session->userdata("email");
        $data->product = $this->items->getOneById($id)[0];
        $user = $this->User->profile_data($email);
        $data->user = $user[0];
        $role = $this->session->userdata("role");
        $data->repeat = true;
        if ($role == "buyer") {
            $data->profile = $this->User->buyer_data($user_id)[0];
        } else if ($role == "seller") {
            $data->profile = $this->User->seller_data($user_id)[0];
        }
        $this->template->load('default_layout', 'content', 'checkout/placeorder', $data);
    }

    public function cancel($id = null)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $cancellled = $this->order->cancel_order($user_id, $id);
        if ($cancellled) {
            $data->status = true;
            $data->message = "Your order is cancelled";
            $data->page  = '/checkout/orders';
        } else {
            $data->status = false;
            $data->message = "Something went wrong";
            $data->page  = '/checkout/orders';
        }
        echo json_encode($data);
    }
}
