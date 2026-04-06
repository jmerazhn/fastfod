# CLAUDE.md — fastfod adaptado para RESOL

Este archivo proporciona contexto completo para trabajar en este proyecto.
Responde siempre en **español**.

---

## Contexto del proyecto

**fastfod** es un sistema POS para restaurantes hecho en Laravel 8 + Livewire.
Se está adaptando para funcionar como **módulo web de comandas** del sistema
**RESOL** (POS Windows en C#/.NET).

El objetivo es que los **meseros ingresen comandas desde tablets o teléfonos**
conectados a la red WiFi del negocio. La API y la web corren en la misma PC
donde está instalado RESOL.

---

## Arquitectura

```
Tablet / Teléfono (WiFi del negocio)
          ↓  http://192.168.1.X:8000
   fastfod (Laravel — misma PC de RESOL)
          ↓
   BD MySQL de RESOL (misma instancia, mismo servidor)
```

**fastfod NO tiene base de datos propia.** Se conecta directamente a la base
de datos de RESOL. Los modelos Eloquent apuntan a las tablas existentes de RESOL.

---

## Base de datos de RESOL

**Nombre de la BD:** `resol`
**Motor:** MySQL 8.0.44
**Las tablas ya existen** — fastfod no debe crear tablas nuevas ni correr
migraciones que afecten la BD de RESOL.

### Tablas de RESOL que usa fastfod

#### `mesas`
| Columna | Tipo | Notas |
|---------|------|-------|
| id | INT PK | |
| numero | INT | Número visible de la mesa |
| lugar | VARCHAR | Zona/área |

#### `usuarios`
| Columna | Tipo | Notas |
|---------|------|-------|
| id | INT PK | |
| nombre | VARCHAR | |
| correo | VARCHAR | |
| clave | VARCHAR | Hash MD5 de la contraseña |
| perfil | VARCHAR | 'Administrador', 'Mesero', etc. |
| estatus | VARCHAR | |
| permisos | VARCHAR | |
| foto | VARCHAR | |

> **Importante:** La autenticación usa MD5, no bcrypt. Al hacer login hay que
> comparar `md5($password)` contra el campo `clave`.

#### `categorias`
| Columna | Tipo | Notas |
|---------|------|-------|
| id | INT PK | |
| nombre | VARCHAR | |
| foto | VARCHAR | |
| lugar | VARCHAR | 'COCINA' o 'BARRA' — define en qué impresora se imprime |
| icono | VARCHAR | |

#### `productos`
| Columna | Tipo | Notas |
|---------|------|-------|
| id | INT PK | |
| nombre | VARCHAR | |
| precio | DECIMAL | |
| costo | DECIMAL | |
| categoria_id | INT FK | |
| icono | VARCHAR | |
| inventario | TINYINT | 1 = controla stock, 0 = no |
| stock | INT | |
| estatus | VARCHAR | Solo mostrar activos |

#### `comandas`
| Columna | Tipo | Notas |
|---------|------|-------|
| id | INT PK | |
| mesa_id | INT FK | |
| mesero_id | INT FK | |
| producto_id | INT FK | |
| cantidad | INT | |
| precio | DECIMAL | |
| descuento | DECIMAL | |
| orden | VARCHAR | Nombre del producto / notas |
| cambios | VARCHAR | Modificaciones al producto |
| impresa | TINYINT | 0 = no impresa, 1 = ya impresa |
| estatus | VARCHAR | 'Pendiente', 'Pagada' |
| cooked_estatus | VARCHAR | Estado de cocción |
| created_at | DATETIME | |

> Al insertar una comanda desde fastfod, cada fila de `comandas` representa
> **un producto** (no una orden completa). Es decir, si el mesero agrega
> 3 productos, se insertan 3 filas en `comandas` con el mismo `mesa_id`.

---

## Stack tecnológico de fastfod

- **Backend:** Laravel 8, PHP 8.0
- **Frontend:** Livewire 2, Tailwind CSS, Alpine.js
- **Auth:** Laravel Breeze (a adaptar para usar tabla `usuarios` de RESOL)
- **Build:** Laravel Mix
- **Servidor local:** Laragon (Windows)

---

## Trabajo a realizar

### Objetivo principal
Adaptar fastfod para que los meseros puedan:
1. Hacer login con sus credenciales de RESOL
2. Ver las mesas disponibles
3. Seleccionar una mesa
4. Agregar productos por categoría a la comanda
5. Enviar la comanda (insertar en tabla `comandas` de RESOL)
6. RESOL en Windows la verá automáticamente sin cambios

### Tareas pendientes

#### 1. Configurar conexión a BD de RESOL
- Editar `.env` para apuntar a la BD `resol`
- Deshabilitar o ignorar las migraciones existentes de fastfod
  (las tablas de fastfod: `users`, `categories`, `orders`, etc. NO se usan)

#### 2. Adaptar modelos Eloquent
Cambiar los modelos para apuntar a las tablas de RESOL:

| Modelo actual | Tabla actual | → Tabla RESOL |
|--------------|-------------|----------------|
| `User` | `users` | `usuarios` |
| `Category` | `categories` | `categorias` |
| `Product` | `products` | `productos` |
| `Order` | `orders` | `comandas` |
| `OrderDetail` | `order_details` | *(ver nota abajo)* |

> En RESOL cada fila de `comandas` es un producto individual (no hay tabla
> separada de detalle). No existe `detalle_comandas` como tal.

#### 3. Adaptar autenticación
- El login debe autenticar contra `usuarios` de RESOL
- La contraseña se hashea con MD5: `md5($password)`
- NO usar bcrypt ni el sistema de auth de Laravel por defecto
- Guardar en sesión: `id`, `nombre`, `perfil` del usuario

#### 4. Pantallas a adaptar/crear
- **Login** — formulario simple, validar contra `usuarios` con MD5
- **Mesas** — listar mesas, mostrar cuáles tienen comanda abierta
- **Comanda** — categorías + productos + botones +/-, enviar inserta en `comandas`

#### 5. Pantallas de fastfod que NO se necesitan
- Dashboard (ventas, gráficas)
- Clientes
- Reportes
- Configuraciones de impresora
- Gestión de usuarios/productos/categorías (eso lo hace RESOL)

---

## Archivos clave de fastfod

```
app/Http/Livewire/Sales.php        ← lógica del carrito (base para comandas)
app/Http/Livewire/Categories.php   ← listado de categorías
app/Models/Product.php             ← modelo de productos
app/Models/Order.php               ← modelo de órdenes → adaptar a comandas
app/Traits/CartTrait.php           ← lógica de carrito (reutilizable)
resources/views/livewire/sales/    ← vistas del POS (base para la UI)
routes/web.php                     ← rutas de la app
.env                               ← configurar BD aquí
```

---

## Instalación inicial

Antes de levantar el servidor por primera vez, instalar las dependencias de PHP:

```bash
composer install
```

> Si `composer` no está instalado, descargarlo desde https://getcomposer.org/download/
> Laragon incluye Composer — verificar que esté en el PATH.

Luego levantar el servidor:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## Notas importantes

- **No correr `php artisan migrate`** en la BD de RESOL — las tablas ya existen
  y migrar podría romper datos de producción.
- **No modificar** la estructura de tablas de RESOL.
- Laragon ya tiene PHP y MySQL configurados — el proyecto corre con
  `php artisan serve` o directamente desde el virtualhost de Laragon.
- La app debe ser **simple y rápida** en tablet/celular — no agregar
  funcionalidades extra más allá de lo necesario para ingresar comandas.
