/**
 * dashboard.js — Dashboard stats, charts, widgets
 */

const DashboardPage = (() => {

  let period = 'week';

  /* ---- Stat computation ---- */
  function computeStats(sales) {
    const revenue = sales.reduce((s, t) => s + t.total, 0);
    const orders  = sales.length;
    const items   = sales.reduce((s, t) => s + t.items.reduce((ss,i)=>ss+i.qty,0), 0);
    const avg     = orders ? Math.round(revenue / orders) : 0;
    return { revenue, orders, items, avg };
  }

  
  /* ---- Previous period for comparison ---- */
  function getPrevStats(period) {
    const allSales = window.allSales || [];
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    let start, prevStart, prevEnd;

    if (period === 'day') {
      start     = today;
      prevStart = new Date(today); prevStart.setDate(today.getDate() - 1);
      prevEnd   = today;
    } else if (period === 'week') {
      start     = new Date(today); start.setDate(today.getDate() - 6);
      prevStart = new Date(today); prevStart.setDate(today.getDate() - 13);
      prevEnd   = new Date(today); prevEnd.setDate(today.getDate() - 7);
    } else {
      start     = new Date(today); start.setDate(today.getDate() - 29);
      prevStart = new Date(today); prevStart.setDate(today.getDate() - 59);
      prevEnd   = new Date(today); prevEnd.setDate(today.getDate() - 30);
    }
    const prev = allSales.filter(s => {
      const d = new Date(s.timestamp);
      return d >= prevStart && d < prevEnd;
    });
    return computeStats(prev);
  }

  /* ---- Render stat cards ---- */
  function renderStats(sales) {
    const s    = computeStats(sales);
    const prev = getPrevStats(period);

    function trend(cur, prv) {
      if (!prv) return { pct: 100, dir: 'up' };
      const pct = Math.round(((cur - prv) / prv) * 100);
      return { pct: Math.abs(pct), dir: pct >= 0 ? 'up' : 'down' };
    }
    const tRev  = trend(s.revenue, prev.revenue);
    const tOrd  = trend(s.orders,  prev.orders);
    const tItem = trend(s.items,   prev.items);
    const tAvg  = trend(s.avg,     prev.avg);

    const cards = [
      { id:'stat-revenue', value: fRp(s.revenue),      label:'Total Pendapatan', icon:'💰', color:'var(--emerald-dim)', t: tRev  },
      { id:'stat-orders',  value: s.orders,            label:'Jumlah Transaksi', icon:'🧾', color:'var(--blue-dim)',    t: tOrd  },
      { id:'stat-items',   value: s.items,             label:'Item Terjual',     icon:'📦', color:'var(--purple-dim)',  t: tItem },
      { id:'stat-avg',     value: fRp(s.avg),          label:'Rata-rata / Order',icon:'📈', color:'var(--amber-dim)',   t: tAvg  },
    ];

    cards.forEach(c => {
      const el = document.getElementById(c.id);
      if (!el) return;
      el.querySelector('.stat-value').textContent = c.value;
      el.querySelector('.stat-label').textContent = c.label;
      const tEl = el.querySelector('.stat-trend');
      tEl.className = `stat-trend trend-${c.t.dir}`;
      tEl.textContent = (c.t.dir === 'up' ? '▲ ' : '▼ ') + c.t.pct + '%';
    });
  }

  /* ---- Build bar chart data ---- */
  function getChartData(sales, period) {
    const now   = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const buckets = [];

    if (period === 'day') {
      for (let h = 8; h <= 20; h++) {
        const label = h + ':00';
        const rev = sales.filter(s => new Date(s.timestamp).getHours() === h)
                         .reduce((sum, s) => sum + s.total, 0);
        buckets.push({ label, rev });
      }
    } else if (period === 'week') {
      const days = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
      for (let d = 6; d >= 0; d--) {
        const dt = new Date(today); dt.setDate(today.getDate() - d);
        const label = days[dt.getDay()];
        const rev = sales.filter(s => {
          const sd = new Date(s.timestamp);
          return sd.toDateString() === dt.toDateString();
        }).reduce((sum, s) => sum + s.total, 0);
        buckets.push({ label, rev });
      }
    } else {
      for (let d = 29; d >= 0; d -= 3) {
        const dt = new Date(today); dt.setDate(today.getDate() - d);
        const label = (dt.getDate()) + '/' + (dt.getMonth()+1);
        const revArr = [];
        for (let x = 0; x < 3; x++) {
          const dx = new Date(dt); dx.setDate(dt.getDate() + x);
          sales.filter(s => new Date(s.timestamp).toDateString() === dx.toDateString())
               .forEach(s => revArr.push(s.total));
        }
        buckets.push({ label, rev: revArr.reduce((a,b)=>a+b,0) });
      }
    }
    return buckets;
  }

  function renderBarChart(sales) {
    const data   = getChartData(sales, period);
    const maxRev = Math.max(...data.map(b => b.rev), 1);
    const container = document.getElementById('bar-chart');
    if (!container) return;

    container.innerHTML = data.map(b => {
      const h = Math.max(4, Math.round((b.rev / maxRev) * 100));
      return `
        <div class="bar-col">
          <div class="bar-fill" style="height:0%" data-h="${h}" title="${fRpFull(b.rev)}"></div>
          <span class="bar-label">${b.label}</span>
        </div>`;
    }).join('');

    // Animate
    requestAnimationFrame(() => {
      container.querySelectorAll('.bar-fill').forEach(b => {
        setTimeout(() => { b.style.height = b.dataset.h + '%'; }, 50);
      });
    });
  }

  /* ---- Category donut ---- */
  function renderDonut(sales) {
    const catRev = {};
    sales.forEach(s => {
      s.items.forEach(item => {
        const cat = item.category || "Lainnya";
        if (!catRev[cat]) catRev[cat] = 0;
        catRev[cat] += item.price * item.qty;
      });
    });

    const sorted = Object.entries(catRev)
      .map(([name, rev]) => ({ name, rev }))
      .sort((a, b) => b.rev - a.rev)
      .slice(0, 5);
    const total = sorted.reduce((s, c) => s + c.rev, 0) || 1;
    const COLORS = ['#10b981','#3b82f6','#f59e0b','#a78bfa','#ef4444'];
    const r = 52, cx = 60, cy = 60, stroke = 20;
    const circ = 2 * Math.PI * r;

    let offset = 0;
    const svgPaths = sorted.map((c, i) => {
      const dash = (c.rev / total) * circ;
      const path = `
        <circle cx="${cx}" cy="${cy}" r="${r}"
          fill="none"
          stroke="${COLORS[i]}"
          stroke-width="${stroke}"
          stroke-dasharray="${dash.toFixed(2)} ${(circ - dash).toFixed(2)}"
          stroke-dashoffset="${(-offset).toFixed(2)}"
        />`;
      offset += dash;
      return path;
    }).join('');

    const svg = document.getElementById('donut-svg');
    if (svg) {
      svg.innerHTML = svgPaths;
      svg.setAttribute('viewBox', `0 0 ${cx*2} ${cy*2}`);
    }
    const legend = document.getElementById('donut-legend');

    if (legend) {
      legend.innerHTML = sorted.map((c, i) => `
        <div class="donut-leg-row">
          <span class="donut-leg-label">
            <span class="legend-dot" style="background:${COLORS[i]}"></span>
            ${c.name}
          </span>
          <span class="donut-leg-val">
            ${Math.round((c.rev/total)*100)}%
          </span>
        </div>
      `).join('');
    }
  }

  /* ---- Top products ---- */
  function renderTopProducts(sales) {
    const productRevMap = {};
    sales.forEach(s => {
      s.items.forEach(item => {
        if (!productRevMap[item.id]) productRevMap[item.id] = { id:item.id, name:item.name, emoji:item.emoji||'📦', rev:0, qty:0 };
        productRevMap[item.id].rev += item.price * item.qty;
        productRevMap[item.id].qty += item.qty;
      });
    });
    const top = Object.values(productRevMap).sort((a,b) => b.rev - a.rev).slice(0, 6);
    const maxRev = top[0]?.rev || 1;

    const el = document.getElementById('top-products-list');
    if (!el) return;
    if (!top.length) { el.innerHTML = '<div class="empty-state"><div class="es-icon">📭</div><p>Belum ada data</p></div>'; return; }

    el.innerHTML = top.map((p, i) => `
      <div class="product-rank-item">
        <div class="rank-num ${i < 3 ? 'top' : ''}">${i+1}</div>
        <div class="rank-emoji">${p.emoji}</div>
        <div class="rank-details">
          <div class="rank-name">${p.name}</div>
          <div class="rank-cat">${p.qty} porsi terjual</div>
          <div class="rank-bar-bg"><div class="rank-bar-fill" style="width:${Math.round(p.rev/maxRev*100)}%"></div></div>
        </div>
        <div class="rank-rev">${fRp(p.rev)}</div>
      </div>`).join('');
  }

  /* ---- Recent transactions ---- */
  function renderRecentTxn(sales) {
    const el = document.getElementById('recent-txn-list');
    if (!el) return;
    const recent = [...sales].sort((a,b) => new Date(b.timestamp)-new Date(a.timestamp)).slice(0,8);
    if (!recent.length) { el.innerHTML = '<div class="empty-state"><div class="es-icon">🧾</div><p>Belum ada transaksi</p></div>'; return; }

    el.innerHTML = recent.map(t => {
      const d = new Date(t.timestamp);
      const time = d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
      const date = d.toLocaleDateString('id-ID',{day:'2-digit',month:'short'});
      return `
        <div class="txn-row">
          <div class="txn-dot"></div>
          <div class="txn-info">
            <div class="txn-no">${t.id}</div>
            <div class="txn-time">${date}, ${time} · ${t.kasir}</div>
          </div>
          <div class="txn-amt">${fRp(t.total)}</div>
        </div>`;
    }).join('');
  }

  /* ---- Period buttons ---- */
  function initPeriodBtns() {
    document.querySelectorAll('.period-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        period = btn.dataset.period;
        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        render();
      });
    });
  }

  async function fetchSales() {
    const response = await fetch(`/admin/dashboard/data?period=${period}`);
    const data = await response.json();
    return data;
  }
  async function render() {
    const sales = await fetchSales();
    renderStats(sales);
    renderBarChart(sales);
    renderDonut(sales);
    renderTopProducts(sales);
    renderRecentTxn(sales);

  }

  function init() {
    initPeriodBtns();
    render();
  }

  return { init, render };
})();
