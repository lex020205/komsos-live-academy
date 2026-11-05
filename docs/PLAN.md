# RENCANA ARSITEKTUR: KOMSOS LIVE ACADEMY

**Tanggal:** 2026-11-05  
**Versi:** 1.0  
**Status:** Menunggu Persetujuan

---

## 1. RINGKASAN PROJECT

Mengubah desain HTML statis `docs/design/index.html` (4406 baris) menjadi aplikasi Laravel dinamis dengan:
- 9 halaman utama dengan routing terpisah
- Database untuk konten dinamis
- Autentikasi & tracking progres per user
- Interaktivitas JS (simulator, kuis, wizard)
- Panel admin CRUD

**Stack:**
- Laravel 13 + PHP 8.3
- Vite + Tailwind CSS (lokal, migrasi dari CDN)
- MySQL database `komsos`
- Node 22 + ES6 modules

---

## 2. DAFTAR ROUTE APLIKASI

### Route Publik (Web)
```
GET  /                          → HomeController@index           (Beranda)
GET  /langkah                   → StepController@index           (SOP 12 Langkah)
GET  /alat                      → EquipmentController@index      (Katalog Alat)
GET  /alur-sinyal               → SignalRouteController@index    (Diagram Interaktif)
GET  /ptz                       → PtzController@index            (Simulator PTZ)
GET  /hari-h                    → ChecklistController@index      (Checklist Siaran)
GET  /bantuan                   → TroubleshootingController@index (Troubleshooting)
GET  /latihan                   → TrainingController@index       (Simulasi + Kuis)
```

### Route API (JSON)
```
GET  /api/search                → SearchController@global        (Search modal)
GET  /api/equipment             → EquipmentController@api        (Filter alat)
GET  /api/steps                 → StepController@api             (Data langkah)
GET  /api/routes                → SignalRouteController@api      (Rute sinyal)
POST /api/progress              → ProgressController@save        (Simpan progres user)
GET  /api/quiz/questions        → QuizController@questions       (Load soal kuis)
POST /api/quiz/submit           → QuizController@submit          (Submit jawaban)
GET  /api/certificates/{id}     → CertificateController@show     (PDF sertifikat)
POST /api/certificates/generate → CertificateController@generate (Generate cert)
```

### Route Admin (Protected, Role: admin)
```
GET  /admin                     → AdminController@dashboard
GET  /admin/steps               → AdminController@steps
GET  /admin/equipment           → AdminController@equipment
GET  /admin/quiz                → AdminController@quiz
GET  /admin/checklist           → AdminController@checklist
GET  /admin/troubleshooting     → AdminController@troubleshooting
```

---

## 3. STRUKTUR TABEL DATABASE

### 3.1. users (Laravel Default + Role)
```sql
id               bigint UNSIGNED PRIMARY KEY
name             varchar(255)
email            varchar(255) UNIQUE
email_verified_at timestamp NULL
password         varchar(255)
role             enum('user', 'admin') DEFAULT 'user'
remember_token   varchar(100) NULL
created_at       timestamp
updated_at       timestamp
```

### 3.2. steps (12 Langkah SOP Rigging)
```sql
id               bigint UNSIGNED PRIMARY KEY
phase            enum('A', 'B', 'C', 'D')               -- Fase A-D
order            tinyint UNSIGNED                       -- Urutan 1-12
title            varchar(255)                           -- "01. Colokkan Kabel Power"
description      text                                   -- Instruksi lengkap
time_estimate    tinyint UNSIGNED                       -- Menit
cable_type       varchar(100) NULL                      -- "Jack 3.5mm Stereo TRS"
diagram_data     json NULL                              -- Data untuk SVG diagram
tips             text NULL                              -- "Cek dulu: ..."
warnings         text NULL                              -- "Awas: ..."
created_at       timestamp
updated_at       timestamp
```

