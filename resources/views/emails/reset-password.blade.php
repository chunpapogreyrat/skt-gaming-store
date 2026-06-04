<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; background: #0d0d0d; color: #e0e0e0; margin: 0; padding: 0; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #ff003c, #c0002e); padding: 32px 40px; text-align: center; }
        .header h1 { font-family: 'Orbitron', sans-serif; color: #fff; font-size: 28px; letter-spacing: 4px; margin: 0; }
        .body { padding: 36px 40px; }
        .body p { color: #b0b0b0; line-height: 1.7; margin: 0 0 16px; }
        .btn { display: inline-block; margin: 24px 0; padding: 14px 36px; background: #ff003c; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; letter-spacing: 1px; }
        .note { font-size: 12px; color: #666; margin-top: 24px; border-top: 1px solid #2a2a2a; padding-top: 16px; }
        .url { word-break: break-all; color: #ff003c; font-size: 12px; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>YUKI</h1>
    </div>
    <div class="body">
        <p>Xin chào,</p>
        <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại <strong>YUKI Gaming Store</strong>.</p>
        <p>Nhấn nút bên dưới để tạo mật khẩu mới. Link có hiệu lực trong <strong>60 phút</strong>.</p>
        <div style="text-align:center">
            <a href="{{ $resetUrl }}" class="btn">ĐẶT LẠI MẬT KHẨU</a>
        </div>
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bỏ qua email này — tài khoản của bạn vẫn an toàn.</p>
        <div class="note">
            <p>Nếu nút trên không hoạt động, copy link sau vào trình duyệt:</p>
            <p class="url">{{ $resetUrl }}</p>
        </div>
    </div>
</div>
</body>
</html>
