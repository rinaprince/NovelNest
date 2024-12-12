<script setup>
import { ref } from 'vue';

// Reactive state to track the selected option
const selectedType = ref('');
</script>

<template>
  <div>
    <!-- Radio buttons for selecting type -->
    <div>
      <label>
        <input type="radio" name="type" value="digital" v-model="selectedType" /> Digital
      </label>
      <label>
        <input type="radio" name="type" value="fisico" v-model="selectedType" /> Físico
      </label>
    </div>

    <!-- Dynamic form based on selected type -->
    <div v-if="selectedType === 'digital'">
      <h3>Formulario para Digital</h3>
      <form>
        <div>
          <label for="digital-link">Enlace:</label>
          <input id="digital-link" type="url" placeholder="Introduce el enlace" />
        </div>
        <div>
          <label for="digital-format">Formato:</label>
          <select id="digital-format">
            <option value="pdf">PDF</option>
            <option value="epub">EPUB</option>
            <option value="mobi">MOBI</option>
          </select>
        </div>
      </form>
    </div>

    <div v-else-if="selectedType === 'fisico'">
      <h3>Formulario para Físico</h3>
      <form>
        <div>
          <label for="physical-weight">Peso:</label>
          <input id="physical-weight" type="number" placeholder="Introduce el peso en gramos" />
        </div>
        <div>
          <label for="physical-dimensions">Dimensiones:</label>
          <input id="physical-dimensions" type="text" placeholder="Ej: 20x30x5 cm" />
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
</style>