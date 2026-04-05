# Deploy a producción — RESOL Comandas

## Contexto

La app corre en la **misma PC donde está instalado RESOL** (Windows + Laragon).
Los meseros se conectan desde tablets/celulares vía WiFi local.

---

## 1. Build en la máquina de desarrollo

### 1.1 Compilar CSS para producción
```bash
npx tailwindcss -i ./resources/css/app.css -o ./public/css/app.css --minify
```

### 1.2 Optimizar Composer (sin dependencias de dev)
```bash
composer install --no-dev --optimize-autoloader
```

### 1.3 Cachear configuración, rutas y vistas
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 1.4 Ajustar `.env` para producción
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://192.168.1.X:8000   # IP del servidor en la red local

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resol
DB_USERNAME=root
DB_PASSWORD=

CURRENCY_SYMBOL=L

PRINTER_BARRA=EPSON-TMU220        # Nombre exacto en "Dispositivos e impresoras"
PRINTER_COCINA_IP=192.168.1.X     # IP de la impresora de cocina (red RJ45)
PRINTER_COCINA_PORT=9100
```

### 1.5 Empaquetar

Copiar todo el proyecto **excepto**:
```
node_modules/
.git/
storage/logs/*.log
.env.example
```

---

## 2. Instalación en la PC de producción

### 2.1 Requisitos previos

| Componente | Versión mínima | Notas |
|---|---|---|
| PHP | 8.0 | Laragon ya lo incluye |
| MySQL | 8.0 | Ya está instalado con RESOL |
| Extensiones PHP | `mbstring`, `openssl`, `pdo_mysql`, `sockets` | Ver sección 2.2 |
| Impresora BARRA | instalada en Windows | Debe aparecer en "Dispositivos e impresoras" con el nombre exacto configurado en `.env` |

### 2.2 Verificar extensión `sockets`

Requerida por `mike42/escpos-php` para la impresora de cocina (red).

```bash
php -m | grep sockets
```

Si no aparece, abrir `php.ini` de Laragon y descomentar:
```ini
extension=sockets
```

Reiniciar Laragon después.

### 2.3 Pasos de instalación

**1.** Copiar el proyecto a:
```
C:\laragon\www\fastfod
```

**2.** Colocar el `.env` de producción ya configurado en la raíz del proyecto.

**3.** Generar la clave de la app (solo si no viene en el `.env`):
```bash
php artisan key:generate
```

**4.** Publicar assets de Livewire:
```bash
php artisan vendor:publish --tag=livewire:assets --force
```

**5.** Limpiar cachés previos si existieran:
```bash
php artisan config:clear
php artisan view:clear
```

**6.** Re-cachear en el servidor:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2.4 Levantar el servidor

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

> `--host=0.0.0.0` es obligatorio para que las tablets de la red WiFi puedan conectarse.

### 2.5 Abrir puerto en el Firewall de Windows

```
Panel de control → Windows Defender Firewall
→ Configuración avanzada → Reglas de entrada → Nueva regla
→ Puerto → TCP → 8000 → Permitir la conexión
```

### 2.6 Acceso desde tablets y celulares

```
http://192.168.1.X:8000
```

Reemplazar `192.168.1.X` con la IP local de la PC donde corre RESOL.

---

## 3. Arranque automático con Windows

Para que el servidor se levante solo al iniciar Windows, crear el archivo
`C:\laragon\www\fastfod\iniciar-servidor.bat`:

```bat
@echo off
cd /d C:\laragon\www\fastfod
php artisan serve --host=0.0.0.0 --port=8000
```

Luego agregar un acceso directo a ese `.bat` en:
```
C:\Users\<usuario>\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Startup
```

O configurarlo como tarea en el **Programador de tareas de Windows** con
"Ejecutar tanto si el usuario inició sesión como si no" para que corra en segundo plano.

---

## 4. Verificación post-instalación

- [ ] Login funciona con credenciales de RESOL
- [ ] Se listan las mesas correctamente
- [ ] Se pueden agregar productos y enviar comanda
- [ ] La impresora de barra imprime al enviar
- [ ] La impresora de cocina imprime al enviar (requiere `PRINTER_COCINA_IP` en `.env`)
- [ ] Los errores de impresora quedan en `storage/logs/laravel.log`
