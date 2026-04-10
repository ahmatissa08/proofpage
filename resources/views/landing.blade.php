@extends('layouts.app')

@section('title', 'ProofWork — Your work, proven.')

@push('styles')
<style>
:root {
  --bg: #0c0c0e;
  --surface: #131316;
  --surface2: #18181c;
  --border: #242428;
  --border2: #2e2e34;
  --ink: #f2f0eb;
  --ink2: #a09e9a;
  --ink3: #5a5855;
  --amber: #e8a325;
  --amber-dim: rgba(232,163,37,0.12);
  --amber-glow: rgba(232,163,37,0.25);
  --coral: #e85c3a;
  --sky: #4a9eff;
  --mono: 'Geist Mono', monospace;
  --sans: 'Geist', sans-serif;
  --serif: 'Instrument Serif', serif;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:var(--bg);color:var(--ink);font-family:var(--sans);overflow-x:hidden;line-height:1.6}
::-webkit-scrollbar{width:4px}
::-webkit-scrollbar-track{background:var(--bg)}
::-webkit-scrollbar-thumb{background:var(--border2);border-radius:2px}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 2.5rem;border-bottom:1px solid var(--border);background:rgba(12,12,14,0.85);backdrop-filter:blur(20px)}
.logo{font-family:var(--serif);font-size:1.35rem;font-style:italic;color:var(--ink);letter-spacing:-0.01em}
.logo-word{font-family:var(--sans);font-style:normal;font-weight:300;font-size:1.3rem;letter-spacing:-0.02em}
.logo sup{font-family:var(--mono);font-style:normal;font-size:0.45rem;letter-spacing:.15em;color:var(--amber);vertical-align:super;margin-left:2px;text-transform:uppercase}
.nav-links{display:flex;gap:.3rem;align-items:center}
.nav-links a{color:var(--ink3);text-decoration:none;font-size:.8rem;font-weight:400;letter-spacing:.02em;padding:.45rem .85rem;border-radius:4px;transition:color .2s,background .2s}
.nav-links a:hover{color:var(--ink);background:rgba(255,255,255,.04)}
.nav-cta{background:var(--amber)!important;color:#000!important;font-weight:600!important;font-size:.78rem!important;letter-spacing:.04em!important;padding:.5rem 1.1rem!important;border-radius:4px!important;transition:opacity .15s!important}
.nav-cta:hover{opacity:.88!important}

/* HERO */
.hero{min-height:100vh;display:grid;place-content:center;padding:8rem 2.5rem 5rem;position:relative;overflow:hidden}
.hero::before{content:'';position:absolute;inset:0;z-index:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");opacity:.4;pointer-events:none}
.hero-glow{position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(232,163,37,.07) 0%,transparent 70%);top:-100px;left:-100px;pointer-events:none}
.hero-glow-2{position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(74,158,255,.05) 0%,transparent 70%);bottom:0;right:10%;pointer-events:none}
.hero-inner{position:relative;z-index:1;max-width:780px}
.hero-eyebrow{display:inline-flex;align-items:center;gap:.6rem;font-family:var(--mono);font-size:.68rem;color:var(--ink3);letter-spacing:.14em;text-transform:uppercase;margin-bottom:1.8rem;animation:fadeUp .7s ease both}
.eyebrow-dot{width:5px;height:5px;background:var(--amber);border-radius:50%;animation:blink 2s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.25}}
h1{font-family:var(--serif);font-size:clamp(3.4rem,7vw,6.5rem);font-weight:400;line-height:1;letter-spacing:-.03em;animation:fadeUp .7s .08s ease both}
h1 em{font-style:italic;color:var(--amber)}
.hero-line2{display:block;font-style:italic;color:var(--ink2)}
.hero-sub{font-size:1.05rem;color:var(--ink2);max-width:52ch;line-height:1.65;margin-top:1.6rem;font-weight:300;animation:fadeUp .7s .16s ease both}
.hero-actions{display:flex;gap:.8rem;align-items:center;margin-top:2.5rem;animation:fadeUp .7s .24s ease both;flex-wrap:wrap}
.btn-primary{background:var(--amber);color:#000;border:none;padding:.85rem 1.8rem;font-family:var(--sans);font-size:.88rem;font-weight:600;letter-spacing:.02em;border-radius:4px;cursor:pointer;text-decoration:none;transition:opacity .15s,transform .15s;display:inline-block}
.btn-primary:hover{opacity:.88;transform:translateY(-1px)}
.btn-ghost{background:transparent;color:var(--ink2);border:1px solid var(--border2);padding:.85rem 1.8rem;font-family:var(--sans);font-size:.88rem;font-weight:400;border-radius:4px;cursor:pointer;text-decoration:none;transition:border-color .2s,color .2s,transform .15s;display:inline-block}
.btn-ghost:hover{color:var(--ink);transform:translateY(-1px)}
.hero-stats{display:flex;gap:2.5rem;margin-top:3.5rem;padding-top:2rem;border-top:1px solid var(--border);animation:fadeUp .7s .32s ease both;flex-wrap:wrap}
.stat-num{font-family:var(--serif);font-size:1.9rem;font-style:italic;color:var(--amber);display:block;line-height:1}
.stat-label{font-family:var(--mono);font-size:.62rem;color:var(--ink3);letter-spacing:.1em;text-transform:uppercase;margin-top:.25rem}

/* SECTION HELPERS */
.section-tag{font-family:var(--mono);font-size:.65rem;color:var(--ink3);letter-spacing:.14em;text-transform:uppercase;margin-bottom:1.5rem;display:block}
.section-tag::before{content:'── ';color:var(--amber);opacity:.5}
.section-h2{font-family:var(--serif);font-size:clamp(2rem,4vw,3rem);font-style:italic;font-weight:400;letter-spacing:-.02em;margin-bottom:.4rem}
.section-sub{color:var(--ink3);font-size:.88rem;margin-bottom:3rem}

/* REPORT PREVIEW */
.preview-section{padding:5rem 2.5rem 4rem;max-width:1100px;margin:0 auto}
.report-window{background:var(--surface);border:1px solid var(--border);border-radius:10px;overflow:hidden;box-shadow:0 40px 100px rgba(0,0,0,.5);max-width:680px;position:relative}
.report-window-bar{display:flex;align-items:center;gap:.5rem;padding:.8rem 1.2rem;background:var(--surface2);border-bottom:1px solid var(--border)}
.dot{width:10px;height:10px;border-radius:50%}
.dot.r{background:#ff5f56}.dot.y{background:#ffbd2e}.dot.g{background:#27c93f}
.window-url{flex:1;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:4px;padding:.2rem .75rem;font-family:var(--mono);font-size:.65rem;color:var(--ink3);margin-left:.5rem}
.rpt-header{display:flex;align-items:center;justify-content:space-between;padding:1.2rem 1.5rem;border-bottom:1px solid var(--border)}
.rpt-name{font-size:.9rem;font-weight:500}
.rpt-week{font-family:var(--mono);font-size:.62rem;color:var(--ink3);margin-top:.15rem}
.verified-badge{display:flex;align-items:center;gap:.4rem;background:rgba(39,201,63,.1);border:1px solid rgba(39,201,63,.2);color:#27c93f;font-family:var(--mono);font-size:.58rem;padding:.25rem .65rem;border-radius:20px;letter-spacing:.1em}
.verified-badge::before{content:'';width:5px;height:5px;background:#27c93f;border-radius:50%}
.rpt-entries{padding:1.2rem 1.5rem;display:flex;flex-direction:column;gap:0}
.entry{display:grid;grid-template-columns:32px 1fr auto;gap:.9rem;align-items:start;padding:1rem 0;border-bottom:1px solid var(--border)}
.entry:last-child{border-bottom:none}
.entry-icon{width:32px;height:32px;border:1px solid var(--border2);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0}
.entry-title{font-size:.82rem;font-weight:500;margin-bottom:.2rem}
.entry-detail{font-family:var(--mono);font-size:.62rem;color:var(--ink3);line-height:1.5}
.entry-detail .hl{color:var(--amber);font-weight:500}
.entry-src{font-family:var(--mono);font-size:.58rem;color:var(--ink3);opacity:.6;white-space:nowrap;padding-top:.15rem}
.rpt-footer{display:flex;align-items:center;justify-content:space-between;padding:.8rem 1.5rem;background:var(--surface2);border-top:1px solid var(--border);font-family:var(--mono);font-size:.6rem;color:var(--ink3)}
.rpt-footer .hash{opacity:.35}

/* SPLIT */
.split-wrap{padding:2rem 2.5rem;max-width:1100px;margin:0 auto}
.split-section{display:grid;grid-template-columns:1fr 1fr;border:1px solid var(--border);border-radius:10px;overflow:hidden}
.split-col{padding:3.5rem 3rem}
.split-col.problem{background:var(--surface);border-right:1px solid var(--border)}
.split-col.solution{background:var(--surface2)}
.split-h2{font-family:var(--serif);font-size:1.6rem;font-style:italic;font-weight:400;margin-bottom:1.8rem;letter-spacing:-.01em}
.problem .split-h2{color:var(--coral)}.solution .split-h2{color:var(--amber)}
.item-list{list-style:none;display:flex;flex-direction:column;gap:1.2rem}
.item-list li{display:flex;gap:.9rem;font-size:.85rem;color:var(--ink2);line-height:1.55}
.bullet{flex-shrink:0;margin-top:.1rem;font-family:var(--mono);font-size:.7rem;opacity:.7}
.problem .bullet{color:var(--coral)}.solution .bullet{color:var(--amber)}
.item-list li strong{display:block;color:var(--ink);font-weight:500;font-size:.82rem;margin-bottom:.1rem}

/* FEATURES */
.features-section{padding:6rem 2.5rem;max-width:1100px;margin:0 auto}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);border:1px solid var(--border);border-radius:10px;overflow:hidden}
.feature-item{padding:2rem;border-right:1px solid var(--border);border-bottom:1px solid var(--border);transition:background .2s;position:relative;overflow:hidden}
.feature-item::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--amber),transparent);opacity:0;transition:opacity .3s}
.feature-item:hover{background:rgba(255,255,255,.02)}.feature-item:hover::after{opacity:1}
.feature-item:nth-child(3n){border-right:none}
.feature-item:nth-child(4),.feature-item:nth-child(5),.feature-item:nth-child(6){border-bottom:none}
.f-num{font-family:var(--mono);font-size:.58rem;color:var(--amber);letter-spacing:.12em;opacity:.7;margin-bottom:1rem}
.f-title{font-size:.9rem;font-weight:500;margin-bottom:.5rem;color:var(--ink)}
.f-desc{font-size:.8rem;color:var(--ink3);line-height:1.6}

