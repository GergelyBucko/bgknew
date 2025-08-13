<?php

// ===================== CONFIG =====================
$CONTACT_RECIPIENT = $CONTACT_RECIPIENT ?? 'info@studiobgk.com';
$CONTACT_FROM      = $CONTACT_FROM      ?? 'no-reply@studiobgk.com';
$CONTACT_FROM_NAME = $CONTACT_FROM_NAME ?? 'Studio BGK Kapcsolat';

$NOTION_TOKEN       = $NOTION_TOKEN       ?? 'xx';
$NOTION_DATABASE_ID = $NOTION_DATABASE_ID ?? '24ef145d4ba9807ab19bc7eaf492ef00';
$NOTION_VERSION     = $NOTION_VERSION     ?? '2022-06-28';

$LEAD_CSV_PATH     = $LEAD_CSV_PATH     ?? null;

$EMIT_CONTACT_JSONLD = $EMIT_CONTACT_JSONLD ?? false;

// ===================== HELPERS =====================
function sbkg_is_email($email){ return (bool) filter_var($email, FILTER_VALIDATE_EMAIL); }
function sbkg_h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function sbkg_notion_create_page($token, $databaseId, $version, array $properties, array $children = []){
  if (!$token || !$databaseId) return false;
  $url = 'https://api.notion.com/v1/pages';
  $payload = [
    'parent' => [ 'database_id' => $databaseId ],
    'properties' => $properties,
  ];
  if (!empty($children)) { $payload['children'] = $children; }

  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
      'Content-Type: application/json; charset=UTF-8',
      'Authorization: Bearer ' . $token,
      'Notion-Version: ' . $version,
    ],
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
  ]);
  $res = curl_exec($ch);
  $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $err  = curl_errno($ch);
  curl_close($ch);
  if ($err) return false;
  // Siker: 200 vagy 201 is előfordulhat
  return ($http >= 200 && $http < 300);
}

