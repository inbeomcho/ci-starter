<style>
        .main_board {
                display:flex;
                justify-content: center;
                align-items: center;

        }

        .main_frame {
                display: flex;
                flex-direction: column;
                width: 1300px;
                min-height: 1150px;
                font-family: 'Segoe UI', 'Arial', sans-serif;
                background-color:rgba(208, 244, 215, 0.49);
                border: 1px solid #cbd4c2;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .title_area {
                width: 100%;
                font-size: 32px;
                font-weight: 900;
                margin-bottom: 15px;
        }

        .context_area {
                flex:1;
                display: flex;
                flex-direction: column;
        }



        /* /board/*의 버튼 스타일 */
        .board_common_btn {
                background-color: rgba(12, 158, 102, 0.1);
                transition: background-color 0.2s;
                cursor:pointer;
                border-radius: 6px;
                border: none;
                width: 100px;
                height: 30px;
                margin-bottom: 20px;
                text-decoration: none;
                font-weight: bold;
        }
        .board_common_btn:hover {
                background-color: rgba(12, 158, 102, 0.2);
                color: #0c9e66;
                text-decoration: none;
                font-weight: bold;
        }

        .margino_line {
                border-top: 1px solid rgb(134, 168, 156);
                margin: 15px 0;
        }

</style>





<html>
        <head>
                <title>Tutorial</title>
        </head>
        <body class="main_board">
                <div class="main_frame">
                        <div class="title_area"><?php echo $title ?? "Main"; ?></div>
                        <div class="context_area">