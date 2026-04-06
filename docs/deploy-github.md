# Deploy desde GitHub — RESOL Comandas

## Requisitos previos

| Componente | Versión mínima | Cómo verificar |
|---|---|---|
| PHP 8.1 (Thread Safe) | 8.1 | `php -v` |
| Composer | 2.x | `composer --version` |
| Git | cualquiera | `git --version` |
| MySQL | 8.0 | ya instalado con RESOL |

---

## 1. Instalar PHP standalone

Ver guía completa: `instalar-php-standalone.md`

Verificar que estas extensiones estén activas en `C:\php\php.ini`:

```ini
extension_dir = "ext"
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=sockets
extension=fileinfo
extension=intl
```

Verificar con:
```bash
php -m
```

---

## 2. Instalar Composer

Descargar e instalar desde: `https://getcomposer.org/Composer-Setup.exe`

El instalador detecta PHP automáticamente y lo agrega al PATH.

Verificar:
```bash
composer --version
```

---

## 3. Clonar el repositorio

```bash
cd C:\
git clone https://github.com/tu-usuario/fastfod.git
cd fastfod
```

---

## 4. Instalar dependencias PHP

```bash
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-intl
```

> El flag `--ignore-platform-req=ext-intl` es necesario porque `mike42/escpos-php`
> requiere la extensión `intl`, que no siempre viene habilitada por defecto.
> Si `intl` ya está activa en `php.ini`, el flag es opcional.

---

## 5. Configurar el entorno

Crear el archivo `.env` en la raíz del proyecto con el siguiente contenido:

```env
APP_NAME="RESOL Comandas"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://192.168.1.X:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resol
DB_USERNAME=root
DB_PASSWORD=

CURRENCY_SYMBOL=L

PRINTER_BARRA=EPSON-TMU220
PRINTER_COCINA_IP=192.168.1.X
PRINTER_COCINA_PORT=9100
```

> Reemplazar `192.168.1.X` con la IP local de la PC donde corre RESOL.
> Ajustar `DB_PASSWORD` y el nombre de la impresora según el entorno.

---

## 6. Generar clave de la app

```bash
php artisan key:generate
```

---

## 7. Publicar assets de Livewire

```bash
php artisan vendor:publish --tag=livewire:assets --force
```

---

## 8. Cachear configuración, rutas y vistas

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 9. Levantar el servidor

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

> `--host=0.0.0.0` es obligatorio para que las tablets de la red WiFi puedan conectarse.

Acceder desde tablets y celulares:
```
http://192.168.1.X:8000
```

---

## 10. Abrir puerto en el Firewall de Windows

```
Panel de control → Windows Defender Firewall
→ Configuración avanzada → Reglas de entrada → Nueva regla
→ Puerto → TCP → 8000 → Permitir la conexión
```

---

## 11. Arranque automático con NSSM (servicio de Windows)

Convierte la app en un servicio real de Windows: arranca con el sistema,
no requiere sesión abierta y se reinicia automáticamente si falla.

### 11.1 Descargar NSSM

Ir a: `https://nssm.cc/download`

Descargar la versión win64. Extraer y copiar `nssm.exe` en:
```
C:\Windows\System32\
```

Verificar:
```bash
nssm version
```

### 11.2 Registrar el servicio

Abrir una terminal **como Administrador** y ejecutar:
```bash
nssm install ResolComandas
```

Se abre una interfaz gráfica. Configurar la pestaña **Application**:

| Campo | Valor |
|---|---|
| Path | `C:\php\php.exe` |
| Startup directory | `C:\fastfod` |
| Arguments | `artisan serve --host=0.0.0.0 --port=8000` |

> Ajustar `Startup directory` si el proyecto está en otra ruta.

Clic en **Install service**.

### 11.3 Iniciar el servicio

```bash
nssm start ResolComandas
```

Verificar que esté corriendo:
```bash
nssm status ResolComandas
```

Debe mostrar: `SERVICE_RUNNING`

### 11.4 Comandos útiles

```bash
nssm stop ResolComandas       # Detener
nssm restart ResolComandas    # Reiniciar
nssm remove ResolComandas     # Desinstalar el servicio (pide confirmación)
```

También se puede gestionar desde `services.msc` (Servicios de Windows)
buscando **ResolComandas**.

### 11.5 Ver logs del servicio

NSSM puede redirigir stdout/stderr a un archivo. En la interfaz gráfica,
pestaña **I/O**, configurar:

| Campo | Valor |
|---|---|
| Output (stdout) | `C:\fastfod\storage\logs\nssm-out.log` |
| Error (stderr) | `C:\fastfod\storage\logs\nssm-err.log` |

O editarlo después:
```bash
nssm edit ResolComandas
```

---

## Verificación post-instalación

- [ ] Login funciona con credenciales de RESOL
- [ ] Se listan las mesas correctamente
- [ ] Se pueden agregar productos y enviar comanda
- [ ] La impresora de barra imprime al enviar
- [ ] La impresora de cocina imprime al enviar
- [ ] Los errores de impresora quedan en `storage/logs/laravel.log`
