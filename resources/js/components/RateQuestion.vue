<template>
  <div class="question p-4 mb-4">
    <h3 class="mb-3">Question 3: Rate each color</h3>
    <div v-for="(color, index) in selectedColors" :key="color">
      <div class="color-rating">
        <span class="color-name">{{ color }}</span>
        <select class="form-select" v-model="colorRates[color]" @change="updateRates">
          <option v-for="rating in 5" :key="rating" :value="rating">{{ rating }}</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { questionsConfig, defaultColorRating } from '../const'

export default {
  props: {
    answers: Array,
  },
  setup(props, { emit }) {
    const selectedColors = props.answers[questionsConfig.select.index];
    const prevRates = props.answers[questionsConfig.rate.index];
    const colorRates = ref({});

    onMounted(() => {
      // Define which colors to set
      selectedColors.forEach((color) => {
        colorRates.value[color] = defaultColorRating;
      });
      // Restore previous rates
      if (prevRates) for (const color in prevRates) {
        const rate = prevRates[color]
        colorRates.value[color] = rate
      }
    });

    const updateRates = () => {
      emit('dataUpdate', colorRates.value); // Emit the updated color rates
    };

    return {
      selectedColors,
      colorRates,
      updateRates,
    };
  },
};
</script>

<style scoped>
.color-rating {
  margin-bottom: 1rem;
}
</style>
