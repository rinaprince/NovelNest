<script>

import { onMounted, watch } from 'vue';
import { prepareChartData, renderChart } from '../../js/chart-utils.js';

const props = defineProps(['users']);

onMounted(() => {
  if (props.users.length > 0) {
    const chartData = prepareChartData(props.users);
    renderChart(chartData);
  }
});

watch(
    () => props.users,
    (newUsers) => {
      if (newUsers.length > 0) {
        const chartData = prepareChartData(newUsers);
        renderChart(chartData);
      }
    }
);
</script>

<template>
  <div class="container">
    <div class="row">

      <div class="col-12">
        <div class="d-flex justify-content-center">
          <canvas id="userChart" class="my-4 tamano"></canvas>
        </div>
      </div>

      <div class="col-12">
        <table class="table table-hover text-center">
          <thead class="table-danger">
          <tr>
            <th>Id</th>
            <th>Nombre de usuario</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Roles</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="users.length === 0">
            <td colspan="2">No se ha encontrado nada.</td>
          </tr>
          <tr v-else v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.nomUsuari }}</td>
            <td>{{ user.nom }}</td>
            <td>{{ user.cognom }}</td>
            <td>{{ user.correu }}</td>
            <td>{{ user.rols.join(', ') }}</td>
            <td class="d-flex">
              <a class="btn btn-success me-1" :href="`/user/show/${user.id}`"><i class="bi bi-eye"></i></a>
              <a class="btn btn-primary me-1" :href="`/user/edit/${user.id}`"><i class="bi bi-pencil-square"></i></a>
              <button class="btn btn-danger me-1" @click="deleteUser(user.id)"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>