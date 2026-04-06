# Instalar PHP standalone en Windows (sin Laragon ni XAMPP)

## Requisitos

- Windows 10 / 11 (64 bits)
- MySQL ya instalado con RESOL (no se necesita instalar otro)

---

## 1. Descargar PHP

Ir a: https://windows.php.net/download

Descargar **PHP 8.1 x64 Thread Safe** (archivo `.zip`).

> Usar siempre la versión **Thread Safe** cuando se usa `php artisan serve`.

---

## 2. Extraer y ubicar

Extraer el zip en:
```
C:\php
```

Verificar que exista `C:\php\php.exe`.

---

## 3. Agregar PHP al PATH del sistema

```
Panel de control
→ Sistema → Configuración avanzada del sistema
→ Variables de entorno
→ Variable "Path" (del sistema) → Editar → Nuevo
→ Escribir: C:\php
→ Aceptar en todo
```

Verificar abriendo una terminal nueva:
```bash
php -v
```
Debe mostrar la versión instalada.

---

## 4. Configurar php.ini

En `C:\php`, copiar el archivo:
```
php.ini-production  →  php.ini
```

Abrir `php.ini` y aplicar los siguientes cambios:

### 4.1 Directorio de extensiones
Buscar y descomentar:
```ini
extension_dir = "ext"
```

### 4.2 Extensiones requeridas
Buscar y descomentar cada una:
```ini
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=sockets
extension=fileinfo
extension=intl
```

> `sockets` es requerida por la impresora de cocina (red).
> `pdo_mysql` es requerida para conectarse a la BD de RESOL.
> `intl` es requerida por `mike42/escpos-php` (impresora térmica).

---

## 5. Verificar extensiones activas

```bash
php -m
```

Deben aparecer en la lista: `mbstring`, `openssl`, `PDO`, `pdo_mysql`, `sockets`, `fileinfo`, `intl`.

---

## 6. Levantar la app

```bash
cd C:\laragon\www\fastfod
php artisan serve --host=0.0.0.0 --port=8000
```

> MySQL de RESOL debe estar corriendo. Si RESOL está abierto, ya lo está.

---

## 7. Arranque automático con Windows

Hay dos opciones según el caso de uso:

---

### Opción A — Inicio de sesión automático (recomendada si siempre hay usuario logueado)

Crear `C:\laragon\www\fastfod\iniciar-servidor.vbs`:
```vbs
Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c cd /d C:\laragon\www\fastfod && php artisan serve --host=0.0.0.0 --port=8000", 0, False
```

Agregar acceso directo de ese `.vbs` en la carpeta Startup de Windows:
```
C:\Users\<usuario>\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Startup
```

El servidor arranca automáticamente al iniciar sesión, sin mostrar ventana.

---

### Opción B — Servicio de Windows con NSSM (recomendada para producción)

Convierte la app en un servicio real de Windows: arranca con el sistema,
no requiere sesión abierta y se reinicia automáticamente si falla.

**1. Descargar NSSM**

https://nssm.cc/download — extraer `nssm.exe` en `C:\Windows\System32`

**2. Registrar el servicio (ejecutar como Administrador)**
```bash
nssm install ResolComandas
```

Configurar en la interfaz que se abre:

| Campo | Valor |
|---|---|
| Path | `C:\php\php.exe` |
| Startup directory | `C:\laragon\www\fastfod` |
| Arguments | `artisan serve --host=0.0.0.0 --port=8000` |

**3. Iniciar el servicio**
```bash
nssm start ResolComandas
```

**Comandos útiles:**
```bash
nssm stop ResolComandas      # Detener
nssm restart ResolComandas   # Reiniciar
nssm remove ResolComandas    # Desinstalar el servicio
```

También se puede gestionar desde `services.msc` como cualquier servicio de Windows.
