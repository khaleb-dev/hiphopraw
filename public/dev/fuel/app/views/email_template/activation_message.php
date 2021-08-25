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
            <h1>Account Activation!</h1>
            <p>This account activation email was sent because you recently signed up for using TMYW.Confirm your registration by clicking the link below.</p>
            <p>
                <a href="<?php echo BASEURL . '/member/activation_confirmation/' . $md5_id . '/' . $activation_code ?>">Click here to activate your account!</a>
            </p>
            <p>
                Click <a href="<?php echo BASEURL ?>">here</a> to visit TMYW.
            </p>
        </div>
    </body>
</html>
