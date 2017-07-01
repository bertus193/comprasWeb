<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NuevaOferta extends CI_Controller
{
    public function index()
    {
        $this->load->model('app');

        $this->load->helper('url');
        $this->load->database();

        $data['vista'] = $param1;
        $data['accion'] = $param2;
        $this->load->view('index', $data);
    }
}
