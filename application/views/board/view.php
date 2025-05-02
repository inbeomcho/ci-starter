<style>
    .detail_header {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    .common_btn {
        background-color: rgba(12, 158, 102, 0.1);
        transition: background-color 0.2s;
        cursor:pointer;
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
        flex: 1;
        margin-bottom: 20px;
        padding: 0px 5px;
    }

    .detail_footer {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
</style>

<script>
    function deleteSubmit() {
        fetch("/board/delete/<?php echo $board['board_id']; ?>", {
            method: "PATCH",
        })
        .then(response => {
            if (response.ok) {
                alert("삭제 성공");
                window.location.href = "/board/";
            } else {
                throw new Error("삭제 실패");
            }
        })
        .catch(error => {
            alert(error.error);
            window.location.href = "/board/";
        });
    }
</script>

<div class="detail_header">
    <a href="/board/write/<?php echo $board['board_id'] ?>">
        <button class="common_btn" type="button">답글작성</button>
    </a>
</div>

<div class="detail_body">
    <div><?php echo $board['board_title'] ?></div>
    <div><?php echo $board['board_content'] ?></div>
</div>

<div class="detail_footer">
    <button class="common_btn" onclick="deleteSubmit()">삭제</button>
    <a href="/board/update/<?php echo $board['board_id'] ?>">
        <button class="common_btn" type="button">수정</button>
    </a>
</div>