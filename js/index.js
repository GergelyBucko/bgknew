// index.js – stabil, védett verzió
(() => {
  "use strict";

  // ===== Helpers
  const $all = (sel, root = document) => Array.from(root.querySelectorAll(sel));
  const $ = (sel, root = document) => root.querySelector(sel);
  const onReady = (fn) =>
    document.readyState === "loading" ? document.addEventListener("DOMContentLoaded", fn) : fn();

  // ===== GSAP / ScrollTrigger védelem
  const HAS_GSAP = !!window.gsap;
  const HAS_ST = !!(window.gsap && window.ScrollTrigger);
  if (HAS_ST) {
    // egyszer regisztráljuk
    gsap.registerPlugin(ScrollTrigger);
  } else if (HAS_GSAP) {
    console.warn("GSAP betöltve, de ScrollTrigger nincs betöltve. A GSAP-alapú scroll animok kimaradnak.");
  } else {
    // nincs GSAP – semmi baj, a natív/IO alapú részek menni fognak
    console.warn("GSAP nincs betöltve. A GSAP-es effektek kimaradnak, de minden más fut.");
  }

  onReady(() => {
    // ============ 1) Tab-panels scroll switcher (GSAP) ============
    if (HAS_ST) {
      const container = $("#bgk-tab-switcher");
      const panels = $all(".tab-panel");
      const count = panels.length;

      if (container && count > 0) {
        // Kezdeti állapot
        gsap.set(panels, { x: "100%", autoAlpha: 0, zIndex: 0 });
        gsap.set(panels[0], { x: "0%", autoAlpha: 1, zIndex: 1 });

        for (let i = 1; i < count; i++) {
          const prev = panels[i - 1];
          const curr = panels[i];

          // lefelé: prev balra ki, curr jobbról be
          ScrollTrigger.create({
            trigger: container,
            start: `${(i * 100) / count}% center`,
            end: `${((i + 1) * 100) / count}% center`,
            scrub: true,
            onEnter: () => {
              gsap.to(prev, { x: "-100%", autoAlpha: 0, zIndex: 0, duration: 0.6, ease: "power2.out" });
              gsap.set(curr, { x: "100%", zIndex: 1 });
              gsap.to(curr, { x: "0%", autoAlpha: 1, duration: 0.6, ease: "power2.out" });
            },
          });

          // felfelé: curr jobbra ki, prev balról be
          ScrollTrigger.create({
            trigger: container,
            start: `${(i * 100) / count}% center`,
            end: `${((i - 1) * 100) / count}% center`,
            scrub: true,
            onEnterBack: () => {
              gsap.to(curr, { x: "100%", autoAlpha: 0, zIndex: 0, duration: 0.6, ease: "power2.out" });
              gsap.set(prev, { x: "-100%", zIndex: 1 });
              gsap.to(prev, { x: "0%", autoAlpha: 1, duration: 0.6, ease: "power2.out" });
            },
          });
        }
      }
    }

    // ============ 2) Timeline elemek beúszása (GSAP) ============
    if (HAS_ST) {
      $all(".timeline-text").forEach((el) => {
        gsap.to(el, {
          x: 0,
          opacity: 1,
          duration: 1,
          ease: "power2.out",
          scrollTrigger: { trigger: el, start: "top 80%" },
        });
      });

      $all(".timeline-img").forEach((el) => {
        gsap.to(el, {
          x: 0,
          opacity: 1,
          duration: 1,
          ease: "power2.out",
          scrollTrigger: { trigger: el, start: "top 80%" },
        });
      });

      // Mobil variáns
      $all(".timeline-text-mobile, .timeline-img-mobile").forEach((el) => {
        gsap.to(el, {
          y: 0,
          opacity: 1,
          duration: 1,
          ease: "power2.out",
          scrollTrigger: { trigger: el, start: "top 85%" },
        });
      });
    }

    // ============ 3) Referencia sorok beúszása (GSAP) ============
    if (HAS_ST) {
      $all(".ref-row").forEach((row) => {
        gsap.fromTo(
          row,
          { opacity: 0, y: 100 },
          { opacity: 1, y: 0, duration: 1, ease: "power3.out", scrollTrigger: { trigger: row, start: "top 85%" } }
        );
      });
    }

    // ============ 4) Hover proximity mozgás (natív) ============
    (() => {
      const tiles = $all(".ref-tile");
      if (!tiles.length) return;

      const maxDist = 600;
      const strength = 12;
      const smoothing = 0.1;

      tiles.forEach((tile) => {
        tile._targetX = 0;
        tile._targetY = 0;
        tile._currentX = 0;
        tile._currentY = 0;
      });

      let rafPending = false;
      const updateRAF = () => {
        tiles.forEach((tile) => {
          tile._currentX += (tile._targetX - tile._currentX) * smoothing;
          tile._currentY += (tile._targetY - tile._currentY) * smoothing;
          tile.style.transform = `translate(${tile._currentX}px, ${tile._currentY}px)`;
        });
        rafPending = false;
      };

      document.addEventListener(
        "mousemove",
        (e) => {
          tiles.forEach((tile) => {
            const rect = tile.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            const dx = cx - e.clientX;
            const dy = cy - e.clientY;
            const dist = Math.hypot(dx, dy);

            if (dist < maxDist) {
              const factor = ((1 - dist / maxDist) || 0) * strength;
              tile._targetX = (dx / (dist || 1)) * factor;
              tile._targetY = (dy / (dist || 1)) * factor;
            } else {
              tile._targetX = 0;
              tile._targetY = 0;
            }
          });
          if (!rafPending) {
            rafPending = true;
            requestAnimationFrame(updateRAF);
          }
        },
        { passive: true }
      );
    })();

    // ============ 5) Maszkos képváltó (natív) ============
    (() => {
      const images = $all(".masked-image");
      if (!images.length) return;

      // indikátorok keresése – próbáljuk először a konténert
      let indicators = $all(".indicators > *");
      if (!indicators.length) {
        // fallback az eredeti szelektorodra
        indicators = $all(".active-indicator, .active-indicator ~ div");
      }

      let current = 0;
      const len = images.length;
      const setState = (idx) => {
        images.forEach((img, i) => {
          img.classList.toggle("opacity-100", i === idx);
          img.classList.toggle("opacity-0", i !== idx);
        });
        indicators.forEach((dot, i) => {
          dot.classList.toggle("bg-black", i === idx);
          dot.classList.toggle("bg-gray-300", i !== idx);
        });
      };

      // Kezdő állapot
      setState(0);

      // Autoplay
      setInterval(() => {
        current = (current + 1) % len;
        setState(current);
      }, 4000);
    })();

    // ============ 6) Galéria (prev/next + swipe) ============
    $all(".gallery").forEach((gallery) => {
      const images = $all(".gallery-image", gallery);
      const prevBtn = $(".prev", gallery);
      const nextBtn = $(".next", gallery);
      if (!images.length || !prevBtn || !nextBtn) return;

      let current = 0;
      const show = (idx) => {
        images.forEach((img, i) => {
          img.classList.toggle("opacity-100", i === idx);
          img.classList.toggle("opacity-0", i !== idx);
          img.classList.toggle("z-10", i === idx);
        });
      };
      const showNext = () => {
        current = (current + 1) % images.length;
        show(current);
      };
      const showPrev = () => {
        current = (current - 1 + images.length) % images.length;
        show(current);
      };

      nextBtn.addEventListener("click", showNext);
      prevBtn.addEventListener("click", showPrev);
      show(current);

      // Swipe
      let startX = 0;
      gallery.addEventListener(
        "touchstart",
        (e) => {
          startX = e.touches[0].clientX;
        },
        { passive: true }
      );
      gallery.addEventListener(
        "touchend",
        (e) => {
          const endX = e.changedTouches[0].clientX;
          if (startX - endX > 50) showNext();
          if (endX - startX > 50) showPrev();
        },
        { passive: true }
      );
    });

    // ============ 7) “Fade card” háttérhalványítás (GSAP) ============
    if (HAS_ST) {
      const cards = $all(".fade-card");
      if (cards.length) {
        cards.forEach((card, i) => {
          const nextCard = cards[i + 1];
          if (!nextCard) return;

          ScrollTrigger.create({
            trigger: nextCard,
            start: "top 60%",
            end: "top 10%",
            scrub: true,
            onUpdate: (self) => {
              const progress = self.progress;
              // 1 -> 0-ig, finom halványítás
              card.style.opacity = String(1 - progress);
            },
          });
        });
      }
    }

    // ============ 8) Viewport-anim indító (IntersectionObserver) ============
    (() => {
      const els = $all("[data-anim]");
      if (!els.length) return;

      // kezdeti állapot (ha HTML-ben nem adtad meg)
      els.forEach((el) => {
        const delay = (el.dataset.delay || "0") + "ms";
        el.style.setProperty("--anim-delay", delay);
        if (!el.classList.contains("opacity-0")) el.classList.add("opacity-0");
      });

      const run = (el) => {
        const type = el.dataset.anim; // "fade" | "fade-pulse"
        if (type === "fade") el.classList.add("animate-fade-in");
        if (type === "fade-pulse") el.classList.add("animate-fade-in-then-scale");
        el.style.animationDelay = `var(--anim-delay)`;
        el.classList.remove("opacity-0");
      };

      if (!("IntersectionObserver" in window)) {
        els.forEach(run);
        return;
      }

      const io = new IntersectionObserver(
        (entries, obs) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              run(entry.target);
              obs.unobserve(entry.target); // egyszer indít – ha mindig újra kell, ezt vedd ki
            }
          });
        },
        {
          threshold: 0.05,
          rootMargin: "0px 0px -10% 0px",
        }
      );

      els.forEach((el) => io.observe(el));
    })();
  });
})();

