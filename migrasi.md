# MASTER PROMPT — FULL MIGRATION CODEIGNITER 3 → LARAVEL

Anda bertindak sebagai **Senior Software Architect, Senior Laravel Developer, Database Architect, Security Engineer, dan QA Engineer**.

Saya memiliki aplikasi web production lama berbasis **CodeIgniter 3 (CI3)**.

TUGAS ANDA ADALAH MELAKUKAN **MIGRASI TOTAL DARI CODEIGNITER 3 KE LARAVEL**.

Saya ingin menjalankan prompt ini **SATU KALI**, kemudian Anda bekerja secara autonomous sampai migrasi selesai.

JANGAN berhenti hanya karena menemukan banyak file.

JANGAN meminta saya mengonfirmasi setiap langkah kecil.

JANGAN hanya memberikan panduan atau contoh.

**KERJAKAN MIGRASINYA LANGSUNG PADA PROJECT.**

---

# 1. TUJUAN AKHIR

Hasil akhir harus berupa aplikasi **Laravel production-ready** yang memiliki seluruh fungsi aplikasi CI3 sebelumnya, tetapi menggunakan arsitektur dan best practice Laravel modern.

Aplikasi Laravel harus:

- Memiliki seluruh fitur CI3.
- Memiliki seluruh business logic yang diperlukan.
- Memiliki authentication.
- Memiliki authorization.
- Memiliki CRUD.
- Memiliki validation.
- Memiliki upload file.
- Memiliki AJAX/API.
- Memiliki pagination.
- Memiliki search/filter.
- Memiliki dashboard.
- Memiliki report.
- Memiliki email jika digunakan.
- Memiliki cron/job jika digunakan.
- Memiliki seluruh UI yang diperlukan.
- Memiliki database baru.
- Memiliki Laravel migrations lengkap.
- Memiliki seeders jika diperlukan.
- Memiliki factories jika diperlukan.
- Memiliki automated tests.
- Aman digunakan untuk production.
- Tidak memiliki dependency terhadap CodeIgniter.

---

# 2. DATABASE — WAJIB MIGRATE ULANG

DATABASE LAMA **TIDAK AKAN DIGUNAKAN SEBAGAI DATABASE PRODUCTION FINAL**.

Kita akan membuat **DATABASE BARU** khusus Laravel.

Karena itu:

**JANGAN sekadar menghubungkan Laravel ke database lama dan menganggap pekerjaan selesai.**

Anda wajib melakukan reverse engineering database CI3 kemudian membuat ulang database menggunakan Laravel Migration.

Analisis seluruh:

- Tabel
- Kolom
- Primary key
- Foreign key
- Index
- Unique constraint
- Default value
- Nullable
- Data type
- Relasi
- Pivot table
- Enum
- Soft delete jika ada
- Timestamp
- Struktur authentication
- Struktur permission/role
- Struktur transaksi
- Struktur konfigurasi

Kemudian buat:

- Laravel migrations
- Eloquent Models
- Relationships
- Factories bila diperlukan
- Seeders
- Database seeder utama

Migration harus dapat dijalankan menggunakan:

    php artisan migrate:fresh --seed

dan menghasilkan database Laravel baru yang lengkap.

---

# 3. JANGAN MERUSAK SOURCE CI3

Selama proses migrasi:

**JANGAN menghapus source code CI3.**

CI3 digunakan sebagai:

> SOURCE OF TRUTH / REFERENCE

Laravel harus dibangun berdasarkan hasil analisis aplikasi CI3.

Jangan mengubah source CI3 kecuali benar-benar diperlukan dan jelaskan alasannya.

---

# 4. AUDIT PROJECT SECARA OTOMATIS

Sebelum melakukan migrasi, scan seluruh project.

Jangan hanya membaca beberapa controller.

Periksa seluruh:

    application/controllers
    application/models
    application/views
    application/config
    application/libraries
    application/helpers
    application/hooks
    application/core
    application/migrations
    application/third_party

dan seluruh folder lain yang digunakan aplikasi.

Periksa juga:

