<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #9EC8B9 50%, #ffffff 50%);
            background-image: url('images/login_bg.png'); /* Gambar latar belakang */
            background-size: cover; /* Mengisi seluruh area latar belakang */
            background-position: center; /* Posisi gambar di tengah */
            background-repeat: no-repeat; /* Agar gambar tidak diulang */
            display: flex;
            justify-content: flex-end;
            align-items: center;
            min-height: 100vh;
            color: #333;
            padding: 150px;
        }

        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"], input[type="password"] {
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
        }

        button {
            background-color: #5C8374;
            color: #fff;
            font-weight: 500;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
            width: 100%;
            margin-top: 20px;
            font-size: 16px;
        }

        button:hover {
            background-color: #527853;
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
            width: 100%;
        }

        .input-group input {
            padding-right: 40px;
        }

        .input-group .icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #999;
        }

        .back-btn {
            margin-top: 20px;
            font-size: 14px;
            text-decoration: none;
            color: #333;
            transition: color 0.3s;
            display: inline-block;
        }

        .back-btn:hover {
            color: #5C8374;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px;
            }

            input[type="text"], input[type="password"], button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="process_login.php" method="post">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
                <span class="icon">&#128100;</span>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <span class="icon">&#128274;</span>
            </div>
            <button type="submit">Login</button>
        </form>
        <a href="#" class="back-btn" onclick="history.go(-1); return false;">Back</a>
    </div>
</body>
</html>