### 3.3. equipment (Katalog Alat & Kabel)
```sql
id               bigint UNSIGNED PRIMARY KEY
name             varchar(255)                           -- "Audio Mixer 16-Channel"
category         enum('audio', 'video', 'kabel', 'komputer')
description      text
ports_json       json NULL                              -- Array port [{name, type, desc}]
image_url        varchar(500) NULL
tips             text NULL
warnings         text NULL
order            tinyint UNSIGNED DEFAULT 0
created_at       timestamp
updated_at       timestamp
```

### 3.4. signal_routes (6 Rute Sinyal AV)
```sql
id               bigint UNSIGNED PRIMARY KEY
slug             varchar(50) UNIQUE                     -- 'sub-atem', 'mic-mixer', dll
title            varchar(255)                           -- "Sub-Mixer → ATEM Mini"
from_device      varchar(100)                           -- "Mixer Kecil Komsos"
to_device        varchar(100)                           -- "ATEM Mini"
cable_type       varchar(100)                           -- "Jack 3.5mm Stereo TRS"
from_port        varchar(255)                           -- "Phones / Monitor Out L-R"
to_port          varchar(255)                           -- "Port Mic 1 (Belakang Kiri)"
tips             text NULL
warnings         text NULL
created_at       timestamp
updated_at       timestamp
```

### 3.5. troubleshooting_issues (7 Kasus Bantuan)
```sql
id               bigint UNSIGNED PRIMARY KEY
category         enum('suara', 'video', 'internet', 'teks', 'ptz', 'tv')
title            varchar(255)                           -- "Layar Video Hitam di OBS"
symptoms         text                                   -- "Diagnosa singkat"
steps_json       json                                   -- Array [{step, title, desc}]
time_estimate    tinyint UNSIGNED                       -- Estimasi detik
order            tinyint UNSIGNED DEFAULT 0
created_at       timestamp
updated_at       timestamp
```

### 3.6. troubleshooting_tags (Relasi Many-to-Many)
```sql
id               bigint UNSIGNED PRIMARY KEY
issue_id         bigint UNSIGNED FOREIGN KEY → troubleshooting_issues
tag              varchar(50)                            -- 'suara', 'video', dll
```

### 3.7. checklist_items (15 Item Hari-H)
```sql
id               bigint UNSIGNED PRIMARY KEY
phase            tinyint UNSIGNED                       -- 1, 2, 3 (Sebelum/Saat/Sesudah)
order            tinyint UNSIGNED                       -- Urutan dalam fase
title            varchar(255)
description      text NULL
badge            varchar(100) NULL                      -- "Jack 3.5mm", "HDMI 1-4"
is_critical      boolean DEFAULT false                  -- Highlight kuning?
created_at       timestamp
updated_at       timestamp
```

### 3.8. quiz_questions (5 Soal Kuis)
```sql
id               bigint UNSIGNED PRIMARY KEY
order            tinyint UNSIGNED
category         varchar(100)                           -- "Etika & Kontrol Kamera"
question         text                                   -- Pertanyaan lengkap
options_json     json                                   -- [{key: 'A', text: '...'}]
correct_answer   char(1)                                -- 'A', 'B', 'C', atau 'D'
explanation      text                                   -- Penjelasan liturgis
reference        varchar(255) NULL                      -- "PUMR Bab IV"
created_at       timestamp
updated_at       timestamp
```

### 3.9. quiz_attempts (Riwayat Kuis User)
```sql
id               bigint UNSIGNED PRIMARY KEY
user_id          bigint UNSIGNED FOREIGN KEY → users
score            tinyint UNSIGNED                       -- 0-100
answers_json     json                                   -- [{q_id, answer, correct}]
completed_at     timestamp
created_at       timestamp
updated_at       timestamp
```

### 3.10. user_progress (Tracking Progres Langkah)
```sql
id               bigint UNSIGNED PRIMARY KEY
user_id          bigint UNSIGNED FOREIGN KEY → users
step_id          bigint UNSIGNED FOREIGN KEY → steps
completed        boolean DEFAULT false
last_visited_at  timestamp NULL
created_at       timestamp
updated_at       timestamp

UNIQUE KEY (user_id, step_id)
```

