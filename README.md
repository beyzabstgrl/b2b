<!--
===============================
🛠️ B2B Sipariş Yönetimi API
===============================
-->

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red)](https://laravel.com)  
[![Docker](https://img.shields.io/badge/Docker-Compose-blue)](https://docs.docker.com/compose/)  
[![PHP](https://img.shields.io/badge/PHP-8.2+-blueviolet)](https://www.php.net/)  
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

# 📦 B2B Sipariş Yönetimi API

Basit bir B2B sipariş yönetim sistemi.  
Laravel 11 & Docker Compose ile konteynerize edilmiştir.

---

## 📋 İçindekiler

- [🛠️ Ön Koşullar](#️-ön-koşullar)
- [🚀 Kurulum & Çalıştırma](#-kurulum--çalıştırma)
- [👥 Örnek Kullanıcılar](#-örnek-kullanıcılar)
- [📌 API Endpointleri](#-api-endpointleri)
    - [Authentication](#1-authentication)
    - [Ürün İşlemleri](#2-ürün-işlemleri)
    - [Sipariş İşlemleri](#3-sipariş-işlemleri)
- [📂 Postman Collection](#-postman-collection)
- [⭐ Bonus Özellikler](#-bonus-özellikler)

---

## 🛠️ Ön Koşullar

- Docker & Docker Compose
- En az **4 GB RAM**
- Git CLI

---

## 🚀 Kurulum & Çalıştırma

1. **Repo’yu klonlayın**
   ```bash
   git clone https://github.com/<kullanici-adiniz>/b2b-order-api.git
   cd b2b-order-api
2.**Docker servislerini başlatın**
   ```bash
docker compose up -d

3. **Uygulama ayarlarını yapılandırın**
 ```bash
docker compose exec app php artisan key:generate  
docker compose exec app php artisan migrate:fresh --seed

4. **(Opsiyonel) Laravel sunucusunu çalıştırın**
 ```bash
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000

5. **Erişim URL’leri**
API: http://localhost:8000/api/...

PHP‑FPM: http://localhost:9000

phpMyAdmin: http://localhost:8081

<p>Örnek Kullanıcılar
Rol	Email	Şifre
Admin	admin@example.com	password123
Customer	alice@example.com	secret123
Customer	bob@example.com	secret123
</p>

API Endpointleri
1. Authentication
Method	Endpoint	Açıklama
POST	/api/register	Kullanıcı kaydı
POST	/api/login	Giriş (token döner)
POST	/api/logout	Çıkış

2. Ürün İşlemleri
Method	Endpoint	Erişim
GET	/api/products	Herkes
GET	/api/products/{id}	Herkes
POST	/api/products	Admin
PUT	/api/products/{id}	Admin
DELETE	/api/products/{id}	Admin

3. Sipariş İşlemleri
Method	Endpoint	Erişim
GET	/api/orders	Admin: tüm, Customer: kendi sipariş
POST	/api/orders	Customer
GET	/api/orders/{id}	Admin veya sahibi Customer


Postman Collection
Import ederek tüm istekleri kolayca test edebilirsiniz:
postman_collection.json

