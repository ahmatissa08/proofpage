<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>You're on the ProofWork waitlist!</title>
</head>
<body style="background:#0c0c0e;margin:0;padding:40px 20px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif">
  <div style="max-width:520px;margin:0 auto;background:#131316;border:1px solid #242428;border-radius:10px;overflow:hidden">

    <!-- Header bar -->
    <div style="height:3px;background:linear-gradient(90deg,#e8a325,#4a9eff)"></div>

    <!-- Body -->
    <div style="padding:40px 36px">
      <div style="font-size:1.6rem;font-style:italic;color:#f2f0eb;margin-bottom:8px;font-family:Georgia,serif">
        ProofWork
      </div>
      <div style="font-family:'Courier New',monospace;font-size:0.6rem;color:#5a5855;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:32px">
        Private Beta Waitlist
      </div>

      <h1 style="font-size:1.5rem;font-weight:600;color:#f2f0eb;margin-bottom:16px;letter-spacing:-0.03em">
        You're on the list 🎉
      </h1>

      <p style="color:#a09e9a;font-size:0.9rem;line-height:1.7;margin-bottom:20px">
        Hey{{ $entry->name ? ' '.$entry->name : '' }},<br><br>
        Thanks for signing up — you're officially on the ProofWork waitlist.
        We're building a tool that auto-generates client-ready proof of work
        from your real activity (GitHub, Linear, Calendar, and more).
      </p>

      <p style="color:#a09e9a;font-size:0.9rem;line-height:1.7;margin-bottom:32px">
        Early users on the <strong style="color:#e8a325">{{ ucfirst($entry->plan_interest) }}</strong>
        plan get <strong style="color:#f2f0eb">3 months free</strong> when we launch.
        We'll email you the moment you can get in.
      </p>

      <!-- What to expect box -->
      <div style="background:#0c0c0e;border:1px solid #242428;border-radius:6px;padding:20px 24px;margin-bottom:32px">
        <div style="font-family:'Courier New',monospace;font-size:0.62rem;color:#5a5855;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:14px">
          What happens next
        </div>
        <div style="font-size:0.82rem;color:#a09e9a;line-height:2">
          ✓ &nbsp;We'll notify you when ProofWork launches<br>
          ✓ &nbsp;You get early access before public launch<br>
          ✓ &nbsp;3 months free on {{ ucfirst($entry->plan_interest) }} plan<br>
          ✓ &nbsp;Direct line to the founder for feedback
        </div>
      </div>

      <p style="color:#5a5855;font-size:0.78rem;line-height:1.6">
        Questions? Just reply to this email.<br>
        — The ProofWork team
      </p>
    </div>

    <!-- Footer -->
    <div style="padding:20px 36px;border-top:1px solid #242428;background:#0c0c0e">
      <p style="font-family:'Courier New',monospace;font-size:0.6rem;color:#3a3835;text-align:center">
        © {{ date('Y') }} ProofWork · You received this because you signed up at proofwork.app<br>
        <a href="#" style="color:#5a5855;text-decoration:underline">Unsubscribe</a>
      </p>
    </div>
  </div>
</body>
</html>