### 3.11. certificates (Sertifikat Kelulusan)
```sql
id               bigint UNSIGNED PRIMARY KEY
user_id          bigint UNSIGNED FOREIGN KEY → users
cert_number      varchar(50) UNIQUE                     -- "KMS-2025-089"
score            tinyint UNSIGNED                       -- Score kuis
predicate        varchar(50)                            -- "Sangat Memuaskan"
issued_at        timestamp
created_at       timestamp
updated_at       timestamp
```

---

## 4. STRUKTUR FILE BACKEND (Laravel)

### 4.1. Models
```
app/Models/
├── User.php                   (sudah ada, tambah relasi & role)
├── Step.php
├── Equipment.php
├── SignalRoute.php
├── TroubleshootingIssue.php
├── ChecklistItem.php
├── QuizQuestion.php
├── QuizAttempt.php
├── UserProgress.php
└── Certificate.php
```

### 4.2. Controllers
```
app/Http/Controllers/
├── HomeController.php         (beranda, jalur belajar)
├── StepController.php         (langkah SOP wizard)
├── EquipmentController.php    (alat & kabel)
├── SignalRouteController.php  (alur sinyal)
├── PtzController.php          (simulator PTZ - static view)
├── ChecklistController.php    (hari-h checklist)
├── TroubleshootingController.php (bantuan)
├── TrainingController.php     (latihan page)
├── Api/
│   ├── SearchController.php   (global search)
│   ├── QuizController.php     (kuis API)
│   ├── CertificateController.php
│   └── ProgressController.php
└── Admin/
    └── AdminController.php    (CRUD panel)
```

### 4.3. Requests (Validasi)
```
app/Http/Requests/
├── QuizSubmitRequest.php
├── ProgressSaveRequest.php
└── Admin/
    ├── StepRequest.php
    ├── EquipmentRequest.php
    └── QuizQuestionRequest.php
```

### 4.4. Policies (Authorization)
```
app/Policies/
└── AdminPolicy.php            (gate untuk admin-only)
```

---

## 5. STRUKTUR FILE FRONTEND (Blade + JS)

### 5.1. Views (Blade Templates)
```
resources/views/
├── layouts/
│   └── app.blade.php          (header, footer, modals global)
├── components/
│   ├── header.blade.php       (navigation bar)
│   ├── search-modal.blade.php (Ctrl+K modal)
│   ├── hotline-modal.blade.php
│   ├── atem-modal.blade.php   (port inspector)
│   └── certificate-modal.blade.php
└── pages/
    ├── home.blade.php         (beranda)
    ├── steps.blade.php        (langkah SOP)
    ├── equipment.blade.php    (alat)
    ├── signal-routes.blade.php (alur sinyal)
    ├── ptz.blade.php          (simulator PTZ)
    ├── checklist.blade.php    (hari-h)
    ├── troubleshooting.blade.php (bantuan)
    └── training.blade.php     (latihan)
```

### 5.2. JavaScript Modules
```
resources/js/
├── app.js                     (entry point Vite)
├── modules/
│   ├── navigation.js          (view switching, active nav)
│   ├── search.js              (global search modal + fetch)
│   ├── wizard.js              (step selector, prev/next)
│   ├── equipment-filter.js    (filter alat by category)
│   ├── signal-routes.js       (rute selector, diagram update)
│   ├── ptz-simulator.js       (move, zoom, preset, autofocus)
│   ├── checklist.js           (hari-h counter, progress bar)
│   ├── troubleshooting.js     (filter by tag/search)
│   ├── cable-simulator.js     (latihan colok kabel)
│   ├── quiz.js                (kuis interaktif, scoring)
│   └── progress.js            (save user progress via API)
└── utils/
    ├── api.js                 (fetch wrapper)
    └── modal.js               (open/close modals)
```

### 5.3. CSS (Tailwind)
```
resources/css/
└── app.css                    (import Tailwind, custom utilities)
```

---

## 6. MIGRATION & SEEDER

