<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comercio extends CI_Controller
{
    // /index.php/comercio/index
    public function index()
    {
        $app = $this->load->model('app');

        $this->load->helper('url');

        $data['app'] = $app;
        $data['currentUrl'] = site_url(strtok(uri_string(), '/').'/');
        $this->load->view('index', $data);
    }

    // /index.php/comercio/nuevaOferta
    public function nuevaOferta()
    {
        $app = $this->load->model('app');

        $this->load->helper('url');

        $data['app'] = $app;
        $data['currentUrl'] = site_url(strtok(uri_string(), '/').'/');

        $this->load->view('index', $data);
    }
}
