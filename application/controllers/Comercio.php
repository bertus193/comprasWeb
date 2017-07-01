<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comercio extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        $this->load->helper('url');
        $this->load->helper('security');

        $this->data['app'] = $this->load->model('app');
    }


    // /index.php/comercio/index
    public function index()
    {
        $this->data['currentUrl'] = site_url(strtok(uri_string(), '/').'/');
        $this->data['view'] = "index";
        
        $this->load->view('index', $this->data);
    }

    // /index.php/comercio/nuevaOferta
    public function nuevaOferta()
    {
        $this->data['currentUrl'] = site_url(strtok(uri_string(), '/').'/');
        $this->data['view'] = "nuevaOferta";

        $this->load->view('index', $this->data);
    }

    public function ofertas()
    {
        $app = $this->load->model('app');
        $data['app'] = $app;
        $this->load->view('ofertas', $data);
    }
}