### 6.1. Migration Files
```
database/migrations/
├── 2024_01_01_000001_add_role_to_users_table.php
├── 2024_01_02_000001_create_steps_table.php
├── 2024_01_03_000001_create_equipment_table.php
├── 2024_01_04_000001_create_signal_routes_table.php
├── 2024_01_05_000001_create_troubleshooting_issues_table.php
├── 2024_01_06_000001_create_troubleshooting_tags_table.php
├── 2024_01_07_000001_create_checklist_items_table.php
├── 2024_01_08_000001_create_quiz_questions_table.php
├── 2024_01_09_000001_create_quiz_attempts_table.php
├── 2024_01_10_000001_create_user_progress_table.php
└── 2024_01_11_000001_create_certificates_table.php
```

### 6.2. Seeders (Data dari HTML)
```
database/seeders/
├── DatabaseSeeder.php         (panggil semua seeder)
├── UserSeeder.php             (admin@paroki.id + test user)
├── StepSeeder.php             (12 langkah dari HTML)
├── EquipmentSeeder.php        (11 alat dari HTML)
├── SignalRouteSeeder.php      (6 rute dari HTML)
├── TroubleshootingSeeder.php  (7 kasus dari HTML)
├── ChecklistSeeder.php        (15 item dari HTML)
└── QuizSeeder.php             (5 soal dari HTML)
```

---

## 7. FITUR AUTENTIKASI & AUTHORIZATION

### 7.1. Login/Register
- Route: `/login`, `/register`, `/logout` (Laravel Breeze/Fortify)
- Middleware: `auth` untuk progres, kuis, sertifikat
- Guest: bisa lihat semua konten publik (read-only)

### 7.2. Role
- **user** (default): akses semua konten, simpan progres, ikut kuis
- **admin**: akses panel CRUD `/admin`

### 7.3. Policy
- AdminPolicy: hanya role admin bisa akses `/admin/*`

---

## 8. FITUR INTERAKTIVITAS JAVASCRIPT

### 8.1. Global Search Modal (Ctrl+K atau `/`)
- Keyboard shortcut listener
- Fetch ke `/api/search?q=...`
- Tampilkan hasil dari: steps, equipment, troubleshooting
- Arrow keys navigasi, Enter buka halaman

### 8.2. Wizard Langkah (SOP 12 Step)
```javascript
// wizard.js
- selectStep(id) → load data step dari API
- nextStep() / prevStep() → navigasi
- toggleStepDone() → centang checkbox + simpan progres
- updateSopProgress() → hitung progress bar
```

### 8.3. Filter Alat (Equipment)
```javascript
// equipment-filter.js
- filterAlat(category) → show/hide cards by data-category
- searchAlat(keyword) → filter by name/description
```

### 8.4. Rute Sinyal (6 Routes)
```javascript
// signal-routes.js
- selectRute(slug) → fetch detail, update panel bawah
- toggleSimulasiSinyal() → animasi glow
- resetRutePilihan() → clear selection
```

### 8.5. PTZ Simulator
```javascript
// ptz-simulator.js
- ptzMove(direction) → transform viewport (pan/tilt)
- ptzZoom(direction) → scale viewport
- applyPtzPreset(num) → load preset position
- ptzAutoFocus() → simulasi AF
- toggleGrid() → show/hide Rule of Thirds
- testRefleksPtz(scenario) → mini quiz
```

### 8.6. Hari-H Checklist
```javascript
// checklist.js
- updateHariHCount() → count checked boxes
- resetHariHChecklist() → uncheck all
- updateProgressBar() → visual progress
```

### 8.7. Troubleshooting Filter
```javascript
// troubleshooting.js
- filterHelpTag(tag) → show/hide help-card by data-category
- filterHelpIssues(keyword) → search title/symptoms
- resetHelpFilter() → show all
```

### 8.8. Simulasi Kabel
```javascript
// cable-simulator.js
- pickCable(type) → highlight selected cable
- plugCableIntoPort(portId) → cek benar/salah
- updateCableScore() → hitung correct/total
- resetCableSimulator() → reset state
```

