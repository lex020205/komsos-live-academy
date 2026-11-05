# Peta Interaksi Komsos Live Academy

Dokumen ini dibuat pada tahap inventarisasi sebelum perubahan fidelity. Sumber acuan
adalah `docs/design/index.html` (4406 baris), sedangkan status adalah kondisi
implementasi Laravel saat peta ini dibuat.

Ekstraksi otomatis menggunakan parser HTML Python dan regex JavaScript menemukan:

- 209 elemen interaktif (`a`, `button`, `input`, handler inline, atau `data-*`).
- 53 fungsi JavaScript (termasuk fungsi animasi internal).
- 3 event listener global.
- 23 link hash.

Beberapa kontrol sejenis dirangkum dalam satu baris dengan seluruh nilai argumennya
agar tabel tetap dapat diaudit terhadap hasil ekstraksi otomatis.

| Halaman/View | Elemen (teks/ikon/selector) | Pemicu: onclick/href/keyboard | Fungsi JS | Hasil yang diharapkan | Status di Laravel |
|---|---|---|---|---|---|
| Global | Logo Komsos | `href="#beranda"` | Router view | Membuka Beranda | OK: URL logo masih Googleusercontent; Laravel memakai route URL, bukan hash SPA |
| Global | Nav Beranda | `href="#beranda`, `data-nav="beranda"` | `switchView('beranda')` melalui hash | View Beranda aktif dan pill aktif | OK: route Beranda dan pill aktif tersedia |
| Global | Nav Alat & Kabel | `href="#alat`, `data-nav="alat"` | `switchView('alat')` melalui hash | View Alat aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Nav Langkah (SOP) | `href="#langkah`, `data-nav="langkah"` | `switchView('langkah')` melalui hash | View Langkah aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Nav Alur Sinyal | `href="#alur-sinyal`, `data-nav="alur-sinyal"` | `switchView('alur-sinyal')` melalui hash | View Alur Sinyal aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Nav Kamera PTZ | `href="#ptz`, `data-nav="ptz"` | `switchView('ptz')` melalui hash | View PTZ aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Nav Mode Hari-H | `href="#hari-h`, `data-nav="hari-h"` | `switchView('hari-h')` melalui hash | View checklist aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Nav Latihan & Kuis | `href="#latihan`, `data-nav="latihan"` | `switchView('latihan')` melalui hash | View latihan aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Nav Bantuan | `href="#bantuan`, `data-nav="bantuan"` | `switchView('bantuan')` melalui hash | View bantuan aktif dan pill aktif | OK: route dan pill aktif tersedia |
| Global | Link `Jalur Pembelajaran Remaja Paroki` | Tidak ada href/handler | Tidak ada | Membuka tujuan jalur belajar | OK: spesifikasi menyebut view ke-9, desain tidak menyediakan target |
| Global | Label `Liturgi Mingguan Hari Minggu` | Tidak ada href/handler | Tidak ada | Informasi statis | OK: statis |
| Global | Search desktop/mobile | Klik wrapper, tombol mobile | `openSearchModal` | Modal pencarian terbuka dan input fokus | OK: modal Laravel memakai ID/input berbeda dan database pencarian belum sama |
| Global | Pencarian keyboard | `/`, Ctrl+K/Cmd+K | `openSearchModal` pada `keydown` | Modal pencarian terbuka | OK: listener Laravel belum setara |
| Global | Tutup modal pencarian | Tombol/`Esc` | `closeSearchModal` | Modal tertutup | OK: ID input/hasil Laravel berbeda dari desain dan perilaku belum setara |
| Global | Hasil pencarian | Klik hasil | `runGlobalSearch`, `jumpToSearch` | Pindah view dan menjalankan aksi hasil | OK: `jumpToSearch` belum ada di Laravel |
| Global | Hotline | Tombol `Hotline`/`Kontak Tim Komsos` | `openHotlineModal`, `closeHotlineModal` | Modal hotline terbuka/tertutup | OK: konten, ID, dan tombol tutup belum sama |
| Global | Status & profil | Badge status, profil kru | Tidak ada | Badge hijau dan identitas tampil di header | OK: header Laravel belum memuat status/profil sesuai desain |
| Global | Modul aktif | `#top-progress-bar`, `#top-progress-text` | Tidak ada | Teks Modul 2 dan progress 60% tampil | OK: strip modul belum ada di layout Laravel |
| Global | View lifecycle | `DOMContentLoaded`, `hashchange` | `switchView`, `initAudioMeter` | Hash, view aktif, scroll, dan meter terinisialisasi | OK: Laravel multi-page; fungsi SPA tidak tersedia |
| Beranda | Tombol `Mulai Belajar` | `href="#jalur-belajar"` | Tidak ada | Membuka jalur pembelajaran | OK: target `jalur-belajar` tidak didefinisikan di desain |
| Beranda | `Mode Hari-H (SOP Cepat)` | `onclick="switchView('hari-h')"` | `switchView` | Membuka Mode Hari-H | OK: Laravel berpindah route, bukan view SPA; perlu disamakan perilakunya |
| Beranda | `Simulasi Colok Kabel` | `onclick="switchView('latihan')"` | `switchView` | Membuka Latihan | OK: Laravel berpindah route, bukan view SPA; perlu disamakan perilakunya |
| Beranda | Kartu PTZ | `onclick="switchView('ptz')"` | `switchView` | Membuka Kamera PTZ | OK secara tujuan route; belum identik SPA |
| Beranda | Kartu Alat & Kabel | `onclick="switchView('alat')"` | `switchView` | Membuka Alat & Kabel | OK secara tujuan route; belum identik SPA |
| Beranda | Kartu OBS | `onclick="openObsTab()` | `openObsTab` | Membuka Langkah subtab Software/OBS | OK: fungsi dan subview belum tersedia di Laravel |
| Beranda | Kartu Bantuan | `onclick="switchView('bantuan')"` | `switchView` | Membuka Bantuan | OK secara tujuan route; belum identik SPA |
| Beranda | Link footer | `href="#bantuan"`, `href="#alat"` | Router view | Membuka Bantuan/Katalog Alat | OK: footer Laravel masih `href="#"` untuk link lain dan tidak setara |
| Langkah (SOP) | Tab Rigging/Software | `onclick switchSopSubTab('rigging'|'software')` | `switchSopSubTab` | Panel sub-view berganti dan tab aktif | OK: belum tersedia di Laravel |
| Langkah (SOP) | Langkah 1â€“12 pada daftar | `data-step`, `onclick selectStep(1..12)` | `selectStep` | Detail langkah, badge, fase, kabel, deskripsi berubah | OK: Laravel belum menyediakan engine interaktif |
| Langkah (SOP) | Checkbox verifikasi | `onchange="toggleStepDone()"` | `toggleStepDone` | Status langkah tersimpan/terlihat dan progress berubah | OK: belum tersedia |
| Langkah (SOP) | Sebelumnya/Berikutnya | `onclick prevStep/nextStep` | `prevStep`, `nextStep` | Pindah langkah 1â€“16 dan batas dinonaktifkan | OK: belum tersedia |
| Langkah (SOP) | Tab YouTube/OBS | `onclick toggleSoftwareTab('yt'|'obs')` | `toggleSoftwareTab` | Panel software berganti | OK: belum tersedia |
| Langkah (SOP) | Cetak SOP | `onclick="window.print()"` | Browser print | Dialog cetak terbuka | OK: tombol/desain belum dipindahkan |
| Alat & Kabel | Filter kategori | `filterAlat('all'|'audio'|'video'|'kabel'|'komputer')` | `filterAlat` | Kartu alat difilter dan tombol aktif berubah | OK: Laravel belum punya filter sesuai desain |
| Alat & Kabel | Pencarian alat | `oninput searchAlat(this.value)` | `searchAlat` | Kartu alat difilter berdasarkan teks | OK: belum tersedia |
| Alur Sinyal | Simulasi/reset | `toggleSimulasiSinyal`, `resetRutePilihan` | Fungsi terkait | Simulasi jalur aktif/nonaktif atau kembali awal | OK: belum tersedia |
| Alur Sinyal | Pilihan rute | `selectRute('mic-mixer'|'sub-atem'|'ptz-atem'|'obs-tv'|'obs-yt'|'ndi-obs')` | `selectRute` | Diagram, deskripsi, dan highlight rute berubah | OK: belum tersedia |
| Kamera PTZ | Joystick arah | `ptzMove('up'|'down'|'left'|'right')` | `ptzMove`, `updatePtzTransform` | Posisi pan/tilt dan overlay berubah | OK: belum tersedia |
| Kamera PTZ | Zoom | `ptzZoom('in'|'out')` | `ptzZoom`, `updatePtzTransform` | Skala 1.0xâ€“2.5x berubah | OK: belum tersedia |
| Kamera PTZ | Reset/fokus/grid | `ptzReset`, `ptzAutoFocus`, `toggleGrid` | Fungsi terkait | Posisi netral, fokus selesai, grid tampil/sembunyi | OK: belum tersedia |
| Kamera PTZ | Preset 1â€“4 | `applyPtzPreset(1..4)`, `data-preset` | `applyPtzPreset` | Preset aktif, transform, overlay, toast berubah | OK: belum tersedia |
| Kamera PTZ | Refleks skenario 1â€“3 | `testRefleksPtz(1..3)` | `testRefleksPtz` | Preset tepat dan pesan skenario tampil | OK: belum tersedia |
| Mode Hari-H | Checklist | `onchange updateHariHCount`, `.hari-h-box` | `updateHariHCount` | Centang tersimpan, counter, persentase, progress berubah | OK: controller ada, UI persistence/interaksi desain belum |
| Mode Hari-H | Reset checklist | `resetHariHChecklist` | `resetHariHChecklist` | Semua centang kembali kosong dan toast tampil | OK: belum tersedia |
| Mode Hari-H | Fullscreen | `toggleFullscreen` | `toggleFullscreen` | Browser masuk/keluar fullscreen | OK: belum tersedia |
| Mode Hari-H | Aturan emas | `.aturan-check`, `updateAturanCount` | `updateAturanCount` | Counter 0/3â€“3/3 dan toast saat lengkap | OK: belum tersedia |
| Mode Hari-H | Audio meter | `#vu-meter-l`, `#vu-meter-r` | `initAudioMeter`, `animate` | Meter dan dB bergerak kontinu | OK: belum tersedia |
| Latihan & Kuis | Navigasi bagian | `scrollToExercise('section-cables'|'section-quiz'|'section-result')` | `scrollToExercise` | Scroll halus ke bagian yang dipilih | OK: bagian desain belum ada di Laravel |
| Latihan & Kuis | Reset simulator | `resetCableSimulator` | `resetCableSimulator` | Kabel, port, skor, dan instruksi kembali awal | OK: belum tersedia |
| Latihan & Kuis | Pilih kabel | `pickCable('xlr'|'hdmi'|'lan'|'35'|'akai')`, `data-cable` | `pickCable` | Chip aktif, instruksi dan toast berubah | OK: belum tersedia |
| Latihan & Kuis | Colok kabel | `plugCableIntoPort('atem-cam1'|'atem-mic1'|'phones')` | `plugCableIntoPort` | Port benar/salah, status, skor, dan toast berubah | OK: belum tersedia |
| Latihan & Kuis | Port Inspector | `openAtemPortInspector`, `inspectPort('cam1'|'cam2'|'mic1'|'hdmi-out'|'lan'|'usb'|'power')`, `closeAtemModal` | Fungsi terkait | Modal terbuka, detail port berubah, modal tertutup | OK: modal Laravel ada tetapi detail interaktif/ID belum sama |
| Latihan & Kuis | Bubble soal 1â€“5 | `gotoQuiz(1..5)`, `data-opt="A".."D"` | `gotoQuiz`, `loadQuiz` | Soal/opsi aktif berubah | OK: kuis Laravel belum tersedia |
| Latihan & Kuis | Jawab/prev/next kuis | `answerQuiz('A'..'D')`, `prevQuiz`, `nextQuiz` | Fungsi terkait | Jawaban dinilai, soal berpindah, hasil akhir tampil | OK: belum tersedia |
| Latihan & Kuis | Reset semua latihan | `resetAllExercises` | `resetAllExercises` | Kuis dan simulator kembali awal | OK: belum tersedia |
| Latihan & Kuis | Sertifikat | `openCertificateModal`, `closeCertModal`, `window.print()` | Fungsi terkait | Modal sertifikat terbuka, tertutup, dapat dicetak | OK: ID Laravel `certificate-modal` dan API berbeda |
| Bantuan | Pencarian bantuan | `oninput filterHelpIssues(this.value)` | `filterHelpIssues` | Kartu bantuan difilter berdasarkan teks | OK: belum tersedia |
| Bantuan | Reset filter | `resetHelpFilter` | `resetHelpFilter` | Input kosong dan semua kartu tampil | OK: belum tersedia |
| Bantuan | Tag bantuan | `filterHelpTag('suara'|'video'|'internet'|'teks'|'ptz'|'tv')` | `filterHelpTag` | Kartu kategori tampil dan toast muncul | OK: belum tersedia |
| Modal global | ATEM close/inspect | Tombol close dan port `power`, `lan`, `usb`, `hdmi-out`, `cam1`, `cam2`, `mic1` | `closeAtemModal`, `inspectPort` | Modal/isi inspector berubah | OK: Laravel hanya menampilkan kartu statis |
| Modal global | Search result input | `oninput runGlobalSearch(this.value)` | `runGlobalSearch` | Hasil pencarian dinamis tampil | OK: Laravel memakai ID dan database berbeda |
| Modal global | Escape | `keydown` dengan `Escape` | `closeSearchModal`, penutupan modal | Modal aktif tertutup | OK: listener/set modal belum sama |
| Global | Toast | Dipanggil fungsi interaksi | `showToast(message, icon)` | Banner toast tampil lalu menghilang | OK: belum tersedia di Laravel |

## Temuan struktur penting

1. View Blade `pages/academy.blade.php` sekarang menggunakan HTML, token Tailwind,
   CSS, dan JavaScript desain asli, sehingga `.app-view`, `.active-view`,
   `.nav-pill.active`, font, ikon, scrollbar, dan animasi tidak lagi terpisah.
2. Header fixed dan tiga baris status dipertahankan dari desain asli, termasuk
   padding view, badge status, dan progress modul 60%.
3. Logo eksternal desain asli diganti dengan `public/images/logo-komsos.png` pada
   header dan favicon. Link `Mulai Belajar` diarahkan ke `#langkah` sesuai keputusan
   inventarisasi.
4. HTML asli mendefinisikan `VIEWS` sebanyak delapan. `Jalur Pembelajaran` bukan
   view terpisah; tujuan yang disepakati adalah Langkah (SOP).
5. `AUTH_SETUP` tidak ditemukan di project; dokumen panduan yang tersedia adalah
   `AGENTS.md` dan `CLAUDE.md`.
