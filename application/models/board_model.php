    <?php

Class Board_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // 전체 불러오기
    public function get_boards() {
        $sql = "select * from board order by group_id desc, group_order;";
        return $this->db->query($sql)->result_array();
    }
    
    // 상세불러오기
    public function get_board($board_id=0) {
        $data = $this->db->get_where("board", array('board_id'=> $board_id));
        $result = $data->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    // 작성
    private function check_deleted_parent($parent_id) {
        // 작성 중 부모 게시글 하드 딜리트된 경우
        $this->db->from('board');
        $this->db->where('board_id', $parent_id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $parent_id : 0;
    }
    public function write_board($title, $content, $parent_id = 0) {
        $parent_id = $this->check_deleted_parent($parent_id);
        if ($parent_id == 0) {
            $last_group = $this->db->query("SELECT MAX(group_id) AS max_group_id FROM board")->row();
            $group_id = ($last_group->max_group_id ?? 0) + 1;
    
            $data = [
                'board_title'   => $title,
                'board_content' => $content,
                'group_id'      => $group_id,
                'group_order'   => '0',
                'depth'         => 0
            ];
    
        } else {
            $parent = $this->db->query("SELECT * FROM board WHERE board_id = ?", [$parent_id])->row_array();
    
            $group_id = $parent['group_id'];
            $depth = $parent['depth'] + 1;
    
            $like = $parent['group_order'] . '-';
            $child = $this->db->query("
                SELECT group_order FROM board 
                WHERE group_id = ? AND group_order LIKE ? AND depth = ? 
                ORDER BY group_order ASC LIMIT 1",
                [$group_id, $like . '%', $depth]
            )->row_array();
    
            if ($child) {
                $new_order = $like . uniqid();
            } else {
                $new_order = $like . '1';
            }
    
            $data = [
                'board_title'   => $title,
                'board_content' => $content,
                'group_id'      => $group_id,
                'group_order'   => $new_order,
                'depth'         => $depth
            ];
        }
    
        return $this->db->insert('board', $data);
    }

    // 삭제
    private function count_group($board_id) {
        $sql = '
            SELECT COUNT(group_id) AS cnt
            FROM board
            WHERE group_id = (
                SELECT group_id
                FROM board
                WHERE board_id = ?
            )
        ';
        $query = $this->db->query($sql, [$board_id]);
        echo $query->row()->cnt;
        return $query->row()->cnt;
    }
    public function delete_board($board_id) {
        $count = $this->count_group($board_id);

        if ($count>1) {
            // soft delete
            $set = array('board_title'=>'', 'board_content' => '');
            $where = array('board_id'=>$board_id);
            $this->db->update('board', $set,$where);
        } else {
            // hard delete
            $this->db->delete('board', ['board_id'=> $board_id]);
        }
    }

    // 업데이트
    public function update_board($data) {
        $set = array('board_title'=>$data['board_title'],
                    'board_content' => $data['board_content']);
        $where = array('board_id'=>$data['board_id']);
        $this->db->update('board',$set,$where);
    }
}
