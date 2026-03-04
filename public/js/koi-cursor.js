/**
 * Realistic Worm Cursor Effect
 * Червь, ползущий за курсором мыши
 */

(function () {
  'use strict';

  // ── Настройки ──────────────────────────────────────────
  const SEGMENT_COUNT  = 18;    // количество сегментов тела
  const SEGMENT_LENGTH = 9;     // длина одного сегмента
  const FOLLOW_SPEED   = 0.13;  // плавность (меньше = медленнее)
  const MOUSE_OFFSET   = 80;    // расстояние от курсора до головы
  // ───────────────────────────────────────────────────────

  const segments = [];
  for (let i = 0; i < SEGMENT_COUNT; i++) {
    segments.push({ x: window.innerWidth / 2 + i * SEGMENT_LENGTH, y: window.innerHeight / 2 });
  }

  const canvas = document.createElement('canvas');
  canvas.style.cssText = `
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none; z-index: 99999;
  `;
  document.body.appendChild(canvas);
  const ctx = canvas.getContext('2d');

  function resize() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
  resize();
  window.addEventListener('resize', resize);

  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;
  document.addEventListener('mousemove', e => { mouseX = e.clientX; mouseY = e.clientY; });

  // ── Ширина тела по позиции (0=голова, 1=хвост) ──
  function segmentRadius(t) {
    if (t < 0.08) return 3.5 + t * 20;   // головка чуть округлее
    if (t > 0.88) return 4 - (t - 0.88) * 25; // хвост сужается
    return 5.5;                             // тело равномерное
  }

  // ── Цвет сегмента (розово-коричневый червь) ──
  function segmentColor(t, isTop) {
    // Основа: тёплый розово-коричневый
    const r = isTop ? 160 : 190;
    const g = isTop ?  75 :  95;
    const b = isTop ?  60 :  75;
    return `rgb(${r},${g},${b})`;
  }

  // ── Рисование тела ──
  function drawWorm(segs, phase) {
    const n = segs.length;

    // Собираем точки верхнего и нижнего контура
    const upper = [];
    const lower = [];

    for (let i = 0; i < n; i++) {
      const t = i / (n - 1);
      const r = Math.max(segmentRadius(t), 0.3);

      let angle;
      if (i < n - 1) {
        angle = Math.atan2(segs[i+1].y - segs[i].y, segs[i+1].x - segs[i].x);
      } else {
        angle = Math.atan2(segs[i].y - segs[i-1].y, segs[i].x - segs[i-1].x);
      }
      const perp = angle - Math.PI / 2;

      upper.push({ x: segs[i].x + Math.cos(perp) * r, y: segs[i].y + Math.sin(perp) * r });
      lower.push({ x: segs[i].x - Math.cos(perp) * r, y: segs[i].y - Math.sin(perp) * r });
    }

    // ── Тело: градиентная заливка через путь ──
    ctx.save();
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    // Строим замкнутый путь тела
    ctx.beginPath();
    ctx.moveTo(upper[0].x, upper[0].y);
    for (let i = 1; i < n; i++) ctx.lineTo(upper[i].x, upper[i].y);
    // Закругление хвоста
    const tail = segs[n - 1];
    ctx.lineTo(tail.x, tail.y);
    for (let i = n - 1; i >= 0; i--) ctx.lineTo(lower[i].x, lower[i].y);
    // Закругление головы
    ctx.closePath();

    // Градиент вдоль тела (голова → хвост)
    const grad = ctx.createLinearGradient(segs[0].x, segs[0].y, segs[n-1].x, segs[n-1].y);
    grad.addColorStop(0,   '#b04b3c');
    grad.addColorStop(0.3, '#c85a42');
    grad.addColorStop(0.6, '#be5240');
    grad.addColorStop(1,   '#9a3e30');
    ctx.fillStyle = grad;
    ctx.fill();

    // Тёмный контур
    ctx.strokeStyle = 'rgba(80,25,15,0.55)';
    ctx.lineWidth = 0.8;
    ctx.stroke();

    ctx.restore();

    // ── Кольца (сегментация) ──
    ctx.save();
    ctx.strokeStyle = 'rgba(70,20,10,0.30)';
    ctx.lineWidth = 0.9;
    ctx.lineCap = 'round';

    for (let i = 1; i < n - 1; i++) {
      // Линия кольца — поперёк тела
      ctx.beginPath();
      ctx.moveTo(upper[i].x, upper[i].y);
      ctx.lineTo(lower[i].x, lower[i].y);
      ctx.stroke();
    }
    ctx.restore();

    // ── Блик (световая полоса сверху) ──
    ctx.save();
    ctx.strokeStyle = 'rgba(255,180,150,0.28)';
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    ctx.beginPath();
    // Блик идёт по верхней четверти тела
    for (let i = 0; i < n; i++) {
      const t = i / (n - 1);
      const r = Math.max(segmentRadius(t), 0.3) * 0.45;
      let angle;
      if (i < n - 1) angle = Math.atan2(segs[i+1].y - segs[i].y, segs[i+1].x - segs[i].x);
      else angle = Math.atan2(segs[i].y - segs[i-1].y, segs[i].x - segs[i-1].x);
      const perp = angle - Math.PI / 2;
      const hx = segs[i].x + Math.cos(perp) * r;
      const hy = segs[i].y + Math.sin(perp) * r;
      if (i === 0) ctx.moveTo(hx, hy); else ctx.lineTo(hx, hy);
    }
    ctx.stroke();
    ctx.restore();

    // ── Голова ──
    drawHead(segs[0], segs[1], phase);
  }

  function drawHead(head, next, phase) {
    const angle = Math.atan2(head.y - next.y, head.x - next.x);

    ctx.save();
    ctx.translate(head.x, head.y);
    ctx.rotate(angle);

    // Головка — чуть более округлый эллипс
    const headGrad = ctx.createRadialGradient(2, -1, 1, 2, 0, 7);
    headGrad.addColorStop(0, '#d06050');
    headGrad.addColorStop(1, '#8c3528');

    ctx.beginPath();
    ctx.ellipse(4, 0, 7, 5.5, 0, 0, Math.PI * 2);
    ctx.fillStyle = headGrad;
    ctx.fill();
    ctx.strokeStyle = 'rgba(80,25,15,0.5)';
    ctx.lineWidth = 0.8;
    ctx.stroke();

    // Поясок (clitellum) — более тёмное кольцо
    ctx.strokeStyle = 'rgba(60,15,10,0.4)';
    ctx.lineWidth = 1.5;
    ctx.beginPath();
    ctx.ellipse(1, 0, 1, 5, 0, 0, Math.PI * 2);
    ctx.stroke();

    ctx.restore();
  }

  // ── Clitellum (поясок на теле) ──
  function drawClitellum(segs) {
    // Поясок — утолщение в районе 30% тела
    const idx = Math.floor(SEGMENT_COUNT * 0.28);
    const seg = segs[idx];
    const next = segs[idx + 1];
    if (!next) return;

    const angle = Math.atan2(next.y - seg.y, next.x - seg.x);
    const perp = angle - Math.PI / 2;
    const r = segmentRadius(idx / SEGMENT_COUNT) + 1.5;

    ctx.save();
    ctx.strokeStyle = 'rgba(90,30,20,0.5)';
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';

    // 3 кольца пояска
    for (let k = -1; k <= 1; k++) {
      const sx = seg.x + (Math.cos(angle) * k * 2);
      const sy = seg.y + (Math.sin(angle) * k * 2);
      ctx.beginPath();
      ctx.moveTo(sx + Math.cos(perp) * r, sy + Math.sin(perp) * r);
      ctx.lineTo(sx - Math.cos(perp) * r, sy - Math.sin(perp) * r);
      ctx.stroke();
    }
    ctx.restore();
  }

  // ── Основной цикл ──────────────────────────────────────
  let phase = 0;

  function loop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    phase += 0.05;

    // Голова тянется позади курсора
    const headAngle = Math.atan2(mouseY - segments[0].y, mouseX - segments[0].x);
    const targetX = mouseX - Math.cos(headAngle) * MOUSE_OFFSET;
    const targetY = mouseY - Math.sin(headAngle) * MOUSE_OFFSET;

    segments[0].x += (targetX - segments[0].x) * FOLLOW_SPEED;
    segments[0].y += (targetY - segments[0].y) * FOLLOW_SPEED;

    // Цепочка сегментов
    for (let i = 1; i < SEGMENT_COUNT; i++) {
      const prev = segments[i - 1];
      const curr = segments[i];
      const a = Math.atan2(curr.y - prev.y, curr.x - prev.x);
      curr.x = prev.x + Math.cos(a) * SEGMENT_LENGTH;
      curr.y = prev.y + Math.sin(a) * SEGMENT_LENGTH;
    }

    drawWorm(segments, phase);
    drawClitellum(segments);

    requestAnimationFrame(loop);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loop);
  } else {
    loop();
  }

})();
