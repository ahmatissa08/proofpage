<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="background:#0c0c0e;margin:0;padding:40px 20px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif">
  <div style="max-width:520px;margin:0 auto;background:#131316;border:1px solid #242428;border-radius:10px;overflow:hidden">
    <div style="height:3px;background:linear-gradient(90deg,#e8a325,#4a9eff)"></div>
    <div style="padding:40px 36px">
      <div style="font-size:1.4rem;font-style:italic;color:#f2f0eb;margin-bottom:28px;font-family:Georgia,serif">ProofWork</div>
      <div style="color:#a09e9a;font-size:0.9rem;line-height:1.75;white-space:pre-line">{!! nl2br(e(str_replace(['{name}','{email}'], [$recipientName, $recipientEmail ?? ''], $broadcastBody))) !!}</div>
    </div>
    <div style="padding:20px 36px;border-top:1px solid #242428;background:#0c0c0e">
      <p style="font-family:'Courier New',monospace;font-size:0.6rem;color:#3a3835;text-align:center">
        © {{ date('Y') }} ProofWork · You're receiving this because you joined our waitlist.<br>
      </p>
    </div>
  </div>
</body>
</html>
