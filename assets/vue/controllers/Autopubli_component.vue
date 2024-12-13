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
            <input class="form-check-input" type="radio" name="type" value="digital" id="digital"
                   v-model="selectedType"/>
            <label class="form-check-label" for="digital">
              Digital
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="type" value="fisico" id="fisico" v-model="selectedType"/>
            <label class="form-check-label" for="fisico">
              Físico
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Opcions -->
    <div class="container pt-5">
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <div v-if="selectedType === 'digital'">
            <form>
              <div>
                <select class="form-select" id="digital-format">
                  <option selected>Elige un formato</option>
                  <option value="pdf">PDF</option>
                  <option value="epub">EPUB</option>
                  <option value="mobi">MOBI</option>
                </select>
              </div>
              <div class="pt-4">
                <label for="digital-link">¡Sube tu portada si la tienes!</label>
                <input class="form-control" id="digital-link" type="file" placeholder="Sube tu portada"/>
              </div>
              <div class="pt-4">
                <label for="physical-quantity">Cantidad:</label>
                <input class="form-control" id="physical-quantity" type="number"/>
              </div>
              <div class="pt-4">
                <label for="physical-quantity">Tipo de edición</label>
                <select class="form-select">
                  <option value="pdf">Inicial</option>
                  <option value="epub">Básica</option>
                  <option value="mobi">Intermedia</option>
                </select>
              </div>
            </form>
          </div>

          <form v-if="selectedType === 'fisico'">
            <div>
              <h4>Color de Interior</h4>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="interior-color" id="bn-superior" value="superior-bn" />
                <label class="form-check-label" for="bn-superior">
                  Superior en blanco y negro
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="interior-color" id="bn-estandar" value="estandar-bn" />
                <label class="form-check-label" for="bn-estandar">
                  Estándar en blanco y negro
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="interior-color" id="color-estandar" value="color-estandar" />
                <label class="form-check-label" for="color-estandar">
                  Color estándar
                </label>
              </div>
            </div>
            <div>
              <h4 class="mt-4">Tipo de Papel</h4>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="paper-type" id="paper-crema" value="crema" />
                <label class="form-check-label" for="paper-crema">
                  Crema
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="paper-type" id="paper-blanco" value="blanco" />
                <label class="form-check-label" for="paper-blanco">
                  Blanco
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="paper-type" id="paper-blanco-recubierto" value="blanco-recubierto" />
                <label class="form-check-label" for="paper-blanco-recubierto">
                  Blanco recubierto
                </label>
              </div>
            </div>
            <div>
              <h4 class="mt-4">Tipo de Encuadernación</h4>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="binding-type" id="softcover" value="softcover" />
                <label class="form-check-label" for="softcover">
                  Tapa blanda
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="binding-type" id="hardcover" value="hardcover" />
                <label class="form-check-label" for="hardcover">
                  Tapa dura
                </label>
              </div>
            </div>
            <div>
              <h4 class="mt-4">Acabado de la Portada</h4>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cover-finish" id="glossy" value="glossy" />
                <label class="form-check-label" for="glossy">
                  Brillante
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cover-finish" id="matte" value="matte" />
                <label class="form-check-label" for="matte">
                  Mate
                </label>
              </div>
            </div>
            <div class="pt-4">
              <label for="physical-quantity">Cantidad:</label>
              <input class="form-control" id="physical-quantity" type="number" placeholder="Introduce la cantidad" />
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
</template>

<style scoped>
</style>