
<style>
    .common_btn {
        background-color: rgba(12, 158, 102, 0.1);
        transition: background-color 0.2s;
        cursor: pointer;
        border-radius: 6px;
        border: 1px solid rgba(12, 158, 102, 0.5);
        width: 100px;
        height: 30px;
        margin-bottom: 20px;
    }
    
    .common_btn:hover {
        background-color: rgba(12, 158, 102, 0.2);
    }
    
    .detail_body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;  /* 상세 본문이 전체 공간을 차지하도록 설정 */
        margin-bottom: 20px;
        padding: 0px 5px;
    }

    #detail_title {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #ddd;
        outline: none;
    }

    #detail_content {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        min-height: 150px;
        border-radius: 4px;
        border: 1px solid #ddd;
        resize: vertical;
        flex-grow: 1;
        outline: none;
    }

    .detail_footer {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
</style>

<script>
    function submitUpdate() {
        const obj_write = JSON.stringify({
            board_title: document.getElementById("detail_title").value,
            board_content: document.getElementById("detail_content").value,
            board_id: document.getElementById('board_id').value
        });

        fetch('/board/update/', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: obj_write
        })
        .then(response => {
            if (response.ok) {
                alert("수정 성공");
                window.location.href = "/board/view/" + document.getElementById('board_id').value;
            }
        })
        .catch(error => {
            console.error("오류 발생:", error);
        });
    }
</script>
<input type="hidden" id="board_id" value="<?php echo $board['board_id'] ?>">

<div class="detail_body">
    <input id="detail_title" type="text" value="<?php echo $board['board_title'] ?>">
    <textarea id="detail_content" placeholder="내용을 입력하세요"><?php echo $board['board_content'] ?></textarea>
</div>

<div class="detail_footer">
    <button class="common_btn" onclick="history.back()">취소</button>
    <button class="common_btn" onclick="submitUpdate()">수정</button>
</div>