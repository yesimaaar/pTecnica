<template>
  <div class="dashboard-container">
    <header class="app-header">
      <div class="header-content">
        <h1>Tide Lit <span class="badge">Prueba Técnica</span></h1>
        <p>Sistema de Gestión de Libros y Reseñas</p>
      </div>
    </header>

    <div class="main-layout">
      <aside class="sidebar">
        <div class="card form-card">
          <div class="card-header">
            <h3>📝 Nueva Reseña</h3>
          </div>
          <form @submit.prevent="simulatePost" class="review-form">
            <div class="form-group">
              <label>Libro</label>
              <select v-model="newReview.book_id" required>
                <option :value="null" disabled>Selecciona un libro...</option>
                <option v-for="book in books" :key="book.id" :value="book.id">
                  {{ book.title }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label>Calificación (1-5)</label>
              <div class="rating-input">
                <input v-model.number="newReview.rating" type="range" min="1" max="5" step="1">
                <span class="rating-display">⭐ {{ newReview.rating }}</span>
              </div>
            </div>

            <div class="form-group">
              <label>Comentario</label>
              <textarea v-model="newReview.comment" required placeholder="Escribe tu opinión..."></textarea>
            </div>

            <button type="submit" class="btn-primary">Registrar Reseña</button>
          </form>
        </div>
      </aside>

      <section class="content">
        <div class="card table-card">
          <div class="card-header flex-header">
            <h3>📚 Catálogo de Libros</h3>
            <button @click="loadMockData" class="btn-refresh" :class="{ 'spinning': loading }">
              🔄 Actualizar
            </button>
          </div>

          <div class="table-responsive">
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Libro</th>
                  <th>Autor</th>
                  <th>Año</th>
                  <th>Promedio</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="book in books" :key="book.id">
                  <td class="bold">{{ book.title }}</td>
                  <td>{{ book.author }}</td>
                  <td class="text-center">{{ book.published_year }}</td>
                  <td class="text-center">
                    <span class="rating-pill">⭐ {{ book.average_rating }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const mockBooks = [
  { id: 1, title: "El Arte de Programar", author: "Donald Knuth", published_year: 1968, average_rating: 4.5 },
  { id: 2, title: "Clean Code", author: "Robert C. Martin", published_year: 2008, average_rating: 4.8 },
  { id: 3, title: "Refactoring", author: "Martin Fowler", published_year: 1999, average_rating: 4.7 }
];

const books = ref([]);
const loading = ref(true);
const newReview = ref({ book_id: null, rating: 5, comment: '' });

const loadMockData = () => {
  loading.value = true;
  setTimeout(() => {
    books.value = [...mockBooks];
    loading.value = false;
  }, 600);
};

const simulatePost = () => {
  alert(`POST enviado: Reseña para el libro ID ${newReview.value.book_id}`);
  newReview.value = { book_id: null, rating: 5, comment: '' };
};

onMounted(loadMockData);
</script>

<style scoped>
/* Layout Base */
.dashboard-container { min-height: 100vh; background-color: #f0f2f5; color: #1c1e21; padding: 20px; font-family: system-ui, -apple-system, sans-serif; }
.app-header { margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 20px; text-align: center; background: white; margin: -20px -20px 30px -20px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.header-content h1 { margin: 0; font-size: 2rem; color: #1a1a1a; }
.header-content p { margin: 5px 0 0; color: #666; }
.badge { background: #42b983; color: white; font-size: 0.8rem; padding: 4px 10px; border-radius: 12px; vertical-align: middle; margin-left: 10px; }

.main-layout { display: grid; grid-template-columns: 320px 1fr; gap: 25px; max-width: 1200px; margin: 0 auto; }

/* Tarjetas */
.card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e1e4e8; }
.card-header { padding: 15px 20px; border-bottom: 1px solid #f0f2f5; background: #fafbfc; }
.flex-header { display: flex; justify-content: space-between; align-items: center; }

/* Formulario */
.review-form { padding: 20px; }
.form-group { margin-bottom: 20px; }
label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; }
select, textarea, input[type="range"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
textarea { height: 100px; resize: none; }
.rating-input { display: flex; align-items: center; gap: 10px; }
.btn-primary { width: 100%; background: #007bff; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
.btn-primary:hover { background: #0056b3; }

/* Tabla */
.styled-table { width: 100%; border-collapse: collapse; }
.styled-table th { background: #f8f9fa; padding: 15px; text-align: left; font-size: 0.85rem; color: #65676b; }
.styled-table td { padding: 15px; border-bottom: 1px solid #f0f2f5; }
.bold { font-weight: 600; color: #050505; }
.rating-pill { background: #e7f3ff; color: #1877f2; padding: 4px 10px; border-radius: 20px; font-weight: bold; font-size: 0.9rem; }

/* Botones y Animaciones */
.btn-refresh { background: none; border: 1px solid #ddd; padding: 5px 15px; border-radius: 6px; cursor: pointer; }
.spinning { animation: spin 1s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

/* Responsividad */
@media (max-width: 850px) {
  .main-layout { grid-template-columns: 1fr; }
}
</style>