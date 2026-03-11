<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Amerta — Aplikasi Kasir</title>

  <link rel="stylesheet" href="{{ asset('assets/kasir/css/main.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/navbar.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/products.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/order.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/kasir/css/transactions.css')}}" />

  <style>
    /* print receipt */
    @media print {
      body > *:not(#receipt-modal) { display: none !important; }
      #receipt-modal { position: static !important; background: white !important; }
      .modal { box-shadow: none; }
      .print-btn, .modal-close { display: none !important; }
    }
    .app-outer { display: flex; flex-direction: column; min-height: 100vh; }

    .payment-input{
      display:flex;
      flex-direction:column;
      gap:6px;
      margin-bottom:16px;
    }

    .payment-label{
      font-size:0.75rem;
      color:var(--text-light);
      font-weight:600;
    }

    .payment-field{
      padding:8px 10px;
      border-radius:6px;
      border:1px solid #ddd;
      font-size:0.9rem;
    }

    .product-img{
      width:150px;
      height:150px;
      object-fit:cover;
      border-radius:10px;
    }

    .out-of-stock{
      opacity:0.4;
      filter: grayscale(100%);
      pointer-events:none;
    }
  </style>
</head>

<body>
<div class="app-outer">

  <!-- ============================
       NAVBAR
       ============================ -->
  @include('kasir.partials.navbar')

  

  <main class="main-content">
    <div class="content">
        @yield('content')
        
    </div>

  </main><!-- /.main-content -->

</div><!-- /.app-outer -->


<!-- Toast Container -->
<div class="toast-container" id="toast-container"></div>

<!-- Scripts (order matters) -->
<script src="{{ asset('assets/kasir/js/products.js')}}"></script>
<script src="{{ asset('assets/kasir/js/order.js')}}"></script>
<script src="{{ asset('assets/kasir/js/transactions.js')}}"></script>
<script src="{{ asset('assets/kasir/js/app.js')}}"></script>

</body>
</html>
