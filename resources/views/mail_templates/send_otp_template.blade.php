<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background: #fff;
            color: #333;
            padding: 1em 0;
        }

        main {
            padding: 1em 0;
        }

        footer {
            background: #333;
            color: #fff;
            padding: 1em 0;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
    
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Login OTP</h1>
        </header>

        <main>
            <p>Dear User,</p>
            
            <p>Your One-Time Password (OTP) for login is: <strong>{{ $otp }}</strong></p>
            
            <p class="small-font">This OTP is valid for a short period. Please use it to complete your login.</p>
            
            <p class="small-font">If you did not request this OTP or are having trouble logging in, please contact us.</p>

            <br>

            <p>Regards,</p>
            <p>Bookvenue Team</p>
        </main>

        <br><br>

        <footer>
            <p>&copy; {{ date('Y') }} Bookvenue. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
