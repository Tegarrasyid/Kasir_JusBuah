/**
 * products.js — Product catalog data & rendering
 */

const ProductCatalog = (() => {

  const PRODUCTS = [
    // ☕ Minuman
    { id: 1,  name: 'Espresso',        category: 'minuman', emoji: '☕', price: 22000,  variant: 'Single Shot',    badge: null,    stock: true  },
    { id: 2,  name: 'Cappuccino',      category: 'minuman', emoji: '🥛', price: 32000,  variant: 'Hot / Iced',    badge: 'hot',   stock: true  },
    { id: 3,  name: 'Matcha Latte',    category: 'minuman', emoji: '🍵', price: 38000,  variant: 'Hot / Iced',    badge: 'new',   stock: true  },
    { id: 4,  name: 'Cold Brew',       category: 'minuman', emoji: '🧊', price: 35000,  variant: 'Original',      badge: null,    stock: true  },
    { id: 5,  name: 'Caramel Macch.',  category: 'minuman', emoji: '🍶', price: 42000,  variant: 'Iced',           badge: 'promo', stock: true  },
    { id: 6,  name: 'Teh Tarik',       category: 'minuman', emoji: '🧋', price: 28000,  variant: 'Original',      badge: null,    stock: true  },
    { id: 7,  name: 'Jus Alpukat',     category: 'minuman', emoji: '🥑', price: 30000,  variant: 'Segar',          badge: null,    stock: false },
    { id: 8,  name: 'Lemon Tea',       category: 'minuman', emoji: '🍋', price: 24000,  variant: 'Hot / Iced',    badge: null,    stock: true  },

    // 🍞 Makanan
    { id: 9,  name: 'Croissant',       category: 'makanan', emoji: '🥐', price: 28000,  variant: 'Original',      badge: null,    stock: true  },
    { id: 10, name: 'Sandwich Ayam',   category: 'makanan', emoji: '🥪', price: 45000,  variant: 'Grilled',       badge: 'hot',   stock: true  },
    { id: 11, name: 'Nasi Goreng',     category: 'makanan', emoji: '🍳', price: 38000,  variant: 'Spesial',       badge: null,    stock: true  },
    { id: 12, name: 'Waffle',          category: 'makanan', emoji: '🧇', price: 35000,  variant: 'Maple Syrup',   badge: 'new',   stock: true  },
    { id: 13, name: 'Pasta Carbonara', category: 'makanan', emoji: '🍝', price: 58000,  variant: 'Creamy',        badge: null,    stock: true  },
    { id: 14, name: 'Salad Bowl',      category: 'makanan', emoji: '🥗', price: 42000,  variant: 'Caesar / Thai', badge: 'promo', stock: true  },
    { id: 15, name: 'French Fries',    category: 'makanan', emoji: '🍟', price: 25000,  variant: 'Regular / BBQ', badge: null,    stock: true  },
    { id: 16, name: 'Burger Smoke',    category: 'makanan', emoji: '🍔', price: 55000,  variant: 'Double Patty',  badge: 'hot',   stock: false },

    // 🍰 Dessert
    { id: 17, name: 'Tiramisu',        category: 'dessert', emoji: '🍮', price: 45000,  variant: 'Slice',         badge: null,    stock: true  },
    { id: 18, name: 'Choco Lava',      category: 'dessert', emoji: '🍫', price: 40000,  variant: 'Warm',          badge: 'hot',   stock: true  },
    { id: 19, name: 'Cheesecake',      category: 'dessert', emoji: '🎂', price: 42000,  variant: 'Strawberry',    badge: 'new',   stock: true  },
    { id: 20, name: 'Ice Cream',       category: 'dessert', emoji: '🍨', price: 28000,  variant: '2 Scoop',       badge: null,    stock: true  },
    { id: 21, name: 'Brownie',         category: 'dessert', emoji: '🍩', price: 30000,  variant: 'Fudge',         badge: null,    stock: true  },
    { id: 22, name: 'Pudding Susu',    category: 'dessert', emoji: '🍮', price: 22000,  variant: 'Caramel',       badge: 'promo', stock: true  },

    // 🛍 Paket
    { id: 23, name: 'Set Sarapan A',   category: 'paket',   emoji: '🌅', price: 65000,  variant: 'Croissant + Kopi', badge: 'promo', stock: true },
    { id: 24, name: 'Set Makan Siang', category: 'paket',   emoji: '☀️', price: 85000,  variant: 'Nasi + Jus',       badge: null,    stock: true },
    { id: 25, name: 'Set Sore',        category: 'paket',   emoji: '🌇', price: 55000,  variant: 'Waffle + Teh',     badge: 'new',   stock: true },
  ];

  const CATEGORIES = [
    { id: 'semua',   label: 'Semua',    emoji: '✨' },
    { id: 'minuman', label: 'Minuman',  emoji: '☕' },
    { id: 'makanan', label: 'Makanan',  emoji: '🍳' },
    { id: 'dessert', label: 'Dessert',  emoji: '🍰' },
    { id: 'paket',   label: 'Paket',    emoji: '🎁' },
  ];

  let activeCategory = 'semua';
  let searchQuery    = '';

  /* ---- Format currency ---- */
  function formatRp(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
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
        </button>`;
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
      const matchCat = activeCategory === 'semua' || p.category === activeCategory;
      const matchQ   = p.name.toLowerCase().includes(searchQuery.toLowerCase());
      return matchCat && matchQ;
    });

    const countEl = document.getElementById('product-count');
    if (countEl) countEl.textContent = `${filtered.length} item`;

    if (!filtered.length) {
      grid.innerHTML = `
        <div class="empty-state">
          <div class="empty-icon">🔍</div>
          <p>Produk tidak ditemukan</p>
        </div>`;
      return;
    }

    grid.innerHTML = filtered.map((p, i) => {
      const badgeHtml = p.badge
        ? `<span class="product-badge badge-${p.badge}">${
            p.badge === 'hot' ? '🔥 Hot' : p.badge === 'new' ? '✨ New' : '🏷 Promo'
          }</span>`
        : '';
      const oos = !p.stock ? 'out-of-stock' : '';
      return `
        <div class="product-card ${oos}" data-id="${p.id}"
             style="animation-delay:${i * 0.04}s">
          <div class="product-emoji-wrap">
            <span>${p.emoji}</span>
            ${badgeHtml}
          </div>
          <div class="product-name">${p.name}</div>
          <div class="product-variant">${p.variant}${!p.stock ? ' · <span style="color:var(--red)">Habis</span>' : ''}</div>
          <div class="product-footer">
            <span class="product-price">${formatRp(p.price)}</span>
            <button class="add-btn" title="Tambah ke pesanan">+</button>
          </div>
        </div>`;
    }).join('');

    // Click handlers
    grid.querySelectorAll('.product-card').forEach(card => {
      card.addEventListener('click', (e) => {
        const id = parseInt(card.dataset.id);
        const product = PRODUCTS.find(p => p.id === id);
        if (!product || !product.stock) return;

        // Pop animation
        card.classList.remove('adding');
        void card.offsetWidth;
        card.classList.add('adding');

        OrderPanel.addItem(product);
      });
    });
  }

  /* ---- Init ---- */
  function init() {
    buildCategories();
    renderProducts();

    // Search
    const searchInput = document.getElementById('product-search');
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value;
        renderProducts();
      });
    }
  }

  return { init, PRODUCTS };
})();
