<template>
  <div class="container mt-5">
    <header class="text-center mb-5">
      <h1 class="display-4 fw-bold">📚 Librería Tidelit</h1>
      <p class="text-muted">Prueba Técnica: Consumo de Lista de Libros (GET)</p>
    </header>

    <div class="card shadow-lg border-0">
      <div class="card-header bg-dark text-white p-3">
        <h5 class="mb-0">Inventario Actualizado</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Título del Libro</th>
                <th>Autor</th>
                <th>Año de Publicación</th>
                <th class="text-center">Promedio de Rating</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="book in books" :key="book.id" class="align-middle">
                <td class="ps-4 fw-semibold">{{ book.title }}</td>
                <td>{{ book.author }}</td>
                <td>{{ book.published_year }}</td>
                <td class="text-center">
                  <span class="badge rounded-pill bg-warning text-dark px-3">
                    {{ book.rating }} ⭐
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <footer class="mt-4 text-center text-muted">
      <small>Visualización basada en los requerimientos del PDF de Tidelit</small>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { mockBooks } from './mockbooks';

const books = ref([]);

// Simulamos el consumo del endpoint GET /api/books
onMounted(() => {
  books.value = mockBooks;
});
</script>

<style>
body { background-color: #000000; }
.table thead th { border-top: none; }
</style>