/* PRICING */
.pricing-section{padding:6rem 2.5rem;max-width:1100px;margin:0 auto}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);border:1px solid var(--border);border-radius:10px;overflow:hidden;max-width:840px}
.price-card{padding:2rem 1.8rem;border-right:1px solid var(--border);background:var(--surface)}
.price-card:last-child{border-right:none}
.price-card.featured{background:rgba(232,163,37,.05);border:1px solid rgba(232,163,37,.2);position:relative}
.price-card.featured::before{content:'Most popular';position:absolute;top:0;left:50%;transform:translate(-50%,-50%);background:var(--amber);color:#000;font-family:var(--mono);font-size:.58rem;letter-spacing:.1em;text-transform:uppercase;padding:.2rem .75rem;border-radius:20px;font-weight:500}
.price-tier{font-family:var(--mono);font-size:.65rem;color:var(--ink3);letter-spacing:.12em;text-transform:uppercase;margin-bottom:1.2rem}
.featured .price-tier{color:var(--amber)}
.price-num{font-family:var(--serif);font-size:2.8rem;font-style:italic;font-weight:400;letter-spacing:-.04em;line-height:1;margin-bottom:.3rem}
.price-cycle{font-size:.75rem;color:var(--ink3);margin-bottom:1.5rem}
.price-list{list-style:none;display:flex;flex-direction:column;gap:.55rem;margin-bottom:1.8rem}
.price-list li{font-size:.78rem;color:var(--ink2);display:flex;gap:.5rem;align-items:center;line-height:1.4}
.price-list li::before{content:'✓';color:var(--amber);font-family:var(--mono);font-size:.7rem;flex-shrink:0;opacity:.8}
.price-btn{width:100%;padding:.72rem;font-family:var(--sans);font-size:.8rem;font-weight:500;border-radius:4px;cursor:pointer;border:1px solid var(--border2);background:transparent;color:var(--ink2);transition:all .2s;letter-spacing:.02em}
.price-btn:hover{border-color:var(--ink3);color:var(--ink)}
.price-btn.amber{background:var(--amber);color:#000;border-color:transparent;font-weight:600}
.price-btn.amber:hover{opacity:.88}

/* WAITLIST */
.waitlist-section{padding:7rem 2.5rem 6rem;text-align:center;position:relative;overflow:hidden}
.waitlist-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 60% 50% at 50% 50%,rgba(232,163,37,.06) 0%,transparent 70%);pointer-events:none}
.waitlist-h2{font-family:var(--serif);font-size:clamp(2.5rem,5vw,4.5rem);font-style:italic;font-weight:400;letter-spacing:-.03em;margin-bottom:1rem;position:relative}
.waitlist-p{color:var(--ink2);font-size:.95rem;max-width:42ch;margin:0 auto 2.5rem;position:relative}
.waitlist-form-wrap{display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap;max-width:480px;margin:0 auto;position:relative}
.email-input{background:var(--surface);border:1px solid var(--border2);color:var(--ink);padding:.85rem 1.2rem;font-family:var(--mono);font-size:.82rem;border-radius:4px;flex:1;min-width:220px;outline:none;transition:border-color .2s}
.email-input:focus{border-color:var(--amber)}
.email-input::placeholder{color:var(--ink3)}
#form-message{display:none;margin-top:1rem;font-family:var(--mono);font-size:.72rem;letter-spacing:.08em}
#form-message.success{color:#27c93f}
#form-message.error{color:var(--coral)}
.waitlist-meta{margin-top:1.5rem;font-family:var(--mono);font-size:.65rem;color:var(--ink3);letter-spacing:.08em;position:relative}
.avatars{display:flex;justify-content:center;align-items:center;margin-bottom:.5rem;gap:0}
.avatar{width:28px;height:28px;border-radius:50%;border:2px solid var(--bg);font-size:.65rem;display:flex;align-items:center;justify-content:center;margin-left:-6px;font-family:var(--sans);font-weight:600}
.avatar:first-child{margin-left:0}