// ====== Billboard (prizmatábla) slider — background-image alapú, résmentes ======
(() => {
  const el = document.getElementById("billboard1");
  if (!el) return;

  const imgs = JSON.parse(el.getAttribute("data-images") || "[]");
  if (!imgs.length) return;

  const colsAttr = parseInt(el.getAttribute("data-cols") || "12", 10);
  const interval = parseInt(el.getAttribute("data-interval") || "4000", 10);
  el.style.setProperty("--cols", String(colsAttr));

  // Rács
  const grid = document.createElement("div");
  grid.className = "billboard-grid";
  el.appendChild(grid);

  // Aktuális állapot
  let current = 0;
  const nextIndex = () => (current + 1) % imgs.length;

  // Oszlopok létrehozása: background-image a front/back felületeken
  const cols = [];
  for (let i = 0; i < colsAttr; i++) {
    const col = document.createElement("div");
    col.className = "billboard-col";
    col.style.setProperty("--i", String(i));

    const front = document.createElement("div");
    front.className = "billboard-face front";
    front.style.backgroundImage = `url("${imgs[current]}")`;

    const back = document.createElement("div");
    back.className = "billboard-face back";
    back.style.backgroundImage = `url("${imgs[nextIndex()]}")`;

    col.appendChild(front);
    col.appendChild(back);
    grid.appendChild(col);
    cols.push({ col, front, back });
  }

  // Indikátorok (ha vannak)
  const indicatorsWrap = el.parentElement?.querySelector(".indicators");
  const indicators = indicatorsWrap ? Array.from(indicatorsWrap.children) : [];
  const setDots = (idx) => {
    indicators.forEach((d, i) => {
      d.classList.toggle("bg-black", i === idx);
      d.classList.toggle("bg-gray-300", i !== idx);
    });
  };
  setDots(current);

  // Flip animáció
  const doFlip = () => {
    const next = nextIndex();

    // háttérkép csere a back-eken
    cols.forEach(({ back }) => {
      back.style.backgroundImage = `url("${imgs[next]}")`;
    });

    // oszlopok átfordítása, staggertel
    const stagger = parseInt(getComputedStyle(el).getPropertyValue("--stagger") || 35, 10);
    const flipDur = parseInt(getComputedStyle(el).getPropertyValue("--flip-duration") || 600, 10);

    cols.forEach(({ col }, i) => {
      setTimeout(() => col.classList.add("is-flipping"), i * stagger);
    });

    // a végén front = back, visszaállítás
    setTimeout(() => {
      cols.forEach(({ col, front, back }) => {
        front.style.backgroundImage = back.style.backgroundImage;
        col.classList.remove("is-flipping");
      });
      current = next;
      setDots(current);
    }, (colsAttr - 1) * stagger + flipDur + 20);
  };

  let timer = setInterval(doFlip, interval);

  // motion-reduce: finom crossfade
  if (window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    clearInterval(timer);

    const bgA = document.createElement("div");
    const bgB = document.createElement("div");
    Object.assign(bgA.style, {
      position: "absolute", inset: "0",
      backgroundSize: "cover", backgroundPosition: "50% 50%",
      transition: "opacity 700ms",
      opacity: "1"
    });
    Object.assign(bgB.style, {
      position: "absolute", inset: "0",
      backgroundSize: "cover", backgroundPosition: "50% 50%",
      transition: "opacity 700ms",
      opacity: "0"
    });
    bgA.style.backgroundImage = `url("${imgs[current]}")`;
    bgB.style.backgroundImage = `url("${imgs[nextIndex()]}")`;
    el.appendChild(bgA); el.appendChild(bgB);

    let usingA = true;
    setInterval(() => {
      const next = nextIndex();
      if (usingA) {
        bgB.style.backgroundImage = `url("${imgs[next]}")`;
        bgA.style.opacity = "0"; bgB.style.opacity = "1";
      } else {
        bgA.style.backgroundImage = `url("${imgs[next]}")`;
        bgA.style.opacity = "1"; bgB.style.opacity = "0";
      }
      usingA = !usingA;
      current = next;
      setDots(current);
    }, interval);
  }
})();

