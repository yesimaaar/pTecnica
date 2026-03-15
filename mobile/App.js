import React, { useState, useEffect } from 'react';
import { 
  StyleSheet, Text, View, FlatList, 
  TouchableOpacity, ActivityIndicator, SafeAreaView, Alert 
} from 'react-native';

export default function App() {
  const [books, setBooks] = useState([]);
  const [loading, setLoading] = useState(true);

  // USA TU IP LOCAL (Ejem: 192.168.1.15)
  const API_URL = 'http://192.168.1.XX:8000/api/books';

  const fetchBooks = async () => {
    setLoading(true);
    try {
      const response = await fetch(API_URL);
      const data = await response.json();
      setBooks(data);
    } catch (error) {
      Alert.alert("Error", "No se pudo conectar con el servidor Symfony. Revisa la IP.");
      console.error(error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBooks();
  }, []);

  const renderItem = ({ item }) => (
    <View style={styles.card}>
      <View style={{ flex: 1 }}>
        <Text style={styles.title}>{item.title}</Text>
        <Text style={styles.author}>{item.author} ({item.published_year})</Text>
      </View>
      <View style={styles.badge}>
        <Text style={styles.badgeText}>⭐ {item.average_rating}</Text>
      </View>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.headerTitle}>Tide Lit Mobile</Text>
      </View>

      {loading ? (
        <ActivityIndicator size="large" color="#007AFF" style={{marginTop: 20}} />
      ) : (
        <FlatList
          data={books}
          keyExtractor={(item) => item.id.toString()}
          renderItem={renderItem}
          contentContainerStyle={{ padding: 15 }}
          onRefresh={fetchBooks}
          refreshing={loading}
        />
      )}

      <TouchableOpacity style={styles.btn} onPress={fetchBooks}>
        <Text style={styles.btnText}>🔄 Actualizar</Text>
      </TouchableOpacity>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f5f5f5' },
  header: { padding: 20, backgroundColor: '#fff', alignItems: 'center', borderBottomWidth: 1, borderBottomColor: '#ddd' },
  headerTitle: { fontSize: 20, fontWeight: 'bold' },
  card: { backgroundColor: '#fff', padding: 15, borderRadius: 10, marginBottom: 10, flexDirection: 'row', alignItems: 'center' },
  title: { fontSize: 16, fontWeight: 'bold' },
  author: { color: '#666' },
  badge: { backgroundColor: '#e3f2fd', padding: 8, borderRadius: 5 },
  badgeText: { color: '#007AFF', fontWeight: 'bold' },
  btn: { backgroundColor: '#007AFF', padding: 15, margin: 15, borderRadius: 8, alignItems: 'center' },
  btnText: { color: '#fff', fontWeight: 'bold' }
});