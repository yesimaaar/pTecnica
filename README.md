# Prueba Técnica — Symfony 6 + Vue 3 + React Native

Sistema de gestión de libros y reseñas con API REST en Symfony 6, frontend web en Vue 3 y frontend mobile en React Native (Expo).

---

## Requisitos

| Herramienta | Versión mínima |
|---|---|
| PHP |
| Composer |
| Node.js | 18+ |
| npm | 9+ |
| PostgreSQL | 14+ |
| Expo CLI | Última estable |
| Symfony CLI | Última estable |

---

## Instalación — Backend (Symfony 6)

### 1. Clonar el repositorio

```bash
git clone (https://github.com/yesimaaar/pTecnica.git)
cd tu-repo
```

### 2. Configurar variables de entorno

Edita el archivo `.env` y configura la conexión a PostgreSQL:

```env
DATABASE_URL="postgresql://postgres:pTecnica@localhost:5432/biblioteca?serverVersion=16"
APP_ENV=dev
APP_SECRET=
```

### 3. Instalar dependencias PHP

```bash
composer install
```

### 4. Crear la base de datos

```bash
php bin/console doctrine:database:create
```

### 5. Ejecutar migraciones

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

### 6. Cargar fixtures (datos iniciales)

```bash
php bin/console doctrine:fixtures:load --no-interaction
```

### 7. Levantar el servidor

```bash
symfony serve --start
```

La API estará disponible en: (https://127.0.0.1:8000)`

---

## Instalación — Frontend Web (Vue 3)

```bash
cd frontend
npm install
npm run dev
```

La app Vue estará disponible en: `http://localhost:5173`

> Asegúrate de tener el backend corriendo antes de abrir el frontend.

---

## Instalación — Frontend Mobile (React Native / Expo)

```bash
cd mobile
npm install
expo start
```

## Endpoints

### GET /App/books

Devuelve la lista de libros con el promedio de rating calculado con `AVG()` en una consulta Doctrine eficiente.

**Ejemplo de respuesta:**

```json
[
  {
    "title": "El Arte de Programar",
    "author": "Donald Knuth",
    "published_year": 1968,
    "average_rating": 4.5
  },
  {
    "title": "Clean Code",
    "author": "Robert C. Martin",
    "published_year": 2008,
    "average_rating": 3.67
  },
  {
    "title": "Refactoring",
    "author": "Martin Fowler",
    "published_year": 1999,
    "average_rating": null
  }
]
```

**Decisión técnica:** Si un libro no tiene reseñas, `average_rating` retorna `null` (no `0`) para distinguir entre "sin calificaciones" y "calificación cero". El frontend lo maneja mostrando "Sin reseñas".

**Curl de ejemplo:**

```bash
curl http://localhost:8000/App/books
```

---

### POST /App/reviews

Registra una nueva reseña para un libro existente.

**Request body (JSON):**

```json
{
  "book_id": 1,
  "rating": 5,
  "comment": "Excelente libro, fundamental para cualquier programador"
}
```

**Respuesta exitosa (201 Created):**

```json
{
  "id": 7,
  "book_id": 1,
  "rating": 5,
  "comment": "Excelente libro, fundamental para cualquier programador",
  "created_at": "2024-03-14 12:00:00"
}
```

**Curl de ejemplo:**

```bash
curl -X POST http://localhost:8000/App/reviews \
  -H "Content-Type: application/json" \
  -d '{"book_id": 1, "rating": 5, "comment": "Excelente libro"}'
```

## ¿Qué cambiarías para escalar a cientos de miles de libros y usuarios?

Para escalar esta aplicación implementaría mejoras en varias capas. En la base de datos, agregaría índices en los campos más consultados (`book_id` en reviews, `author` y `title` en books) y paginación obligatoria en `GET /api/books` para no cargar miles de registros en una sola respuesta. El `average_rating` lo almacenaría como campo desnormalizado en la entidad `Book`, actualizándolo de forma asíncrona con Symfony Messenger cada vez que se crea una reseña, eliminando el `AVG()` en caliente.

Para caché, usaría Redis para almacenar la lista de libros con un TTL corto (30–60 segundos), ya que es el endpoint más consultado y cambia con poca frecuencia. En infraestructura, separaría el servidor de la API del servidor de base de datos, pondría un load balancer frente a múltiples instancias de Symfony y usaría un CDN para los assets del frontend. Finalmente, agregaría rate limiting por IP en los endpoints de escritura para proteger contra abusos, y un sistema de monitoreo con Sentry para errores y métricas de rendimiento para detectar cuellos de botella en producción antes de que impacten a los usuarios.

---

## Video evidencia

🎥 **Link al video:** [Ver en Google Drive](https://drive.google.com/drive/folders/13jZROOaeW6zErwxMvPBMT0UF1tE3fql-?usp=sharing)

El video muestra:
- Backend Symfony corriendo y la API respondiendo correctamente
- Frontend Vue 3 listando libros con su `average_rating`
- Frontend React Native (Expo) mostrando la misma lista en mobile
- POST de reseña vía Postman y refresco de la lista

---

## Branch y commit evaluado

- **Branch:** `dev`
- **Commit final:** *(reemplaza con el hash — ejecuta `git log --oneline -1`)*