/* FOOTER */
footer{padding:2rem 2.5rem;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem}
footer .flogo{font-family:var(--serif);font-size:1.1rem;font-style:italic;color:var(--ink)}
footer p{font-family:var(--mono);font-size:.6rem;color:var(--ink3)}

/* ANIMS */
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.reveal{opacity:0;transform:translateY(24px);transition:opacity .65s ease,transform .65s ease}
.reveal.in{opacity:1;transform:translateY(0)}

/* RESPONSIVE */
@media(max-width:768px){
  nav{padding:1rem 1.2rem}
  .nav-links a:not(.nav-cta){display:none}
  .hero{padding:7rem 1.2rem 4rem}
  .hero-stats{gap:1.5rem}
  .split-section{grid-template-columns:1fr}
  .split-col.problem{border-right:none;border-bottom:1px solid var(--border)}
  .features-grid{grid-template-columns:1fr}
  .feature-item{border-right:none!important}
  .feature-item:nth-child(4),.feature-item:nth-child(5){border-bottom:1px solid var(--border)!important}
  .feature-item:nth-child(6){border-bottom:none!important}
  .pricing-grid{grid-template-columns:1fr}
  .price-card{border-right:none;border-bottom:1px solid var(--border)}
  .price-card:last-child{border-bottom:none}
  .preview-section,.features-section,.pricing-section{padding:4rem 1.2rem}
  .waitlist-section{padding:5rem 1.2rem 4rem}
  footer{padding:1.5rem 1.2rem}
  .waitlist-form-wrap{flex-direction:column}
  .email-input{width:100%}
  .split-wrap{padding:2rem 1.2rem}
}
</style>
@endpush

