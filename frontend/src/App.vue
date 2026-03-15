<template>
  <div class="app-container">
    <header class="main-header">
      <div class="header-text">
        <h1>Tide Lit <span class="badge">Web</span></h1>
        <p>Catálogo Real desde API Symfony</p>
      </div>
      <button @click="fetchBooks" :disabled="loading" class="refresh-btn">
        {{ loading ? 'Cargando...' : '🔄 Actualizar Lista' }}
      </button>
    </header>

    <main class="content">
      <div v-if="loading" class="loader">Cargando datos del servidor...</div>
      
      <div v-else class="book-list">
        <div v-for="book in books" :key="book.id" class="book-item">
          <div class="book-details">
            <h3>{{ book.title }}</h3>
            <p class="meta">{{ book.author }} • {{ book.published_year }}</p>
          </div>
          <div class="rating-box">
            <span class="star">⭐</span>
            <span class="score">{{ book.average_rating }}</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const books = ref([]);
const loading = ref(false);

const fetchBooks = async () => {
  loading.value = true;
  try {
    const response = await fetch('http://localhost:8000/api/books');
    if (!response.ok) throw new Error('Error en la API');
    books.value = await response.json();
  } catch (error) {
    console.error("Error:", error);
    alert("Error al conectar con el backend Symfony");
  } finally {
    loading.value = false;
  }
};

onMounted(fetchBooks);
</script>

<style scoped>
/* Mantén los mismos estilos que ya tenías */
.app-container { font-family: sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
.main-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 20px; }
.book-item { display: flex; justify-content: space-between; padding: 15px; background: #f9f9f9; margin-bottom: 10px; border-radius: 8px; }
.rating-box { font-weight: bold; color: #007bff; }
</style>