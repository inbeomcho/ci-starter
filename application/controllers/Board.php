<?php

class Board extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("board_model");
        $this->load->model("pagination_model");
        $this->load->helper("url_helper");
    }

    // router대체
    public function index() {
        $segements = $this->uri->segment_array();

        $method = $segements[2] ?? null;

        if ($method == 'view') {
            $this->view($method);
        } elseif ($method == 'delete') {
            $this->delete($method);
        } elseif ($method == 'write') {
            $this->write($method);
        } elseif ($method == 'update') {
            $this->update($method);
        } elseif ($method == '') {
            $this->list();
        } else {
            show_404();
        }
    }

    // 전체보기
    public function list() {
        $this->url_changer();
        $this->check_request_method(['GET']);

        $data['board'] = $this->board_model->get_boards();
        $data['title'] = "List";

        $current_page = $this->input->get('p', TRUE) ?: 1;
        $data['pagination'] = $this->pagination_model->get_pagination_data($current_page);

        $this->load->view("templates/header", $data);
        $this->load->view("board/index", $data);
        $this->load->view("templates/footer", $data);
    }

    // 상세보기
    public function view($board_id=null) {
        $this->check_request_method(['GET']);
        $this->check_int_param($board_id);

        $data['board'] = $this->board_model->get_board($board_id);
        $data['title'] = "Detail";
        
        $this->check_null_pointer($data['board']);
        $this->check_deleted_board($data['board']['board_title']);
        
        $this->load->view("templates/header", $data);
        $this->load->view("board/view", $data);
        $this->load->view("templates/footer", $data);
    }

    // 삭제
    public function delete() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $board_id = $data['board_id'] ?? null;

        $this->check_request_method(['POST']);
        $this->check_int_param($board_id);
        
        $this->board_model->delete_board($board_id);
    }
    
    // 작성
    public function write($parent_id=0) {
        // 누른 게시글의 board_id가 parent_id로 작동함
        $this->check_request_method(['POST','GET']);
        $this->check_int_param($parent_id);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['board'] = $this->board_model->get_board($parent_id);
            $data['title'] = $parent_id==0?'Write' : 'Reply';
            $data['isReply'] = $parent_id==0?false : true;
            
            if ($data['isReply']) {
                $this->check_null_pointer($data['board']);
                $this->check_deleted_board($data['board']['board_title']);
            }
            
            $this->load->view("templates/header", $data);
            $this->load->view("board/write", $data);
            $this->load->view("templates/footer", $data);   
        } elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $this->board_model->write_board($data['board_title'], $data['board_content'], $data['parent_id']);
        }
    }
    
    // 수정
    public function update($board_id=null) {
        $this->check_request_method(['PATCH', 'GET']);
        $this->check_int_param($board_id);
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data['board'] = $this->board_model->get_board($board_id);
            $data['title'] = 'Update';

            $this->check_null_pointer($data['board']);
            $this->check_deleted_board($data['board']['board_title']);

            $this->load->view("templates/header", $data);
            $this->load->view("board/update", $data);
            $this->load->view("templates/footer", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $this->board_model->update_board($data);
        }
    }


    // 기능 메서드
    private function url_changer() {
        if (!$this->input->get('p')) {
            redirect(base_url('board'). '?p=1');
            return;
        }
    }
    private function check_request_method($method) {
        if (!in_array($_SERVER['REQUEST_METHOD'], $method)) {
            show_error('잘못된 접근 방식', 405);
        }
    }
    
    private function check_int_param($param) {
        if (!is_numeric($param)) {
            show_error('잘못된 접근 방식', 405);
        }
    }
    
    private function check_null_pointer($data) {
        if (!$data) {
            show_error('잘못된 접근 방식', 405);
        }
    }
    
    private function check_deleted_board($data) {
        // soft delete 게시물 접속 차단
        if (!$data) {
            show_error('잘못된 접근 방식', 405);
        }
    }
}