<?php

Class Board_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // 전체 불러오기
    public function get_boards($board_id=0) {
        $sql = "
            WITH RECURSIVE board_tree AS (
                SELECT 
                    board_id,
                    board_title,
                    board_content,
                    owner_board_id,
                    board_depth,
                    parent_id,
                    CAST(board_id AS CHAR(100)) AS path
                FROM board
                WHERE board_id = owner_board_id

                UNION ALL

                SELECT 
                    b.board_id,
                    b.board_title,
                    b.board_content,
                    b.owner_board_id,
                    b.board_depth,
                    b.parent_id,
                    CONCAT(bt.path, '-', b.board_id) AS path
                FROM board b
                JOIN board_tree bt ON b.parent_id = bt.board_id
            )
            SELECT * FROM board_tree
            ORDER BY path;
        ";

        return $this->db->query($sql)->result_array();
    }
    
    // 상세불러오기
    public function get_board($board_id=0) {
        $data = $this->db->get_where("board", array('board_id'=> $board_id));

        return $data->row_array();
    }

    // 삭제
    public function delete_board($board_id) {
        $set = array('board_title'=>'', 'board_content' => '');
        $where = array('board_id'=>$board_id);
        return $this->db->update('board', $set,$where);
    }
}
