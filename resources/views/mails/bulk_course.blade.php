<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; }
        .card { background:white; padding:30px; border-radius:8px; max-width:500px; margin:auto; border-top:4px solid #e10600; }
        h2 { color:#e10600; }
        p { color:#333; line-height:1.6; }
        .footer { margin-top:20px; font-size:12px; color:#999; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🏁 F1 Academy</h2>
        <p>Hello <strong>{{ $studentName }}</strong>,</p>
        <p>You are receiving this message regarding your course:</p>
        <p style="font-size:18px;font-weight:bold;color:#e10600;">{{ $courseTitle }}</p>
        <p>Your instructor has sent you an important update. Please log in to F1 Academy to check the latest course materials and announcements.</p>
        <p>Keep pushing forward! 🚀</p>
        <div class="footer">© 2025 F1 Academy. All rights reserved.</div>
    </div>
</body>
</html>