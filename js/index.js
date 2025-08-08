
  gsap.registerPlugin(ScrollTrigger);

  const panels = gsap.utils.toArray(".tab-panel");
  const count = panels.length;

  gsap.set(panels, { x: "100%", autoAlpha: 0, zIndex: 0 });
  gsap.set(panels[0], { x: "0%", autoAlpha: 1, zIndex: 1 });

  for (let i = 1; i < count; i++) {
    const prev = panels[i - 1];
    const curr = panels[i];

    // lefelé: prev balra ki, curr jobbról be
    ScrollTrigger.create({
      trigger: "#bgk-tab-switcher",
      start: `${(i * 100) / count}% center`,
      end: `${((i + 1) * 100) / count}% center`,
      scrub: true,
      onEnter: () => {
        gsap.to(prev, {
          x: "-100%",
          autoAlpha: 0,
          zIndex: 0,
          duration: 0.6,
          ease: "power2.out"
        });
        gsap.set(curr, { x: "100%", zIndex: 1 });
        gsap.to(curr, {
          x: "0%",
          autoAlpha: 1,
          duration: 0.6,
          ease: "power2.out"
        });
      }
    });

    // felfelé: curr jobbra ki, prev balról be
    ScrollTrigger.create({
      trigger: "#bgk-tab-switcher",
      start: `${(i * 100) / count}% center`,
      end: `${((i - 1) * 100) / count}% center`,
      scrub: true,
      onEnterBack: () => {
        gsap.to(curr, {
          x: "100%",
          autoAlpha: 0,
          zIndex: 0,
          duration: 0.6,
          ease: "power2.out"
        });
        gsap.set(prev, { x: "-100%", zIndex: 1 });
        gsap.to(prev, {
          x: "0%",
          autoAlpha: 1,
          duration: 0.6,
          ease: "power2.out"
        });
      }
    });
  }




  gsap.registerPlugin(ScrollTrigger);

  gsap.utils.toArray('.timeline-text').forEach(el => {
    gsap.to(el, {
      x: 0,
      opacity: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: el,
        start: "top 80%",
      }
    });
  });

  gsap.utils.toArray('.timeline-img').forEach(el => {
    gsap.to(el, {
      x: 0,
      opacity: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: el,
        start: "top 80%",
      }
    });
  });

  // Mobilos verzió: alulról úszik be
  gsap.utils.toArray('.timeline-text-mobile, .timeline-img-mobile').forEach(el => {
    gsap.to(el, {
      y: 0,
      opacity: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: el,
        start: "top 85%",
      }
    });
  });




  gsap.registerPlugin(ScrollTrigger);

  // 1. Soronkénti beúszás (GSAP ScrollTrigger)
  document.querySelectorAll(".ref-row").forEach((row) => {
    gsap.fromTo(
      row,
      { opacity: 0, y: 100 },
      {
        opacity: 1,
        y: 0,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: row,
          start: "top 85%",
        },
      }
    );
  });

  // 2. Hover proximity smooth mozgás
  const tiles = document.querySelectorAll(".ref-tile");
  const maxDist = 600;
  const strength = 12;
  const smoothing = 0.1;

  tiles.forEach(tile => {
    tile._targetX = 0;
    tile._targetY = 0;
    tile._currentX = 0;
    tile._currentY = 0;
  });

  document.addEventListener("mousemove", (e) => {
    tiles.forEach((tile) => {
      const rect = tile.getBoundingClientRect();
      const centerX = rect.left + rect.width / 2;
      const centerY = rect.top + rect.height / 2;
      const distX = centerX - e.clientX;
      const distY = centerY - e.clientY;
      const distance = Math.sqrt(distX ** 2 + distY ** 2);

      if (distance < maxDist) {
        const factor = (1 - distance / maxDist) * strength;
        tile._targetX = (distX / distance) * factor;
        tile._targetY = (distY / distance) * factor;
      } else {
        tile._targetX = 0;
        tile._targetY = 0;
      }
    });
  });

  // 3. Animációs ciklus – smooth mozgás
  function animateTiles() {
    tiles.forEach((tile) => {
      tile._currentX += (tile._targetX - tile._currentX) * smoothing;
      tile._currentY += (tile._targetY - tile._currentY) * smoothing;
      tile.style.transform = `translate(${tile._currentX}px, ${tile._currentY}px)`;
    });
    requestAnimationFrame(animateTiles);
  }
  animateTiles();



      const images = document.querySelectorAll('.masked-image');
      const indicators = document.querySelectorAll('.active-indicator, .active-indicator ~ div');
      let current = 0;

      function showNextImage() {
        images[current].classList.remove('opacity-100');
        images[current].classList.add('opacity-0');
        indicators[current].classList.remove('bg-black');
        indicators[current].classList.add('bg-gray-300');

        current = (current + 1) % images.length;

        images[current].classList.remove('opacity-0');
        images[current].classList.add('opacity-100');
        indicators[current].classList.add('bg-black');
        indicators[current].classList.remove('bg-gray-300');
      }

      // Indikátor első beállítás
      indicators[0].classList.add('bg-black');
      indicators[0].classList.remove('bg-gray-300');

      // Indítás
      setInterval(showNextImage, 4000);

document.querySelectorAll('.gallery').forEach(gallery => {
    const images = gallery.querySelectorAll('.gallery-image');
    const prevBtn = gallery.querySelector('.prev');
    const nextBtn = gallery.querySelector('.next');
    let current = 0;

    function showImage(index) {
      images.forEach((img, i) => {
        img.classList.toggle('opacity-100', i === index);
        img.classList.toggle('opacity-0', i !== index);
        img.classList.toggle('z-10', i === index);
      });
    }

    function showNext() {
      current = (current + 1) % images.length;
      showImage(current);
    }

    function showPrev() {
      current = (current - 1 + images.length) % images.length;
      showImage(current);
    }

    nextBtn.addEventListener('click', showNext);
    prevBtn.addEventListener('click', showPrev);
    showImage(current);

    // Touch / swipe support
    let startX = 0;
    gallery.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
    });
    gallery.addEventListener('touchend', (e) => {
      const endX = e.changedTouches[0].clientX;
      if (startX - endX > 50) showNext();
      if (endX - startX > 50) showPrev();
    });
  });

   document.querySelectorAll('.fade-card').forEach((card, i, cards) => {
    const nextCard = cards[i + 1];
    if (!nextCard) return;

    const trigger = ScrollTrigger.create({
      trigger: nextCard,
      start: "top 60%",    // amikor a következő csempe megérinti az alját
      end: "top 10%",         // amikor teljesen fedi
      scrub: true,
      onUpdate: self => {
        const progress = self.progress;
        card.style.opacity = 1 - progress * 1; // 0.2-re halványul
      }
    });
  });