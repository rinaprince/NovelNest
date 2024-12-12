<script setup>
import {ref} from 'vue';

// Reactive state to track the selected option
const selectedType = ref('');
</script>

<template>
  <div>
    <!-- Elegir -->
    <div class="container">
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <div class="form-check pe-5">
            <input class="form-check-input" type="radio" name="type" value="digital" id="digital" v-model="selectedType" />
            <label class="form-check-label" for="digital">
              Digital
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="type" value="fisico" id="fisico" v-model="selectedType" />
            <label class="form-check-label" for="fisico">
              Físico
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Opcions -->
    <div class="container">
      <div class="row">
    <div v-if="selectedType === 'digital'">
      <form>
        <div class="col-6">
          <select class="form-select" id="digital-format">
            <option selected>Elige un formato</option>
            <option value="pdf">PDF</option>
            <option value="epub">EPUB</option>
            <option value="mobi">MOBI</option>
          </select>
        </div>
        <div class="col-6">
          <label for="digital-link">Portada:</label>
          <input id="digital-link" type="url" placeholder="Sube tu portada"/>
        </div>
      </form>
    </div>

    <div v-else-if="selectedType === 'fisico'">
      <form>
        <div>
          <label for="physical-weight">Peso:</label>
          <input id="physical-weight" type="number" placeholder="Introduce el peso en gramos"/>
        </div>
        <div>
          <label for="physical-dimensions">Dimensiones:</label>
          <input id="physical-dimensions" type="text" placeholder="Ej: 20x30x5 cm"/>
        </div>
      </form>
    </div>
  </div>
    </div>
  </div>
</template>

<style scoped>
</style>