### 8.9. Kuis Interaktif
```javascript
// quiz.js
- gotoQuiz(num) → load soal dari API
- answerQuiz(option) → highlight correct/wrong
- showExplanation() → tampilkan feedback
- nextQuiz() / prevQuiz() → navigasi
- submitQuiz() → POST ke /api/quiz/submit
- showResults() → tampil skor + sertifikat
```

---

## 9. TAHAPAN KERJA (6 Fase)

### **Fase 0: Analisis & Rencana** ✅
**Output:**
- [x] Baca `docs/design/index.html` (4406 baris)
- [x] Identifikasi 9 view, komponen, interaktivitas
- [x] Desain 11 tabel database
- [x] Susun 8 controller + API routes
- [x] Tulis `docs/PLAN.md` lengkap

**Catatan:** Menunggu persetujuan user sebelum lanjut.

---

### **Fase 1: Layout & Routing (Halaman Statis)**
**Target:** Semua 9 halaman bisa dibuka, navigasi aktif, Vite jalan.

**Task:**
1. Buat `resources/views/layouts/app.blade.php`
   - Header dengan nav pills
   - Footer
   - Load Vite (`@vite(['resources/css/app.css', 'resources/js/app.js'])`)
2. Buat 9 Blade view di `resources/views/pages/`
   - Copy konten HTML dari desain, ubah ke Blade syntax
   - Hapus bagian `<head>` dan wrapper `<body>` (pakai layout)
3. Buat 9 route di `routes/web.php`
4. Buat 9 controller kosong (return view)
5. Install Tailwind CSS lokal (ganti CDN)
   - `npm install -D tailwindcss postcss autoprefixer`
   - `npx tailwindcss init -p`
   - Konfigurasi `tailwind.config.js` (warna custom dari desain)
6. Pindahkan CSS custom dari HTML ke `resources/css/app.css`
7. Setup Vite di `vite.config.js`
8. Test navigasi antar halaman

**Test di Browser:**
- Buka `http://localhost/` → beranda tampil
- Klik menu "Langkah (SOP)" → `/langkah` tampil
- Navigasi pills active state (manual dulu, JS di Fase 3)

**Belum Selesai:**
- Data masih hardcode dari HTML (belum dari DB)
- Interaktivitas JS belum berfungsi

---

### **Fase 2: Database & Seeder**
**Target:** Database schema siap, konten dari HTML masuk ke DB, halaman baca dari DB.

**Task:**
1. Buat 11 migration files
2. Jalankan `php artisan migrate`
3. Buat 11 models dengan relasi
   ```php
   // User.php
   public function progress() { return $this->hasMany(UserProgress::class); }
   public function attempts() { return $this->hasMany(QuizAttempt::class); }
   
   // Step.php
   protected $casts = ['diagram_data' => 'array'];
   ```
4. Buat 8 seeder files
   - Extract konten dari HTML → insert ke DB
   - Contoh: 12 langkah SOP dari HTML lines 996-1076
5. Jalankan `php artisan db:seed`
6. Update controller untuk fetch data dari DB
   ```php
   // EquipmentController.php
   public function index() {
       $equipment = Equipment::orderBy('order')->get();
       return view('pages.equipment', compact('equipment'));
   }
   ```
7. Update Blade view untuk loop data
   ```blade
   @foreach($equipment as $item)
       <div class="alat-card" data-category="{{ $item->category }}">
           <h3>{{ $item->name }}</h3>
           <p>{{ $item->description }}</p>
       </div>
   @endforeach
   ```

**Test di Browser:**
- Data alat tampil dari database
- 12 langkah SOP tampil dari database
- 5 soal kuis tampil dari database

**Belum Selesai:**
- Filter, search, interaktivitas belum jalan (perlu JS)
- Belum ada autentikasi

---

### **Fase 3: Interaktivitas JavaScript**
**Target:** Semua fitur interaktif berfungsi (filter, wizard, simulator, kuis).