- composer.json
- package.json
- JavaScript
- CSS
- assets
- AJAX
- endpoint API
- SQL query
- stored procedure jika ada
- cron
- email
- upload
- authentication
- authorization
- session
- cookie
- encryption
- external API
- payment integration
- filesystem
- report/export
- PDF
- Excel
- notification
- logging

Gunakan pencarian global untuk menemukan dependency tersembunyi.

Contoh:

    $this
    base_url
    site_url
    redirect
    form_validation
    input
    session
    db
    upload
    email
    uri
    config
    helper
    library
    model
    load
    hooks

Jangan menganggap dependency hanya berada di controller.

---

# 5. BUAT MIGRATION MAP INTERNAL

Setelah audit, buat mapping internal:

CI3:

    Controller
    Model
    View
    Helper
    Library
    Hook
    Config
    Validation
    Session
    Route

menjadi:

Laravel:

    Controller
    Eloquent Model
    Blade View
    Service / Helper
    Service Class
    Middleware / Event / Listener
    config + .env
    Form Request
    Laravel Session
    routes/web.php
    routes/api.php

Jangan melakukan translasi literal.

**Pahami fungsi lalu implementasikan kembali menggunakan arsitektur Laravel.**

---

# 6. WAJIB MENGGUNAKAN BEST PRACTICE LARAVEL

Kode hasil migrasi harus mengikuti best practice Laravel.

Gunakan:

- MVC
- Eloquent ORM
- Form Request
- Middleware
- Policies
- Gates jika diperlukan
- Service Classes
- Repository hanya jika memang diperlukan
- Events
- Listeners
- Jobs
- Queues
- Notifications
- Resources untuk API
- Blade Components
- Blade Layout
- Laravel Validation
- Laravel Storage
- Laravel Cache
- Laravel Logging
- Laravel Mail
- Laravel Scheduler

sesuai kebutuhan.

---

# 7. JANGAN MEMBUAT FAT CONTROLLER

Controller hanya menangani:

- request
- authorization
- pemanggilan service
- response

Business logic kompleks harus dipindahkan ke:

    app/Services

Jika logic benar-benar sederhana, boleh tetap berada di controller.

Jangan membuat abstraction berlebihan hanya demi terlihat "enterprise".

Gunakan prinsip:

> SIMPLE, CLEAN, MAINTAINABLE.

---

# 8. DATABASE ACCESS

Prioritas:

1. Eloquent
2. Query Builder
3. Raw SQL hanya jika memang diperlukan.

Jangan melakukan:

    SELECT * 

jika hanya membutuhkan beberapa kolom.

Gunakan eager loading untuk mencegah N+1 query.

Perhatikan:

- indexes
- relationships
- transactions
- locking
- pagination
- query performance

Gunakan database transaction untuk operasi multi-step yang harus atomic.

---

# 9. SECURITY

Selama migrasi, audit dan perbaiki security issue.

Periksa:

- SQL Injection
- XSS
- CSRF
- Mass Assignment
- IDOR
- Broken Access Control
- Authentication bypass
- Authorization bypass
- insecure file upload
- path traversal
- session security
- password handling
- sensitive information exposure
- hard-coded credentials
- unsafe raw SQL
- unsafe redirects
- insecure API endpoint

Gunakan mekanisme Laravel.

Password harus menggunakan hashing Laravel.

Jangan menyimpan:

- password plaintext
- API key
- secret
- database password

di source code.

Gunakan `.env`.

---

# 10. AUTHENTICATION & AUTHORIZATION

Analisis sistem login CI3.

Identifikasi:

- login
- logout
- password
- session
- remember me
- role
- permission
- user level
- access control

Kemudian implementasikan kembali dengan mekanisme Laravel yang sesuai.

Jika aplikasi memiliki role/permission kompleks, pertahankan perilakunya.

Jangan membuat authorization hanya berdasarkan:

    if ($user->id == ...)

jika sebenarnya membutuhkan Policy/Permission.

---

# 11. VALIDATION

Semua validation CI3 harus dimigrasikan.

