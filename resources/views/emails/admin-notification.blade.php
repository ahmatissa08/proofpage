<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="background:#0c0c0e;margin:0;padding:40px 20px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif">
  <div style="max-width:480px;margin:0 auto;background:#131316;border:1px solid #242428;border-radius:10px;overflow:hidden">
    <div style="height:3px;background:#e8a325"></div>
    <div style="padding:32px">
      <div style="font-family:'Courier New',monospace;font-size:0.6rem;color:#e8a325;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:20px">
        🎉 New ProofWork signup
      </div>

      <table style="width:100%;border-collapse:collapse">
        <tr>
          <td style="font-family:'Courier New',monospace;font-size:0.7rem;color:#5a5855;padding:8px 0;border-bottom:1px solid #242428;width:110px">EMAIL</td>
          <td style="font-family:'Courier New',monospace;font-size:0.78rem;color:#f2f0eb;padding:8px 0;border-bottom:1px solid #242428">{{ $entry->email }}</td>
        </tr>
        @if($entry->name)
        <tr>
          <td style="font-family:'Courier New',monospace;font-size:0.7rem;color:#5a5855;padding:8px 0;border-bottom:1px solid #242428">NAME</td>
          <td style="font-family:'Courier New',monospace;font-size:0.78rem;color:#f2f0eb;padding:8px 0;border-bottom:1px solid #242428">{{ $entry->name }}</td>
        </tr>
        @endif
        <tr>
          <td style="font-family:'Courier New',monospace;font-size:0.7rem;color:#5a5855;padding:8px 0;border-bottom:1px solid #242428">PLAN</td>
          <td style="font-family:'Courier New',monospace;font-size:0.78rem;color:#e8a325;padding:8px 0;border-bottom:1px solid #242428">{{ ucfirst($entry->plan_interest) }}</td>
        </tr>
        <tr>
          <td style="font-family:'Courier New',monospace;font-size:0.7rem;color:#5a5855;padding:8px 0;border-bottom:1px solid #242428">SOURCE</td>
          <td style="font-family:'Courier New',monospace;font-size:0.78rem;color:#a09e9a;padding:8px 0;border-bottom:1px solid #242428">{{ $entry->source ?? 'direct' }}</td>
        </tr>
        <tr>
          <td style="font-family:'Courier New',monospace;font-size:0.7rem;color:#5a5855;padding:8px 0;border-bottom:1px solid #242428">IP</td>
          <td style="font-family:'Courier New',monospace;font-size:0.78rem;color:#a09e9a;padding:8px 0;border-bottom:1px solid #242428">{{ $entry->ip_address }}</td>
        </tr>
        <tr>
          <td style="font-family:'Courier New',monospace;font-size:0.7rem;color:#5a5855;padding:8px 0">TOTAL LIST</td>
          <td style="font-family:'Courier New',monospace;font-size:0.78rem;color:#4a9eff;padding:8px 0;font-weight:600">{{ number_format($total) }} people</td>
        </tr>
      </table>

      <div style="margin-top:24px">
        <a href="{{ route('admin.waitlist') }}" style="display:inline-block;background:#e8a325;color:#000;font-family:'Courier New',monospace;font-size:0.75rem;font-weight:600;padding:10px 20px;border-radius:4px;text-decoration:none;letter-spacing:0.04em">
          Open Admin Panel →
        </a>
      </div>
    </div>
  </div>
</body>
</html>
