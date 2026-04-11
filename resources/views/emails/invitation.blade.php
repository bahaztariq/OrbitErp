<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Company Invitation</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #eee; border-radius: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .footer { margin-top: 40px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>OrbitErp Invitation</h2>
        </div>
        <p>Hello,</p>
        <p>You have been invited to join <strong>{{ $company->name }}</strong> on OrbitErp.</p>
        <p>Click the button below to accept the invitation and join the team:</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" class="button">Accept Invitation</a>
        </div>
        <p>If the button above doesn't work, you can copy and paste the following link into your browser:</p>
        <p style="word-break: break-all; font-size: 13px; color: #666;">{{ $url }}</p>
        <p>This invitation will expire in 24 hours.</p>
        <div class="footer">
            <p>Sent by OrbitErp System</p>
        </div>
    </div>
</body>
</html>
