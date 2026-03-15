<template>
  <div class="app-container">
    <header class="main-header">
      <div class="header-text">
        <h1>Tide Lit <span class="badge">Web</span></h1>
        <p>Sistema de Gestión de Libros</p>
      </div>
      <button @click="fetchBooks" :disabled="loading" class="refresh-btn">
        {{ loading ? 'Cargando...' : '🔄 Actualizar Lista' }}
      </button>
    </header>

    <main class="content">
      <div v-if="loading" class="loader">
        <div class="spinner"></div>
        <p>Sincronizando con la API...</p>
      </div>
      
      <div v-else class="book-list">
        <div v-for="book in books" :key="book.id" class="book-item">
          <div class="book-details">
            <h3>{{ book.title }}</h3>
            <p class="meta">{{ book.author }} • {{ book.published_year }}</p>
          </div>
          <div class="rating-box">
            <span class="star">⭐</span>
            <span class="score">{{ book.average_rating || 0 }}</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
// Importamos los datos desde tu archivo externo
import { mockBooks } from './mockbooks'; 

const books = ref([]);
const loading = ref(false);

const fetchBooks = () => {
  loading.value = true;
  // Simulación de carga (GET /api/books)
  setTimeout(() => {
    books.value = mockBooks;
    loading.value = false;
  }, 600);
};

onMounted(fetchBooks);
</script>

<style scoped>
.app-container { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 900px; margin: 0 auto; padding: 40px 20px; color: #333; }
.main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
.badge { background: #42b983; color: white; font-size: 0.7rem; padding: 3px 8px; border-radius: 10px; vertical-align: middle; }
.refresh-btn { background-color: #007bff; color: white; border: none; padding: 12px 24px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; }
.refresh-btn:hover { background-color: #0056b3; }
.book-item { display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fff; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
.book-details h3 { margin: 0 0 5px 0; color: #1a1a1a; }
.meta { margin: 0; color: #666; font-size: 0.9rem; }
.rating-box { background: #f0f7ff; padding: 10px 15px; border-radius: 8px; display: flex; align-items: center; gap: 8px; }
.score { font-weight: bold; color: #007bff; font-size: 1.1rem; }
</style>