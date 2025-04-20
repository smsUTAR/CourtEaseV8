<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .auth-links a {
            margin-left: 15px;
            text-decoration: none;
            color: #007BFF;
        }
        .btn-contact {
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            font-family: Arial, sans-serif;
        }
        .contact-us {
            margin-top: 20px;
        }
        .footer-buttons {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Contact Us</h1>
        <div class="auth-links">
            <a href="{{ route('court-listing') }}">Home</a>
            <a href="{{ route('account') }}">Account</a>
            <a href="{{ route('logout') }}">Log Out</a>
        </div>
    </div>

    <div class="contact-us">
        <h2>Contact us if you need our assistance!</h2>
        <h3>Phone Number: Whatsapp 012-3358492</h3>
        <h3>Email: courtease@gmail.com</h3>
    </div>

    <div class="footer-buttons">
        <a href="{{ route('contact') }}" class="btn-contact">Contact Us</a>
    </div>
</div>
</body>
</html>
