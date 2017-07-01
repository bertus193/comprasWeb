<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Portal extends CI_Controller
{
    public function index()
    {
        $app = $this->load->model('app');

        $this->load->helper('url');

        $data['app'] = $app;
        $this->load->view('index', $data);
    }
}
