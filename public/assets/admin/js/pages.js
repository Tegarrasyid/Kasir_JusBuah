/**
 * pages.js — All CRUD page renderers
 */

/* ================================================
   USERS PAGE
   ================================================ */
const UsersPage = (() => {
  let editId = null;

  function render(q = '') {
    const users = Store.get('users').filter(u =>
      u.name.toLowerCase().includes(q.toLowerCase()) ||
      u.username.toLowerCase().includes(q.toLowerCase())
    );
    const tbody = document.getElementById('users-tbody');
    if (!tbody) return;

    const roleLabel = { admin:'Admin', kasir:'Kasir', manajer:'Manajer' };
    const roleClass = { admin:'role-admin', kasir:'role-kasir', manajer:'role-manajer' };
    const colors    = ['#10b981','#3b82f6','#f59e0b','#a78bfa','#ef4444'];

    if (!users.length) {
      tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-muted)">Tidak ada data</td></tr>`;
      return;
    }
    tbody.innerHTML = users.map(u => {
      const c = colors[u.id % colors.length];
      const init = u.name.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
      return `
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="table-avatar" style="background:${c}22;color:${c}">${init}</div>
              <div>
                <div style="font-weight:700">${u.name}</div>
                <div style="font-size:0.72rem;color:var(--text-muted)">@${u.username}</div>
              </div>
            </div>
          </td>
          <td>${u.email}</td>
          <td>${u.phone}</td>
          <td><span class="badge ${roleClass[u.role]}">${roleLabel[u.role]}</span></td>
          <td><span class="badge ${u.active ? 'badge-green':'badge-red'}">${u.active?'Aktif':'Nonaktif'}</span></td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn-icon" title="Edit" onclick="UsersPage.openEdit(${u.id})">✏️</button>
              <button class="btn-icon" title="Hapus" onclick="UsersPage.del(${u.id})">🗑</button>
            </div>
          </td>
        </tr>`;
    }).join('');
  }

  function openAdd() {
    editId = null;
    document.getElementById('user-modal-title').textContent = 'Tambah Pengguna';
    document.getElementById('user-form').reset();
    document.getElementById('user-pass-row').style.display = '';
    Modal.open('user-modal');
  }

  function openEdit(id) {
    const users = Store.get('users');
    const u = users.find(u => u.id === id);
    if (!u) return;
    editId = id;
    document.getElementById('user-modal-title').textContent = 'Edit Pengguna';
    document.getElementById('u-name').value     = u.name;
    document.getElementById('u-username').value = u.username;
    document.getElementById('u-email').value    = u.email;
    document.getElementById('u-phone').value    = u.phone;
    document.getElementById('u-role').value     = u.role;
    document.getElementById('u-active').value   = String(u.active);
    document.getElementById('user-pass-row').style.display = 'none';
    Modal.open('user-modal');
  }

  function save() {
    const name     = document.getElementById('u-name').value.trim();
    const username = document.getElementById('u-username').value.trim();
    const email    = document.getElementById('u-email').value.trim();
    const phone    = document.getElementById('u-phone').value.trim();
    const role     = document.getElementById('u-role').value;
    const active   = document.getElementById('u-active').value === 'true';

    if (!name || !username) { Toast.show('Nama dan username wajib diisi','error'); return; }

    const users = Store.get('users');
    if (editId) {
      const idx = users.findIndex(u => u.id === editId);
      if (idx > -1) Object.assign(users[idx], { name, username, email, phone, role, active });
      Toast.show('Pengguna berhasil diperbarui', 'success');
    } else {
      users.push({ id: Store.nextId(users), name, username, email, phone, role, active, joined: new Date().toISOString().split('T')[0] });
      Toast.show('Pengguna berhasil ditambahkan', 'success');
    }
    Store.set('users', users);
    Modal.closeAll();
    render();
  }

  function del(id) {
    if (!confirm('Hapus pengguna ini?')) return;
    const users = Store.get('users').filter(u => u.id !== id);
    Store.set('users', users);
    render();
    Toast.show('Pengguna dihapus', 'info');
  }

  function init() {
    document.getElementById('users-search')?.addEventListener('input', e => render(e.target.value));
    document.getElementById('btn-add-user')?.addEventListener('click', openAdd);
    document.getElementById('btn-save-user')?.addEventListener('click', save);
    render();
  }

  return { init, render, openEdit, del, openAdd };
})();