Gunakan:

    FormRequest

untuk validation kompleks.

Jangan menaruh validation besar di controller.

Pertahankan:

- required
- unique
- exists
- numeric
- email
- date
- file
- size
- custom validation

---

# 12. VIEW

Migrasikan seluruh view CI3 ke Blade.

Pertahankan UI/UX aplikasi.

Tetapi jangan membawa syntax CI3 secara mentah.

Gunakan:

    @extends
    @section
    @yield
    @include
    @component
    @props
    @if
    @foreach
    @csrf
    @method

Gunakan Laravel asset helper.

Jangan meninggalkan:

    base_url()
    site_url()
    $this->load->view()

di aplikasi Laravel.

---

# 13. JAVASCRIPT & AJAX

Cari seluruh AJAX request CI3.

Migrasikan endpoint ke Laravel.

Pastikan:

- URL benar
- CSRF benar
- response JSON benar
- validation error benar
- HTTP status code benar
- authentication benar
- authorization benar

Jangan hanya mengganti URL.

Pastikan seluruh flow AJAX tetap bekerja.

---

# 14. FILE UPLOAD

Migrasikan upload CI3 menggunakan Laravel Storage.

Periksa:

- destination
- filename
- extension
- MIME
- max size
- validation
- access permission
- delete file
- replace file

Jangan mempercayai extension file dari user.

Gunakan validation Laravel.

---

# 15. REPORT / EXPORT

Jika CI3 memiliki:

- PDF
- Excel
- CSV
- print
- report
- invoice

migrasikan seluruhnya.

Pastikan hasil akhir tetap memiliki fungsi yang sama.

---

# 16. API

Jika aplikasi memiliki API:

identifikasi seluruh endpoint:

    GET
    POST
    PUT
    PATCH
    DELETE

Migrasikan ke:

    routes/api.php

Gunakan:

- API Resources
- Form Requests
- Authentication
- Authorization
- Proper HTTP status code
- JSON response standard

Jangan mengembalikan HTML dari API kecuali memang diperlukan.

---

# 17. CRON / SCHEDULE / BACKGROUND JOB

Cari:

- cron
- scheduled task
- background process
- email otomatis
- cleanup
- notification
- periodic report

Migrasikan ke:

    Laravel Scheduler
    Jobs
    Queues

jika sesuai.

---

# 18. ERROR HANDLING

Jangan membiarkan error tersembunyi.

Gunakan exception handling Laravel.

Jangan menggunakan:

    die()
    exit()
    var_dump()
    print_r()

untuk production code.

Debug code harus dibersihkan.

---

# 19. LOGGING

Migrasikan logging ke Laravel Log.

Gunakan level yang tepat:

- emergency
- alert
- critical
- error
- warning
- notice
- info
- debug

Jangan mencatat:

- password
- token
- API secret
- sensitive user information

---

# 20. CODE QUALITY

Setelah coding selesai, lakukan code review terhadap seluruh kode Laravel.

Cari:

- duplicate code
- dead code
- unused imports
- unused variables
- bad naming
- overly complex methods
- massive controllers
- repeated queries
- N+1 query
- security vulnerability
- hard-coded values
- hard-coded credentials
- unnecessary abstraction
- missing validation
- missing authorization

Perbaiki semuanya.

---

# 21. TESTING

Buat automated test sebanyak yang masuk akal.

Minimal test:

- Authentication
- Authorization
- CRUD utama
- Validation
- Important business logic
- API
- File upload
- Critical workflow

Gunakan:

    php artisan test

Jika test gagal:

**JANGAN berhenti.**

Analisis error → perbaiki → jalankan test lagi.

Ulangi sampai test berhasil atau error tersebut memang disebabkan oleh dependency/environment yang tidak tersedia.

---

# 22. STATIC / QUALITY CHECK

Jika tooling tersedia, jalankan:

    composer validate
    php artisan route:list
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan test

Gunakan static analysis/code formatter yang sudah tersedia di project.

Jangan menambahkan dependency besar hanya untuk terlihat bagus jika tidak diperlukan.

