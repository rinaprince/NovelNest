<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-center">
          <canvas id="userChart" class="my-4 tamano"></canvas>
        </div>
      </div>

      <div class="col-12">
        <table class="table table-hover text-center mt-4">
          <thead class="table-warning">
          <tr>
            <th>Nombre Completo</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="users.length === 0">
            <td colspan="2">No se ha encontrado nada.</td>
          </tr>
          <tr v-else v-for="user in users" :key="user.id">
            <td>{{ user.nom }} {{ user.cognom }}</td>
            <td>
              <a :href="userShowPath(user.id)" class="btn btn-success"><i class="bi bi-eye"></i></a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';

const props = defineProps(['users']);

const userShowPath = (id) => `/user/${id}`;

import { prepareChartData, renderChart } from '../../js/chart-utils.js';

onMounted(() => {
  if (props.users.length > 0) {
    const chartData = prepareChartData(props.users);
    renderChart(chartData);
  }
});

watch(() => props.users, (newUsers) => {
  if (newUsers.length > 0) {
    const chartData = prepareChartData(newUsers);
    renderChart(chartData);
  }
});

</script>