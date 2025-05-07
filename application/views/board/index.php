<style>
    .list_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    .right_actions {
        margin-left: auto;
    }
    .board_wrapper {
        background-color: rgba(12, 158, 102, 0.1);
        border-left: 4px solid #0c9e66;
        margin-bottom: 10px;
        border-radius: 6px;
        transition: background-color 0.2s;
    }

    .board_wrapper:hover {
        background-color: rgba(12, 158, 102, 0.2);
    }

    .board_wrapper a {
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        font-weight: bold;
        display: block;
    }

    .board_wrapper a:hover {
        color: #0c9e66;
    }
</style>
<div class="list_header">
    <div class="left_actions">
        <a href="/">
            <button class="board_common_btn"> 뒤로가기</button>
        </a>
    </div>
    <div class="right_actions">
        <a href="/board/write/">
            <button class="board_common_btn">새글작성</button>
        </a>
    </div>
</div>
<?php if ($board) : ?>
    <?php foreach ($board as $board_item) : ?>
        <?php $depth = min($board_item['depth'], 7); ?>
        <div class="board_container">
            <div class="board_wrapper" style="margin-left: <?= 20 * $depth ?>px;">
                <?php if ($board_item['board_title']=='') :?>
                <a>
                    <?= htmlspecialchars("게시물이 삭제되었습니다.") ?>
                </a>
                <?php else :?>
                <a href="/board/view/<?= $board_item['board_id'] ?>">
                    <?= htmlspecialchars($board_item['board_title']) ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="board_container">
        <div class="board_wrapper">
            <a>
                <?= htmlspecialchars("게시물이 없습니다.") ?>
            </a>
        </div>
    </div>
<?php endif; ?>

