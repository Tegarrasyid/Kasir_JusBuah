@extends('layouts.kasir.app')

@section('title','Dashboard Kasir')
@section('content')

<!-- ============================
      KASIR PAGE (Product + Order)
      ============================ -->
<div class="app-layout" id="kasir-layout">
  <!-- Product Area -->
  <div class="products-area">
    <!-- Toolbar -->
    <div class="product-toolbar">
      <div class="search-box">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input id="product-search" type="text" placeholder="Cari produk..." />
      </div>
    </div>

    <!-- Category Tabs -->
    <div class="category-tabs" id="category-tabs"></div>

    <!-- Section Header -->
    <div class="section-header">
      <span class="section-title">Menu Tersedia</span>
      <span class="section-count" id="product-count">0 item</span>
    </div>

    <!-- Product Grid -->
    <div class="product-grid" id="product-grid"></div>
  </div>

  @include('kasir.partials.sidebar')

</div>


<script>
  window.PRODUCTS = @json($produk);
  window.kasirName = "{{ Auth::user()->name }}";
</script>

@endsection