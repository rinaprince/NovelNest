<template>
  <div v-if="showModal" class="modal-backdrop">
    <div class="modal">
      <h2>Bienvenido/a a NovelNest</h2>
      <p>¡Esperamos que disfrutes de nuestra plataforma!</p>
      <button @click="closeModal">Cerrar</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const showModal = ref(false);

onMounted(() => {
  // Mostrar modal solo si no se ha mostrado previamente
  if (!localStorage.getItem('modalShown')) {
    showModal.value = true;
    localStorage.setItem('modalShown', 'true');
  }
});

const closeModal = () => {
  showModal.value = false;
};
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999; /* Asegura que esté sobre otros elementos */
}

.modal {
  background-color: #ffffff; /* Fondo blanco */
  padding: 30px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
  max-width: 90%; /* Ajuste para pantallas pequeñas */
  width: 400px; /* Ancho fijo */
  color: #000; /* Asegura que el texto sea negro */
}

.modal h2 {
  font-size: 1.8em;
  margin-bottom: 10px;
}

.modal p {
  font-size: 1.2em;
  margin-bottom: 20px;
}

button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #0056b3;
}
</style>