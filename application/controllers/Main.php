<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{
    // construct -> index
    // __init__
    public function __construct()
    {
        // super.__init__
        parent::__construct();
    }

    // Controller명을 uri에 입력했을 때 자동으로 실행시켜줌
    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('main');
        
        $this->load->view('templates/footer');
    }
}