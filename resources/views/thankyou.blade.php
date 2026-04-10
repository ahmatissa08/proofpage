@extends('layouts.app')
@section('title', 'Welcome to ProofWork!')

@push('styles')
<style>
:root {
  --bg:#0c0c0e;--surface:#131316;--surface2:#18181c;--border:#242428;--border2:#2e2e34;
  --ink:#f2f0eb;--ink2:#a09e9a;--ink3:#5a5855;--amber:#e8a325;--coral:#e85c3a;--sky:#4a9eff;
  --mono:'Geist Mono',monospace;--sans:'Geist',sans-serif;--serif:'Instrument Serif',serif;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:var(--bg);color:var(--ink);font-family:var(--sans);min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;overflow:hidden}

/* Confetti canvas */
#confetti-canvas{position:fixed;inset:0;pointer-events:none;z-index:0}

.card{position:relative;z-index:1;background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:3rem 3.5rem;max-width:520px;width:100%;text-align:center;box-shadow:0 40px 100px rgba(0,0,0,.5)}
.card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#e8a325,#4a9eff);border-radius:14px 14px 0 0}

.check-circle{width:64px;height:64px;background:rgba(39,201,63,.1);border:1px solid rgba(39,201,63,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:1.6rem;animation:popIn .5s cubic-bezier(.175,.885,.32,1.275) both}
@keyframes popIn{from{opacity:0;transform:scale(.5)}to{opacity:1;transform:scale(1)}}

.card-title{font-family:var(--serif);font-size:2rem;font-style:italic;font-weight:400;letter-spacing:-.03em;margin-bottom:.75rem;animation:fadeUp .5s .1s ease both}
.card-sub{color:var(--ink2);font-size:.9rem;line-height:1.65;margin-bottom:2rem;animation:fadeUp .5s .2s ease both}

.position-badge{display:inline-flex;align-items:center;gap:.5rem;background:var(--surface2);border:1px solid var(--border2);border-radius:6px;padding:.6rem 1.2rem;font-family:var(--mono);font-size:.72rem;color:var(--ink2);margin-bottom:2rem;animation:fadeUp .5s .3s ease both}
.position-num{color:var(--amber);font-size:1.1rem;font-weight:500}

.share-title{font-family:var(--mono);font-size:.6rem;color:var(--ink3);letter-spacing:.12em;text-transform:uppercase;margin-bottom:.8rem;animation:fadeUp .5s .35s ease both}

.share-buttons{display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap;animation:fadeUp .5s .4s ease both}
.share-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.2rem;border-radius:5px;font-family:var(--sans);font-size:.78rem;font-weight:500;text-decoration:none;cursor:pointer;border:none;transition:opacity .15s,transform .15s}
.share-btn:hover{opacity:.85;transform:translateY(-1px)}
.share-twitter{background:#000;color:#fff;border:1px solid #333}
.share-reddit{background:#ff4500;color:#fff}
.share-copy{background:var(--surface2);color:var(--ink2);border:1px solid var(--border2)}
.share-copy.copied{color:#27c93f;border-color:rgba(39,201,63,.3)}

.back-link{margin-top:2rem;font-family:var(--mono);font-size:.65rem;color:var(--ink3);letter-spacing:.08em;animation:fadeUp .5s .5s ease both}
.back-link a{color:var(--ink3);text-decoration:underline;text-underline-offset:3px}
.back-link a:hover{color:var(--ink2)}

@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
</style>
@endpush

@section('content')
<canvas id="confetti-canvas"></canvas>

<div class="card">
  <div class="check-circle">✓</div>
  <h1 class="card-title">You're in{{ $name ? ', '.$name : '' }}!</h1>
  <p class="card-sub">
    You're on the ProofWork waitlist. We'll email you the moment you can get access.<br>
    Early users get <strong style="color:var(--amber)">3 months free</strong> on the {{ ucfirst($plan) }} plan.
  </p>

  <div class="position-badge">
    <span>You're</span>
    <span class="position-num">#{{ $position }}</span>
    <span>on the waitlist</span>
  </div>

  <div class="share-title">Help us grow — share with other freelancers</div>
  <div class="share-buttons">
    <a class="share-btn share-twitter" href="https://twitter.com/intent/tweet?text={{ urlencode('Just joined the @ProofWork waitlist — auto-generates client proof of work from GitHub, Linear & Calendar. No more "trust me" invoices 🎉 proofwork.app') }}" target="_blank">
      𝕏 Share on X
    </a>
    <a class="share-btn share-reddit" href="https://reddit.com/submit?url={{ urlencode(config('app.url')) }}&title={{ urlencode('ProofWork — auto-generate proof of work reports for freelancers') }}" target="_blank">
      Reddit
    </a>
    <button class="share-btn share-copy" onclick="copyLink(this)">
      Copy link
    </button>
  </div>

  <div class="back-link">
    <a href="{{ route('home') }}">← Back to homepage</a>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Copy link
function copyLink(btn) {
  navigator.clipboard.writeText('{{ config('app.url') }}').then(() => {
    btn.textContent = '✓ Copied!';
    btn.classList.add('copied');
    setTimeout(() => { btn.textContent = 'Copy link'; btn.classList.remove('copied'); }, 2000);
  });
}

// Confetti
(function(){
  const canvas = document.getElementById('confetti-canvas');
  const ctx = canvas.getContext('2d');
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  window.addEventListener('resize', () => { canvas.width = window.innerWidth; canvas.height = window.innerHeight; });

  const colors = ['#e8a325','#4a9eff','#27c93f','#e85c3a','#f2f0eb','#a855f7'];
  const pieces = Array.from({length: 120}, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height - canvas.height,
    r: Math.random() * 6 + 3,
    color: colors[Math.floor(Math.random() * colors.length)],
    speed: Math.random() * 3 + 1.5,
    drift: (Math.random() - 0.5) * 1.5,
    rot: Math.random() * Math.PI * 2,
    rotSpeed: (Math.random() - 0.5) * 0.12,
    opacity: Math.random() * 0.7 + 0.3,
  }));

  let frame = 0;
  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pieces.forEach(p => {
      ctx.save();
      ctx.globalAlpha = p.opacity;
      ctx.fillStyle = p.color;
      ctx.translate(p.x, p.y);
      ctx.rotate(p.rot);
      ctx.fillRect(-p.r/2, -p.r/2, p.r, p.r * 1.6);
      ctx.restore();
      p.y += p.speed;
      p.x += p.drift;
      p.rot += p.rotSpeed;
      if (p.y > canvas.height + 20) {
        p.y = -20;
        p.x = Math.random() * canvas.width;
      }
    });
    frame++;
    if (frame < 300) requestAnimationFrame(draw);
    else ctx.clearRect(0, 0, canvas.width, canvas.height);
  }
  draw();
})();
</script>
@endpush
