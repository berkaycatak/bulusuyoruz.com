# Buluşuyoruz 📅

**Buluşuyoruz**, arkadaş gruplarının kolayca etkinlik planlamasını, ortak gün/saat belirlemesini ve buluşma noktası kararlaştırmasını sağlayan modern bir web uygulamasıdır.

"Ne zaman buluşalım?", "Nerede buluşalım?" kaosuna son! 🚀

## 🌟 Özellikler

### 1. Etkinlik Oluşturma
*   **Detaylı Planlama:** Etkinlik adı, açıklaması ve tarih aralığı belirleme.
*   **İki Farklı Konum Modu:**
    *   **Ortak Konum:** Katılımcıların kendi konumlarını girmesine izin verin, sistem ortak noktayı bulsun (Gelecek özellik).
    *   **Buluşma Noktası:** Belirli bir yer önerin veya katılımcıların önerilerini toplayın.
*   **Sahiplik Yönetimi:** Sadece giriş yapmış kullanıcılar etkinlik oluşturabilir ve yönetebilir.

### 2. Katılımcı Yönetimi
*   **Kolay Katılım:** Paylaşılan link üzerinden hızlıca katılım formu.
*   **Dinamik Tarih & Saat Seçimi:** Etkinlik tarih aralığına göre dinamik oluşan takvim ve saat butonları.
*   **Konum Bildirimi:** Tüm Türkiye il ve ilçeleriyle entegre dinamik seçim kutuları.
*   **Anonim veya Üyeli Katılım:** Giriş yapmadan da (isim belirterek) katılım sağlanabilir (Mevcut yapıda üye zorunlu değilse).

### 3. Dashboard (Yönetim Paneli)
*   **Etkinlik Listesi:** Oluşturduğunuz tüm etkinlikleri tek bir yerden takip edin.
*   **Yanıtları Görüntüleme:** Hangi katılımcının hangi gün, saat ve konumda müsait olduğunu detaylıca inceleyin.
*   **Düzenleme İmkanı:** Oluşturduğunuz etkinliklerin detaylarını sonradan güncelleyin.
*   **Link Paylaşımı:** Tek tıkla etkinlik davet linkini kopyalayın.

## 🛠️ Teknolojiler

Bu proje modern ve güçlü teknolojiler kullanılarak geliştirilmiştir:

*   **Backend:** [Laravel 12](https://laravel.com) - PHP Framework
*   **Frontend:** [Blade Templates](https://laravel.com/docs/blade) + [Alpine.js](https://alpinejs.dev)
*   **Stil:** [Tailwind CSS](https://tailwindcss.com)
*   **Veritabanı:** MySQL / SQLite
*   **Kimlik Doğrulama:** Laravel Breeze

## 🚀 Kurulum

Projeyi yerel ortamınızda çalıştırmak için aşağıdaki adımları izleyin:

### Gereksinimler
*   PHP 8.2+
*   Composer
*   Node.js & NPM
*   MySQL

### Adım Adım
1.  **Projeyi Klonlayın:**
    ```bash
    git clone https://github.com/kullaniciadi/bulusuyoruz.git
    cd bulusuyoruz
    ```

2.  **Bağımlılıkları Yükleyin:**
    ```bash
    composer install
    npm install
    ```

3.  **Çevresel Değişkenleri Ayarlayın:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *.env dosyasını açarak veritabanı bilgilerinizi (DB_DATABASE, DB_USERNAME, vb.) güncelleyin.*

4.  **Veritabanını Hazırlayın:**
    ```bash
    php artisan migrate
    ```
    
    **İl ve İlçe Verilerini Yükleyin:**
    ```bash
    php artisan db:seed --class=LocationSeeder
    ```
    *Bu komut 81 il (koordinatlarıyla birlikte) ve 973 ilçeyi veritabanına ekler.*


5.  **Uygulamayı Başlatın:**
    İki ayrı terminalde şu komutları çalıştırın:
    
    *Backend:*
    ```bash
    php artisan serve
    ```

    *Frontend (Build/Watch):*
    ```bash
    npm run dev
    ```

6.  **Tarayıcıda Açın:**
    `http://localhost:8000` adresine gidin.

---

**Lisans:** [MIT](https://opensource.org/licenses/MIT)
