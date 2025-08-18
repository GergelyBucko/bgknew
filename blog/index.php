<?php
// /blog/index.php

// ====== Alap SEO adatok ======
$SITE_BASE  = 'https://www.studiobgk.com'; // állítsd a valós domainre
$PAGE_URL   = $SITE_BASE . '/blog';
$PAGE_TITLE = 'Blog – Studio BGK';
$PAGE_DESC  = 'Független gondolatok az online jelenlétről, webfejlesztésről, SEO-ról és üzleti növekedésről.';

// ====== Bejegyzések (bővítsd bátran) ======
$posts = [
  [
    'title'    => 'Hogyan növeld az online konverziót?',
    'slug'     => 'online-konverzio',
    'date'     => '2025-06-30', // ISO
    'category' => 'Online jelenlét',
    'cat_slug' => 'online',
    'excerpt'  => 'A Google AI-alapú áttekintés egy olyan keresési funkció, amely a generatív mesterséges intelligencia segítségével gyors válaszokat ad közvetlenül a keresési eredményekben...',
    'image'    => '/blog/blog-images/online-konverzio.webp',
  ],
  [
    'title'    => 'Hogyan használd a keresőoptimalizálást az értékesítéshez?',
    'slug'     => 'seo-ertekesites',
    'date'     => '2025-03-10',
    'category' => 'Értékesítés',
    'cat_slug' => 'ertekesites',
    'excerpt'  => 'Ismerd meg, hogyan segíthet a SEO több ügyfelet hozni az oldaladra és növelni a bevételedet...',
    'image'    => '/blog/blog-images/seo-ertekesites.webp',
  ],
  [
    'title'    => 'Hogyan javítsd a vásárlói élményt?',
    'slug'     => 'vasarloi-elmeny',
    'date'     => '2025-02-12',
    'category' => 'Üzlet',
    'cat_slug' => 'uzlet',
    'excerpt'  => 'Egyszerű lépések és eszközök a felhasználói élmény fejlesztésére – hogy ügyfeleid visszatérjenek...',
    'image'    => '/blog/blog-images/vasarloi-elmeny.webp',
  ],
  // --- ide vehetsz fel új posztokat ugyanígy ---
];

// ====== Kategória lista (a filterhez) ======
$category_options = [
  'all'         => 'Összes',
  'marketing'   => 'Marketing',
  'ertekesites' => 'Értékesítés',
  'uzlet'       => 'Üzlet',
  'online'      => 'Online jelenlét',
];

// ====== Alap rendezés: legújabb elöl ======
usort($posts, fn($a,$b) => strcmp($b['date'], $a['date']));

