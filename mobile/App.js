import React, { useState, useEffect } from 'react';
import { 
  StyleSheet, Text, View, FlatList, 
  TouchableOpacity, ActivityIndicator, SafeAreaView 
} from 'react-native';

// Importamos tus datos mock para desarrollo
// Nota: Para el video final, cambia mockBooks por la respuesta de fetch('http://TU_IP:8000/api/books')
import { mockBooks } from './mockbooks'; 

export default function App() {
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchBooks = async () => {
    setLoading(true);
    try {
      // Simulación de consumo de API (GET /api/books) [cite: 108]
      // Reemplazar por fetch real al conectar con el backend Symfony
      await new Promise(resolve => setTimeout(resolve, 800)); 
      setBooks(mockBooks);
    } catch (error) {
      console.error("Error cargando libros:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBooks();
  }, []);

  const renderItem = ({ item }) => (
    <View style={styles.card}>
      <View style={styles.cardHeader}>
        <Text style={styles.title}>{item.title}</Text>
        <View style={styles.ratingBadge}>
          <Text style={styles.ratingText}>⭐ {item.average_rating || 0}</Text>
        </View>
      </View>
      <Text style={styles.author}>👤 {item.author}</Text>
      <Text style={styles.year}>📅 {item.published_year}</Text>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.headerText}>Tide Lit Mobile</Text>
      </View>

      {loading ? (
        <ActivityIndicator size="large" color="#007AFF" style={{ marginTop: 50 }} />
      ) : (
        <FlatList
          data={books}
          keyExtractor={(item) => item.id.toString()}
          renderItem={renderItem}
          contentContainerStyle={styles.list}
          onRefresh={fetchBooks}
          refreshing={loading}
        />
      )}

      <TouchableOpacity style={styles.refreshButton} onPress={fetchBooks}>
        <Text style={styles.buttonText}>🔄 Actualizar Catálogo</Text>
      </TouchableOpacity>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f8f9fa' },
  header: { padding: 20, backgroundColor: '#fff', alignItems: 'center', borderBottomWidth: 1, borderBottomColor: '#eee' },
  headerText: { fontSize: 20, fontWeight: 'bold', color: '#2c3e50' },
  list: { padding: 15 },
  card: { backgroundColor: '#fff', padding: 15, borderRadius: 10, marginBottom: 15, elevation: 3 },
  cardHeader: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 5 },
  title: { fontSize: 17, fontWeight: 'bold', flex: 1, marginRight: 10 },
  author: { color: '#666', fontSize: 14, marginBottom: 2 },
  year: { color: '#999', fontSize: 12 },
  ratingBadge: { backgroundColor: '#e7f3ff', paddingHorizontal: 8, paddingVertical: 4, borderRadius: 5 },
  ratingText: { color: '#007AFF', fontWeight: 'bold' },
  refreshButton: { backgroundColor: '#007AFF', margin: 20, padding: 15, borderRadius: 8, alignItems: 'center' },
  buttonText: { color: '#fff', fontWeight: 'bold' }
});