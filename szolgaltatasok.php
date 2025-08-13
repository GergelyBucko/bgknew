<?php
// /megoldasok/index.php

// ===== SEO alapok (állítsd a domainre) =====
$SITE_BASE  = 'https://www.studiobgk.com';
$PAGE_URL   = $SITE_BASE . '/megoldasok';
$PAGE_TITLE = 'Megoldások elejétől a végéig – Studio BGK';
$PAGE_DESC  = 'Stratégia, dizájn, web- és appfejlesztés, valamint online marketing — minden egy kézben, a céljaidhoz igazítva. Ismerd meg, hogyan dolgozom.';

// ===== Struktúrált adatokhoz a szolgáltatások =====
$services = [
  // Stratégia
  [
    'group' => 'Stratégia', 'id' => 'strategia', 'color' => '#2867a2',
    'items' => [
      ['name'=>'Általános marketing stratégia','desc'=>'Felmérem a jelenlegi működésed, és létrehozok egy fókuszált tervet a bevétel növelésére.'],
      ['name'=>'Piacra lépési stratégia','desc'=>'Új termék vagy szolgáltatás validálása, célpiac, csatornák és üzenetek megtervezése.'],
      ['name'=>'Növekedési stratégia','desc'=>'Érett vállalkozásoknak: mérföldkövek, prioritások, ütemezés – fókusz a skálázáson.'],
      ['name'=>'Értékesítési tölcsér (funnel) stratégia','desc'=>'A teljes funnel átnézése és optimalizálása, hogy több érdeklődőből legyen vevő.'],
      ['name'=>'Tartalomstratégia','desc'=>'Kommunikációs terv: mit, kinek, hol és mikor — következetesen és mérhetően.'],
      ['name'=>'Branding stratégia','desc'=>'Pozicionálás vagy újrapozicionálás (rebranding) a célközönséged igényeire szabva.'],
    ]
  ],
  // Dizájn
  [
    'group' => 'Dizájn', 'id' => 'dizajn', 'color' => '#ebaf73',
    'items' => [
      ['name'=>'Logótervezés','desc'=>'Letisztult, könnyen felismerhető logó, alapos brief és konkurenciaelemzés után.'],
      ['name'=>'Branding','desc'=>'Arculati rendszer: tipográfia, színpaletta, képvilág, felhasználási példák.'],
      ['name'=>'Csomagolás / címke','desc'=>'Jól beazonosítható, korszerű csomagolás — a polcon és online is működik.'],
      ['name'=>'Közösségi média arculat','desc'=>'Egységes vizuális megjelenés és poszt-sablonok a márkádhoz igazítva.'],
      ['name'=>'Interior koncepció','desc'=>'Kávézók, irodák, vendéglátóterek vizuális irányai — bevont partnerekkel kivitelezhető.'],
    ]
  ],
  // Web & App
  [
    'group' => 'Web & App fejlesztés', 'id' => 'web-app', 'color' => '#2867a2',
    'items' => [
      ['name'=>'Egyedi weboldal / webáruház','desc'=>'Gyors, reszponzív, üzleti célokra hangolt web — kézzel épített, modern stack-kel.'],
      ['name'=>'Applikáció tervezés','desc'=>'Cégedre szabott app-terv és prototípus — az ötlettől a működő demóig.'],
      ['name'=>'Bérelhető webáruház','desc'=>'Shoprenter / Shopify / Unas: gyors belépés automatizálásokkal és méréssel.'],
      ['name'=>'Sablon weboldal','desc'=>'Saját fejlesztésű, optimalizált sablon: gyors indulás, kompromisszum nélkül.'],
    ]
  ],
  // Marketing
  [
    'group' => 'Marketing', 'id' => 'marketing', 'color' => '#ebaf73',
    'items' => [
      ['name'=>'Facebook hirdetéskezelés','desc'=>'Kampánystruktúra, A/B tesztelés, költségsúlyozás, konverziók és riportok.'],
      ['name'=>'Instagram hirdetéskezelés','desc'=>'Célcsoportok, kreatív tesztek, optimalizálás és teljesítményriport.'],
      ['name'=>'Google kampánykezelés','desc'=>'Keresési, Shopping és Display kampányok folyamatos finomhangolása.'],
      ['name'=>'YouTube kampánykezelés','desc'=>'Videós stratégiák, célzás és mérés — elérés, ami konvertál.'],
      ['name'=>'Google Cégem (Business Profile)','desc'=>'Lokális jelenlét optimalizálása: profil, vizuálok, ajánlatok, posztok.'],
      ['name'=>'Remarketing','desc'=>'Listák, hasonmás közönségek és kreatívok — visszahozom az érdeklődőket.'],
      ['name'=>'Social media menedzsment','desc'=>'Terv, gyártás, ütemezés: levehetem a teljes tartalomkezelést a válladról.'],
      ['name'=>'TikTok tartalomgyártás','desc'=>'Forgatás, vágás, feliratozás és posztolás — natív, organikus hatás.'],
    ]
  ],
];
?>
<!DOCTYPE html>
<html lang="hu" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= htmlspecialchars($PAGE_TITLE) ?></title>
    <meta name="description" content="<?= htmlspecialchars($PAGE_DESC) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($PAGE_URL) ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($PAGE_TITLE) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($PAGE_DESC) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($PAGE_URL) ?>">
    <meta property="og:site_name" content="Studio BGK">

    <!-- Tailwind + font -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
      body { font-family: 'Space Grotesk', sans-serif; }
      .reveal { opacity:0; transform: translateY(16px); transition: opacity .5s ease, transform .5s ease; }
      .reveal.in { opacity:1; transform: none; }
      .tab-active-underline:after{
        content:""; position:absolute; left:0; bottom:-2px; height:3px; width:100%;
        background: linear-gradient(90deg, #2867a2, #ebaf73);
        border-radius: 9999px;
      }
      .ring-brand { box-shadow: 0 0 0 3px rgba(40,103,162,.15); }
    </style>

    <!-- JSON-LD: WebPage + Breadcrumb + ItemList (Service) -->
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"WebPage",
      "@id":"<?= htmlspecialchars($PAGE_URL) ?>/#webpage",
      "url":"<?= htmlspecialchars($PAGE_URL) ?>",
      "name":"Megoldások elejétől a végéig – Studio BGK",
      "description":"<?= htmlspecialchars($PAGE_DESC) ?>",
      "inLanguage":"hu-HU"
    }
    </script>
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"BreadcrumbList",
      "itemListElement":[
        {"@type":"ListItem","position":1,"name":"Főoldal","item":"<?= htmlspecialchars($SITE_BASE) ?>"},
        {"@type":"ListItem","position":2,"name":"Megoldások","item":"<?= htmlspecialchars($PAGE_URL) ?>"}
      ]
    }
    </script>
    <?php
      $itemList = [];
      $pos = 1;
      foreach($services as $group){
        foreach($group['items'] as $it){
          $itemList[] = [
            "@type" => "ListItem",
            "position" => $pos++,
            "item" => [
              "@type" => "Service",
              "name" => $it['name'],
              "description" => $it['desc'],
              "areaServed" => ["HU","EU"],
              "provider" => [
                "@type" => "Organization",
                "name" => "Studio BGK",
                "url"  => $SITE_BASE
              ]
            ]
          ];
        }
      }
    ?>
    <script type="application/ld+json">
    <?= json_encode([
      "@context"=>"https://schema.org",
      "@type"=>"ItemList",
      "itemListElement"=>$itemList
    ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>
    </script>
  </head>

  <body class="bg-[#e3e7ec] text-gray-900 overflow-x-hidden relative">
    <?php include __DIR__ . '/../includes/header.html'; ?>

    <!-- HERO -->
    <section class="relative z-20 bg-white text-gray-900 pt-24 sm:pt-32 pb-16 px-4 sm:px-6 lg:px-8 rounded-t-[3rem]">
      <div class="max-w-5xl mx-auto text-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight">Megoldások elejétől a végéig</h1>
        <p class="mt-4 text-base sm:text-lg text-gray-700">Stratégia, dizájn, fejlesztés és marketing — minden, ami az <strong>ügyfélszerzésedet</strong> szolgálja. Egy kézben, fókuszáltan.</p>
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
          <a href="#tabs" class="inline-block bg-[#2867a2] text-white hover:bg-[#1f4f7e] px-8 py-3 rounded-full font-semibold transition">Szolgáltatásaim</a>
          <a href="/#contact" class="inline-block bg-[#ebaf73] text-white hover:bg-[#e49b50] px-8 py-3 rounded-full font-semibold transition">Kérek ajánlatot</a>
        </div>
      </div>
    </section>

    <!-- Bevezető + kép (bal/jobb, a már meglévő blokk hangulatában) -->
    <section class="bg-gradient-to-b from-white to-gray-200 px-4 sm:px-6 lg:px-8 py-16 text-gray-900">
      <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
        <!-- Szöveg -->
        <div class="order-1 lg:order-2 flex flex-col justify-center reveal">
          <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">A rendszer az alap</h2>
          <p class="mt-6 text-lg text-gray-700 leading-relaxed text-justify">
            Akkor működik jól az online jelenlét, ha <strong>egyben</strong> van kezelve: irány, megjelenés, technológia, kommunikáció. Így nincs elveszett költség, nincs széteső feladat — csak tiszta célok és mérhető eredmények.
          </p>
          <p class="mt-4 text-lg text-gray-700 leading-relaxed text-justify">
            Egyedül dolgozom, ezért a <strong>mély fókusz</strong> és a <strong>közvetlen felelősség</strong> adott. A célodhoz igazítom az eszközöket — nem fordítva.
          </p>
        </div>

        <!-- Kép / mockup kerettel -->
        <div class="order-2 lg:order-1 flex justify-center lg:justify-start reveal">
          <div class="relative w-full max-w-[620px]">
            <div class="absolute -inset-0.5 rounded-2xl"
                 style="background: conic-gradient(from 0deg, #2867a2, #ebaf73, #2867a2); filter: blur(12px); opacity:.35;"></div>
            <div class="relative rounded-2xl overflow-hidden shadow-xl ring-brand">
              <img src="/assets/images/seoestartalom.webp" alt="Studio BGK – megoldások" class="w-full h-auto object-cover">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- TABOK: Stratégia / Dizájn / Web & App / Marketing -->
    <section id="tabs" class="bg-white px-4 sm:px-6 lg:px-8 py-16">
      <div class="max-w-7xl mx-auto">
        <!-- Tab header -->
        <div class="flex flex-wrap items-center gap-3 justify-center">
          <?php foreach($services as $i => $group): ?>
            <button
              class="tab-btn relative rounded-full border px-5 py-2 text-sm font-semibold transition
                     border-gray-300 bg-white hover:bg-gray-50 text-gray-800"
              data-target="#tab-<?= htmlspecialchars($group['id']) ?>"
              aria-controls="tab-<?= htmlspecialchars($group['id']) ?>"
              aria-selected="<?= $i===0?'true':'false' ?>"
              role="tab"
            >
              <?= htmlspecialchars($group['group']) ?>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- Panes -->
        <div class="mt-10">
          <?php foreach($services as $i => $group): ?>
            <div id="tab-<?= htmlspecialchars($group['id']) ?>" role="tabpanel"
                 class="tab-pane <?= $i===0?'':'hidden' ?> reveal">
              <!-- Intro sor -->
              <div class="mb-8 text-center">
                <h3 class="text-2xl sm:text-3xl font-extrabold"><?= htmlspecialchars($group['group']) ?></h3>
              </div>

              <!-- Kártyarács -->
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($group['items'] as $it): ?>
                  <article class="h-full rounded-xl bg-white border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden">
                    <div class="h-1" style="background: linear-gradient(90deg, <?= $group['color'] ?>, #ebaf73);"></div>
                    <div class="p-5 flex flex-col h-full">
                      <h4 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($it['name']) ?></h4>
                      <p class="mt-2 text-gray-600 text-sm leading-relaxed"><?= htmlspecialchars($it['desc']) ?></p>
                      <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="/#contact" class="text-[#2867a2] font-semibold hover:underline">Kérek ajánlatot</a>
                        <a href="/#contact" class="inline-flex items-center gap-1 text-sm text-gray-700 hover:text-gray-900"
                           aria-label="Időpont egyeztetés">
                          Időpont egyeztetés
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h10.586l-3.293-3.293A1 1 0 1112.707 4.293l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L14.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                        </a>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Hogyan dolgozom? – 4 lépés -->
    <section id="process" class="bg-gradient-to-b from-white to-gray-200 py-16 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
          <h2 class="text-3xl sm:text-4xl font-extrabold">Hogyan dolgozom?</h2>
          <p class="mt-3 text-gray-700">Piackutatás → stratégia → tervezés → megvalósítás → mérés. Átlátható, mérföldköves folyamat.</p>
        </div>

        <ol class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <li class="reveal rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <div class="w-10 h-10 rounded-full bg-[#2867a2] text-white flex items-center justify-center font-bold">01</div>
            <h3 class="mt-4 font-semibold text-lg">Stratégia</h3>
            <p class="mt-2 text-gray-600 text-sm">Alapos célfeltárás és piackutatás után meghatározom az irányt és a KPI-okat.</p>
          </li>
          <li class="reveal rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <div class="w-10 h-10 rounded-full bg-[#ebaf73] text-white flex items-center justify-center font-bold">02</div>
            <h3 class="mt-4 font-semibold text-lg">Tervezés</h3>
            <p class="mt-2 text-gray-600 text-sm">Arculat, UX és tartalom-terv; architektúra és mérési terv összehangolása.</p>
          </li>
          <li class="reveal rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <div class="w-10 h-10 rounded-full bg-[#2867a2] text-white flex items-center justify-center font-bold">03</div>
            <h3 class="mt-4 font-semibold text-lg">Megvalósítás</h3>
            <p class="mt-2 text-gray-600 text-sm">Fejlesztés, integrációk, automatizálás — közben sprintenkénti egyeztetés.</p>
          </li>
          <li class="reveal rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
            <div class="w-10 h-10 rounded-full bg-[#ebaf73] text-white flex items-center justify-center font-bold">04</div>
            <h3 class="mt-4 font-semibold text-lg">Jelentés</h3>
            <p class="mt-2 text-gray-600 text-sm">Indítás után folyamatos mérés, riport és optimalizálás — ami számít, az látható.</p>
          </li>
        </ol>

        <!-- CTA szalag -->
        <div class="mt-16 text-center reveal">
          <div class="inline-flex flex-col sm:flex-row items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-2xl px-6 py-5">
            <p class="text-gray-800">Készen állsz a következő lépésre?</p>
            <div class="flex gap-3">
              <a href="/#contact" class="bg-[#2867a2] text-white hover:bg-[#1f4f7e] px-6 py-3 rounded-full font-semibold transition">Kérek visszahívást</a>
              <a href="/#contact" class="bg-[#ebaf73] text-white hover:bg-[#e49b50] px-6 py-3 rounded-full font-semibold transition">Indítsuk el</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.html'; ?>

    <!-- Interakciók: tabok + reveal anim -->
    <script>
      // Tabok
      (function(){
        const btns = Array.from(document.querySelectorAll('.tab-btn'));
        const panes= Array.from(document.querySelectorAll('.tab-pane'));

        function activate(targetId){
          panes.forEach(p => p.classList.toggle('hidden', '#'+p.id !== targetId));
          btns.forEach(b => {
            const on = b.getAttribute('data-target') === targetId;
            b.setAttribute('aria-selected', on ? 'true':'false');
            b.classList.toggle('tab-active-underline', on);
            b.classList.toggle('bg-gray-50', on);
            b.classList.toggle('border-gray-300', true);
          });
          // URL hash frissítése (SEO-barát, de nem reload)
          const url = new URL(location);
          url.hash = targetId;
          history.replaceState(null, '', url);
          // fókusz a panelre a11y miatt
          const panel = document.querySelector(targetId);
          if (panel) panel.focus({preventScroll:true});
        }

        btns.forEach(b => {
          b.addEventListener('click', () => activate(b.getAttribute('data-target')));
        });

        // Hash alapján indul
        const start = location.hash && document.querySelector(location.hash) ? location.hash : (btns[0]?.getAttribute('data-target')||'');
        if (start) activate(start);
      })();

      // Reveal animáció (IntersectionObserver)
      (function(){
        const els = Array.from(document.querySelectorAll('.reveal'));
        const io = new IntersectionObserver(entries=>{
          entries.forEach(e=>{
            if (e.isIntersecting) {
              e.target.classList.add('in');
              io.unobserve(e.target);
            }
          });
        }, {threshold: .12});
        els.forEach(el=>io.observe(el));
      })();
    </script>
  </body>
</html>
