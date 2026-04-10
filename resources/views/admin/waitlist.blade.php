<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ProofWork — Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400;500&family=Geist:wght@400;500;600&family=Instrument+Serif:ital@1&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{background:#0c0c0e;color:#f2f0eb;font-family:'Geist',sans-serif;font-size:.88rem;line-height:1.6}
a{color:inherit;text-decoration:none}
.topbar{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;border-bottom:1px solid #242428;background:rgba(12,12,14,.9);position:sticky;top:0;z-index:10;backdrop-filter:blur(12px)}
.topbar-logo{font-family:'Instrument Serif',serif;font-size:1.1rem;font-style:italic}
.topbar-logo span{font-family:'Geist',sans-serif;font-style:normal;font-weight:300}
.topbar-logo small{font-family:'Geist Mono',monospace;font-style:normal;font-size:.6rem;color:#5a5855;margin-left:4px}
.topbar-actions{display:flex;gap:.6rem;align-items:center}
.btn{padding:.42rem .9rem;font-family:'Geist',sans-serif;font-size:.75rem;font-weight:500;border-radius:4px;cursor:pointer;transition:opacity .15s;border:1px solid #2e2e34;background:transparent;color:#a09e9a;text-decoration:none;display:inline-flex;align-items:center;gap:.4rem}
.btn:hover{color:#f2f0eb;border-color:#5a5855}
.btn-amber{background:#e8a325!important;color:#000!important;border-color:transparent!important;font-weight:600!important}
.btn-amber:hover{opacity:.88!important}
.btn-danger{border-color:rgba(232,92,58,.2)!important;color:#e85c3a!important}
.btn-danger:hover{background:rgba(232,92,58,.08)!important}
.container{max-width:1280px;margin:0 auto;padding:2rem}
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:#242428;border:1px solid #242428;border-radius:10px;overflow:hidden;margin-bottom:1.5rem}
.stat-box{background:#131316;padding:1.5rem 1.8rem}
.lbl{font-family:'Geist Mono',monospace;font-size:.58rem;color:#5a5855;letter-spacing:.12em;text-transform:uppercase;margin-bottom:.4rem}
.val{font-family:'Instrument Serif',serif;font-size:2.2rem;font-style:italic;letter-spacing:-.04em;color:#f2f0eb;line-height:1}
.val.amber{color:#e8a325}.val.sky{color:#4a9eff}.val.green{color:#27c93f}
.stat-delta{font-family:'Geist Mono',monospace;font-size:.6rem;color:#5a5855;margin-top:.25rem}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem}
.panel{background:#131316;border:1px solid #242428;border-radius:10px;overflow:hidden}
.panel-header{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid #242428}
.panel-title{font-size:.82rem;font-weight:600}
.panel-body{padding:1.4rem}
.chart-wrap{position:relative;height:200px}
.plan-bars{display:flex;flex-direction:column;gap:.9rem;padding:1.4rem}
.plan-row{display:flex;align-items:center;gap:.8rem}
.plan-name{font-family:'Geist Mono',monospace;font-size:.62rem;color:#a09e9a;letter-spacing:.08em;text-transform:uppercase;width:55px;flex-shrink:0}
.plan-bar-wrap{flex:1;background:#0c0c0e;border-radius:3px;height:6px;overflow:hidden}
.plan-bar{height:100%;border-radius:3px;transition:width 1s cubic-bezier(.4,0,.2,1)}
.plan-count{font-family:'Geist Mono',monospace;font-size:.62rem;color:#5a5855;width:30px;text-align:right}
.broadcast-form{display:flex;flex-direction:column;gap:.8rem}
.broadcast-form input,.broadcast-form textarea{background:#0c0c0e;border:1px solid #2e2e34;color:#f2f0eb;padding:.7rem 1rem;font-family:'Geist',sans-serif;font-size:.8rem;border-radius:4px;outline:none;transition:border-color .2s;width:100%}
.broadcast-form input:focus,.broadcast-form textarea:focus{border-color:#e8a325}
.broadcast-form textarea{resize:vertical;min-height:90px;line-height:1.55}
.broadcast-form input::placeholder,.broadcast-form textarea::placeholder{color:#3a3835}
#broadcast-status{font-family:'Geist Mono',monospace;font-size:.68rem;display:none;padding:.5rem .8rem;border-radius:4px}
#broadcast-status.success{background:rgba(39,201,63,.08);color:#27c93f;border:1px solid rgba(39,201,63,.15)}
#broadcast-status.error{background:rgba(232,92,58,.08);color:#e85c3a;border:1px solid rgba(232,92,58,.15)}
.table-wrap{background:#131316;border:1px solid #242428;border-radius:10px;overflow:hidden}
.table-header{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid #242428;gap:.8rem;flex-wrap:wrap}
.table-title{font-size:.82rem;font-weight:600}
.search-input{background:#0c0c0e;border:1px solid #2e2e34;color:#f2f0eb;padding:.4rem .9rem;font-family:'Geist Mono',monospace;font-size:.72rem;border-radius:4px;outline:none;transition:border-color .2s;width:220px}
.search-input:focus{border-color:#e8a325}
table{width:100%;border-collapse:collapse}
thead th{font-family:'Geist Mono',monospace;font-size:.58rem;color:#5a5855;letter-spacing:.1em;text-transform:uppercase;padding:.75rem 1.4rem;text-align:left;border-bottom:1px solid #242428;background:#18181c}
tbody tr{border-bottom:1px solid #1a1a1e;transition:background .12s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(255,255,255,.015)}
tbody td{padding:.8rem 1.4rem;font-size:.78rem;color:#a09e9a;font-family:'Geist Mono',monospace}
tbody td.email-cell{color:#f2f0eb;font-weight:500}
.badge{display:inline-block;padding:.12rem .5rem;border-radius:3px;font-size:.58rem;letter-spacing:.08em;text-transform:uppercase;font-weight:500}
.badge.pro{background:rgba(232,163,37,.1);color:#e8a325;border:1px solid rgba(232,163,37,.18)}
.badge.free{background:rgba(255,255,255,.04);color:#5a5855;border:1px solid #2e2e34}
.badge.agency{background:rgba(74,158,255,.08);color:#4a9eff;border:1px solid rgba(74,158,255,.18)}
.pagination{padding:.8rem 1.4rem;display:flex;gap:.4rem;align-items:center;border-top:1px solid #242428;flex-wrap:wrap}
.pagination a,.pagination span{font-family:'Geist Mono',monospace;font-size:.65rem;padding:.28rem .55rem;border-radius:3px;border:1px solid #242428;color:#a09e9a;transition:color .15s}
.pagination a:hover{color:#f2f0eb;border-color:#5a5855}
.pagination .active span{background:#e8a325!important;color:#000!important;border-color:transparent!important}
@media(max-width:900px){.grid-2{grid-template-columns:1fr}.stats-row{grid-template-columns:1fr 1fr}}
</style>
</head>
<body>

<div class="topbar">
  <div class="topbar-logo">Proof<span>Work</span><small>admin</small></div>
  <div class="topbar-actions">
    <a href="{{ route('admin.export') }}" class="btn btn-amber">⬇ Export CSV</a>
    <a href="{{ route('home') }}" class="btn">← Landing</a>
    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="btn btn-danger">Logout</button>
    </form>
  </div>
</div>

<div class="container">

  <div class="stats-row">
    <div class="stat-box">
      <div class="lbl">Total waitlist</div>
      <div class="val amber">{{ number_format($total) }}</div>
      <div class="stat-delta">+{{ $todayCount }} today</div>
    </div>
    <div class="stat-box">
      <div class="lbl">This week</div>
      <div class="val sky">{{ $weekCount }}</div>
      <div class="stat-delta">last 7 days</div>
    </div>
    <div class="stat-box">
      <div class="lbl">Pro interest</div>
      <div class="val">{{ $byPlan['pro'] ?? 0 }}</div>
      <div class="stat-delta">{{ ($total - 214) > 0 ? round((($byPlan['pro'] ?? 0) / ($total - 214)) * 100) : 0 }}% of real signups</div>
    </div>
    <div class="stat-box">
      <div class="lbl">Agency interest</div>
      <div class="val green">{{ $byPlan['agency'] ?? 0 }}</div>
      <div class="stat-delta">highest value tier</div>
    </div>
  </div>

  <div class="grid-2">
    <div class="panel">
      <div class="panel-header"><div class="panel-title">Signups — last 14 days</div></div>
      <div class="panel-body">
        <div class="chart-wrap"><canvas id="signupsChart"></canvas></div>
      </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1.5rem">
      <div class="panel">
        <div class="panel-header"><div class="panel-title">Plan interest breakdown</div></div>
        <div class="plan-bars">
          @php $realTotal = max(1, array_sum($byPlan->toArray())); @endphp
          @foreach(['pro' => '#e8a325', 'free' => '#5a5855', 'agency' => '#4a9eff'] as $plan => $color)
          <div class="plan-row">
            <div class="plan-name">{{ $plan }}</div>
            <div class="plan-bar-wrap">
              <div class="plan-bar" style="width:{{ round((($byPlan[$plan] ?? 0) / $realTotal) * 100) }}%;background:{{ $color }}"></div>
            </div>
            <div class="plan-count">{{ $byPlan[$plan] ?? 0 }}</div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="panel">
        <div class="panel-header"><div class="panel-title">📢 Broadcast to all subscribers</div></div>
        <div class="panel-body">
          <div class="broadcast-form">
            <input type="text" id="bc-subject" placeholder="Subject line..." />
            <textarea id="bc-body" placeholder="Your message...&#10;&#10;Variables: {name} {email}"></textarea>
            <div style="display:flex;align-items:center;gap:.8rem">
              <button class="btn btn-amber" onclick="sendBroadcast()" id="bc-btn">Send to all →</button>
              <span style="font-family:'Geist Mono',monospace;font-size:.62rem;color:#5a5855">{{ $entries->total() }} recipients</span>
            </div>
            <div id="broadcast-status"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="table-wrap">
    <div class="table-header">
      <div class="table-title">Entries <span style="color:#5a5855;font-weight:400">{{ $entries->total() }}</span></div>
      <input type="text" class="search-input" placeholder="Search email or name..." oninput="filterTable(this.value)" />
    </div>
    <table id="entries-table">
      <thead>
        <tr><th>#</th><th>Email</th><th>Name</th><th>Plan</th><th>Source</th><th>Date</th></tr>
      </thead>
      <tbody>
        @forelse($entries as $entry)
        <tr data-search="{{ strtolower($entry->email.' '.($entry->name ?? '')) }}">
          <td>{{ $entry->id }}</td>
          <td class="email-cell">{{ $entry->email }}</td>
          <td>{{ $entry->name ?? '—' }}</td>
          <td><span class="badge {{ $entry->plan_interest }}">{{ $entry->plan_interest }}</span></td>
          <td>{{ $entry->source ?? 'direct' }}</td>
          <td>{{ $entry->created_at->format('d M Y H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2.5rem;color:#5a5855">No signups yet.</td></tr>
        @endforelse
      </tbody>
    </table>
    @if($entries->hasPages())
    <div class="pagination">{{ $entries->links() }}</div>
    @endif
  </div>

</div>

<script>
new Chart(document.getElementById('signupsChart'), {
  type: 'bar',
  data: {
    labels: @json($chartLabels),
    datasets: [{
      data: @json($chartData),
      backgroundColor: 'rgba(232,163,37,0.2)',
      borderColor: '#e8a325',
      borderWidth: 1.5,
      borderRadius: 3,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#5a5855', font: { family: 'Geist Mono', size: 9 }, maxRotation: 0 } },
      y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#5a5855', font: { family: 'Geist Mono', size: 9 }, stepSize: 1 }, beginAtZero: true }
    }
  }
});

function filterTable(q) {
  q = q.toLowerCase();
  document.querySelectorAll('#entries-table tbody tr').forEach(r => {
    r.style.display = (r.dataset.search ?? '').includes(q) ? '' : 'none';
  });
}

async function sendBroadcast() {
  const subject = document.getElementById('bc-subject').value.trim();
  const body    = document.getElementById('bc-body').value.trim();
  const btn     = document.getElementById('bc-btn');
  const status  = document.getElementById('broadcast-status');
  if (!subject || !body) {
    status.style.display = 'block'; status.className = 'error';
    status.textContent = 'Subject and message required.'; return;
  }
  if (!confirm('Send this email to ALL subscribers?')) return;
  btn.disabled = true; btn.textContent = 'Sending...';
  try {
    const res = await fetch('{{ route("admin.broadcast") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
      body: JSON.stringify({ subject, body })
    });
    const data = await res.json();
    status.style.display = 'block';
    status.className = res.ok ? 'success' : 'error';
    status.textContent = data.message;
    if (res.ok) { document.getElementById('bc-subject').value = ''; document.getElementById('bc-body').value = ''; }
  } catch(e) {
    status.style.display = 'block'; status.className = 'error'; status.textContent = 'Network error.';
  } finally { btn.disabled = false; btn.textContent = 'Send to all →'; }
}
</script>
</body>
</html>
