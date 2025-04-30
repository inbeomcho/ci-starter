<?php

class Board extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("board_model");
        $this->load->helper("url_helper");
        
        // 게시판
        $route['board'] = 'Board/index';
        $route['board/(:num)'] = 'Board/view/$1';
    }

    // router대체
    public function index() {
        $segements = $this->uri->segment_array();

        $method = $segements[2] ?? null;
        $param = $segements[3] ?? null;

        echo $method, $param;

        if ($method == 'view') {
            $this->view($param);
        } elseif ($method == 'delete') {
            $this->delete($param);
        } elseif ($method == 'write') {
            $this->write($param);
        } elseif ($method == 'update') {
            $this->update($param);
        } else {
            $this->list();
        }
    }

    // 전체보기
    public function list() {
        $data['board'] = $this->board_model->get_boards();
        $data['title'] = "List";

        $this->load->view("templates/header", $data);
        $this->load->view("board/index", $data);
        $this->load->view("templates/footer", $data);
    }

    // 상세보기
    public function view($board_id) {
        $data['board'] = $this->board_model->get_board($board_id);
        $data['title'] = "Detail";
        
        $this->load->view("templates/header", $data);
        $this->load->view("board/view", $data);
        $this->load->view("templates/footer", $data);
    }

    // 삭제
    public function delete($board_id) {
        try {
            $this->board_model->delete_board($board_id);
            
            $this->output->
            set_status_header(200)->
            set_output(json_encode(['success' => true]));
        } catch (Exception $e) {
            $this->output->
            set_status_header(500)->
            set_output(json_encode(['error'=> $e->getMessage()]));
        }
    }
    
    // 작성
    public function write($board_id) {
        $data['board'] = $this->board_model->get_board($board_id);
        $data['title'] = "Write1";
        
        $this->load->view("templates/header", $data);
        $this->load->view("board/write", $data);
        $this->load->view("templates/footer", $data);
    }
    
    // 작성
    public function update($board_id) {
        $data['board'] = $this->board_model->get_board($board_id);
        $data['title'] = "List";
        
        $this->load->view("templates/header", $data);
        $this->load->view("board/view", $data);
        $this->load->view("templates/footer", $data);
    }
}