<!DOCTYPE html>
<html lang="hu" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Studio Tailwind</title>
  <link rel="stylesheet" href="/css/style.css">
<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>
<script src="https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'Space Grotesk', sans-serif;
      }
      .no-scroll {
        overflow: hidden;
      }

      .hide-scrollbar::-webkit-scrollbar {
        display: none;
      }
      .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
      
  body.lock-scroll {
    overflow: hidden;
  }


</style>
<style>
/* Billboard villanás + hairline fix – azonnali override */
.billboard { perspective: 1200px; }
.billboard-grid{ position:absolute; inset:0; display:grid; gap:0; }
.billboard-col{ position:relative; transform-style:preserve-3d; transition:transform 600ms cubic-bezier(.22,.61,.36,1); outline:1px solid transparent; }
.billboard-col.is-flipping{ transform: rotateY(180deg); }

.billboard-face{
  position:absolute; inset:0;
  backface-visibility:hidden; -webkit-backface-visibility:hidden;
  background-repeat:no-repeat;
  background-size: calc(var(--cols) * 100%) 100%;
  background-position: calc(var(--i) * (100% / (var(--cols) - 1))) 50%;
  transform: translateZ(0.12px); /* nagyobb Z, hogy a hajszálcsík eltűnjön */
  will-change: transform, opacity;
}
.billboard-face.back{
  transform: rotateY(180deg) translateZ(0.08px);
  opacity:0;           /* fontos! ne villanjon fel a következő kép */
}
.billboard-col.is-flipping .billboard-face.back{ opacity:1; } /* csak flip közben látszódjon */
</style>


  </head>
  <body class="bg-[#e3e7ec] text-gray-900 overflow-x-hidden relative">
    <!-- Header -->
  <?php include __DIR__ . '/includes/header.html'; ?>

    <!-- Hero Section ----------------->
<section id="heroSection" class="relative z-20 bg-white text-gray-900 pt-24 sm:pt-32 pb-24 sm:pb-32 px-4 sm:px-6 lg:px-8 rounded-t-[3rem] transition-all duration-500 ease-in-out">
  <!-- Video háttér -->
  <video autoplay muted loop playsinline poster="/assets/hero-fallback.jpg"
    class="absolute inset-0 w-full h-full object-cover -z-10 rounded-t-[3rem]">
    <source src="/assets/hero.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <!-- Overlay rétegek -->
  <div class="absolute inset-0 bg-[#f3f3f3]/50 backdrop-blur-sm -z-10 rounded-t-[3rem]"></div>
  <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle,rgba(240,240,240,0.6)_0%,transparent_70%)] rounded-t-[3rem]"></div>

  <!-- Tartalom -->
<div class="max-w-4xl mx-auto text-center">
  <h1 class="opacity-0 animate-fade-in text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-6" style="animation-delay: 0.2s;">
    <span class="uppercase border-b-4 border-[#ebaf73] pb-1 mb-2 inline-block">Garantált</span><br>
    ügyfélszerzés, modern digitális megoldásokkal
  </h1>

  <h2 class="opacity-0 animate-fade-in text-base sm:text-lg text-gray-900 max-w-2xl mx-auto mb-8" style="animation-delay: 0.2s;">
    Teljes körű online marketing, arculat- és webes alkalmazásfejlesztés vállalkozásoknak
  </h2>

  <a href="#contact"
     class="opacity-0 animate-fade-in-then-scale inline-block bg-[#ebaf73] text-white px-6 py-3 rounded-full text-lg font-semibold shadow-lg hover:bg-[#e49b50] transition"
     style="animation-delay: 1s;">
    Dolgozzunk együtt!
  </a>
</div>



</section>


    <!-- Bemutatkozó szekció ------------------->
