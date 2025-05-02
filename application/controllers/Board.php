<?php

class Board extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("board_model");
        $this->load->helper("url_helper");
    }

    // router대체
    public function index() {
        $segements = $this->uri->segment_array();

        $method = $segements[2] ?? null;
        $param = $segements[3] ?? null;

        // echo $method, $param;

        if ($method == 'view') {
            $this->view($param);
        } elseif ($method == 'delete') {
            $this->delete($param);
        } elseif ($method == 'write') {
            $this->write($param);
        } elseif ($method == 'update') {
            $this->update($param);
        } elseif ($method == '') {
            $this->list();
        } else {
            show_404();
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
        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            show_error('잘못된 접근 방식', 405);
            return;
        }
        
        try {
            $this->board_model->delete_board($board_id);
            
            $this->output
            ->set_status_header(200)
            ->set_output(json_encode(['success' => true]));
        } catch (Exception $e) {
            $this->output
            ->set_status_header(500)
            ->set_output(json_encode(['error'=> $e->getMessage()]));
        }
    }
    
    // 작성
    public function write($parent_id=0) {
        // 페이지 로드
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data['board'] = $this->board_model->get_board($parent_id);
            $data['title'] = $parent_id==0?'Write' : 'Reply';
            
            $this->load->view("templates/header", $data);
            $this->load->view("board/write", $data);
            $this->load->view("templates/footer", $data);   
        }

        // api 요청 처리
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $this->board_model->write_board($data['board_title'], $data['board_content'], $data['board_id']);
        }
    }
    
    public function update($board_id=0) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data['board'] = $this->board_model->get_board($board_id);
            $data['title'] = 'Update';

            $this->load->view("templates/header", $data);
            $this->load->view("board/update", $data);
            $this->load->view("templates/footer", $data);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $this->board_model->update_board($data);
        }
    }
}