**Task:**
1. Setup struktur JS modules di `resources/js/modules/`
2. Implementasi 9 modul JS (lihat bagian 8)
3. Buat API routes di `routes/api.php`
4. Buat API controllers di `app/Http/Controllers/Api/`
5. Implementasi endpoints:
   ```php
   // SearchController.php
   public function global(Request $request) {
       $q = $request->query('q');
       $results = [
           'steps' => Step::where('title', 'like', "%$q%")->limit(3)->get(),
           'equipment' => Equipment::where('name', 'like', "%$q%")->limit(3)->get(),
           'issues' => TroubleshootingIssue::where('title', 'like', "%$q%")->limit(3)->get(),
       ];
       return response()->json($results);
   }
   ```
6. Test setiap fitur interaktif:
   - ✅ Filter alat by category
   - ✅ Wizard prev/next step
   - ✅ PTZ simulator move/zoom
   - ✅ Checklist counter
   - ✅ Filter bantuan by tag
   - ✅ Simulasi kabel scoring
   - ✅ Kuis next/prev + scoring

**Test di Browser:**
- Klik filter "Audio Mixer" → hanya audio cards tampil
- Wizard langkah 5 → klik Next → langkah 6 muncul
- PTZ joystick → viewport bergerak
- Checklist centang 7 item → progress bar 47%
- Kuis jawab soal → feedback + penjelasan muncul

**Belum Selesai:**
- Progres belum tersimpan ke database per user
- Belum ada autentikasi

---

### **Fase 4: Autentikasi & Progres Per User**
**Target:** User bisa login, progres tersimpan, kuis result saved, generate sertifikat.