@section('content')
<nav>
  <div class="logo">Proof<span class="logo-word">Work</span><sup>BETA</sup></div>
  <div class="nav-links">
    <a href="#features">Features</a>
    <a href="#pricing">Pricing</a>
    <a href="#waitlist" class="nav-cta">Get early access</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-glow-2"></div>
  <div class="hero-inner">
    <div class="hero-eyebrow">
      <span class="eyebrow-dot"></span>
      Private beta · accepting signups
    </div>
    <h1>Stop writing reports.<br><em>Start proving</em><span class="hero-line2">your work.</span></h1>
    <p class="hero-sub">ProofWork auto-generates client-ready proof of work from your real activity — commits, tasks, meetings, decisions. Every item sourced, timestamped, verifiable.</p>
    <div class="hero-actions">
      <a href="#waitlist" class="btn-primary">Join the waitlist →</a>
      <a href="#preview" class="btn-ghost">See a sample report</a>
    </div>
    <div class="hero-stats">
      <div>
        <span class="stat-num">3–5h</span>
        <span class="stat-label">saved per week</span>
      </div>
      <div>
        <span class="stat-num">0</span>
        <span class="stat-label">manual effort</span>
      </div>
      <div>
        <span class="stat-num">{{ number_format($count) }}</span>
        <span class="stat-label">on waitlist</span>
      </div>
    </div>
  </div>