/* ================================================
   CATEGORIES PAGE
   ================================================ */
const CategoriesPage = (() => {
  let editId = null;

  function render(q = '') {
    const cats = Store.get('categories').filter(c =>
      c.name.toLowerCase().includes(q.toLowerCase())
    );
    const tbody = document.getElementById('cats-tbody');
    if (!tbody) return;

    const products = Store.get('products');
    if (!cats.length) { tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted)">Tidak ada data</td></tr>`; return; }
    tbody.innerHTML = cats.map(c => {
      const prodCount = products.filter(p => p.catId === c.id).length;
      return `
        <tr>
          <td><span style="font-size:1.5rem">${c.emoji}</span></td>
          <td>${c.name}</td>
          <td style="max-width:240px;color:var(--text-muted)">${c.desc || '-'}</td>
          <td>${prodCount} produk</td>
          <td><span class="badge ${c.active?'badge-green':'badge-red'}">${c.active?'Aktif':'Nonaktif'}</span></td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn-icon" onclick="CategoriesPage.openEdit(${c.id})">✏️</button>
              <button class="btn-icon" onclick="CategoriesPage.del(${c.id})">🗑</button>
            </div>
          </td>
        </tr>`;
    }).join('');
  }

  function openAdd() {
    editId = null;
    document.getElementById('cat-modal-title').textContent = 'Tambah Kategori';
    document.getElementById('cat-form').reset();
    Modal.open('cat-modal');
  }

  function openEdit(id) {
    const c = Store.get('categories').find(c => c.id === id);
    if (!c) return;
    editId = id;
    document.getElementById('cat-modal-title').textContent = 'Edit Kategori';
    document.getElementById('c-name').value   = c.name;
    document.getElementById('c-emoji').value  = c.emoji;
    document.getElementById('c-desc').value   = c.desc || '';
    document.getElementById('c-active').value = String(c.active);
    Modal.open('cat-modal');
  }

  function save() {
    const name   = document.getElementById('c-name').value.trim();
    const emoji  = document.getElementById('c-emoji').value.trim() || '📦';
    const desc   = document.getElementById('c-desc').value.trim();
    const active = document.getElementById('c-active').value === 'true';
    if (!name) { Toast.show('Nama kategori wajib diisi','error'); return; }

    const cats = Store.get('categories');
    if (editId) {
      const idx = cats.findIndex(c => c.id === editId);
      if (idx > -1) Object.assign(cats[idx], { name, emoji, desc, active });
      Toast.show('Kategori diperbarui', 'success');
    } else {
      cats.push({ id: Store.nextId(cats), name, emoji, desc, active });
      Toast.show('Kategori ditambahkan', 'success');
    }
    Store.set('categories', cats);
    Modal.closeAll();
    render();
  }

  function del(id) {
    if (!confirm('Hapus kategori ini?')) return;
    Store.set('categories', Store.get('categories').filter(c => c.id !== id));
    render(); Toast.show('Kategori dihapus', 'info');
  }

  function init() {
    document.getElementById('cats-search')?.addEventListener('input', e => render(e.target.value));
    document.getElementById('btn-add-cat')?.addEventListener('click', openAdd);
    document.getElementById('btn-save-cat')?.addEventListener('click', save);
    render();
  }

  return { init, render, openEdit, del };
})();

/* ================================================
   PRODUCTS PAGE
   ================================================ */
