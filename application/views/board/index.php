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


    .pagination_wrapper {
        display:flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pagination_btn {
        font-weight: bold;
        cursor: pointer;
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(12, 158, 102, 0.1);
        border-radius: 6px;
        transition: background-color 0.2s;
    }

    .pagination_btn:hover {
        color: #0c9e66;
    }

    .pagination_btn.active {
        background-color: rgba(19, 130, 87, 0.57);
        border-radius: 50%;
    }
    .pagination_btn.disabled {
        background-color: rgba(67, 110, 94, 0.57);
        cursor: default;
        pointer-events: none;
    }

    .pagination_form {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
        width: 100%;
    }

    #pageInput {
        width: 100px;
        height: 35px;
        padding: 6px 10px;
        font-size: 14px;
        border: none;
        border-left: 4px solid #0c9e66;
        border-radius: 6px;
        background-color: rgba(12, 158, 102, 0.05);
        transition: border-color 0.2s;
    }

    #pageInput:focus {
        border-color: #0c9e66;
        outline: none;
    }

    .pagination_go_btn {
        height: 35px;
        padding: 0 16px;
        font-weight: bold;
        background-color: rgba(12, 158, 102, 0.3);
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .pagination_go_btn:hover {
        background-color: rgba(12, 158, 102, 0.5);
        color: white;
    }
</style>

<script>
    function goToPage(offset) {
        const url = new URL(window.location.href);
        const currentPage = parseInt(url.searchParams.get("p")) || 1;
        const totalPage = <?= $pagination['total_page'] ?>;
        
        if (offset === 'next') {
            newPage = Math.min(currentPage + 1, totalPage);
        } else if (offset === 'prev') {
            newPage = Math.max(currentPage - 1, 1);
        } else {
            const target = parseInt(offset);
            newPage = Math.min(Math.max(1, target), totalPage);
        }
        url.searchParams.set("p", newPage);
        window.location.href = url.toString();
    }
</script>

<div class="list_header">
    <div class="left_actions">
        <a href="/">
            <button class="board_common_btn"> 뒤로가기</button>
        </a>
    </div>
    <div class="right_actions">
        <a href="/board/write?p=<?= $pagination['current_page'] ?>">
            <button class="board_common_btn">새글작성</button>
        </a>
    </div>
</div>

<?php if ($pagination['board_data']) : ?>
    <?php foreach ($pagination['board_data'] as $board_item) : ?>
        <?php $depth = min($board_item['depth'], 7); ?>
        <div class="board_container">
            <div class="board_wrapper" style="margin-left: <?= 20 * $depth ?>px;">
                <?php if ($board_item['board_title']=='') :?>
                <a>
                    <?= htmlspecialchars("게시물이 삭제되었습니다.") ?>
                </a>
                <?php else :?>
                <a href="/board/view/<?= $board_item['board_id'] ?>?p=<?= htmlspecialchars($_GET['p'] ?? 1) ?>">
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

<!-- pagination -->
<div class="pagination_wrapper">
    <div class="pagination_btn <?php echo $pagination['current_page']==1? 'disabled' : ''?>" onclick="goToPage('prev')">&lt;</div>
    <?php for ($i = $pagination['start_page']; $i <= $pagination['end_page']; $i++) { ?>
        <div class="pagination_btn <?php echo ($i == $pagination['current_page']) ? 'active' : ''; ?>"
        onclick="goToPage(<?php echo $i; ?>)">
            <?php echo $i; ?>
        </div>
    <?php } ?>
    <div class="pagination_btn <?php echo $pagination['current_page']==$pagination['total_page']? 'disabled' : ''?>" onclick="goToPage('next')">&gt;</div>
    <br><br>
    <form class="pagination_form" action="" method="get">
        <input type="text" name="p" id="pageInput" placeholder="페이지 이동" autocomplete="off" />
        <button type="submit" class="pagination_go_btn">이동</button>
    </form>
</div>
