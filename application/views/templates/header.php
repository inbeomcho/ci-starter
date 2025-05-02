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
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                border: 1px solid black;
                padding: 7px;
                border-radius: 5px;
        }

        .title_area {
                width: 100%;
                font-size: 32px;
                font-weight: 900;
        }

        .context_area {
                flex:1;
                display: flex;
                flex-direction: column;
        }

        .footer_area {

        }

</style>





<html>
        <head>
                <title>Tutorial</title>
        </head>
        <body class="main_board">
                <div class="main_frame">
                        <div class="title_area"><?php echo $title ?? "Enter Title"; ?></div>
                        <div class="context_area">