</section>

<!-- REPORT PREVIEW -->
<section class="preview-section reveal" id="preview">
  <span class="section-tag">Sample report output</span>
  <div class="report-window">
    <div class="report-window-bar">
      <span class="dot r"></span><span class="dot y"></span><span class="dot g"></span>
      <span class="window-url">proofwork.app/reports/acme-apr-07</span>
    </div>
    <div class="rpt-header">
      <div>
        <div class="rpt-name">Weekly Proof Report — Acme Corp</div>
        <div class="rpt-week">Apr 01–07, 2026 · Generated automatically</div>
      </div>
      <div class="verified-badge">VERIFIED</div>
    </div>
    <div class="rpt-entries">
      <div class="entry">
        <div class="entry-icon">⌥</div>
        <div>
          <div class="entry-title">12 commits merged to main</div>
          <div class="entry-detail">Stripe webhook handler · <span class="hl">bug: fixed double-charge edge case</span> · 4 tests added</div>
        </div>
        <div class="entry-src">GitHub<br>Apr 07 18:42</div>
      </div>
      <div class="entry">
        <div class="entry-icon">◈</div>
        <div>
          <div class="entry-title">8 tasks completed in Linear</div>
          <div class="entry-detail">Dashboard v2 · <span class="hl">API rate limiting implemented</span> · 3 bugs closed</div>
        </div>
        <div class="entry-src">Linear<br>Apr 04–07</div>
      </div>
      <div class="entry">
        <div class="entry-icon">◎</div>
        <div>
          <div class="entry-title">2 client meetings logged</div>
          <div class="entry-detail">Apr 03 — Sprint review (45 min) · <span class="hl">Decision: launch beta Apr 15</span></div>
        </div>
        <div class="entry-src">Calendar<br>Auto-logged</div>
      </div>
    </div>
    <div class="rpt-footer">
      <span>proofwork.app/reports/acme-apr-07</span>
      <span class="hash">hash: 3f9a2c1d</span>
    </div>
  </div>
</section>

