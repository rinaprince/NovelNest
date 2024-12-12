<template>
  <div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">{{ title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>{{ bodyText }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from 'vue';

const props = defineProps({
  title: String,
  bodyText: String
});

onMounted(() => {
  if (!localStorage.getItem('modalShown')) {
    const modalElement = document.getElementById('myModal');
    if (modalElement) {
      const myModal = new bootstrap.Modal(modalElement, {
        keyboard: false
      });
      myModal.show();
      localStorage.setItem('modalShown', 'true');
    }
  }
});
</script>