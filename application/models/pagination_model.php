<?php

Class Pagination_model extends CI_Model {
    function __construct() {
        $this->load->database();
    }

    public function get_pagination_data($current_page=1) {
        // 페이지 당 게시글 개수
        $per_board = 20;
        // 한번에 표시되는 최대 페이지
        $per_page = 5;
        // 총 게시글 수
        $total_board = $this->db->from("board")->count_all_results();
        // 총 페이지 개수
        $total_page = ceil($total_board/$per_board);
        
        if ($current_page < 1) {
            $current_page = 1;
        }
        if ($current_page > $total_page) {
            $current_page = $total_page;
        }

        // 페이지네이션 시작점
        $offset = ($current_page -1) * $per_board;
        // 현재 페이지 가져오기
        $sql = "SELECT * FROM board ORDER BY group_id DESC, group_order ASC LIMIT $offset,$per_board";
        $result = $this->db->query($sql)->result_array();

        
        $current_block = ceil($current_page / $per_page);
        $start_page = ($current_block - 1) * $per_page + 1;
        $end_page = min($start_page + $per_page - 1, $total_page);

        return [
            'total_board' => $total_board,
            'total_page' => $total_page,
            'current_page' => $current_page,
            'start_page' => $start_page,
            'end_page' => $end_page,
            'board_data' => $result
        ];
    }

}