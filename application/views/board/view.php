<style>
    .detail_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    .right_actions {
        margin-left: auto;
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
        event.preventDefault();

        const obj_delete = JSON.stringify({"board_id" : <?php echo $board['board_id']?>});

        fetch("/board/delete/", {
            method: "POST",
            headers: {"Content-Type":"application/json"},
            body: obj_delete
        })
        .then(response => {
            if (response.ok) {
                alert("삭제 성공");
                window.location.href = "/board?p=<?= htmlspecialchars($_GET['p'] ?? 1) ?>";
            } else {
                throw new Error("삭제 실패");
            }
        })
        .catch(error => {
            alert(error);
            window.location.href = "/board?p=<?= htmlspecialchars($_GET['p'] ?? 1) ?>";
        });
    }
</script>

<div class="detail_header">
    <div class="left_actions">
        <a href="/board?p=<?= htmlspecialchars($_GET['p'] ?? 1) ?>">
            <button class="board_common_btn">뒤로가기</button>
        </a>
    </div>
    <div class="right_actions">
        <a href="/board/write/<?php echo $board['board_id'] ?>?p=<?= htmlspecialchars($_GET['p'] ?? 1) ?>">
            <button class="board_common_btn" type="button">답글작성</button>
        </a>
    </div>
</div>

<div class="detail_body">
    <div><?= htmlspecialchars($board['board_title'], ENT_QUOTES, 'UTF-8') ?></div>
    <div class="margino_line"></div>
    <div><?= nl2br(htmlspecialchars($board['board_content'], ENT_QUOTES, 'UTF-8')) ?></div>
</div>

<div class="detail_footer">
    <button class="board_common_btn" onclick="deleteSubmit()">삭제</button>
    <a href="/board/update/<?php echo $board['board_id'] ?>?p=<?= htmlspecialchars($_GET['p'] ?? 1) ?>">
        <button class="board_common_btn" type="button">수정</button>
    </a>
</div>