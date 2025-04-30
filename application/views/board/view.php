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
            alert("삭제 실패");
            window.location.href = "/board/";
        });
    }
</script>

<div><?php echo $board['board_title'] ?></div>
<div><?php echo $board['board_content'] ?></div>

<button onclick="deleteSubmit()">삭제</button>
<button type="button">수정</button>