---

# 23. MIGRATION DATABASE

Pastikan:

    php artisan migrate:fresh

berhasil.

Kemudian:

    php artisan db:seed

berhasil.

Kemudian:

    php artisan migrate:fresh --seed

harus menghasilkan database baru yang siap digunakan.

Pastikan semua foreign key dan dependency migration memiliki urutan yang benar.

---

# 24. ENVIRONMENT

Buat/rapikan:

    .env.example

Pastikan konfigurasi seperti:

- APP_NAME
- APP_ENV
- APP_KEY
- APP_URL
- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
- MAIL
- STORAGE
- API keys

tidak hard-coded.

Jangan pernah memasukkan credential asli ke repository.

---

# 25. LARAVEL STRUCTURE

Gunakan struktur standar Laravel.

Contoh:

    app/
        Http/
            Controllers/
            Requests/
            Middleware/

        Models/

        Services/

        Policies/

        Jobs/

        Events/

        Listeners/

    database/
        migrations/
        seeders/
        factories/

    resources/
        views/
        js/
        css/

    routes/
        web.php
        api.php

Jangan membuat folder aneh hanya karena struktur CI3 sebelumnya seperti itu.

---

# 26. BUSINESS LOGIC HARUS TETAP SAMA

Ini sangat penting.

Jangan mengubah behavior aplikasi tanpa alasan.

Contoh:

Jika CI3 melakukan:

    create order
    calculate total
    save payment
    update stock
    create invoice

maka Laravel harus tetap melakukan workflow tersebut.

Boleh memperbaiki implementasi internal.

Tetapi hasil bisnis harus tetap sama.

---

# 27. DATA MIGRATION

Karena database final adalah database baru, buat juga mekanisme jika diperlukan untuk memindahkan data dari database lama ke database baru.

Analisis apakah aplikasi membutuhkan:

- user migration
- customer migration
- transaction migration
- master data migration
- attachment migration
- historical data migration

Jika diperlukan, buat:

    database/seeders/

atau command khusus seperti:

    php artisan app:migrate-legacy-data

untuk memindahkan data lama ke database baru secara aman.

Jangan membuat data dummy jika data lama sebenarnya harus dipindahkan.

---

# 28. JANGAN BERHENTI KARENA ERROR

Ini adalah aturan paling penting.

Jika menemukan error:

1. Baca error.
2. Identifikasi root cause.
3. Perbaiki.
4. Jalankan ulang.
5. Test ulang.
6. Lanjutkan migrasi.

Jangan berhenti dan hanya melaporkan:

> "Ada error."

Anda bertanggung jawab untuk memperbaikinya.

Jika error membutuhkan keputusan bisnis yang benar-benar tidak dapat diketahui dari source CI3, gunakan behavior CI3 sebagai default dan dokumentasikan asumsi tersebut.

---

# 29. AUTONOMOUS EXECUTION

Kerjakan seluruh proses secara autonomous:

    AUDIT
       ↓
    ARCHITECTURE
       ↓
    DATABASE DESIGN
       ↓
    LARAVEL SETUP
       ↓
    MIGRATION
       ↓
    AUTHENTICATION
       ↓
    MODELS
       ↓
    SERVICES
       ↓
    CONTROLLERS
       ↓
    ROUTES
       ↓
    BLADE
       ↓
    AJAX/API
       ↓
    UPLOAD
       ↓
    REPORT
       ↓
    JOB/CRON
       ↓
    DATA MIGRATION
       ↓
    TESTING
       ↓
    BUG FIXING
       ↓
    SECURITY AUDIT
       ↓
    CODE REVIEW
       ↓
    FINAL CLEANUP
       ↓
    FINAL VERIFICATION

Jangan menunggu saya untuk setiap tahap.

---

# 30. JIKA LARAVEL PROJECT BELUM ADA

Jika project Laravel belum tersedia:

buat project Laravel baru di lokasi yang sesuai.

Gunakan versi Laravel yang kompatibel dengan environment PHP yang tersedia.

Sebelum memilih versi, periksa:

    php -v
    composer --version