<!-- PROBLEM / SOLUTION -->
<div class="split-wrap reveal">
  <div class="split-section">
    <div class="split-col problem">
      <h2 class="split-h2">The problem.</h2>
      <ul class="item-list">
        <li><span class="bullet">✗</span><span><strong>Manual reports nobody trusts</strong>You spend Friday writing a status update. The client wonders if you padded the hours.</span></li>
        <li><span class="bullet">✗</span><span><strong>Spreadsheets aren't proof</strong>An invoice says "development — 20h." That proves nothing to a skeptical client.</span></li>
        <li><span class="bullet">✗</span><span><strong>Screenshots don't scale</strong>Pasting Jira screenshots into a PDF is embarrassing and takes forever.</span></li>
        <li><span class="bullet">✗</span><span><strong>3–5h/week lost to admin</strong>That's money you're leaving on the table, every single week.</span></li>
      </ul>
    </div>
    <div class="split-col solution">
      <h2 class="split-h2">The solution.</h2>
      <ul class="item-list">
        <li><span class="bullet">→</span><span><strong>Auto-collected activity</strong>ProofWork pulls your commits, tasks, meetings, and decisions. Zero effort on your end.</span></li>
        <li><span class="bullet">→</span><span><strong>Verifiable data, not stories</strong>Every item sourced and timestamped from the actual tool where work happened.</span></li>
        <li><span class="bullet">→</span><span><strong>One-click client report</strong>A clean, professional report your client opens in a browser. No login required.</span></li>
        <li><span class="bullet">→</span><span><strong>Time back in your day</strong>Stop writing. Start shipping. We handle the paper trail completely.</span></li>
      </ul>
    </div>
  </div>
</div>

<!-- FEATURES -->
<section class="features-section" id="features">
  <span class="section-tag reveal">What's included</span>
  <h2 class="section-h2 reveal">Everything your client needs to <em style="color:var(--amber)">believe you.</em></h2>
  <p class="section-sub reveal">Six integrations, one report. Automatic, weekly, verifiable.</p>
  <div class="features-grid reveal">
    @php
    $features = [
      ['01 / GITHUB',              'Code Activity',        'Commits, PRs, code reviews — all pulled in automatically. What was built, when, and by whom.'],
      ['02 / LINEAR · JIRA · NOTION','Task Tracking',      'Completed tasks with real timestamps. Not a to-do list in a slide deck — actual closed tickets.'],
      ['03 / GOOGLE CALENDAR',     'Meeting Decisions',    'What was decided, deferred, and actioned. Auto-logged from your calendar.'],
      ['04 / AI',                  'Smart Summary',        'Raw activity turned into a clean narrative. "Here\'s what got done and why it matters."'],
      ['05 / SHARING',             'Client Share Link',    'Send a URL. Your client opens a professional report. No login required on their end.'],
      ['06 / AUTOMATION',         'Weekly Auto-Send',      'Reports go out every Friday. Set it once, forget it forever.'],
    ];
    @endphp
    @foreach($features as $f)
    <div class="feature-item">
      <div class="f-num">{{ $f[0] }}</div>
      <div class="f-title">{{ $f[1] }}</div>
      <div class="f-desc">{{ $f[2] }}</div>
    </div>
    @endforeach
  </div>
</section>

<!-- PRICING -->
<section class="pricing-section" id="pricing">
  <span class="section-tag reveal">Pricing</span>
  <h2 class="section-h2 reveal">Simple. Honest. <em style="color:var(--amber)">Fair.</em></h2>
  <p class="section-sub reveal">Free to start. No credit card required.</p>
  <div class="pricing-grid reveal">
    <!-- FREE -->
    <div class="price-card">
      <div class="price-tier">Free</div>
      <div class="price-num">$0</div>
      <div class="price-cycle">forever</div>
      <ul class="price-list">
        <li>1 project</li>
        <li>1 client</li>
        <li>GitHub + 1 integration</li>
        <li>Manual report send</li>
      </ul>
      <button class="price-btn" onclick="scrollToWaitlist('free')">Get started</button>
    </div>
    <!-- PRO -->
    <div class="price-card featured">
      <div class="price-tier">Pro</div>
      <div class="price-num">$19</div>
      <div class="price-cycle">per month · billed monthly</div>
      <ul class="price-list">
        <li>Unlimited projects</li>
        <li>Unlimited clients</li>
        <li>All 6 integrations</li>
        <li>AI-generated summaries</li>
        <li>Auto weekly send</li>
        <li>Custom branding</li>
      </ul>
      <button class="price-btn amber" onclick="scrollToWaitlist('pro')">Start free trial →</button>
    </div>
    <!-- AGENCY -->
    <div class="price-card">
      <div class="price-tier">Agency</div>
      <div class="price-num">$49</div>
      <div class="price-cycle">per month · up to 5 seats</div>
      <ul class="price-list">
        <li>Everything in Pro</li>
        <li>5 team members</li>
        <li>White-label reports</li>
        <li>Priority support</li>
      </ul>
      <button class="price-btn" onclick="scrollToWaitlist('agency')">Contact us</button>
    </div>
  </div>
