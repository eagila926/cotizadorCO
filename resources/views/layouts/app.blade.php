<!doctype html>
<html lang="es" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Cotizador Ortomolecular')</title>

  {{-- Bootstrap + Icons (CDN, sin Vite) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

  


  <style>
    .navbar-gradient{
      background: #020024;
      background: linear-gradient(181deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 66%, rgba(0, 212, 255, 1) 100%);
    }
    .navbar-gradient .nav-link{
        color:#fff; !important;
    }
    .navbar-gradient .navbar-brand,
    .navbar-gradient .dropdown-item{
      color: #0f0f00; !important;
    }
    .navbar-gradient .dropdown-menu{
      
      border: none;
      box-shadow: 0 10px 25px rgba(0,0,0,.12);
    }
    .avatar-initial{
      width:32px;height:32px;border-radius:50%;
      display:inline-flex;align-items:center;justify-content:center;
      background: #020024;
      background: linear-gradient(181deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 66%, rgba(0, 212, 255, 1) 100%);
      font-weight:600;
    }
  </style>

  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    :root{--brand:#C9A84C;--brand-dark:#8f7226;--brand-soft:#f7efd9;--ink:#252217;--line:#e9dfc6}
    *{font-family:"DM Sans",system-ui,sans-serif}body{min-height:100vh;color:var(--ink);background:linear-gradient(135deg,#fbf8ef 0%,#fffdf8 48%,#f3ead4 100%)!important}h1,h2,h3,h4,h5,h6,.navbar-brand{font-family:"Manrope",sans-serif;letter-spacing:-.025em}main.container{max-width:1320px}
    .navbar-gradient{background:rgba(37,34,23,.97)!important;border-bottom:3px solid var(--brand);box-shadow:0 12px 32px rgba(54,43,15,.14)!important}.navbar-gradient .nav-link{color:rgba(255,255,255,.78)!important;border-radius:10px;padding:.55rem .75rem!important;transition:.2s}.navbar-gradient .nav-link:hover,.navbar-gradient .nav-link.fw-semibold{color:#fff!important;background:rgba(201,168,76,.18)}
    .navbar-gradient .dropdown-menu{border:1px solid var(--line);border-radius:14px;padding:.5rem;box-shadow:0 18px 45px rgba(37,34,23,.15)}.dropdown-item{border-radius:9px;padding:.55rem .75rem}.dropdown-item:hover,.dropdown-item:focus,.dropdown-item.active{background:var(--brand-soft);color:var(--ink)}.avatar-initial{width:34px!important;height:34px!important;border-radius:11px!important;background:var(--brand)!important;color:var(--ink);font-weight:800}
    .card{border:1px solid var(--line);border-radius:18px;box-shadow:0 12px 34px rgba(71,57,20,.07);overflow:hidden;background:rgba(255,255,255,.92)}.card-header{background:linear-gradient(90deg,var(--brand-soft),#fff);border-bottom:1px solid var(--line);font-weight:700}.btn{border-radius:10px;font-weight:600;padding:.55rem .9rem}.btn-primary,.btn-success,.btn-warning{--bs-btn-bg:var(--brand);--bs-btn-border-color:var(--brand);--bs-btn-color:var(--ink);--bs-btn-hover-bg:var(--brand-dark);--bs-btn-hover-border-color:var(--brand-dark);--bs-btn-hover-color:#fff}.btn-outline-primary{--bs-btn-color:var(--brand-dark);--bs-btn-border-color:var(--brand);--bs-btn-hover-bg:var(--brand);--bs-btn-hover-border-color:var(--brand);--bs-btn-hover-color:var(--ink)}
    .form-control,.form-select{border-color:var(--line);border-radius:10px;min-height:42px;background-color:#fffefb}.form-control:focus,.form-select:focus{border-color:var(--brand);box-shadow:0 0 0 .2rem rgba(201,168,76,.18)}.table{--bs-table-striped-bg:rgba(201,168,76,.07);--bs-table-hover-bg:rgba(201,168,76,.12)}.table thead th{background:#302c20;color:#fff;border-color:#4b432e;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em}.badge.bg-primary,.badge.bg-success,.bg-primary,.bg-success{background-color:var(--brand)!important;color:var(--ink)!important}.modal-content{border:1px solid var(--line);border-radius:18px}.modal-header{background:var(--brand-soft);border-color:var(--line)}
  </style>
  @stack('head')
</head>
<body>

  @include('partials.navbar')

  <main class="container py-4">
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @include('recetas.partials.public_links_modal')
  <script>
    // --- Dark mode toggle (Bootstrap 5.3 data-bs-theme) ---
    (function(){
      const html = document.documentElement;
      const saved = localStorage.getItem('theme');
      if(saved){ html.setAttribute('data-bs-theme', saved); }

      document.addEventListener('click', e=>{
        const t = e.target.closest('[data-toggle-theme]');
        if(!t) return;
        const curr = html.getAttribute('data-bs-theme') || 'light';
        const next = curr === 'light' ? 'dark' : 'light';
        html.setAttribute('data-bs-theme', next);
        localStorage.setItem('theme', next);
      });

      // Fullscreen
      document.addEventListener('click', e=>{
        const f = e.target.closest('[data-fullscreen]');
        if(!f) return;
        if (!document.fullscreenElement) {
          document.documentElement.requestFullscreen?.();
        } else {
          document.exitFullscreen?.();
        }
      });
    })();
  </script>

  @stack('scripts')
</body>
</html>