function sbkg_log_csv($path, array $data){
  if (!$path) return false;
  $isNew = !file_exists($path);
  $dir = dirname($path);
  if (!is_dir($dir)) @mkdir($dir, 0750, true);
  $fh = @fopen($path, 'a');
  if (!$fh) return false;
  if (flock($fh, LOCK_EX)) {
    if ($isNew) {
      fputcsv($fh, ['datetime','source','utm_source','utm_medium','utm_campaign','utm_term','utm_content','service','first_name','last_name','company','email','phone','message','ip','referer'], ';');
    }
    fputcsv($fh, [
      date('Y-m-d H:i:s'),
      $data['source'] ?? '',
      $data['utm_source'] ?? '',
      $data['utm_medium'] ?? '',
      $data['utm_campaign'] ?? '',
      $data['utm_term'] ?? '',
      $data['utm_content'] ?? '',
      $data['service'] ?? '',
      $data['first-name'] ?? '',
      $data['last-name'] ?? '',
      $data['company'] ?? '',
      $data['email'] ?? '',
      $data['phone-number'] ?? '',
      str_replace(["
","
"], [' ', ' '], $data['message'] ?? ''),
      $data['ip'] ?? '',
      $data['referer'] ?? ''
    ], ';');
    flock($fh, LOCK_UN);
  }
  fclose($fh);
  @chmod($path, 0640);
  return true;
}

// ===================== INIT =====================
$form_status = null; // 'success' | 'error'
$form_errors = [];

// Sticky defaults
$form_old = [
  'service'      => '',
  'first-name'   => '',
  'last-name'    => '',
  'company'      => '',
  'email'        => '',
  'phone-number' => '',
  'message'      => '',
];

// Capture UTM és referer (analitika/SEO)
$utm = [
  'utm_source'   => $_GET['utm_source']   ?? '',
  'utm_medium'   => $_GET['utm_medium']   ?? '',
  'utm_campaign' => $_GET['utm_campaign'] ?? '',
  'utm_term'     => $_GET['utm_term']     ?? '',
  'utm_content'  => $_GET['utm_content']  ?? '',
];
$http_referer = $_SERVER['HTTP_REFERER'] ?? '';
$source_url   = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');

// ================ HANDLE SUBMISSION ================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form']) && $_POST['contact_form'] === 'studio_bgk_v1') {
  // Anti-bot
  $honeypot = $_POST['website'] ?? '';
  $formTime = isset($_POST['form_time']) ? (int) $_POST['form_time'] : 0;
  $isTooFast = (time() - $formTime) < 3;

  // Gather & sanitize
  foreach ($form_old as $k => $v) {
    $form_old[$k] = trim((string)($_POST[$k] ?? ''));
  }
  $agreed = isset($_POST['agree-to-policies']);

  // UTM-ből hidden POST (ha van)
  $utm['utm_source']   = $_POST['utm_source']   ?? $utm['utm_source'];
  $utm['utm_medium']   = $_POST['utm_medium']   ?? $utm['utm_medium'];
  $utm['utm_campaign'] = $_POST['utm_campaign'] ?? $utm['utm_campaign'];
  $utm['utm_term']     = $_POST['utm_term']     ?? $utm['utm_term'];
  $utm['utm_content']  = $_POST['utm_content']  ?? $utm['utm_content'];
  $http_referer        = $_POST['referer']      ?? $http_referer;

  // Validation
  if ($honeypot !== '' || $isTooFast) {
    $form_errors[] = 'Érvénytelen beküldés.';
  }
  if ($form_old['first-name'] === '') {
    $form_errors[] = 'A vezetéknév mező kötelező.';
  }
  if ($form_old['last-name'] === '') {
    $form_errors[] = 'A keresztnév mező kötelező.';
  }
  if (!sbkg_is_email($form_old['email'])) {
    $form_errors[] = 'Adj meg érvényes email címet.';
  }
  if ($form_old['message'] === '' || mb_strlen($form_old['message']) < 5) {
    $form_errors[] = 'Írj részletesebb üzenetet.';
  }
  if (!$agreed) {
    $form_errors[] = 'El kell fogadnod az Adatkezelési Tájékoztatót.';
  }

  if (empty($form_errors)) {
    // ===== Email =====
    $safeName  = preg_replace("/[
]+/", ' ', $form_old['first-name'] . ' ' . $form_old['last-name']);
    $safeMail  = preg_replace("/[
]+/", '', $form_old['email']);
    $subject = 'Új üzenet – Studio BGK kapcsolatfelvétel';

    $body  = "Új üzenet érkezett a Studio BGK kapcsolati űrlapról

";
    $body .= "Szolgáltatás: " . ($form_old['service'] ?: '-') . "
";
    $body .= "Név: {$safeName}
";
    $body .= "Cégnév: " . ($form_old['company'] ?: '-') . "
";
    $body .= "Email: {$safeMail}
";
    $body .= "Telefon: " . ($form_old['phone-number'] ?: '-') . "

";
    $body .= "Üzenet:
" . $form_old['message'] . "

";
    $body .= "Forrás oldal: {$source_url}
";
    $body .= "UTM: source={$utm['utm_source']} medium={$utm['utm_medium']} campaign={$utm['utm_campaign']} term={$utm['utm_term']} content={$utm['utm_content']}
";
    $body .= "Hivatkozó: {$http_referer}
";
    $body .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'ismeretlen') . "
";
    $body .= "Időpont: " . date('Y-m-d H:i:s') . "
";

    $headers   = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/plain; charset=UTF-8';
    $headers[] = 'From: ' . $CONTACT_FROM_NAME . ' <' . $CONTACT_FROM . '>';
    $headers[] = 'Reply-To: ' . $safeName . ' <' . $safeMail . '>';

    $sent = @mail($CONTACT_RECIPIENT, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, implode("
", $headers));

$notionProps = [
  'Name' => [
    'title' => [[ 'text' => [ 'content' => $safeName ?: ($form_old['email'] ?: 'Új lead') ] ]]
  ],
  'Email' => [ 'email' => $form_old['email'] ],
  'Phone' => [ 'phone_number' => ($form_old['phone-number'] ?: null) ],
  'Company' => [ 'rich_text' => [[ 'text' => [ 'content' => ($form_old['company'] ?: '') ] ]] ],
  'Service' => [ 'rich_text' => [[ 'text' => [ 'content' => $form_old['service'] ] ]] ],
  'Message' => [ 'rich_text' => [[ 'text' => [ 'content' => $form_old['message'] ] ]] ],
  'Source' => [ 'url' => (isset($_SERVER['HTTP_HOST'])
      ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $source_url)
      : $source_url) ],
  'UTM Source'   => [ 'rich_text' => [[ 'text' => [ 'content' => $utm['utm_source'] ] ]] ],
  'UTM Medium'   => [ 'rich_text' => [[ 'text' => [ 'content' => $utm['utm_medium'] ] ]] ],
  'UTM Campaign' => [ 'rich_text' => [[ 'text' => [ 'content' => $utm['utm_campaign'] ] ]] ],
  'UTM Term'     => [ 'rich_text' => [[ 'text' => [ 'content' => $utm['utm_term'] ] ]] ],
  'UTM Content'  => [ 'rich_text' => [[ 'text' => [ 'content' => $utm['utm_content'] ] ]] ],
  'Referer' => [ 'url' => $http_referer ?: null ],
  'Submitted' => [ 'date' => [ 'start' => date('c') ] ],
  'Status' => [ 'select' => [ 'name' => 'New' ] ], 
];
$notionProps = array_filter($notionProps, fn($v) => !is_null($v));


    $notionChildren = [
      [ 'object' => 'block', 'type' => 'heading_3', 'heading_3' => [ 'rich_text' => [[ 'type' => 'text', 'text' => [ 'content' => 'Üzenet' ] ]] ] ],
      [ 'object' => 'block', 'type' => 'paragraph', 'paragraph' => [ 'rich_text' => [[ 'type' => 'text', 'text' => [ 'content' => $form_old['message'] ] ]] ] ],
    ];

    $notion_ok = sbkg_notion_create_page($NOTION_TOKEN, $NOTION_DATABASE_ID, $NOTION_VERSION, $notionProps, $notionChildren);

    // ===== CSV (ha kérted) =====
    $lead_payload = [
      'datetime'     => date('c'),
      'source'       => $source_url,
      'utm_source'   => $utm['utm_source'],
      'utm_medium'   => $utm['utm_medium'],
      'utm_campaign' => $utm['utm_campaign'],
      'utm_term'     => $utm['utm_term'],
      'utm_content'  => $utm['utm_content'],
      'service'      => $form_old['service'],
      'first-name'   => $form_old['first-name'],
      'last-name'    => $form_old['last-name'],
      'company'      => $form_old['company'],
      'email'        => $form_old['email'],
      'phone-number' => $form_old['phone-number'],
      'message'      => $form_old['message'],
      'ip'           => $_SERVER['REMOTE_ADDR'] ?? '',
      'referer'      => $http_referer,
    ];
    if (!empty($LEAD_CSV_PATH)) {
      @sbkg_log_csv($LEAD_CSV_PATH, $lead_payload);
    }

    if ($sent && $notion_ok) {
      $form_status = 'success';
      foreach ($form_old as $k => $v) { $form_old[$k] = ''; }
    } else {
      $form_status = 'error';
      if (!$sent)   { $form_errors[] = 'Az e-mail küldése nem sikerült.'; }
      if (!$notion_ok) { $form_errors[] = 'A Notion bejegyzés létrehozása nem sikerült. Ellenőrizd a token-t, a Database ID-t és a property neveket.'; }
    }
  } else {
    $form_status = 'error';
  }
}

$__render_time = time();
?>

<section id="contact" class="relative z-10 bg-gradient-to-b from-white to-gray-200 text-gray-950 px-4 sm:px-6 lg:px-8 py-24">
  <div class="mx-auto max-w-2xl text-center">
    <h2 class="text-4xl sm:text-5xl font-extrabold mb-6" style="color:#ebaf73">Dolgozzunk együtt!</h2>
    <h3 class="mt-2 text-lg text-gray-600">
      Írd meg, miben segíthetek! Legyen az egyedi weboldal, online stratégia vagy technikai tanácsadás. 24 órán belül válaszolok.
    </h3>
  </div>

  <?php if ($form_status === 'success'): ?>
    <div class="mx-auto mt-10 max-w-xl rounded-xl border border-green-200 bg-green-50 p-4 text-green-900" role="status" aria-live="polite">
      <p><strong>Köszönöm!</strong> Az üzeneted megérkezett. Hamarosan válaszolok.</p>
    </div>
  <?php endif; ?>

  <?php if ($form_status === 'error' && !empty($form_errors)): ?>
    <div class="mx-auto mt-10 max-w-xl rounded-xl border border-red-200 bg-red-50 p-4 text-red-900" role="alert" aria-live="assertive">
      <ul class="list-disc list-inside space-y-1 text-sm">
        <?php foreach ($form_errors as $err): ?>
          <li><?= sbkg_h($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form action="<?= sbkg_h($_SERVER['REQUEST_URI']) ?>#contact" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
    <input type="hidden" name="contact_form" value="studio_bgk_v1">
    <input type="hidden" name="form_time" value="<?= $__render_time ?>">
    <!-- Honeypot -->
    <div class="hidden">
      <label>Ne töltsd ki ezt a mezőt: <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    <!-- UTM & referer továbbvitel -->
    <input type="hidden" name="utm_source"   value="<?= sbkg_h($utm['utm_source']) ?>">
    <input type="hidden" name="utm_medium"   value="<?= sbkg_h($utm['utm_medium']) ?>">
    <input type="hidden" name="utm_campaign" value="<?= sbkg_h($utm['utm_campaign']) ?>">
    <input type="hidden" name="utm_term"     value="<?= sbkg_h($utm['utm_term']) ?>">
    <input type="hidden" name="utm_content"  value="<?= sbkg_h($utm['utm_content']) ?>">
    <input type="hidden" name="referer"      value="<?= sbkg_h($http_referer) ?>">

    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

      <!-- Szolgáltatás mező -->
      <div class="sm:col-span-2">
        <label for="service" class="block text-base font-semibold text-gray-900 mb-1">Milyen szolgáltatás érdekel?</label>
        <input id="service" name="service" type="text" placeholder="Pl.: Weboldalkészítés" value="<?= sbkg_h($form_old['service']) ?>" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]" autocomplete="off">
      </div>

      <!-- Név -->
      <div>
        <label for="first-name" class="block text-sm font-semibold text-gray-900">Vezetéknév*</label>
        <input id="first-name" name="first-name" type="text" required autocomplete="family-name" value="<?= sbkg_h($form_old['first-name']) ?>" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
      </div>

      <div>
        <label for="last-name" class="block text-sm font-semibold text-gray-900">Keresztnév*</label>
        <input id="last-name" name="last-name" type="text" required autocomplete="given-name" value="<?= sbkg_h($form_old['last-name']) ?>" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
      </div>

      <!-- Cégnév -->
      <div class="sm:col-span-2">
        <label for="company" class="block text-sm font-semibold text-gray-900">Cégnév <span class="text-gray-500 text-sm">(opcionális)</span></label>
        <input id="company" name="company" type="text" autocomplete="organization" value="<?= sbkg_h($form_old['company']) ?>" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
      </div>

      <!-- E-mail -->
      <div class="sm:col-span-2">
        <label for="email" class="block text-sm font-semibold text-gray-900">Email*</label>
        <input id="email" name="email" type="email" required autocomplete="email" value="<?= sbkg_h($form_old['email']) ?>" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
      </div>

      <!-- Telefonszám -->
      <div class="sm:col-span-2">
        <label for="phone-number" class="block text-sm font-semibold text-gray-900">Telefonszám</label>
        <input id="phone-number" name="phone-number" type="text" autocomplete="tel" value="<?= sbkg_h($form_old['phone-number']) ?>" class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]">
      </div>

      <!-- Üzenet -->
      <div class="sm:col-span-2">
        <label for="message" class="block text-sm font-semibold text-gray-900">Üzenet*</label>
        <textarea id="message" name="message" rows="4" required class="mt-2.5 block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#2867a2]"><?= sbkg_h($form_old['message']) ?></textarea>
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
      <button type="submit" class="bg-[#2867a2] text-white hover:bg-[#1f4f7e] block w-full px-10 py-4 rounded-full text-lg font-medium transition-all duration-300 text-center">
        Üzenet küldése
      </button>
    </div>
  </form>
</section>

