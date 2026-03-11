/**
 * products.js — Product catalog from Laravel database
 */

const ProductCatalog = (() => {

  const RAW_PRODUCTS = window.PRODUCTS || [];

  /*
  Convert database structure → UI structure
  supaya tetap kompatibel dengan UI lama
  */
  const PRODUCTS = RAW_PRODUCTS.map(p => ({
    id: p.id,
    name: p.nama_produk,
    price: p.harga_jual,
    category: p.nama_kategori || 'lainnya',
    emoji: p.emoji || '🍽',
    variant: p.deskripsi || '',
    foto: p.foto,
    badge: null,
    stock: Boolean(p.stok_produk)
  }));

  //filter(Boolean) supaya tidak ada kategori kosong dari database
  const uniqueCategories = [...new Set(PRODUCTS.map(p => p.category).filter(Boolean))];

  const CATEGORIES = [
    { id: 'semua', label: 'Semua', emoji: '✨' },
    ...uniqueCategories.map(cat => ({
      id: cat,
      label: cat.charAt(0).toUpperCase() + cat.slice(1),
      emoji: '🍽'
    }))
  ];


  let activeCategory = 'semua';
  let searchQuery = '';

  /* ---- Format currency ---- */

  function formatRp(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
  }

  window.formatRp = formatRp;


  /* ---- Build category tabs ---- */

  function buildCategories() {

    const container = document.getElementById('category-tabs');
    if (!container) return;

    container.innerHTML = CATEGORIES.map(cat => {

      const count = cat.id === 'semua'
        ? PRODUCTS.length
        : PRODUCTS.filter(p => p.category === cat.id).length;

      const active = cat.id === activeCategory ? 'active' : '';

      return `
        <button class="cat-tab ${active}" data-cat="${cat.id}">
          <span class="cat-emoji">${cat.emoji}</span>
          ${cat.label}
          <span class="cat-count">${count}</span>
        </button>
      `;

    }).join('');

    container.querySelectorAll('.cat-tab').forEach(btn => {

      btn.addEventListener('click', () => {

        activeCategory = btn.dataset.cat;

        buildCategories();
        renderProducts();

      });

    });

  }


  /* ---- Render product cards ---- */

  function renderProducts() {

    const grid = document.getElementById('product-grid');
    if (!grid) return;

    let filtered = PRODUCTS.filter(p => {

      const matchCat =
        activeCategory === 'semua' || p.category === activeCategory;

      const matchQ =
        p.name.toLowerCase().includes(searchQuery.toLowerCase());

      return matchCat && matchQ;

    });


    const countEl = document.getElementById('product-count');

    if (countEl) {
      countEl.textContent = `${filtered.length} item`;
    }


    if (!filtered.length) {

      grid.innerHTML = `
        <div class="empty-state">
          <div class="empty-icon">🔍</div>
          <p>Produk tidak ditemukan</p>
        </div>
      `;

      return;
    }


    grid.innerHTML = filtered.map((p, i) => {

      const badgeHtml = p.badge
        ? `<span class="product-badge badge-${p.badge}">
            ${p.badge === 'hot' ? '🔥 Hot'
            : p.badge === 'new' ? '✨ New'
            : '🏷 Promo'}
          </span>`
        : '';

      const oos = !p.stock ? 'out-of-stock' : '';

      return `
        <div class="product-card ${oos}" data-id="${p.id}"
             style="animation-delay:${i * 0.04}s">

          <div class="product-emoji-wrap">
            <img src="/storage/${p.foto}" class="product-img">
            ${badgeHtml}
          </div>

          <div class="product-name">${p.name}</div>

          <div class="product-variant">
            ${p.variant}
            ${!p.stock ? ' · <span style="color:var(--red)">Habis</span>' : ''}
          </div>

          <div class="product-footer">

            <span class="product-price">
              ${formatRp(p.price)}
            </span>

            <button class="add-btn">+</button>

          </div>

        </div>
      `;

    }).join('');


    /* ---- Click product ---- */

    grid.querySelectorAll('.product-card').forEach(card => {

      card.addEventListener('click', () => {

        const id = parseInt(card.dataset.id);

        const product = PRODUCTS.find(p => p.id === id);

        if (!product || !product.stock) return;

        card.classList.remove('adding');
        void card.offsetWidth;
        card.classList.add('adding');

        OrderPanel.addItem({
          id: product.id,
          name: product.name,
          price: product.price,
          emoji: product.emoji
        });

      });

    });

  }


  /* ---- Init ---- */

  function init() {

    buildCategories();
    renderProducts();

    const searchInput = document.getElementById('product-search');

    if (searchInput) {

      searchInput.addEventListener('input', e => {

        searchQuery = e.target.value;

        renderProducts();

      });

    }

  }

  return { init };

})();