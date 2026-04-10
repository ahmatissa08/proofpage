<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ProofWork Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400;500&family=Instrument+Serif:ital@1&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#0c0c0e;color:#f2f0eb;font-family:'Geist Mono',monospace;min-height:100vh;display:flex;align-items:center;justify-content:center}
.card{background:#131316;border:1px solid #242428;border-radius:10px;padding:2.5rem;width:100%;max-width:340px}
.card-title{font-family:'Instrument Serif',serif;font-size:1.8rem;font-style:italic;margin-bottom:.3rem}
.card-sub{font-size:.7rem;color:#5a5855;letter-spacing:.1em;text-transform:uppercase;margin-bottom:2rem}
input[type=password]{width:100%;background:#0c0c0e;border:1px solid #2e2e34;color:#f2f0eb;padding:.75rem 1rem;font-family:'Geist Mono',monospace;font-size:.82rem;border-radius:4px;outline:none;transition:border-color .2s;margin-bottom:1rem}
input[type=password]:focus{border-color:#e8a325}
button{width:100%;background:#e8a325;color:#000;border:none;padding:.78rem;font-family:'Geist Mono',monospace;font-size:.8rem;font-weight:500;border-radius:4px;cursor:pointer;letter-spacing:.04em;transition:opacity .15s}
button:hover{opacity:.88}
.error{font-size:.7rem;color:#e85c3a;margin-bottom:1rem}
</style>
</head>
<body>
<div class="card">
  <div class="card-title">ProofWork</div>
  <div class="card-sub">Admin access</div>
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif
  <form action="{{ route('admin.login') }}" method="POST">
    @csrf
    <input type="password" name="password" placeholder="Password" autofocus autocomplete="current-password">
    <button type="submit">Enter →</button>
  </form>
</div>
</body>
</html>