**Task:**
1. Install Laravel Breeze (minimal auth)
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install && npm run build
   php artisan migrate
   ```
2. Tambah kolom `role` ke `users` table (migration)
3. Buat middleware `IsAdmin` untuk route admin
4. Implementasi ProgressController
   ```php
   public function save(Request $request) {
       $request->validate([
           'step_id' => 'required|exists:steps,id',
           'completed' => 'boolean'
       ]);
       
       UserProgress::updateOrCreate(
           ['user_id' => auth()->id(), 'step_id' => $request->step_id],
           ['completed' => $request->completed, 'last_visited_at' => now()]
       );
       
       return response()->json(['success' => true]);
   }
   ```
5. Implementasi QuizController submit
   ```php
   public function submit(Request $request) {
       $answers = $request->validate(['answers' => 'required|array']);
       
       $score = 0;
       foreach($answers['answers'] as $ans) {
           $question = QuizQuestion::find($ans['question_id']);
           if($question->correct_answer === $ans['answer']) {
               $score += 20; // 5 soal x 20 poin
           }
       }
       
       $attempt = QuizAttempt::create([
           'user_id' => auth()->id(),
           'score' => $score,
           'answers_json' => $answers['answers'],
           'completed_at' => now()
       ]);
       
       return response()->json(['score' => $score, 'attempt_id' => $attempt->id]);
   }
   ```
6. Implementasi CertificateController generate
   ```php
   public function generate(Request $request) {
       $attempt = QuizAttempt::findOrFail($request->attempt_id);
       
       if($attempt->score < 80) {
           return response()->json(['error' => 'Skor minimal 80'], 400);
       }
       
       $cert = Certificate::create([
           'user_id' => auth()->id(),
           'cert_number' => 'KMS-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
           'score' => $attempt->score,
           'predicate' => $attempt->score >= 90 ? 'Sangat Memuaskan' : 'Memuaskan',
           'issued_at' => now()
       ]);
       
       return response()->json($cert);
   }
   ```
7. Update JS untuk save progres otomatis
   ```javascript
   // progress.js
   async function saveProgress(stepId, completed) {
       await fetch('/api/progress', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
           },
           body: JSON.stringify({ step_id: stepId, completed })
       });
   }
   ```
8. Protect API routes dengan middleware `auth:sanctum`

**Test di Browser:**
- Register akun baru → berhasil
- Login → session active
- Centang langkah 5 → reload page → masih centang (tersimpan)
- Submit kuis skor 92 → sertifikat ter-generate dengan nomor unik

**Belum Selesai:**
- Panel admin belum ada

---

### **Fase 5: Panel Admin CRUD**
**Target:** Admin bisa CRUD steps, equipment, quiz, checklist, troubleshooting.

**Task:**
1. Buat route group `/admin` dengan middleware `auth` + `can:admin`
2. Buat AdminController dengan 5 method CRUD
   - Dashboard (`/admin`)
   - Steps CRUD (`/admin/steps`)
   - Equipment CRUD (`/admin/equipment`)
   - Quiz CRUD (`/admin/quiz`)
   - Checklist CRUD (`/admin/checklist`)
   - Troubleshooting CRUD (`/admin/troubleshooting`)
3. Buat Blade views admin sederhana (bisa pakai Tailwind forms)
4. Implementasi validasi via FormRequest
5. Buat Policy `AdminPolicy`
   ```php
   public function before($user) {
       return $user->role === 'admin' ? true : null;
   }
   ```
6. Seed 1 admin user di UserSeeder
   ```php
   User::create([
       'name' => 'Admin Paroki',
       'email' => 'admin@paroki.id',
       'password' => bcrypt('password'),
       'role' => 'admin'
   ]);
   ```

**Test di Browser:**
- Login sebagai admin → akses `/admin` berhasil
- Tambah langkah baru → tersimpan
- Edit soal kuis → perubahan tampil di halaman latihan
- Login sebagai user biasa → `/admin` 403 forbidden

**Belum Selesai:**
- Testing otomatis belum ada

---

### **Fase 6: Testing & Dokumentasi Deploy**
**Target:** PHPUnit test pass, dokumentasi deployment lengkap.

**Task:**
1. Buat feature test untuk route utama
   ```php
   // tests/Feature/HomeTest.php
   public function test_homepage_loads() {
       $response = $this->get('/');
       $response->assertStatus(200);
       $response->assertSee('Komsos Live Academy');
   }
   ```
2. Test autentikasi
   ```php
   public function test_guest_cannot_save_progress() {
       $response = $this->postJson('/api/progress', ['step_id' => 1, 'completed' => true]);
       $response->assertStatus(401);
   }
   ```
3. Test quiz submit
   ```php
   public function test_quiz_submit_calculates_score() {
       $user = User::factory()->create();
       $response = $this->actingAs($user)->postJson('/api/quiz/submit', [
           'answers' => [
               ['question_id' => 1, 'answer' => 'B'],
               ['question_id' => 2, 'answer' => 'A'],
           ]
       ]);
       $response->assertJsonStructure(['score', 'attempt_id']);
   }
   ```
4. Jalankan `php artisan test`
5. Tulis dokumentasi deployment di `docs/README-DEPLOY.md`
   - Setup .env production
   - Optimize Tailwind CSS (`npm run build`)
   - Cache config/routes (`php artisan optimize`)
   - Setup SSL di Laragon/server
6. Perapian:
   - Hapus comment HTML berlebihan
   - Format code (`php artisan pint`)
   - Remove unused CSS classes

**Test di Browser:**
- `php artisan test` → semua test hijau
- `npm run build` → assets production compiled
- Buka di production mode → performa optimal

**Output Final:**
- ✅ Aplikasi Laravel full-stack siap deploy
- ✅ Database terisi konten dari HTML
- ✅ Semua fitur interaktif berfungsi
- ✅ Autentikasi + progres per user
- ✅ Panel admin CRUD
- ✅ Test coverage feature test
- ✅ Dokumentasi deployment

---

## 10. CATATAN PENTING

### 10.1. Warna Custom Tailwind
```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: '#032448',
        'primary-container': '#1f3a5f',
        secondary: '#7e5700',
        'secondary-container': '#fdc668',
        tertiary: '#002b15',
        surface: '#fcf9f8',
        // ... (copy dari HTML line 17-37)
      },
      fontFamily: {
        headline: ['Epilogue', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      }
    }
  }
}
```

### 10.2. Font Google
Tambah di `layouts/app.blade.php`:
```html
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
```

### 10.3. Animasi Custom
Pindahkan dari HTML line 80-95 ke `resources/css/app.css`:
```css
@keyframes pulseGlow {
  0%, 100% { opacity: 0.6; transform: scale(1); }
  50% { opacity: 1; transform: scale(1.05); }
}
.pulse-glow { animation: pulseGlow 2s infinite ease-in-out; }
```

### 10.4. Keputusan Ambigu (Perlu Konfirmasi)
1. **Login wajib atau tidak?**
   - **Rekomendasi:** Tamu bisa lihat semua konten (read-only), tapi tidak bisa simpan progres/kuis.
   - User login → bisa simpan progres + ikut kuis + dapat sertifikat.

2. **Role admin: siapa yang assign?**
   - **Rekomendasi:** Seed 1 admin default (`admin@paroki.id`), admin bisa upgrade user lain jadi admin via panel.

3. **Sertifikat format PDF atau HTML?**
   - **Rekomendasi:** HTML dulu (bisa print browser), nanti bisa upgrade ke PDF via library (DomPDF/TCPDF) jika perlu watermark/security.

---

## 11. STRUKTUR FOLDER AKHIR

```
aplikasi-komsos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── StepController.php
│   │   │   ├── EquipmentController.php
│   │   │   ├── SignalRouteController.php
│   │   │   ├── PtzController.php
│   │   │   ├── ChecklistController.php
│   │   │   ├── TroubleshootingController.php
│   │   │   ├── TrainingController.php
│   │   │   ├── Api/
│   │   │   │   ├── SearchController.php
│   │   │   │   ├── QuizController.php
│   │   │   │   ├── CertificateController.php
│   │   │   │   └── ProgressController.php
│   │   │   └── Admin/
│   │   │       └── AdminController.php
│   │   ├── Requests/
│   │   │   ├── QuizSubmitRequest.php
│   │   │   └── ProgressSaveRequest.php
│   │   └── Middleware/
│   │       └── IsAdmin.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Step.php
│   │   ├── Equipment.php
│   │   ├── SignalRoute.php
│   │   ├── TroubleshootingIssue.php
│   │   ├── ChecklistItem.php
│   │   ├── QuizQuestion.php
│   │   ├── QuizAttempt.php
│   │   ├── UserProgress.php
│   │   └── Certificate.php
│   └── Policies/
│       └── AdminPolicy.php
├── database/
│   ├── migrations/
│   │   └── (11 migration files)
│   └── seeders/
│       └── (8 seeder files)
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── components/
│   │   │   ├── header.blade.php
│   │   │   ├── search-modal.blade.php
│   │   │   └── (3 modals lainnya)
│   │   └── pages/
│   │       └── (9 halaman blade)
│   ├── js/
│   │   ├── app.js
│   │   └── modules/
│   │       └── (9 modul JS)
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php           (9 route halaman + auth)
│   └── api.php           (5 API endpoints)
├── docs/
│   ├── design/
│   │   └── index.html    (desain acuan)
│   ├── PLAN.md           (dokumen ini)
│   └── README-DEPLOY.md  (dibuat di Fase 6)
└── tests/
    └── Feature/
        ├── HomeTest.php
        ├── AuthTest.php
        └── QuizTest.php
```

---

## 12. PERSETUJUAN & NEXT STEP

**Status:** 📋 **MENUNGGU PERSETUJUAN USER**

Silakan review rencana ini. Jika ada yang perlu diubah/ditambah/dihapus, beritahu sebelum saya mulai Fase 1.

**Pertanyaan untuk User:**
1. **Login wajib atau opsional?** (rekomendasi: opsional, tamu read-only)
2. **Sertifikat format HTML atau PDF?** (rekomendasi: HTML dulu)
3. **Tailwind CDN atau lokal?** (rekomendasi: migrasi ke lokal di Fase 1)
4. **Apakah ada fitur tambahan yang belum tercakup?**

Setelah disetujui, saya akan mulai **Fase 1: Layout & Routing**.

---

**Dibuat oleh:** Hermes Agent  
**Tanggal:** 2026-11-05  
**Estimasi Total Waktu:** 6-8 jam kerja (semua fase)