</section>

<!-- WAITLIST -->
<section class="waitlist-section" id="waitlist">
  <h2 class="waitlist-h2">Stop explaining.<br><em>Start proving.</em></h2>
  <p class="waitlist-p">Join the waitlist. Launching soon. Early users get 3 months free on Pro.</p>

  <div class="waitlist-form-wrap">
    <input type="email" id="email" class="email-input" placeholder="your@email.com" autocomplete="email" />
    <input type="hidden" id="plan_interest" value="pro" />
    <button class="btn-primary" id="submit-btn" onclick="handleSubmit()">Get early access →</button>
  </div>
  <div id="form-message"></div>

  <div class="waitlist-meta">
    <div class="avatars" id="avatars"></div>
    <span id="count-text">{{ $count }} freelancers already on the list</span>
  </div>
</section>

<footer>
  <div class="flogo">ProofWork</div>
  <p>© {{ date('Y') }} ProofWork · Built by a solo founder · No VC money</p>
</footer>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';

// Build avatars
(function(){
  const colors = ['#e8a325','#4a9eff','#e85c3a','#27c93f','#a855f7'];
  const letters = ['A','M','J','S','L'];
  const row = document.getElementById('avatars');
  for (let i = 0; i < 5; i++) {
    const av = document.createElement('div');
    av.className = 'avatar';
    av.style.cssText = `background:${colors[i]};color:#000`;
    av.textContent = letters[i];
    row.appendChild(av);
  }
})();

function scrollToWaitlist(plan) {
  document.getElementById('plan_interest').value = plan;
  document.getElementById('waitlist').scrollIntoView({ behavior: 'smooth' });
  setTimeout(() => document.getElementById('email').focus(), 600);
}

async function handleSubmit() {
  const emailEl = document.getElementById('email');
  const planEl  = document.getElementById('plan_interest');
  const btn     = document.getElementById('submit-btn');
  const msg     = document.getElementById('form-message');
  const email   = emailEl.value.trim();

  if (!email || !email.includes('@')) {
    emailEl.style.borderColor = '#e85c3a';
    setTimeout(() => emailEl.style.borderColor = '', 1500);
    return;
  }

  btn.disabled = true;
  btn.textContent = 'Joining...';

  try {
    const res = await fetch('{{ route("waitlist.store") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        email: email,
        plan_interest: planEl.value,
      })
    });

    const data = await res.json();

    msg.style.display = 'block';
    msg.className = res.ok ? 'success' : 'error';

    if (res.status === 201) {
      if (data.redirect) {
        window.location.href = data.redirect;
        return;
      }
      msg.textContent = '✓ You\'re on the list! Check your inbox.';
      btn.textContent = 'Joined! ✓';
      emailEl.style.display = 'none';
    } else if (res.status === 200) {
      // already_exists
      msg.textContent = '✓ You\'re already on the list!';
      btn.textContent = 'Already joined';
    } else {
      msg.className = 'error';
      msg.textContent = data.message ?? 'Something went wrong. Please try again.';
      btn.disabled = false;
      btn.textContent = 'Get early access →';
    }
  } catch (err) {
    msg.style.display = 'block';
    msg.className = 'error';
    msg.textContent = 'Network error. Please try again.';
    btn.disabled = false;
    btn.textContent = 'Get early access →';
  }
}

document.getElementById('email').addEventListener('keydown', e => {
  if (e.key === 'Enter') handleSubmit();
});

// Scroll reveal
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
