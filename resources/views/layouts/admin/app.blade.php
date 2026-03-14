<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('assets/admin/css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/pages.css') }}">

  @stack('styles')
</head>
<body>

<div class="app-shell">

  <!-- =============================================
       SIDEBAR
       ============================================= -->
  
  @include('admin.partials.sidebar')

  <!-- =============================================
       TOPBAR
       ============================================= -->

  @include('admin.partials.topbar')



  <!-- =============================================
       MAIN CONTENT
       ============================================= -->
  <main class="main-content">
    <span class="current">
        @yield('breadcrumb','Dashboard')
    </span>
    <div class="content">
        @yield('content')
    </div>


  </main><!-- /.main-content -->
</div><!-- /.app-shell -->

<!-- =============================================
     MOBILE SIDEBAR OVERLAY
     ============================================= -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>
<button class="sidebar-toggle-btn" id="sidebar-toggle">☰</button>

<!-- Toast -->
<div class="toast-wrap" id="toast-wrap"></div>

<!-- Scripts -->
<script src="{{ asset('assets/admin/js/app.js')}}"></script>
<script src="{{ asset('assets/admin/js/store.js')}}"></script>
<script src="{{ asset('assets/admin/js/dashboard.js')}}"></script>
<script src="{{ asset('assets/admin/js/pages.js')}}"></script>
{{-- script untuk jam dinavbar --}}
<script>
    function updateTopbarClock() {
        const clock = document.getElementById('topbar-clock');
        if (!clock) return;
        const now = new Date();
        const time = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const date = now.toLocaleDateString('id-ID', {
            weekday: 'short',
            day: '2-digit',
            month: 'short'
        });
        clock.textContent = `${time}`;
        // clock.textContent = `${date} • ${time}`;
    }

    setInterval(updateTopbarClock, 1000);
    updateTopbarClock();
</script>
<script>
    document.addEventListener("DOMContentLoaded", function(){DashboardPage.init();});
</script>
</body>
</html>
