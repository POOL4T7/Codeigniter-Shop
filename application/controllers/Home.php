<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('htmlpurifier');
		$this->load->helper('browser_Helper');
		$this->load->library('session');
		$this->load->model('User');
		$this->load->model('items');
		$this->load->model('shop');
	}

	public function index()
	{
		$data['title'] = "Products";
		$this->template->load('default_layout', 'content', 'home/pagination', $data);
	}

	public function index_ajax($offset = null)
	{
		$search = array(
			'keyword' => trim($this->input->post('search_key')),
		);

		$this->load->library('pagination');
		$limit = 30;
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$config['base_url'] = site_url();
		$config['total_rows'] = $this->items->get_products($limit, $offset, $search, $count = true);
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="" class="current_page">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$this->pagination->initialize($config);

		$data['products'] = $this->items->get_products($limit, $offset, $search, $count = false);
		$data['counts'] = $this->items->count_all();
		$data['offset'] = $data['counts'] / 10;
		$data['pagelinks'] = $this->pagination->create_links();
		$this->load->view('home/ajax', $data);
	}

	public function about()
	{
		$data = array();
		$this->load->library('map');
		$config['center'] = '29.927831, 78.139401';
		$config['zoom'] = '15';
		$this->map->initialize($config);
		$marker = array();
		$marker['position'] = '29.927831, 78.139401';
		$this->map->add_marker($marker);
		$data['map'] = $this->map->create_map();
		$this->template->load('default_layout', 'content', 'about', $data);
	}
}