dan dependency environment.

Jangan menurunkan versi PHP atau mengubah environment secara destructive tanpa alasan.

---

# 31. BACKUP / SAFETY

Sebelum melakukan perubahan besar:

pastikan source CI3 tetap dapat digunakan.

Jangan:

    rm -rf

folder source CI3.

Jangan menghapus database lama.

Jangan melakukan operasi destructive terhadap database lama.

Database baru Laravel boleh dibuat dan di-reset selama proses development.

---

# 32. FINAL VERIFICATION

Sebelum menyatakan selesai, lakukan pemeriksaan akhir.

Pastikan:

[ ] Laravel boot tanpa error
[ ] Composer dependency normal
[ ] `.env` benar
[ ] Database migration berhasil
[ ] Seeder berhasil
[ ] Semua route terdaftar
[ ] Authentication berjalan
[ ] Authorization berjalan
[ ] CRUD utama berjalan
[ ] Validation berjalan
[ ] AJAX berjalan
[ ] API berjalan jika ada
[ ] Upload berjalan
[ ] Report berjalan
[ ] Email berjalan jika ada
[ ] Scheduler/Job berjalan jika ada
[ ] Test berhasil
[ ] Tidak ada hard-coded secret
[ ] Tidak ada debug code
[ ] Tidak ada dependency CI3
[ ] Tidak ada `$this->load`
[ ] Tidak ada `base_url()`
[ ] Tidak ada `site_url()`
[ ] Tidak ada CI3 Controller
[ ] Tidak ada CI3 Model
[ ] Tidak ada CI3 View
[ ] Tidak ada query yang tidak diperlukan
[ ] Tidak ada obvious N+1 query
[ ] Authorization sudah diperiksa
[ ] File upload sudah diamankan
[ ] Code sudah direview

---

# 33. FINAL REPORT

Setelah seluruh pekerjaan selesai, berikan laporan akhir yang berisi:

## MIGRATION SUMMARY

- Status migrasi
- Laravel version
- PHP version
- Database
- Jumlah module
- Jumlah controller
- Jumlah model
- Jumlah migration
- Jumlah route
- Jumlah test

## MIGRATED FEATURES

Daftar seluruh fitur CI3 yang berhasil dimigrasikan.

## DATABASE

Daftar tabel baru dan relasinya.

## FILES CREATED

Daftar file penting yang dibuat.

## FILES MODIFIED

Daftar file penting yang diubah.

## TEST RESULT

Tampilkan hasil:

    php artisan test

dan test penting lainnya.

## KNOWN ISSUES

Hanya tampilkan jika benar-benar ada.

## ASSUMPTIONS

Tampilkan asumsi yang dibuat selama migrasi.

---

# 34. DEFINISI "SELESAI"

Migrasi dianggap SELESAI hanya jika:

**Aplikasi Laravel dapat dijalankan, database baru dapat dibuat melalui migration, fitur utama dapat digunakan, dan test utama berhasil.**

Jangan menyatakan "selesai" hanya karena file sudah berhasil dibuat.

Validasi aplikasi secara nyata.

---

# MULAI SEKARANG

Mulai dengan melakukan audit seluruh project CI3.

Setelah audit:

- buat architecture plan internal,
- buat database migration,
- setup Laravel,
- migrasikan seluruh fitur,
- lakukan testing,
- perbaiki seluruh error,
- lakukan security review,
- lakukan code review,
- lakukan final verification.

**JANGAN BERHENTI DI TENGAH JALAN.**

**JANGAN HANYA MEMBERIKAN INSTRUKSI KEPADA SAYA.**

**KERJAKAN MIGRASINYA.**

**SAYA INGIN HASIL AKHIR BERUPA PROJECT LARAVEL YANG SIAP DIJALANKAN.**

Prioritas utama:

> **FUNCTIONALITY + SECURITY + DATA INTEGRITY + CLEAN ARCHITECTURE + LARAVEL BEST PRACTICES + TESTABILITY + MAINTAINABILITY**

Mulai sekarang.