// ====== Segédfüggvény: magyar dátum formázás ======
function hu_date($iso){
  $months = ['01'=>'január','02'=>'február','03'=>'március','04'=>'április','05'=>'május','06'=>'június','07'=>'július','08'=>'augusztus','09'=>'szeptember','10'=>'október','11'=>'november','12'=>'december'];
  [$y,$m,$d] = explode('-', $iso);
  $mname = $months[$m] ?? $m;
  // pl.: június 30, 2025
  return sprintf('%s %d, %d', $mname, (int)$d, (int)$y);
}
?>
<!DOCTYPE html>
<html lang="hu" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= htmlspecialchars($PAGE_TITLE) ?></title>
    <meta name="description" content="<?= htmlspecialchars($PAGE_DESC) ?>" />
    <link rel="canonical" href="<?= htmlspecialchars($PAGE_URL) ?>" />
    <meta name="robots" content="index,follow" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= htmlspecialchars($PAGE_TITLE) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($PAGE_DESC) ?>" />
    <meta property="og:url" content="<?= htmlspecialchars($PAGE_URL) ?>" />
    <meta property="og:site_name" content="Studio BGK" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">   
    <style>
      body { font-family: 'Roboto', sans-serif; }
      .hide-scrollbar::-webkit-scrollbar{display:none;}
      .hide-scrollbar{-ms-overflow-style:none;scrollbar-width:none;}
    </style>

    <!-- JSON-LD: WebPage + Blog + Breadcrumb + ItemList -->
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"WebPage",
      "@id":"<?= htmlspecialchars($PAGE_URL) ?>/#webpage",
      "url":"<?= htmlspecialchars($PAGE_URL) ?>",
      "name":"Blog – Studio BGK",
      "description":"<?= htmlspecialchars($PAGE_DESC) ?>",
      "inLanguage":"hu-HU"
    }
    </script>
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"Blog",
      "name":"Studio BGK Blog",
      "url":"<?= htmlspecialchars($PAGE_URL) ?>",
      "inLanguage":"hu-HU",
      "publisher":{"@type":"Organization","name":"Studio BGK","url":"<?= htmlspecialchars($SITE_BASE) ?>"}
    }
    </script>
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"BreadcrumbList",
      "itemListElement":[
        {"@type":"ListItem","position":1,"name":"Főoldal","item":"<?= htmlspecialchars($SITE_BASE) ?>"},
        {"@type":"ListItem","position":2,"name":"Blog","item":"<?= htmlspecialchars($PAGE_URL) ?>"}
      ]
    }
    </script>
    <?php
      $items = [];
      foreach ($posts as $i => $p) {
        $items[] = [
          "@type"    => "ListItem",
          "position" => $i + 1,
          "url"      => $SITE_BASE . '/blog/posts/' . $p['slug'],
          "name"     => $p['title']
        ];
      }
    ?>
    <script type="application/ld+json">
    <?= json_encode([
      "@context" => "https://schema.org",
      "@type"    => "ItemList",
      "itemListElement" => $items
    ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>
    </script>
  </head>
  <body class="bg-[#e3e7ec] text-gray-900 overflow-x-hidden relative">
    <?php include __DIR__ . '/../includes/header.html'; ?>

    <!-- HERO (visszafogott, a fókusz a listán) -->
    <section class="relative z-20 bg-white text-gray-900 pt-24 sm:pt-32 pb-6 px-4 sm:px-6 lg:px-8 rounded-t-[3rem]">
      <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold">Blog</h1>
        <p class="mt-3 text-gray-700">Online jelenlét, webfejlesztés, SEO, üzleti növekedés.</p>
      </div>
    </section>

    <!-- BLOG GRID (pont, mint a terved) -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">

      <!-- Filter & Sort sor -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Kategória szűrő -->
        <div class="flex items-center">
          <label for="category" class="text-sm font-medium text-gray-700">Kategória:</label>
          <select id="category" class="ml-2 rounded-md border border-gray-300 bg-white text-sm focus:ring-2 focus:ring-[#2867a2] focus:border-[#2867a2]">
            <?php foreach ($category_options as $val => $label): ?>
              <option value="<?= htmlspecialchars($val) ?>"><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Rendezés -->
        <div class="flex items-center">
          <label for="sort" class="text-sm font-medium text-gray-700">Rendezés:</label>
          <select id="sort" class="ml-2 rounded-md border border-gray-300 bg-white text-sm focus:ring-2 focus:ring-[#2867a2] focus:border-[#2867a2]">
            <option value="desc">Legújabb elöl</option>
            <option value="asc">Legrégebbi elöl</option>
          </select>
        </div>
      </div>

      <!-- Lista -->
      <div id="posts-wrap" class="space-y-12">
        <?php foreach ($posts as $p): ?>
          <article
            class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden"
            itemscope itemtype="https://schema.org/BlogPosting"
            data-category="<?= htmlspecialchars($p['cat_slug']) ?>"
            data-date="<?= htmlspecialchars($p['date']) ?>"
          >
            <!-- Kép + kategória badge -->
            <div class="relative">
              <?php if (!empty($p['image'])): ?>
                <a href="/blog/posts/<?= htmlspecialchars($p['slug']) ?>" class="block">
                  <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-64 object-cover" itemprop="image" loading="lazy">
                </a>
              <?php endif; ?>
              <span class="absolute top-4 right-4 bg-[#2867a2] text-white text-xs font-semibold px-3 py-1 rounded-full">
                <?= htmlspecialchars(mb_strtoupper($p['category'])) ?>
              </span>
            </div>

            <!-- Tartalom -->
            <div class="px-6 pb-6 text-center">
              <h2 class="text-2xl font-bold text-gray-900 mt-4" itemprop="headline">
                <a href="/blog/posts/<?= htmlspecialchars($p['slug']) ?>" itemprop="url" class="hover:text-gray-700">
                  <?= htmlspecialchars($p['title']) ?>
                </a>
              </h2>

              <?php if (!empty($p['excerpt'])): ?>
                <p class="mt-3 text-gray-600 text-sm leading-relaxed" itemprop="description">
                  <?= htmlspecialchars($p['excerpt']) ?>
                </p>
              <?php endif; ?>

              <a href="/blog/posts/<?= htmlspecialchars($p['slug']) ?>" class="mt-4 inline-block text-[#2867a2] font-semibold hover:underline">
                OLVASS TOVÁBB »
              </a>

              <div class="mt-4 text-xs text-gray-500">
                <time datetime="<?= htmlspecialchars($p['date']) ?>" itemprop="datePublished"><?= htmlspecialchars(hu_date($p['date'])) ?></time>
                <meta itemprop="dateModified" content="<?= htmlspecialchars($p['date']) ?>">
                <meta itemprop="mainEntityOfPage" content="<?= htmlspecialchars($SITE_BASE . '/blog/posts/' . $p['slug']) ?>">
                <span itemprop="author" itemscope itemtype="https://schema.org/Person" class="hidden">
                  <meta itemprop="name" content="B. Gergely Kristóf">
                </span>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- Nincs találat -->
      <p id="no-results" class="hidden text-center text-gray-600">Nincs találat ezzel a szűrővel.</p>
    </main>

    <?php include __DIR__ . '/../includes/footer.html'; ?>

    <!-- Szűrés & rendezés (URL paramokkal) -->
    <script>
      (function(){
        const wrap   = document.getElementById('posts-wrap');
        const cards  = Array.from(wrap.querySelectorAll('article'));
        const selCat = document.getElementById('category');
        const selSort= document.getElementById('sort');
        const noRes  = document.getElementById('no-results');

        // URL paramok betöltése
        const params = new URLSearchParams(location.search);
        const qCat  = params.get('category');
        const qSort = params.get('sort');
        if (qCat && selCat.querySelector(`option[value="${qCat}"]`)) selCat.value = qCat;
        if (qSort && (qSort === 'asc' || qSort === 'desc')) selSort.value = qSort;

        function apply(){
          const cat  = selCat.value;
          const sort = selSort.value;

          // Rendezés a dátum szerint (DOM újrarendezése)
          cards.sort((a,b)=>{
            const da = a.dataset.date, db = b.dataset.date;
            return sort === 'asc' ? da.localeCompare(db) : db.localeCompare(da);
          }).forEach(el => wrap.appendChild(el));

          // Szűrés a kategória szerint
          let visible = 0;
          cards.forEach(c=>{
            const matched = (cat === 'all') || (c.dataset.category === cat);
            c.classList.toggle('hidden', !matched);
            if (matched) visible++;
          });

          noRes.classList.toggle('hidden', visible > 0);

          // URL frissítés (reload nélkül)
          const p = new URLSearchParams();
          if (cat !== 'all') p.set('category', cat);
          if (sort !== 'desc') p.set('sort', sort);
          const url = p.toString() ? `?${p.toString()}` : location.pathname;
          history.replaceState(null, '', url);
        }

        selCat.addEventListener('change', apply);
        selSort.addEventListener('change', apply);
        apply();
      })();
    </script>
  </body>
</html>
