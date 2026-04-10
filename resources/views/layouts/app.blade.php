<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'ProofWork — Your work, proven.')</title>
  <meta name="description" content="@yield('meta_description', 'Auto-generate client-ready proof of work from GitHub, Notion, Calendar, and more.')">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- OG tags for Reddit sharing -->
  <meta property="og:title" content="ProofWork — Stop writing reports. Start proving your work.">
  <meta property="og:description" content="Auto-generate client-ready proof of work from GitHub, Linear, Calendar. No more 'trust me' invoices.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url('/') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist+Mono:wght@300;400;500&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">

  @stack('styles')
</head>
<body>
  @yield('content')
  @stack('scripts')
</body>
</html>
