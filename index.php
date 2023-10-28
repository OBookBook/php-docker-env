<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PHP!!</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #FFA07A, #FF6B6B);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 8px;
            animation: slideIn 1.3s ease-out 1 forwards;
        }

        .message-board {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            width: 40%;
        }

        .text {
            width: 50%;
            text-align: left;
        }

        h1 {
            color: #FF6B6B;
            font-size: 36px;
            margin: 0;
            padding: 0;
            text-align: left;
        }

        p {
            color: #333;
            font-size: 18px;
            margin: 5px 0;
            text-align: left;
        }

        .category {
            font-weight: bold;
            color: #FF6B6B;
            margin: 15px 0 10px;
            font-size: 24px;
        }

        .technology {
            color: #333;
            font-size: 18px;
            margin: 5px 0;
        }

        .links {
            text-align: left;
        }

        .link {
            text-decoration: none;
            color: #1DA1F2;
            font-size: 20px;
            margin-right: 20px;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message-board">
            <?php
            $envSetup = [
                "Project" => "Web Application in PHP",
                "Environment" => "Docker",
                "Database" => "MySQL",
                "Database Management" => "phpMyAdmin",
                "Development Environment" => "VSCode",
                "Package Management" => "Composer",
                "Code Quality" => "PHP_CodeSniffer",
                "Debugging" => "Xdebug"
            ];

            foreach ($envSetup as $element => $setup) {
                echo "<div class='category'>$element:</div>";
                echo "<div class='technology'>$setup</div>";
            }
            ?>
        </div>
        <div class="text">
            <h1>The container has started.</h1>
            <p>Welcome to PHP!!</p>
            <div class="links">
                <a class="link" href="https://twitter.com/OBookBook" target="_blank">Twitter</a>
                <a class="link" href="https://zenn.dev/0bookbook" target="_blank">Zenn</a>
            </div>
        </div>
    </div>
</body>

</html>
