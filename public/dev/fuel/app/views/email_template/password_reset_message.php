<html>
    <head>
        <style>
            body {
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif
            }
            .message-container {
                margin: 10px auto;
                width: 800px;
                background-color: #EEEEEE;
                border-radius: 6px 6px 6px 6px;
                margin-bottom: 30px;
                padding: 20px;
            }
            .message-container h1 {
                font-size: 60px;
                line-height: 1;
                font-weight: bold;
                margin-bottom: 0;
            }
            .message-container p {
                font-size: 16px;
                font-weight: 200;
                line-height: 27px;
            }

        </style>
    </head>
    <body>
        <div class="message-container">
            <h1>Password Reset</h1>
            <p>
                This email was sent because you recently request for resetting TMYW user password.
                Your password has been reset. Use this password to login. You are requited to change your password after login.
            </p>
            <p><strong>Password</strong>: <?php echo $password ?></p></p>
            <p>
                Click <a href="<?php echo BASEURL ?>">here</a> to visit TMYW.
            </p>
        </div>
    </body>
</html>
