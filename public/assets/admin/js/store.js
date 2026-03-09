/**
 * store.js — Central data store (localStorage-backed)
 */

const Store = (() => {

  /* ---- Defaults ---- */
  const DEFAULTS = {

    users: [
      { id:1, name:'Budi Santoso',   username:'admin',         role:'admin',   email:'budi@kafe.com',   phone:'081234567890', active:true,  joined:'2023-01-15' },
      { id:2, name:'Ahmad Fauzi',    username:'kasir.fauzi',   role:'kasir',   email:'fauzi@kafe.com',  phone:'082345678901', active:true,  joined:'2023-03-01' },
      { id:3, name:'Rina Wulandari', username:'kasir.rina',    role:'kasir',   email:'rina@kafe.com',   phone:'083456789012', active:true,  joined:'2023-05-12' },
      { id:4, name:'Deni Kurniawan', username:'manajer.deni',  role:'manajer', email:'deni@kafe.com',   phone:'084567890123', active:false, joined:'2022-11-20' },
    ],

    categories: [
      { id:1, name:'Minuman Panas',  emoji:'☕', desc:'Kopi, teh, dan minuman hangat lainnya',   active:true },
      { id:2, name:'Minuman Dingin', emoji:'🧊', desc:'Es kopi, jus, dan minuman segar',          active:true },
      { id:3, name:'Makanan Berat',  emoji:'🍳', desc:'Nasi, pasta, dan hidangan utama',          active:true },
      { id:4, name:'Cemilan',        emoji:'🍟', desc:'Snack, kentang, dan makanan ringan',        active:true },
      { id:5, name:'Dessert',        emoji:'🍰', desc:'Kue, es krim, dan pencuci mulut',          active:true },
      { id:6, name:'Paket Hemat',    emoji:'🎁', desc:'Bundling produk dengan harga spesial',     active:true },
    ],

    products: [
      { id:1,  name:'Espresso',        catId:1, emoji:'☕', price:22000, stock:true,  cost:8000  },
      { id:2,  name:'Cappuccino',      catId:1, emoji:'🥛', price:32000, stock:true,  cost:11000 },
      { id:3,  name:'Matcha Latte',    catId:1, emoji:'🍵', price:38000, stock:true,  cost:14000 },
      { id:4,  name:'Cold Brew',       catId:2, emoji:'🧊', price:35000, stock:true,  cost:12000 },
      { id:5,  name:'Caramel Macch.',  catId:2, emoji:'🍶', price:42000, stock:true,  cost:15000 },
      { id:6,  name:'Jus Alpukat',     catId:2, emoji:'🥑', price:30000, stock:false, cost:10000 },
      { id:7,  name:'Nasi Goreng',     catId:3, emoji:'🍳', price:38000, stock:true,  cost:14000 },
      { id:8,  name:'Pasta Carbonara', catId:3, emoji:'🍝', price:58000, stock:true,  cost:22000 },
      { id:9,  name:'Burger Smoke',    catId:3, emoji:'🍔', price:55000, stock:true,  cost:20000 },
      { id:10, name:'French Fries',    catId:4, emoji:'🍟', price:25000, stock:true,  cost:8000  },
      { id:11, name:'Croissant',       catId:4, emoji:'🥐', price:28000, stock:true,  cost:9000  },
      { id:12, name:'Tiramisu',        catId:5, emoji:'🍮', price:45000, stock:true,  cost:16000 },
      { id:13, name:'Choco Lava',      catId:5, emoji:'🍫', price:40000, stock:true,  cost:14000 },
      { id:14, name:'Set Sarapan A',   catId:6, emoji:'🌅', price:65000, stock:true,  cost:22000 },
    ],

    ingredients: [
      { id:1,  name:'Biji Kopi Arabica', emoji:'☕', unit:'gram',   stock:2500, minStock:500,  price:180  },
      { id:2,  name:'Susu Full Cream',   emoji:'🥛', unit:'ml',     stock:8000, minStock:2000, price:15   },
      { id:3,  name:'Gula Pasir',        emoji:'🍚', unit:'gram',   stock:3000, minStock:500,  price:12   },
      { id:4,  name:'Matcha Powder',     emoji:'🍵', unit:'gram',   stock:800,  minStock:200,  price:250  },
      { id:5,  name:'Tepung Terigu',     emoji:'🌾', unit:'gram',   stock:5000, minStock:1000, price:10   },
      { id:6,  name:'Telur Ayam',        emoji:'🥚', unit:'butir',  stock:60,   minStock:20,   price:2500 },
      { id:7,  name:'Alpukat',           emoji:'🥑', unit:'buah',   stock:15,   minStock:10,   price:8000 },
      { id:8,  name:'Daging Sapi',       emoji:'🥩', unit:'gram',   stock:1200, minStock:300,  price:120  },
      { id:9,  name:'Keju Parmesan',     emoji:'🧀', unit:'gram',   stock:600,  minStock:150,  price:200  },
      { id:10, name:'Coklat Blok',       emoji:'🍫', unit:'gram',   stock:900,  minStock:200,  price:150  },
      { id:11, name:'Kentang',           emoji:'🥔', unit:'gram',   stock:3500, minStock:500,  price:18   },
      { id:12, name:'Krim Kental Manis', emoji:'🍯', unit:'ml',     stock:2000, minStock:400,  price:20   },
    ],

    recipes: [
      { id:1, productId:1, components:[ {ingId:1,qty:18,unit:'gram'}, {ingId:3,qty:5,unit:'gram'} ] },
      { id:2, productId:2, components:[ {ingId:1,qty:18,unit:'gram'}, {ingId:2,qty:150,unit:'ml'}, {ingId:3,qty:8,unit:'gram'} ] },
      { id:3, productId:3, components:[ {ingId:4,qty:12,unit:'gram'}, {ingId:2,qty:200,unit:'ml'}, {ingId:3,qty:10,unit:'gram'} ] },
      { id:4, productId:7, components:[ {ingId:5,qty:200,unit:'gram'}, {ingId:6,qty:2,unit:'butir'}, {ingId:3,qty:15,unit:'gram'} ] },
    ],

    restockLog: [
      { id:1, ingId:1, qty:1000, unit:'gram', note:'Dari supplier Pak Joko', date:'2025-03-01', by:'Budi Santoso' },
      { id:2, ingId:2, qty:5000, unit:'ml',   note:'Restok harian',          date:'2025-03-05', by:'Ahmad Fauzi'  },
    ],

    sales: generateSampleSales(),
  };

  function generateSampleSales() {
    const sales = [];
    const products = [
      {id:1,name:'Espresso',price:22000,emoji:'☕'},{id:2,name:'Cappuccino',price:32000,emoji:'🥛'},
      {id:3,name:'Matcha Latte',price:38000,emoji:'🍵'},{id:4,name:'Cold Brew',price:35000,emoji:'🧊'},
      {id:7,name:'Nasi Goreng',price:38000,emoji:'🍳'},{id:10,name:'French Fries',price:25000,emoji:'🍟'},
      {id:12,name:'Tiramisu',price:45000,emoji:'🍮'},{id:13,name:'Choco Lava',price:40000,emoji:'🍫'},
    ];
    const kasirs = ['Ahmad Fauzi','Rina Wulandari'];
    const methods = ['tunai','qris','debit','gopay'];
    let id = 1;
    const now = new Date();

    for (let d = 30; d >= 0; d--) {
      const dayDate = new Date(now);
      dayDate.setDate(now.getDate() - d);
      const txCount = 8 + Math.floor(Math.random() * 12);

      for (let t = 0; t < txCount; t++) {
        const h = 8 + Math.floor(Math.random() * 12);
        const m = Math.floor(Math.random() * 60);
        const ts = new Date(dayDate);
        ts.setHours(h, m, 0);

        const itemCount = 1 + Math.floor(Math.random() * 4);
        const items = [];
        let subtotal = 0;
        for (let i = 0; i < itemCount; i++) {
          const p = products[Math.floor(Math.random() * products.length)];
          const qty = 1 + Math.floor(Math.random() * 3);
          items.push({ id: p.id, name: p.name, price: p.price, qty, emoji: p.emoji });
          subtotal += p.price * qty;
        }
        const tax = Math.round(subtotal * 0.1);
        const total = subtotal + tax;

        sales.push({
          id: `ORD-${String(id).padStart(4,'0')}`,
          timestamp: ts.toISOString(),
          items,
          subtotal,
          discount: 0,
          tax,
          total,
          payment: methods[Math.floor(Math.random() * methods.length)],
          customer: `Pelanggan ${id}`,
          kasir: kasirs[Math.floor(Math.random() * kasirs.length)],
        });
        id++;
      }
    }
    return sales;
  }

  /* ---- Load from localStorage or defaults ---- */
  function load(key) {
    try {
      const raw = localStorage.getItem('admin_' + key);
      return raw ? JSON.parse(raw) : JSON.parse(JSON.stringify(DEFAULTS[key] || []));
    } catch { return JSON.parse(JSON.stringify(DEFAULTS[key] || [])); }
  }

  function save(key, data) {
    try { localStorage.setItem('admin_' + key, JSON.stringify(data)); } catch {}
  }

  function get(key) { return load(key); }

  function set(key, data) { save(key, data); }

  function nextId(arr) {
    return arr.length ? Math.max(...arr.map(i => i.id)) + 1 : 1;
  }

  /* ---- Helpers ---- */
  function getCategoryName(catId) {
    const cats = get('categories');
    const c = cats.find(c => c.id === catId);
    return c ? `${c.emoji} ${c.name}` : '-';
  }
  function getIngredientName(ingId) {
    const ings = get('ingredients');
    const i = ings.find(i => i.id === ingId);
    return i ? i.name : '-';
  }
  function getProductName(productId) {
    const prods = get('products');
    const p = prods.find(p => p.id === productId);
    return p ? p.name : '-';
  }

  /* ---- Sales helpers ---- */
  function getSalesForPeriod(period) {
    const sales = get('sales');
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    return sales.filter(s => {
      const d = new Date(s.timestamp);
      if (period === 'day') {
        return d >= today;
      } else if (period === 'week') {
        const weekAgo = new Date(today); weekAgo.setDate(today.getDate() - 6);
        return d >= weekAgo;
      } else {
        const monthAgo = new Date(today); monthAgo.setDate(today.getDate() - 29);
        return d >= monthAgo;
      }
    });
  }

  return { get, set, nextId, getCategoryName, getIngredientName, getProductName, getSalesForPeriod };
})();

/* ---- Format Rupiah ---- */
function fRp(n) {
  if (n >= 1000000) return 'Rp ' + (n/1000000).toFixed(1) + 'jt';
  if (n >= 1000)    return 'Rp ' + (n/1000).toFixed(0) + 'rb';
  return 'Rp ' + n.toLocaleString('id-ID');
}
function fRpFull(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
