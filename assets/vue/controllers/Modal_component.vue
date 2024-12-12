<template>
  <div v-if="showModal" class="custom-modal-backdrop">
    <div class="custom-modal">
      <h2>Esta página web usa cookies</h2>
      <p>Las cookies de este sitio web se usan para personalizar el contenido y los anuncios, ofrecer funciones de redes sociales y analizar el tráfico. Además, compartimos información sobre el uso que haga del sitio web con nuestros partners de redes sociales, publicidad y análisis web, quienes pueden combinarla con otra información que les haya proporcionado o que hayan recopilado a partir del uso que haya hecho de sus servicios.</p>
      <button class="btn btn-secondary" @click="closeModal">Aceptar</button>
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
.custom-modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
}

.custom-modal {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  background-color: #ffffff;
  padding: 30px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  max-width: 100%;
  width: 50%;
  color: #000;
}
</style>