<section id="mit-csinalunk" class="relative z-10 bg-white text-gray-900 px-4 sm:px-6 lg:px-8 py-24">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

    <!-- Jobb oldal (kisebb képernyőn felül) -->
    <div class="order-1 md:order-2 flex flex-col self-start text-center md:text-left">
      <h2 class=" opacity-0  text-4xl sm:text-5xl font-bold mb-6" data-anim="fade" data-delay="0" >
        <span class="relative inline-block">
          <span class="text-gray-900 ">„célom a <span class="italic font-bold">teljesség</span>”</span>
          <!-- dísz idézőjel (nem kötelező) -->
        </span>
      </h2>

      <p class="opacity-0 text-lg leading-relaxed mb-8 md:mb-10 text-justify" data-anim="fade" data-delay="0.2" >
        Ahhoz, hogy valami igazán működjön, rendszerben kell gondolkodni. Legyen szó a teljes online jelenlétünkről, vagy egy ügyfélszerző kampányról.
        <br><strong>A siker a részleteken múlik!</strong>
      </p>

      <a href="#about"
         class="opacity-0 inline-block px-10 py-4 rounded-full text-lg font-medium
                 transition-all duration-300 text-center bg-[#2867a2] text-white hover:bg-[#1f4f7e]"
         data-anim="fade" data-delay="0.4" 
         aria-label="Bővebben rólam">
        Bővebben...
      </a>
    </div>

    <!-- Bal oldal (kisebb képernyőn alul) -->
    <div class="order-2 md:order-1 flex flex-col self-start text-center md:text-left">
      <h2 class="opacity-0 text-4xl sm:text-5xl font-bold mb-6 " data-anim="fade" data-delay="0">
        <span class="italic font-bold text-black">Mit</span> fogunk csinálni?
      </h2>

      <p class="opacity-0 text-lg leading-relaxed mb-8 md:mb-10 text-justify" data-anim="fade" data-delay="0.2">
        Röviden:<br>
        Online rendszereket építünk, amik pénzt termelnek a vállalkozásodnak.<br><br>
        Letisztult, felhasználóbarát weboldalak,<br>
        értékesítést támogató marketing rendszerek,<br>
        erős, hiteles vizuális arculat.
        <br><strong>Minden ami számít, <span class="italic">egy helyen, egy kézben!</span></strong>
      </p>
    </div>

  </div>

  <!-- Bizalmi sor -->
  <div class="max-w-7xl mx-auto mt-12 md:mt-16">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
      <div class=" opacity-0" data-anim="fade" data-delay="0">
        <p class="text-3xl font-bold text-[#ebaf73]">99%</p>
        <p class="text-xs text-gray-600">ügyfél-elégedettség</p>
      </div>
      <div class=" opacity-0" data-anim="fade" data-delay="0">
        <p class="text-3xl font-bold text-[#ebaf73]">120+</p>
        <p class="text-xs text-gray-600">lezárt fejlesztés</p>
      </div>
      <div class="opacity-0" data-anim="fade" data-delay="0">
        <p class="text-3xl font-bold text-[#ebaf73]">&lt; 1s</p>
        <p class="text-xs text-gray-600">LCP cél weben</p>
      </div>
      <div class="opacity-0" data-anim="fade" data-delay="0">
        <p class="text-3xl font-bold text-[#ebaf73]">A+</p>
        <p class="text-xs text-gray-600">PageSpeed cél</p>
      </div>
    </div>
  </div>
</section>


    <!-- SZOLGÁLTATÁSOK VÉGLEGES ----------------------->
    <section class="bg-gradient-to-b from-white to-gray-200 px-4 sm:px-6 lg:px-8 py-24 text-gray-900">
      <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">

        <!-- Jobb oszlop – szolgáltatáslista -->
        <div class="order-1 lg:order-2 flex flex-col justify-between py-6">
          <div class="flex flex-col justify-between h-full">
            <!-- Fejléc -->
            <div class="space-y-8">
              <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">Megoldások elejétől a végéig</h2>

              <!-- Lista -->
              <div class="space-y-8">
                <div class="border-l border-gray-300 pl-4">
                  <h3 class="font-semibold text-lg">Digitális stratégia</h3>
                  <h4 class="text-gray-700">Kezdésképp megtervezzük a teljes kommunikációdat és az ügyfeleid pontos elérésének a módját</h4>
                </div>
                <div class="border-l border-gray-300 pl-4">
                  <h3 class="font-semibold text-lg">Arculattervezés</h3>
                  <h4 class="text-gray-700">Ezután kialakítjuk azt a minőségi megjelenést, ami maximálisan tudja képviselni cégedet online és offline is</h4>
                </div>
                <div class="border-l border-gray-300 pl-4">
                  <h3 class="font-semibold text-lg">Weboldalkészítés</h3>
                  <h4 class="text-gray-700">A következő lépésben elkészül a weboldal, ahol a vásárlóid elérhetik szolgáltatásaidat. Alapvetően minden honlap a legfrissebb technológiákat alkalmazva, kódszinten épül fel</h4>
                </div>
                <div class="border-l border-gray-300 pl-4">
                  <h3 class="font-semibold text-lg">Online marketing</h3>
                  <h4 class="text-gray-700">Végezetül mindent bevetünk a maximális konverzióért</h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Bal oszlop – maszkolt kép + gomb -->
        <div class="order-2 lg:order-1 flex flex-col justify-between py-6">
          <div class="w-full max-w-[600px] mx-auto flex flex-col h-full">
            <!-- Kép -->
    <div class="relative w-full max-w-[600px] mx-auto">
      <!-- Prizmatábla váltó -->
      <div
        id="billboard1"
        class="billboard rounded-2xl shadow-md overflow-hidden aspect-[655/480] bg-gray-100"
        data-images='[
          "/assets/images/weboldalkeszites.webp",
          "/assets/images/seoestartalom.webp",
          "/assets/images/technikaitanacsadas.webp",
          "/assets/images/weboldalkeszites.webp"
        ]'
        data-cols="12"
        data-interval="4000"
      ></div>

      <!-- Jelzőpontok (maradhatnak a tieid is) -->
      <div class="indicators flex justify-center mt-4 gap-2">
        <div class="w-1.5 h-1.5 rounded-full bg-gray-300 transition-all duration-300"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-gray-300 transition-all duration-300"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-gray-300 transition-all duration-300"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-gray-300 transition-all duration-300"></div>
      </div>
    </div>


            <!-- Gomb -->
            <div class="mt-8">
              <a href="#"
                class="bg-[#2867a2] text-white hover:bg-[#1f4f7e] block w-full px-10 py-4 rounded-full text-lg font-medium transition-all duration-300 text-center">
                Bővebben...
              </a>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!--CHAT ANALYSIS SZEKCIÓ--------------------->
    <section id="bgk-tab-switcher" class="relative bg-gradient-to-b from-gray-200 to-[#2867a2] pt-0 mt-[-6rem]">
      <div class="h-[400vh] relative">
        <div class="sticky top-0 h-screen flex items-center justify-center overflow-hidden">
          <div class="relative w-full max-w-xl md:max-w-2xl h-[400px]">

            <!-- 1. buborék (jobbra, kék) -->
            <div class="tab-panel absolute inset-0 flex items-center justify-center">
              <div class="relative bg-[#007aff] text-white rounded-2xl px-6 py-4 max-w-sm md:max-w-md shadow-lg
                after:content-[''] after:absolute after:bottom-3 after:right-[-10px]
                after:border-t-8 after:border-t-transparent
                after:border-l-8 after:border-l-[#007aff]
                after:border-b-8 after:border-b-transparent">
                <p class="text-base md:text-lg font-medium">Van már weboldalad?</p>
                <p class="text-sm md:text-base mt-2">Kíváncsi vagyok, mennyire vagy jelen online</p>
              </div>
            </div>

            <!-- 2. buborék (balra, szürke) -->
            <div class="tab-panel absolute inset-0 flex items-center justify-center">
              <div class="relative bg-gray-200 text-gray-800 rounded-2xl px-6 py-4 max-w-sm md:max-w-md shadow-lg
                after:content-[''] after:absolute after:bottom-3 after:left-[-10px]
                after:border-t-8 after:border-t-transparent
                after:border-r-8 after:border-r-gray-200
                after:border-b-8 after:border-b-transparent">
                <p class="text-base md:text-lg font-medium">Igen, van!</p>
                <p class="text-sm md:text-base mt-2">Jól működik, hozza a vevőket, nincs panasz</p>
              </div>
            </div>

            <!-- 3. buborék (jobbra, kék + CTA) -->
            <div class="tab-panel absolute inset-0 flex items-center justify-center">
              <div class="relative bg-[#007aff] text-white rounded-2xl px-6 py-4 max-w-sm md:max-w-md shadow-lg
                after:content-[''] after:absolute after:bottom-3 after:right-[-10px]
                after:border-t-8 after:border-t-transparent
                after:border-l-8 after:border-l-[#007aff]
                after:border-b-8 after:border-b-transparent">
                <h2 class="text-lg md:text-xl font-semibold mb-2">Ez szuper, de menjünk biztosra!</h2>
                <p class="text-sm md:text-base mb-3">Egy gyors átfogó elemzéssel pontosan megmutatom, hol veszíthetsz el érdeklődőket anélkül, hogy tudnál róla <br>Érdekel?</p>
                <button class="mt-2 bg-white text-[#007aff] font-semibold px-4 py-2 rounded-full hover:bg-blue-100 transition">
                  Naná! →
                </button>
              </div>
            </div>

          </div>
          <!-- Pulzáló lefele nyíl -->
      <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce text-white opacity-80">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 md:h-12 md:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>

        </div>
      </div>
    </section>

    <!--SUBSERVICES----------------->
    <section id="timeline" class="relative bg-[#2867a2] py-24 px-4 sm:px-6 lg:px-8 text-white">
      <div class="max-w-7xl mx-auto relative">
        <div class="mb-16 text-center">
          <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
            Tünj ki a tömegből!
          </h2>
        </div>
        <div class="relative">
        <!-- Fekete középvonal -->
        <div class="hidden md:block absolute top-0 bottom-0 left-1/2 w-[2px] bg-black z-0"></div>

        <!-- Blokkok konténer -->
        <div class="space-y-24">

          <!-- 1. blokk -->
          <div class="grid md:grid-cols-2 items-center gap-12 relative z-10">
            <!-- Kép balra -->
            <div class="timeline-img hidden md:block opacity-0 translate-x-[-50px]">
              <img src="/assets/images/weboldalkeszites.webp" alt="Weboldal készítés" class="rounded-xl shadow-xl">
            </div>
            <!-- Szöveg jobbra -->
            <div class="timeline-text opacity-0 translate-x-[50px]">
              <h3 class="text-2xl font-bold mb-4">Technikai tanácsadás</h3>
              <p class="text-lg leading-relaxed">Segítünk átlátni, hogy mi hogyan működik a háttérben: tárhely, domain, weboldal, e-mail, DNS, Google, biztonság, gyorsaság — mindaz, amitől egy online rendszer stabil és megbízható lesz. Akkor is, ha nem vagy kocka.</p>
            </div>
            <!-- Mobil: szöveg + kép -->
            <div class="md:hidden space-y-4">
              <div class="timeline-img-mobile opacity-0 translate-y-[50px]">
                <img src="/assets/images/weboldalkeszites.webp" class="rounded-xl shadow-xl" alt="">
              </div>
            </div>
          </div>

          <!-- 2. blokk -->
          <div class="grid md:grid-cols-2 items-center gap-12 relative z-10">
            <!-- Szöveg balra -->
            <div class="timeline-text opacity-0 translate-x-[-50px]">
              <h3 class="text-2xl font-bold mb-4">Keresőoptimalizálás</h3>
              <p class="text-lg leading-relaxed">Technikai és tartalmi SEO egyben: gyors betöltés, reszponzivitás, Google-barát szerkezet, kulcsszókutatás, szövegírás, meta adatok és keresőbarát struktúra. A cél: első oldalas megjelenés, több organikus forgalom.</p>
            </div>
            <!-- Kép jobbra -->
            <div class="timeline-img hidden md:block opacity-0 translate-x-[50px]">
              <img src="/assets/images/seoestartalom.webp" alt="Struktúra" class="rounded-xl shadow-xl">
            </div>
            <!-- Mobil -->
            <div class="md:hidden space-y-4">
              <div class="timeline-img-mobile opacity-0 translate-y-[50px]">
                <img src="/assets/images/seoestartalom.webp" class="rounded-xl shadow-xl" alt="">
              </div>
            </div>
          </div>

          <!-- 3. blokk -->
          <div class="grid md:grid-cols-2 items-center gap-12 relative z-10">
            <!-- Kép balra -->
            <div class="timeline-img hidden md:block opacity-0 translate-x-[-50px]">
              <img src="/assets/images/technikaitanacsadas.webp" alt="Tanácsadás" class="rounded-xl shadow-xl">
            </div>
            <!-- Szöveg jobbra -->
            <div class="timeline-text opacity-0 translate-x-[50px]">
              <h3 class="text-2xl font-bold mb-4">Automatizálás | AI</h3>
              <p class="text-lg leading-relaxed">Automatizáljuk a monoton, időrabló folyamatokat – űrlapok, e-mailek, CRM, naptár, számlázás, chatbot. Ha kell, mesterséges intelligenciával turbózva. Te csak a fontos döntésekre koncentrálj, a rendszer elvégzi a többit.</p>
            </div>
            <!-- Mobil -->
            <div class="md:hidden space-y-4">
              <div class="timeline-img-mobile opacity-0 translate-y-[50px]">
                <img src="/assets/images/technikaitanacsadas.webp" class="rounded-xl shadow-xl" alt="">
              </div>
            </div>
          </div>

        </div>
        </div>
      </div>
    </section>

<!-- STACKED PAKLI SZEKCIÓ -->
  <section class="bg-gradient-to-b from-[#2867a2] to-white text-gray-900 py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <h2 class="text-4xl font-extrabold mb-16 text-center text-white">Referenciáink</h2>

      <div class="space-y-32 relative">

        <!-- START: Csempék -->
        <!-- Használható sablon mind az 5-höz -->
        <!-- Képek: 3 kép .gallery-image-ben, nav nyilak: .prev/.next -->

        <!-- Csempe sablon (ismételd meg 5-ször) -->
        <article class="h-[400px] fade-card sticky top-32 bg-white rounded-xl shadow-sm overflow-hidden grid md:grid-cols-5 grid-cols-1">
          <!-- Kép + galéria -->
          <div class="md:col-span-2 relative group overflow-hidden">
            <div class="relative w-full h-full gallery h-[300px] md:h-full">
              <img src="/assets/images/weboldalkeszites.webp" class="gallery-image w-full h-full object-cover transition duration-500 ease-in-out" alt="Weboldal kép 1">
              <img src="/assets/images/seoestartalom.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 2">
              <img src="/assets/images/technikaitanacsadas.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 3">

              <!-- Bal nyíl -->
              <button class="prev absolute top-1/2 left-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10094;
              </button>
              <!-- Jobb nyíl -->
              <button class="next absolute top-1/2 right-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10095;
              </button>
            </div>
          </div>

          <!-- Szöveg -->
          <div class="md:col-span-3 p-6 flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Weboldal – Étterem</h3>
            <p class="text-lg text-gray-700">Letisztult arculat, gyors betöltés, mobilbarát kialakítás – egy családi étterem teljes digitális jelenlétét készítettük el az alapoktól.</p>
          </div>
        </article>

              <article class="h-[400px] fade-card sticky top-32 bg-white rounded-xl shadow-sm overflow-hidden grid md:grid-cols-5 grid-cols-1">
          <!-- Kép + galéria -->
          <div class="md:col-span-2 relative group overflow-hidden">
            <div class="relative w-full h-full gallery h-[300px] md:h-full">
              <img src="/assets/images/weboldalkeszites.webp" class="gallery-image w-full h-full object-cover transition duration-500 ease-in-out" alt="Weboldal kép 1">
              <img src="/assets/images/seoestartalom.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 2">
              <img src="/assets/images/technikaitanacsadas.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 3">

              <!-- Bal nyíl -->
              <button class="prev absolute top-1/2 left-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10094;
              </button>
              <!-- Jobb nyíl -->
              <button class="next absolute top-1/2 right-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10095;
              </button>
            </div>
          </div>

          <!-- Szöveg -->
          <div class="md:col-span-3 p-6 flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Weboldal – Étterem</h3>
            <p class="text-lg text-gray-700">Letisztult arculat, gyors betöltés, mobilbarát kialakítás – egy családi étterem teljes digitális jelenlétét készítettük el az alapoktól.</p>
          </div>
        </article>

              <article class="h-[400px] fade-card sticky top-32 bg-white rounded-xl shadow-sm overflow-hidden grid md:grid-cols-5 grid-cols-1">
          <!-- Kép + galéria -->
          <div class="md:col-span-2 relative group overflow-hidden">
            <div class="relative w-full h-full gallery h-[300px] md:h-full">
              <img src="/assets/images/weboldalkeszites.webp" class="gallery-image w-full h-full object-cover transition duration-500 ease-in-out" alt="Weboldal kép 1">
              <img src="/assets/images/seoestartalom.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 2">
              <img src="/assets/images/technikaitanacsadas.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 3">

              <!-- Bal nyíl -->
              <button class="prev absolute top-1/2 left-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10094;
              </button>
              <!-- Jobb nyíl -->
              <button class="next absolute top-1/2 right-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10095;
              </button>
            </div>
          </div>

          <!-- Szöveg -->
          <div class="md:col-span-3 p-6 flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Weboldal – Étterem</h3>
            <p class="text-lg text-gray-700">Letisztult arculat, gyors betöltés, mobilbarát kialakítás – egy családi étterem teljes digitális jelenlétét készítettük el az alapoktól.</p>
          </div>
        </article>

              <article class="h-[400px] fade-card sticky top-32 bg-white rounded-xl shadow-sm overflow-hidden grid md:grid-cols-5 grid-cols-1">
          <!-- Kép + galéria -->
          <div class="md:col-span-2 relative group overflow-hidden">
            <div class="relative w-full h-full gallery h-[300px] md:h-full">
              <img src="/assets/images/weboldalkeszites.webp" class="gallery-image w-full h-full object-cover transition duration-500 ease-in-out" alt="Weboldal kép 1">
              <img src="/assets/images/seoestartalom.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 2">
              <img src="/assets/images/technikaitanacsadas.webp" class="gallery-image w-full h-full object-cover absolute top-0 left-0 opacity-0 transition duration-500 ease-in-out" alt="Weboldal kép 3">

              <!-- Bal nyíl -->
              <button class="prev absolute top-1/2 left-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10094;
              </button>
              <!-- Jobb nyíl -->
              <button class="next absolute top-1/2 right-2 -translate-y-1/2 text-gray-700/50 hover:text-gray-900 transition z-10 text-4xl leading-none">
                &#10095;
              </button>
            </div>
          </div>

          <!-- Szöveg -->
          <div class="md:col-span-3 p-6 flex flex-col justify-center">
            <h3 class="text-2xl font-bold mb-2">Weboldal – Étterem</h3>
            <p class="text-lg text-gray-700">Letisztult arculat, gyors betöltés, mobilbarát kialakítás – egy családi étterem teljes digitális jelenlétét készítettük el az alapoktól.</p>
          </div>
        </article>

      </div>
    </div>
  </section>

    <!--CSOMAGAJANLATOK------------------->
    <section id="packages" class="bg-gradient-to-b from-white to-gray-200 py-24 px-4 sm:px-6 lg:px-8 text-gray-950">
      <div class="max-w-7xl mx-auto text-center mb-16">
        <h2 class="text-4xl sm:text-5xl font-extrabold mb-6">Nem tudod, hol kezdjünk?</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ezért hoztuk létre az előre összeállított csomagokat – attól függően, hogy mennyire szeretnéd kiszervezni az online jelenléted.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">

        <!-- START csomag -->
        <div class="border border-gray-200 rounded-2xl shadow-xl p-8 flex flex-col justify-between bg-neutral-50 hover:shadow-2xl transition">
          <div>
            <h3 class="text-2xl font-bold mb-4">Start</h3>
            <p class="text-gray-600 mb-6">Ha még csak most indulsz, és az alapokat szeretnéd stabilan lefektetni.</p>
            <ul class="text-left space-y-3 text-sm">
              <li>✅ Konzultáció és célfeltárás</li>
              <li>✅ Egylapos bemutatkozó weboldal</li>
              <li>✅ Saját domain + tárhely beállítás</li>
              <li>✅ Alap arculat (színek, betűtípusok, logóhely)</li>
              <li>✅ Kapcsolatfelvételi űrlap</li>
              <li>✅ Mobilra optimalizálás</li>
            </ul>
          </div>
          <a href="#contact" class="mt-8 inline-block bg-black text-white px-6 py-3 rounded-full font-semibold text-center hover:bg-gray-800 transition">Ez érdekel</a>
        </div>

        <!-- PROFI csomag -->
        <div class="border-4 border-[#007aff] rounded-2xl shadow-2xl p-8 flex flex-col justify-between bg-white hover:shadow-3xl transition relative">
          <div>
            <div class="absolute -top-4 right-4 bg-[#007aff] text-white px-4 py-1 rounded-full text-xs font-bold shadow-md">Legnépszerűbb</div>
            <h3 class="text-2xl font-bold mb-4">Profi</h3>
            <p class="text-gray-600 mb-6">Már működsz, de kell a szintlépés és a tudatos online jelenlét.</p>
            <ul class="text-left space-y-3 text-sm">
              <li>✅ Minden a Start csomagból</li>
              <li>✅ Többoldalas, egyedi weboldal</li>
              <li>✅ Keresőoptimalizálási alapbeállítások (SEO)</li>
              <li>✅ Weboldal elemzés + tartalomstruktúra</li>
              <li>✅ Egyedi arculat és képi világ</li>
              <li>✅ Alap analitika beépítés</li>
            </ul>
          </div>
          <a href="#contact" class="mt-8 inline-block bg-[#007aff] text-white px-6 py-3 rounded-full font-semibold text-center hover:bg-blue-600 transition">Ez érdekel</a>
        </div>

        <!-- KOMPLEX csomag -->
        <div class="border border-gray-200 rounded-2xl shadow-xl p-8 flex flex-col justify-between bg-neutral-50 hover:shadow-2xl transition">
          <div>
            <h3 class="text-2xl font-bold mb-4">Komplex</h3>
            <p class="text-gray-600 mb-6">Ha mindent ránk bíznál: a stratégiától az automatizálásig.</p>
            <ul class="text-left space-y-3 text-sm">
              <li>✅ Minden a Profi csomagból</li>
              <li>✅ Teljes digitális stratégia (audit + tervezés)</li>
              <li>✅ Automatizált ügyfélkezelés (CRM, űrlapok, e-mail)</li>
              <li>✅ AI-alapú tartalomsegítség és chatbot opció</li>
              <li>✅ Google és Meta hirdetési fiók beállítás</li>
              <li>✅ Teljes rendszer összekötés + betanítás</li>
            </ul>
          </div>
          <a href="#contact" class="mt-8 inline-block bg-black text-white px-6 py-3 rounded-full font-semibold text-center hover:bg-gray-800 transition">Ez érdekel</a>
        </div>

      </div>
    </section>

    <!--PARALLAX CTA------------------------>
    <section class="relative bg-fixed bg-center bg-cover text-white" style="background-image: url('/assets/images/parallax-cta.webp');">
      <div class="bg-black/60 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 flex flex-col items-center justify-center text-center">
          <h2 class="text-2xl sm:text-3xl font-bold mb-4 leading-snug">
            Egyedi elképzelésed van?<br>Segítek megvalósítani!
          </h2>
          <a href="#contact" class="mt-4 inline-block bg-white text-black px-6 py-3 rounded-full text-base font-medium hover:bg-gray-200 transition">
            Kérj visszahívást →
          </a>
        </div>
      </div>
    </section>

    <!--CONTACT------------------------------->
    <section id="contact" class="relative z-10 bg-gradient-to-b from-gray-200 to-white text-gray-950 px-4 sm:px-6 lg:px-8 py-24">
      <div class="mx-auto max-w-2xl text-center">
        <h2 class="section-title" style="color:#ebaf73">Dolgozzunk együtt!</h2>
        <p class="mt-2 text-lg text-gray-600">
          Írd meg, miben segíthetek! Legyen az egyedi weboldal, online stratégia vagy technikai tanácsadás. 24 órán belül válaszolok.
        </p>
      </div>

      <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

          <!-- Szolgáltatás mező -->
          <div class="sm:col-span-2">
            <label for="service" class="block text-base font-semibold text-gray-900 mb-1">Milyen szolgáltatás érdekel?</label>
            <input id="service" name="service" type="text" placeholder="Pl.: Weboldalkészítés" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
          </div>

          <!-- Név -->
          <div>
            <label for="first-name" class="block text-sm font-semibold text-gray-900">Vezetéknév*</label>
            <input id="first-name" name="first-name" type="text" required autocomplete="family-name" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
          </div>

          <div>
            <label for="last-name" class="block text-sm font-semibold text-gray-900">Keresztnév*</label>
            <input id="last-name" name="last-name" type="text" required autocomplete="given-name" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
          </div>

          <!-- Cégnév -->
          <div class="sm:col-span-2">
            <label for="company" class="block text-sm font-semibold text-gray-900">Cégnév <span class="text-gray-500 text-sm">(opcionális)</span></label>
            <input id="company" name="company" type="text" autocomplete="organization" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
          </div>

          <!-- E-mail -->
          <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-semibold text-gray-900">Email*</label>
            <input id="email" name="email" type="email" required autocomplete="email" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
          </div>

          <!-- Telefonszám -->
          <div class="sm:col-span-2">
            <label for="phone-number" class="block text-sm font-semibold text-gray-900">Telefonszám</label>
            <input id="phone-number" name="phone-number" type="text" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
          </div>

          <!-- Üzenet -->
          <div class="sm:col-span-2">
            <label for="message" class="block text-sm font-semibold text-gray-900">Üzenet*</label>
            <textarea id="message" name="message" rows="4" required class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]"></textarea>
          </div>

          <!-- Figyelmeztetés -->
          <div class="sm:col-span-2">
            <p class="text-sm text-gray-500">A *-gal jelölt mezők kitöltése kötelező.</p>
          </div>

          <!-- GDPR -->
          <div class="flex items-center gap-x-4 sm:col-span-2">
            <label for="agree-to-policies" class="relative inline-flex h-6 w-11 items-center cursor-pointer">
              <input id="agree-to-policies" name="agree-to-policies" type="checkbox" class="peer sr-only" required>
              <div class="w-full h-full rounded-full bg-gray-400 peer-checked:bg-[#2867a2] transition-colors duration-300"></div>
              <span class="absolute left-1 top-1 size-4 rounded-full bg-white shadow ring-1 ring-gray-900/5 transition-transform duration-300 transform peer-checked:translate-x-5"></span>
            </label>
            <p class="text-sm text-gray-600">
              Elfogadom az <a href="/adatkezelesi-tajekoztato.html" target="_blank" class="font-semibold text-[#2867a2] underline">Adatkezelési Tájékoztatót</a>.
            </p>
          </div>
        </div>

        <!-- CTA -->
        <div class="mt-10">
          <button type="submit" class="bg-[#ebaf73] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#e49b50] transition">
            Üzenet küldése →
          </button>
        </div>
      </form>
    </section>

    <!--BLOG--------------------------->
    <section id="blog" class="relative z-10 bg-white text-gray-950 px-4 sm:px-6 lg:px-8 py-24">
      <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-2xl lg:mx-0">
          <h2 class="section-title">Kiemelt blogbejegyzések</h2>
          <p class="mt-2 text-lg/8 text-gray-600">Olvashatsz független gondolataimről az online jelenlét és üzleti növekedés témáiban.</p>
        </div>
        <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
          
          <article class="flex max-w-xl flex-col items-start justify-between float-up animate">
            <div class="flex items-center gap-x-4 text-xs">
              <time datetime="2020-03-16" class="text-gray-500">2020. március 16.</time>
              <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a>
            </div>
            <div class="group relative grow">
              <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                <a href="/blog/posts/online-konverzio">
                  <span class="absolute inset-0"></span>
                  Hogyan növeld az online konverziót?
                </a>
              </h3>
              <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Tippek és eszközök az online konverziós arány növelésére, a látogatók ügyfelekké alakításához.</p>
            </div>
          </article>

          <article class="flex max-w-xl flex-col items-start justify-between float-up animate">
            <div class="flex items-center gap-x-4 text-xs">
              <time datetime="2020-03-10" class="text-gray-500">2020. március 10.</time>
              <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Értékesítés</a>
            </div>
            <div class="group relative grow">
              <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                <a href="/blog/posts/seo-ertekesites">
                  <span class="absolute inset-0"></span>
                  Hogyan használd a keresőoptimalizálást az értékesítéshez?
                </a>
              </h3>
              <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Ismerd meg, hogyan segíthet a SEO több ügyfelet hozni az oldaladra és növelni a bevételedet.</p>
            </div>
          </article>

          <article class="flex max-w-xl flex-col items-start justify-between float-up animate">
            <div class="flex items-center gap-x-4 text-xs">
              <time datetime="2020-02-12" class="text-gray-500">2020. február 12.</time>
              <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Üzlet</a>
            </div>
            <div class="group relative grow">
              <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                <a href="/blog/posts/vasarloi-elmeny">
                  <span class="absolute inset-0"></span>
                  Hogyan javítsd a vásárlói élményt?
                </a>
              </h3>
              <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Egyszerű lépések és eszközök a felhasználói élmény fejlesztésére – hogy ügyfeleid visszatérjenek.</p>
            </div>
          </article>

        </div>
      </div>
      <div class="mt-12 flex justify-center">
      <a href="/blog" class="btn btn-outline">
        További bejegyzések
      </a>
    </div>

    </section>

<?php include __DIR__ . '/includes/footer.html'; ?>

    <!-- TECH STACK SECTION -->
    <section class="bg-neutral-300 py-4 relative">
          <!-- Görgethető konténer -->
          <div class="overflow-x-auto hide-scrollbar">
            <div class="flex items-center justify-center lg:justify-center space-x-10 px-6 w-max lg:mx-auto h-8">

              <img src="/assets/techstack/html5.svg" alt="HTML5 logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/css3.svg" alt="CSS3 logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/javascript.svg" alt="JavaScript logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/react.svg" alt="React logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/nextjs.svg" alt="Next.js logó" class="h-8 bg-white p-1 rounded" loading="lazy">
              <img src="/assets/techstack/php.svg" alt="PHP logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/nodejs.svg" alt="Node.js logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/figma.svg" alt="Figma logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/Canva.svg" alt="Canva logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/meta.webp" alt="Meta logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/google_ads.svg" alt="Google Ads logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/Notion.webp" alt="Notion logó" class="h-8" loading="lazy">
              <img src="/assets/techstack/openai.svg" alt="OpenAI logó" class="h-8" loading="lazy">

            </div>
          </div>

          <!-- Mobil scroll nyíl -->
          <div class="absolute right-2 top-1/2 transform -translate-y-1/2 lg:hidden pointer-events-none">
            <svg class="w-5 h-5 text-neutral-950 animate-pulse" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </div>
    </section>

<script src="/js/index.js" defer></script>
<script src="/js/header-scripts.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>
  </body>
</html>
