<?php

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('htmlpurifier');
        if (!$this->session->userdata('id')) {
            redirect('/credentials/login');
        }
        $this->load->model('items');
        $this->load->model('carts');
        $this->load->model('shop');
        $this->load->library('cart');
    }

    public function index()
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $data->items = $this->carts->data($user_id);
        $product = array();
        $i = 0;
        foreach ($data->items as $data->item) {
            $product[$i] = $this->items->getOneById($data->items[$i]->product_id);
            $i = $i + 1;
        }
        $data->products = $product;
        $this->template->load('default_layout', 'content', 'cart/Cart', $data);
    }

    public function addToCart($id)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $product_seller_id = $this->shop->getsellerByProductid($id);
        $seller_id = $this->shop->seller_id($product_seller_id)[0]->id;
        $shop_id = $this->shop->shop_id($seller_id)[0]->id;
        $product_added = $this->carts->add($user_id, $id, $shop_id, 1);
        if ($product_added) {
            return 1;
        } else {
            return 0;
        }
    }

    public function decCart($id)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $product_added = $this->carts->decCart($user_id, $id);
        if ($product_added) {
            echo "Cart quantity decreased by 1";
        } else {
            echo 0;
        }
    }

    public function remove($id)
    {
        $data = new stdClass();
        $user_id = $this->session->userdata("id");
        $removed = $this->carts->removeItem($user_id, $id);
        if ($removed) {
            echo "Item is removed from cart *from controller*";
        } else {
            echo 0;
        }
    }
}
