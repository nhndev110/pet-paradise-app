<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tài Khoản Nhân Viên Đã Được Tạo</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                line-height: 1.6;
                color: #333;
                padding: 20px;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                border: 1px solid #ddd;
                padding: 20px;
                border-radius: 5px;
            }

            .header {
                text-align: center;
                padding-bottom: 10px;
                border-bottom: 1px solid #eee;
            }

            .footer {
                margin-top: 20px;
                padding-top: 10px;
                border-top: 1px solid #eee;
                text-align: center;
                font-size: 0.8em;
            }

            .credentials {
                background-color: #f5f5f5;
                padding: 10px;
                margin: 15px 0;
                border-radius: 5px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1>Chào Mừng Đến Với Pet Paradise</h1>
            </div>

            <p>Xin chào {{ $user->name }},</p>

            <p>Tài khoản nhân viên của bạn đã được tạo trong hệ thống của chúng tôi. Chào mừng bạn đến với đội ngũ Pet
                Paradise!</p>

            <div class="credentials">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Mật Khẩu Tạm Thời:</strong> {{ $plainPassword }}</p>
            </div>

            <p>Vui lòng đăng nhập bằng thông tin đăng nhập được cung cấp và thay đổi mật khẩu của bạn ngay lập tức để
                bảo mật.</p>

            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với đội ngũ quản trị.</p>

            <div class="footer">
                <p>© {{ date('Y') }} Pet Paradise. Đã đăng ký bản quyền.</p>
            </div>
        </div>
    </body>

</html>
