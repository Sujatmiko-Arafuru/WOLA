# Sistem Analisis Beban Kerja Pegawai
## Poltekkes Kemenkes Denpasar

Sistem web untuk menganalisis beban kerja pegawai dengan perhitungan waktu yang akurat dan tampilan yang interaktif.

### 🚀 Fitur Utama

#### Untuk Pegawai:
- **Dashboard Interaktif** - Statistik kinerja dengan animasi dan grafik
- **Input Beban Kerja** - Form yang user-friendly dengan preview perhitungan
- **Riwayat Entri** - Tampilan semua entri dengan status beban kerja
- **Edit dengan Tracking** - Sistem edit dengan notifikasi ke admin
- **Status Beban Kerja** - Indikator optimal, berlebih, atau kurang

#### Untuk Admin:
- **Dashboard Komprehensif** - Statistik lengkap dengan grafik bulanan
- **Kelola Tugas** - CRUD uraian tugas dan waktu per unit
- **Kelola Akun Pegawai** - Manajemen akun dengan password visibility toggle
- **Notifikasi Perubahan** - Pantau semua perubahan dengan detail lengkap
- **Sistem Tracking** - Log semua edit dengan alasan dan timestamp

### 📊 Perhitungan Beban Kerja

Sistem menggunakan konversi waktu yang telah ditetapkan:
- **1 Hari Kerja Efektif** = 5 jam (300 menit)
- **1 Minggu** = 5 hari kerja
- **1 Bulan** = 4 minggu
- **1 Tahun** = 12 bulan

### 🎨 Tampilan dan UX

- **Design Modern** - Gradient colors dan card-based layout
- **Responsive** - Mobile-friendly dengan Bootstrap 5
- **Interaktif** - Animasi, hover effects, dan loading states
- **User-Friendly** - Form validation dan feedback yang jelas
- **Accessibility** - Icon Font Awesome dan color contrast yang baik

### 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Bootstrap 5, Font Awesome 6, Chart.js
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Authentication**: Laravel Auth dengan role-based access

### 📋 Instalasi

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd WOLA
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Run Development Server**
   ```bash
   php artisan serve
   ```

### 👥 Akun Default

#### Admin:
- **Email**: admin@poltekkes-denpasar.ac.id
- **Password**: admin123

#### Pegawai Sample:
- **NIP**: 196501011990032001
- **Password**: pegawai123

### 📁 Struktur Database

#### Users Table
- `id`, `name`, `nip`, `email`, `position`, `role`, `password`, `timestamps`

#### Tasks Table
- `id`, `task_description`, `time_per_unit`, `is_active`, `timestamps`

#### Workload Entries Table
- `id`, `user_id`, `task_id`, `quantity`, `time_unit`, `total_minutes`, `edit_count`, `timestamps`

#### Edit Logs Table
- `id`, `workload_entry_id`, `user_id`, `old_quantity`, `new_quantity`, `old_time_unit`, `new_time_unit`, `old_total_minutes`, `new_total_minutes`, `reason`, `edit_number`, `admin_notified`, `timestamps`

### 🔐 Keamanan

- **Role-based Access Control** - Admin dan Employee terpisah
- **Password Hashing** - Laravel Hash untuk keamanan password
- **CSRF Protection** - Token protection untuk semua form
- **Input Validation** - Server-side validation untuk semua input
- **SQL Injection Protection** - Eloquent ORM dengan prepared statements

### 📱 Responsive Design

Sistem telah dioptimalkan untuk berbagai ukuran layar:
- **Desktop** - Layout penuh dengan sidebar
- **Tablet** - Layout adaptif dengan navigation collapse
- **Mobile** - Single column layout dengan touch-friendly buttons

### 🎯 Fitur Unggulan

1. **Real-time Calculation** - Perhitungan otomatis saat input
2. **Visual Feedback** - Status badges dan color coding
3. **Edit Tracking** - Sistem audit trail yang lengkap
4. **Notification System** - Admin mendapat notifikasi setiap perubahan
5. **Data Visualization** - Chart.js untuk statistik bulanan
6. **Export Ready** - Struktur data siap untuk export ke Excel/PDF

### 🚀 Deployment

Untuk production deployment:

1. **Environment Setup**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Database Configuration**
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=your-host
   DB_DATABASE=your-database
   DB_USERNAME=your-username
   DB_PASSWORD=your-password
   ```

3. **Optimize Application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### 📞 Support

Untuk pertanyaan atau bantuan teknis, silakan hubungi tim pengembang.

### 📄 License

Sistem ini dikembangkan untuk Poltekkes Kemenkes Denpasar. Hak cipta dilindungi undang-undang.

---

**Dikembangkan dengan ❤️ untuk meningkatkan efisiensi kerja pegawai Poltekkes Kemenkes Denpasar**