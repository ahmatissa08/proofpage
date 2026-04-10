<?php

namespace App\Http\Controllers;

use App\Mail\BroadcastMail;
use App\Mail\WaitlistConfirmationMail;
use App\Mail\WaitlistAdminNotificationMail;
use App\Models\WaitlistEntry;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WaitlistController extends Controller
{
    public function __construct(protected TelegramService $telegram) {}

    // ── Landing page
    public function index()
    {
        $count = WaitlistEntry::count() + 214;
        return view('landing', compact('count'));
    }

    // ── Store signup
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'         => ['required', 'email', 'max:255'],
            'name'          => ['nullable', 'string', 'max:120'],
            'plan_interest' => ['nullable', 'in:free,pro,agency'],
        ]);

        if (WaitlistEntry::where('email', $validated['email'])->exists()) {
            return response()->json([
                'status'  => 'already_exists',
                'message' => "You're already on the list!",
            ], 200);
        }

        $entry = WaitlistEntry::create([
            'email'         => $validated['email'],
            'name'          => $validated['name'] ?? null,
            'plan_interest' => $validated['plan_interest'] ?? 'pro',
            'source'        => $request->input('utm_source')
                                ?? parse_url($request->headers->get('referer') ?? '', PHP_URL_HOST),
            'ip_address'    => $request->ip(),
            'user_agent'    => substr($request->userAgent() ?? '', 0, 512),
        ]);

        $total    = WaitlistEntry::count() + 214;
        $position = WaitlistEntry::count();

        // Emails
        try {
            Mail::to($entry->email)->send(new WaitlistConfirmationMail($entry));
        } catch (\Throwable $e) {
            Log::error('Confirmation email failed: ' . $e->getMessage());
        }

        try {
            $adminEmail = config('proofwork.admin_email');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new WaitlistAdminNotificationMail($entry, $total));
            }
        } catch (\Throwable $e) {
            Log::error('Admin email failed: ' . $e->getMessage());
        }

        // Telegram
        try {
            $this->telegram->notifyNewSignup($entry, $total);
        } catch (\Throwable $e) {
            Log::error('Telegram notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'status'   => 'success',
            'message'  => "You're on the list! Check your inbox.",
            'count'    => $total,
            'position' => $position,
            'redirect' => route('thankyou', [
                'name' => $entry->name ?? '',
                'plan' => $entry->plan_interest,
                'pos'  => $position,
            ]),
        ], 201);
    }

    // ── Thank you page
    public function thankyou(Request $request)
    {
        $name     = $request->query('name', '');
        $plan     = $request->query('plan', 'pro');
        $position = (int) $request->query('pos', WaitlistEntry::count() + 214);

        return view('thankyou', compact('name', 'plan', 'position'));
    }

    // ── Admin dashboard
    public function admin()
    {
        $entries    = WaitlistEntry::orderByDesc('created_at')->paginate(50);
        $total      = WaitlistEntry::count() + 214;
        $byPlan     = WaitlistEntry::selectRaw('plan_interest, count(*) as cnt')
                          ->groupBy('plan_interest')->pluck('cnt', 'plan_interest');
        $todayCount = WaitlistEntry::whereDate('created_at', today())->count();
        $weekCount  = WaitlistEntry::where('created_at', '>=', now()->subDays(7))->count();

        // Chart: last 14 days
        $chartLabels = [];
        $chartData   = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $chartLabels[] = $day->format('d M');
            $chartData[]   = WaitlistEntry::whereDate('created_at', $day->toDateString())->count();
        }

        return view('admin.waitlist', compact(
            'entries', 'total', 'byPlan', 'todayCount', 'weekCount', 'chartLabels', 'chartData'
        ));
    }

    // ── Export CSV
    public function export()
    {
        $entries = WaitlistEntry::orderByDesc('created_at')->get();
        $csv = "id,email,name,plan_interest,source,ip_address,signed_up_at\n";
        foreach ($entries as $e) {
            $csv .= implode(',', [
                $e->id,
                $e->email,
                '"' . str_replace('"', '""', $e->name ?? '') . '"',
                $e->plan_interest,
                $e->source ?? '',
                $e->ip_address ?? '',
                $e->created_at->toIso8601String(),
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="proofwork-waitlist-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }

    // ── Broadcast email to all subscribers
    public function broadcast(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:200'],
            'body'    => ['required', 'string', 'max:5000'],
        ]);

        $entries = WaitlistEntry::all();
        $sent    = 0;
        $failed  = 0;

        foreach ($entries as $entry) {
            try {
                Mail::to($entry->email)->send(new BroadcastMail(
                    broadcastSubject: $request->subject,
                    broadcastBody:    $request->body,
                    recipientName:    $entry->name ?? '',
                ));
                $sent++;
            } catch (\Throwable $e) {
                Log::error("Broadcast failed for {$entry->email}: " . $e->getMessage());
                $failed++;
            }
        }

        return response()->json([
            'message' => "Sent to {$sent} subscribers." . ($failed > 0 ? " {$failed} failed." : ''),
        ], 200);
    }
}