const ProductsPage = (() => {
  let editId = null;

  function populateCatSelect(selectId) {
    const sel = document.getElementById(selectId);
    if (!sel) return;
    const cats = Store.get('categories');
    sel.innerHTML = '<option value="">-- Pilih Kategori --</option>' +
      cats.map(c => `<option value="${c.id}">${c.emoji} ${c.name}</option>`).join('');
  }

  function render(q = '') {
    const products = Store.get('products').filter(p =>
      p.name.toLowerCase().includes(q.toLowerCase())
    );
    const tbody = document.getElementById('products-tbody');
    if (!tbody) return;

    if (!products.length) { tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">Tidak ada data</td></tr>`; return; }
    tbody.innerHTML = products.map(p => `
      <tr>
        <td><span style="font-size:1.4rem">${p.emoji||'📦'}</span></td>
        <td>${p.name}</td>
        <td>${Store.getCategoryName(p.catId)}</td>
        <td style="font-weight:700;color:var(--emerald)">${fRpFull(p.price)}</td>
        <td style="color:var(--text-muted)">${fRpFull(p.cost||0)}</td>
        <td><span class="badge ${p.stock?'badge-green':'badge-red'}">${p.stock?'Tersedia':'Habis'}</span></td>
        <td>
          <div style="display:flex;gap:6px">
            <button class="btn-icon" onclick="ProductsPage.openEdit(${p.id})">✏️</button>
            <button class="btn-icon" onclick="ProductsPage.del(${p.id})">🗑</button>
          </div>
        </td>
      </tr>`).join('');
  }

  function openAdd() {
    editId = null;
    populateCatSelect('p-catid');
    document.getElementById('prod-modal-title').textContent = 'Tambah Produk';
    document.getElementById('prod-form').reset();
    Modal.open('prod-modal');
  }

  function openEdit(id) {
    const p = Store.get('products').find(p => p.id === id);
    if (!p) return;
    editId = id;
    populateCatSelect('p-catid');
    document.getElementById('prod-modal-title').textContent = 'Edit Produk';
    document.getElementById('p-name').value   = p.name;
    document.getElementById('p-emoji').value  = p.emoji || '';
    document.getElementById('p-catid').value  = p.catId;
    document.getElementById('p-price').value  = p.price;
    document.getElementById('p-cost').value   = p.cost || '';
    document.getElementById('p-stock').value  = String(p.stock);
    Modal.open('prod-modal');
  }

  function save() {
    const name  = document.getElementById('p-name').value.trim();
    const emoji = document.getElementById('p-emoji').value.trim() || '📦';
    const catId = parseInt(document.getElementById('p-catid').value);
    const price = parseInt(document.getElementById('p-price').value);
    const cost  = parseInt(document.getElementById('p-cost').value) || 0;
    const stock = document.getElementById('p-stock').value === 'true';
    if (!name || !catId || !price) { Toast.show('Nama, kategori, dan harga wajib diisi','error'); return; }

    const prods = Store.get('products');
    if (editId) {
      const idx = prods.findIndex(p => p.id === editId);
      if (idx > -1) Object.assign(prods[idx], { name, emoji, catId, price, cost, stock });
      Toast.show('Produk diperbarui', 'success');
    } else {
      prods.push({ id: Store.nextId(prods), name, emoji, catId, price, cost, stock });
      Toast.show('Produk ditambahkan', 'success');
    }
    Store.set('products', prods);
    Modal.closeAll(); render();
  }

  function del(id) {
    if (!confirm('Hapus produk ini?')) return;
    Store.set('products', Store.get('products').filter(p => p.id !== id));
    render(); Toast.show('Produk dihapus', 'info');
  }

  function init() {
    document.getElementById('products-search')?.addEventListener('input', e => render(e.target.value));
    document.getElementById('btn-add-product')?.addEventListener('click', openAdd);
    document.getElementById('btn-save-product')?.addEventListener('click', save);
    render();
  }

  return { init, render, openEdit, del };
})();

/* ================================================
   INGREDIENTS PAGE
   ================================================ */
const IngredientsPage = (() => {
  let editId = null;

  function render(q = '') {
    const ings = Store.get('ingredients').filter(i =>
      i.name.toLowerCase().includes(q.toLowerCase())
    );
    const tbody = document.getElementById('ing-tbody');
    if (!tbody) return;

    if (!ings.length) { tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">Tidak ada data</td></tr>`; return; }
    tbody.innerHTML = ings.map(i => {
      const pct = Math.min(100, Math.round(i.stock / (i.minStock * 3) * 100));
      const cls = i.stock <= 0 ? 'stock-out' : i.stock <= i.minStock ? 'stock-low' : 'stock-ok';
      const statusBadge = i.stock <= 0 ? '<span class="badge badge-red">Habis</span>' : i.stock <= i.minStock ? '<span class="badge badge-amber">Menipis</span>' : '<span class="badge badge-green">Aman</span>';
      return `
        <tr>
          <td><span style="font-size:1.4rem">${i.emoji||'📦'}</span></td>
          <td>${i.name}</td>
          <td><span class="unit-label">${i.unit}</span></td>
          <td>
            <div class="stock-indicator">
              <span style="font-weight:700">${i.stock.toLocaleString('id-ID')}</span>
              <div class="stock-bar-bg"><div class="stock-bar-fill ${cls}" style="width:${pct}%"></div></div>
              ${statusBadge}
            </div>
          </td>
          <td style="color:var(--text-muted)">${i.minStock.toLocaleString('id-ID')}</td>
          <td style="color:var(--text-muted)">${fRpFull(i.price)}/${i.unit}</td>
          <td>
            <div style="display:flex;gap:6px">
              <button class="btn-icon" onclick="IngredientsPage.openEdit(${i.id})">✏️</button>
              <button class="btn-icon" onclick="IngredientsPage.del(${i.id})">🗑</button>
            </div>
          </td>
        </tr>`;
    }).join('');
  }

  function openAdd() {
    editId = null;
    document.getElementById('ing-modal-title').textContent = 'Tambah Bahan Baku';
    document.getElementById('ing-form').reset();
    Modal.open('ing-modal');
  }

  function openEdit(id) {
    const i = Store.get('ingredients').find(i => i.id === id);
    if (!i) return;
    editId = id;
    document.getElementById('ing-modal-title').textContent = 'Edit Bahan Baku';
    document.getElementById('i-name').value     = i.name;
    document.getElementById('i-emoji').value    = i.emoji || '';
    document.getElementById('i-unit').value     = i.unit;
    document.getElementById('i-stock').value    = i.stock;
    document.getElementById('i-minstock').value = i.minStock;
    document.getElementById('i-price').value    = i.price;
    Modal.open('ing-modal');
  }

  function save() {
    const name     = document.getElementById('i-name').value.trim();
    const emoji    = document.getElementById('i-emoji').value.trim() || '📦';
    const unit     = document.getElementById('i-unit').value.trim() || 'unit';
    const stock    = parseFloat(document.getElementById('i-stock').value) || 0;
    const minStock = parseFloat(document.getElementById('i-minstock').value) || 0;
    const price    = parseFloat(document.getElementById('i-price').value) || 0;
    if (!name) { Toast.show('Nama bahan wajib diisi','error'); return; }

    const ings = Store.get('ingredients');
    if (editId) {
      const idx = ings.findIndex(i => i.id === editId);
      if (idx > -1) Object.assign(ings[idx], { name, emoji, unit, stock, minStock, price });
      Toast.show('Bahan baku diperbarui', 'success');
    } else {
      ings.push({ id: Store.nextId(ings), name, emoji, unit, stock, minStock, price });
      Toast.show('Bahan baku ditambahkan', 'success');
    }
    Store.set('ingredients', ings);
    Modal.closeAll(); render();
  }

  function del(id) {
    if (!confirm('Hapus bahan baku ini?')) return;
    Store.set('ingredients', Store.get('ingredients').filter(i => i.id !== id));
    render(); Toast.show('Bahan baku dihapus', 'info');
  }

  function init() {
    document.getElementById('ing-search')?.addEventListener('input', e => render(e.target.value));
    document.getElementById('btn-add-ing')?.addEventListener('click', openAdd);
    document.getElementById('btn-save-ing')?.addEventListener('click', save);
    render();
  }

  return { init, render, openEdit, del };
})();

/* ================================================
   RECIPES PAGE
   ================================================ */
const RecipesPage = (() => {
  let editProductId = null;
  let tempComponents = [];

  function populateProductSelect() {
    const sel = document.getElementById('recipe-product-select');
    if (!sel) return;
    const prods = Store.get('products');
    sel.innerHTML = '<option value="">-- Pilih Produk --</option>' +
      prods.map(p => `<option value="${p.id}">${p.emoji||''} ${p.name}</option>`).join('');
  }

  function populateIngSelect() {
    const sel = document.getElementById('comp-ing-select');
    if (!sel) return;
    const ings = Store.get('ingredients');
    sel.innerHTML = '<option value="">-- Bahan --</option>' +
      ings.map(i => `<option value="${i.id}" data-unit="${i.unit}">${i.emoji||''} ${i.name}</option>`).join('');
  }

  function render(q = '') {
    const recipes  = Store.get('recipes');
    const products = Store.get('products');
    const tbody = document.getElementById('recipes-tbody');
    if (!tbody) return;

    const filtered = products.filter(p => {
      const hasRecipe = recipes.find(r => r.productId === p.id);
      return hasRecipe && p.name.toLowerCase().includes(q.toLowerCase());
    });
    const noRecipe = products.filter(p => !recipes.find(r => r.productId === p.id));

    if (!filtered.length && !noRecipe.length) {
      tbody.innerHTML = `<tr><td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted)">Tidak ada data</td></tr>`;
      return;
    }

    const ings = Store.get('ingredients');
    tbody.innerHTML = [
      ...filtered.map(p => {
        const recipe = recipes.find(r => r.productId === p.id);
        const comps = (recipe?.components || []).map(c => {
          const ing = ings.find(i => i.id === c.ingId);
          return ing ? `${ing.emoji||''} ${ing.name} <span style="color:var(--emerald);font-weight:700">${c.qty} ${c.unit}</span>` : '';
        }).join(' &bull; ');
        return `
          <tr>
            <td><span style="font-size:1.3rem">${p.emoji||'📦'}</span></td>
            <td style="font-weight:700">${p.name}</td>
            <td style="font-size:0.8rem">${comps || '<span style="color:var(--text-muted)">-</span>'}</td>
            <td>
              <div style="display:flex;gap:6px">
                <button class="btn-icon" onclick="RecipesPage.openEdit(${p.id})">✏️</button>
                <button class="btn-icon" onclick="RecipesPage.delRecipe(${p.id})">🗑</button>
              </div>
            </td>
          </tr>`;
      }),
      ...noRecipe.filter(p => p.name.toLowerCase().includes(q.toLowerCase())).map(p => `
        <tr style="opacity:0.5">
          <td><span style="font-size:1.3rem">${p.emoji||'📦'}</span></td>
          <td>${p.name}</td>
          <td><span style="color:var(--text-muted);font-size:0.78rem">Belum ada resep</span></td>
          <td><button class="btn-sm btn-secondary" onclick="RecipesPage.openEdit(${p.id})">+ Buat Resep</button></td>
        </tr>`)
    ].join('');
  }

  function renderComponents() {
    const el = document.getElementById('recipe-comps');
    if (!el) return;
    const ings = Store.get('ingredients');
    if (!tempComponents.length) {
      el.innerHTML = '<div style="color:var(--text-muted);font-size:0.82rem;padding:8px 0">Belum ada bahan. Tambahkan di bawah.</div>';
      return;
    }
    el.innerHTML = tempComponents.map((c, idx) => {
      const ing = ings.find(i => i.id === c.ingId);
      return `
        <div class="recipe-comp-row">
          <span class="comp-name">${ing?.emoji||''} ${ing?.name||'?'}</span>
          <span class="comp-qty">${c.qty}</span>
          <span class="comp-unit">${c.unit}</span>
          <span class="comp-remove" onclick="RecipesPage.removeComp(${idx})">✕</span>
        </div>`;
    }).join('');
  }

  function removeComp(idx) {
    tempComponents.splice(idx, 1);
    renderComponents();
  }

  function addComp() {
    const ingSel = document.getElementById('comp-ing-select');
    const qty    = parseFloat(document.getElementById('comp-qty').value);
    const ingId  = parseInt(ingSel?.value);
    if (!ingId || !qty) { Toast.show('Pilih bahan dan isi jumlah','error'); return; }
    const opt = ingSel.options[ingSel.selectedIndex];
    const unit = opt?.dataset?.unit || 'unit';
    tempComponents.push({ ingId, qty, unit });
    renderComponents();
    document.getElementById('comp-qty').value = '';
  }

  function openEdit(productId) {
    editProductId = productId;
    const product = Store.get('products').find(p => p.id === productId);
    const recipe  = Store.get('recipes').find(r => r.productId === productId);
    tempComponents = JSON.parse(JSON.stringify(recipe?.components || []));

    populateIngSelect();
    document.getElementById('recipe-modal-title').textContent = `Resep: ${product?.name || ''}`;
    document.getElementById('recipe-product-name').textContent = `${product?.emoji||''} ${product?.name||''}`;
    renderComponents();
    Modal.open('recipe-modal');
  }

  function delRecipe(productId) {
    if (!confirm('Hapus resep ini?')) return;
    const recipes = Store.get('recipes').filter(r => r.productId !== productId);
    Store.set('recipes', recipes);
    render(); Toast.show('Resep dihapus', 'info');
  }

  function save() {
    if (!editProductId) return;
    const recipes = Store.get('recipes').filter(r => r.productId !== editProductId);
    recipes.push({ id: Store.nextId(recipes), productId: editProductId, components: tempComponents });
    Store.set('recipes', recipes);
    Modal.closeAll(); render();
    Toast.show('Resep disimpan', 'success');
  }

  function init() {
    document.getElementById('recipe-search')?.addEventListener('input', e => render(e.target.value));
    document.getElementById('btn-add-comp')?.addEventListener('click', addComp);
    document.getElementById('btn-save-recipe')?.addEventListener('click', save);
    render();
  }

  return { init, render, openEdit, delRecipe, removeComp };
})();

/* ================================================
   RESTOCK PAGE
   ================================================ */
const RestockPage = (() => {

  function populateIngSelect() {
    const sel = document.getElementById('restock-ing-select');
    if (!sel) return;
    const ings = Store.get('ingredients');
    sel.innerHTML = '<option value="">-- Pilih Bahan Baku --</option>' +
      ings.map(i => `<option value="${i.id}" data-unit="${i.unit}">${i.emoji||''} ${i.name} (stok: ${i.stock} ${i.unit})</option>`).join('');
  }

  function onIngChange() {
    const sel = document.getElementById('restock-ing-select');
    const opt = sel?.options[sel.selectedIndex];
    const unitEl = document.getElementById('restock-unit-display');
    if (unitEl) unitEl.textContent = opt?.dataset?.unit || '';
  }

  function render() {
    const logs = Store.get('restockLog');
    const ings = Store.get('ingredients');
    const el   = document.getElementById('restock-log');
    if (!el) return;

    // Show low stock warnings
    const lowEl = document.getElementById('low-stock-warn');
    const low   = ings.filter(i => i.stock <= i.minStock);
    if (lowEl) {
      if (low.length) {
        lowEl.innerHTML = `
          <div style="background:var(--amber-dim);border:1px solid rgba(245,158,11,0.25);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px">
            <span style="font-size:1.2rem">⚠️</span>
            <div>
              <div style="font-weight:700;font-size:0.88rem;color:var(--amber)">Stok Menipis/Habis!</div>
              <div style="font-size:0.8rem;color:var(--text-secondary);margin-top:3px">${low.map(i=>`${i.emoji} ${i.name} (${i.stock} ${i.unit})`).join(' · ')}</div>
            </div>
          </div>`;
      } else {
        lowEl.innerHTML = '';
      }
    }

    if (!logs.length) {
      el.innerHTML = '<div class="empty-state"><div class="es-icon">📦</div><p>Belum ada riwayat penambahan stok</p></div>';
      return;
    }

    const recent = [...logs].sort((a,b) => new Date(b.date)-new Date(a.date)).slice(0,20);
    el.innerHTML = recent.map(log => {
      const ing = ings.find(i => i.id === log.ingId);
      const d = new Date(log.date).toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'});
      return `
        <div class="restock-card">
          <div class="restock-icon">${ing?.emoji||'📦'}</div>
          <div class="restock-info">
            <div class="restock-name">${ing?.name||'?'}</div>
            <div class="restock-meta">${d} · oleh ${log.by}${log.note ? ' · '+log.note : ''}</div>
          </div>
          <div class="restock-qty">+${log.qty} ${log.unit}</div>
        </div>`;
    }).join('');
  }

  function save() {
    const ingId = parseInt(document.getElementById('restock-ing-select').value);
    const qty   = parseFloat(document.getElementById('restock-qty').value);
    const note  = document.getElementById('restock-note').value.trim();
    if (!ingId || !qty) { Toast.show('Pilih bahan dan isi jumlah','error'); return; }

    // Update ingredient stock
    const ings = Store.get('ingredients');
    const idx  = ings.findIndex(i => i.id === ingId);
    if (idx === -1) { Toast.show('Bahan tidak ditemukan','error'); return; }
    const unit = ings[idx].unit;
    ings[idx].stock += qty;
    Store.set('ingredients', ings);

    // Add to log
    const logs = Store.get('restockLog');
    logs.unshift({
      id: Store.nextId(logs), ingId, qty, unit, note,
      date: new Date().toISOString(),
      by: 'Administrator',
    });
    Store.set('restockLog', logs);

    Modal.closeAll();
    render();
    Toast.show(`+${qty} ${unit} ${ings[idx].name} berhasil ditambahkan`, 'success');
  }

  function init() {
    document.getElementById('btn-add-restock')?.addEventListener('click', () => {
      populateIngSelect();
      document.getElementById('restock-form').reset();
      document.getElementById('restock-unit-display').textContent = '';
      Modal.open('restock-modal');
    });
    document.getElementById('restock-ing-select')?.addEventListener('change', onIngChange);
    document.getElementById('btn-save-restock')?.addEventListener('click', save);
    render();
  }

  return { init, render };
})();

/* ================================================
   REPORTS PAGE
   ================================================ */
const ReportsPage = (() => {
  let period = 'week';

  function computeReport(sales) {
    const revenue  = sales.reduce((s, t) => s + t.total, 0);
    const orders   = sales.length;
    const items    = sales.reduce((s, t) => s + t.items.reduce((ss,i)=>ss+i.qty,0), 0);
    const avg      = orders ? Math.round(revenue / orders) : 0;
    const tax      = sales.reduce((s, t) => s + (t.tax||0), 0);
    const discount = sales.reduce((s, t) => s + (t.discount||0), 0);
    return { revenue, orders, items, avg, tax, discount };
  }

  function renderSummary(sales) {
    const r = computeReport(sales);
    const vals = {
      'report-revenue': fRpFull(r.revenue),
      'report-orders':  r.orders + ' transaksi',
      'report-items':   r.items + ' item',
      'report-avg':     fRpFull(r.avg),
      'report-tax':     fRpFull(r.tax),
      'report-disc':    fRpFull(r.discount),
    };
    Object.entries(vals).forEach(([id, val]) => {
      const el = document.getElementById(id);
      if (el) el.textContent = val;
    });
  }

  function renderPaymentBreakdown(sales) {
    const methods = {};
    sales.forEach(s => { methods[s.payment] = (methods[s.payment]||0) + s.total; });
    const total = Object.values(methods).reduce((a,b)=>a+b,0)||1;
    const labels = { tunai:'💵 Tunai', qris:'📱 QRIS', debit:'💳 Debit', kredit:'🏦 Kredit', gopay:'🟢 GoPay', ovo:'🟣 OVO' };
    const el = document.getElementById('report-payment-table');
    if (!el) return;

    const sorted = Object.entries(methods).sort((a,b)=>b[1]-a[1]);
    el.innerHTML = sorted.map(([m, rev]) => `
      <tr>
        <td>${labels[m]||m}</td>
        <td>${sales.filter(s=>s.payment===m).length}</td>
        <td style="font-weight:700;color:var(--emerald)">${fRpFull(rev)}</td>
        <td>${Math.round(rev/total*100)}%</td>
      </tr>`).join('');
  }

  function renderKasirPerf(sales) {
    const kasirMap = {};
    sales.forEach(s => {
      if (!kasirMap[s.kasir]) kasirMap[s.kasir] = { name:s.kasir, rev:0, cnt:0 };
      kasirMap[s.kasir].rev += s.total;
      kasirMap[s.kasir].cnt++;
    });
    const sorted = Object.values(kasirMap).sort((a,b)=>b.rev-a.rev);
    const maxRev = sorted[0]?.rev || 1;
    const el = document.getElementById('report-kasir-list');
    if (!el) return;

    const initials = n => n.split(' ').map(x=>x[0]).join('').substring(0,2).toUpperCase();
    el.innerHTML = sorted.map(k => `
      <div class="kasir-perf-row">
        <div class="kp-avatar">${initials(k.name)}</div>
        <div class="kp-info">
          <div class="kp-name">${k.name}</div>
          <div class="kp-count">${k.cnt} transaksi</div>
          <div class="kp-bar-wrap" style="margin-top:4px">
            <div class="kp-bar-bg"><div class="kp-bar-fill" style="width:${Math.round(k.rev/maxRev*100)}%"></div></div>
          </div>
        </div>
        <div class="kp-rev">${fRp(k.rev)}</div>
      </div>`).join('');
  }

  function renderSalesTable(sales) {
    const tbody = document.getElementById('report-sales-tbody');
    if (!tbody) return;
    const recent = [...sales].sort((a,b)=>new Date(b.timestamp)-new Date(a.timestamp)).slice(0,50);
    if (!recent.length) { tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-muted)">Tidak ada data</td></tr>`; return; }
    tbody.innerHTML = recent.map(t => {
      const d = new Date(t.timestamp);
      return `
        <tr>
          <td>${t.id}</td>
          <td>${d.toLocaleDateString('id-ID',{day:'2-digit',month:'short'})} ${d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'})}</td>
          <td>${t.kasir||'-'}</td>
          <td>${t.items.length} jenis (${t.items.reduce((s,i)=>s+i.qty,0)} item)</td>
          <td>${t.payment}</td>
          <td style="font-weight:700;color:var(--emerald)">${fRpFull(t.total)}</td>
          <td><span class="badge badge-green">✓ Lunas</span></td>
        </tr>`;
    }).join('');
  }

  function render() {
    const sales = Store.getSalesForPeriod(period);
    renderSummary(sales);
    renderPaymentBreakdown(sales);
    renderKasirPerf(sales);
    renderSalesTable(sales);
  }

  function init() {
    document.querySelectorAll('.report-period-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        period = btn.dataset.period;
        document.querySelectorAll('.report-period-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        render();
      });
    });
    render();
  }

  return { init, render };
})();

/* ================================================
   Page Renderers dispatcher (called by Nav)
   ================================================ */
const PageRenderers = {
  dashboard:   () => DashboardPage.render(),
  users:       () => UsersPage.render(),
  categories:  () => CategoriesPage.render(),
  products:    () => ProductsPage.render(),
  ingredients: () => IngredientsPage.render(),
  recipes:     () => RecipesPage.render(),
  restock:     () => RestockPage.render(),
  reports:     () => ReportsPage.render(),
};

/* Boot all pages on DOMContentLoaded */
document.addEventListener('DOMContentLoaded', () => {
  DashboardPage.init();
  UsersPage.init();
  CategoriesPage.init();
  ProductsPage.init();
  IngredientsPage.init();
  RecipesPage.init();
  RestockPage.init();
  ReportsPage.init();
});
