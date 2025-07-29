# 🛠️ B2B Sipariş Yönetimi API

Laravel 11 ile geliştirilmiş ve Docker Compose ile konteynerize edilmiş basit bir B2B sipariş yönetimi sistemidir.  
**Admin:** Ürün ve sipariş yönetimi yapabilir.  
**Customer:** Ürünleri görüntüleyip sipariş oluşturabilir.

---

## 📋 İçindekiler

- [🛠️ Ön Koşullar](#ön-koşullar)
- [🚀 Kurulum ve Çalıştırma](#kurulum-ve-çalıştırma)
- [👥 Örnek Kullanıcılar](#örnek-kullanıcılar)
- [📌 API Endpointleri](#api-endpointleri)
- [📂 Postman Collection](#postman-collection)
- [⭐ Bonus Özellikler](#bonus-özellikler)

---

## 🛠️ Ön Koşullar

- Docker & Docker Compose
- En az **4 GB RAM**
- Git CLI

---

## 🚀 Kurulum ve Çalıştırma

```bash
# Repo’yu klonlayın


# Docker servislerini başlatın
docker compose up -d

# Uygulama ayarlarını yapılandırın
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed

# (Opsiyonel) Laravel sunucusunu başlatın
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000



🌐 Erişim Adresleri
API: http://localhost:8000/api

PHP-FPM: http://localhost:9000

phpMyAdmin: http://localhost:8081

👥 Örnek Kullanıcılar
Rol	Email	Şifre
Admin	admin@example.com	password123
Customer	alice@example.com	secret123
Customer	bob@example.com	secret123

📌 API Endpointleri
Kategori	Method	Endpoint	Açıklama	Erişim
Authentication	POST	/api/register	Kullanıcı kaydı	Herkes
POST	/api/login	Giriş yap ve token al	Herkes
POST	/api/logout	Token ile çıkış	Giriş yapmış kullanıcı
Ürün İşlemleri	GET	/api/products	Tüm ürünleri listele	Herkes
GET	/api/products/{id}	Belirli ürünü getir	Herkes
POST	/api/products	Yeni ürün oluştur	Sadece Admin
PUT	/api/products/{id}	Ürünü güncelle	Sadece Admin
DELETE	/api/products/{id}	Ürünü sil	Sadece Admin
Sipariş İşlemleri	GET	/api/orders	Siparişleri listele	Admin: tüm / Customer: kendi
POST	/api/orders	Yeni sipariş oluştur	Sadece Customer
GET	/api/orders/{id}	Sipariş detayını getir	Admin veya ilgili Customer

📂 Postman Collection
Tüm API isteklerini test etmek için postman_collection.json dosyasını Postman’e import edebilirsiniz.

⭐ Bonus Özellikler
Rol bazlı erişim kontrolü (Admin / Customer)

Laravel Sanctum ile token tabanlı kimlik doğrulama

Docker ile hızlı kurulum

phpMyAdmin ile kolay veritabanı yönetimi

Seeder ile örnek veri desteği

