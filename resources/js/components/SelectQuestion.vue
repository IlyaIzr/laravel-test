<template>
  <div class="question p-4 mb-4">
    <h3 class="mb-3">Question 2: Choose colors you're using the most</h3>
    <div class="selected-colors">
      <div v-for="(color, key) in selectedColors" :key="key" class="selected-color">
        <span class="colorName">{{ colorOptions[color] }}</span>
        <span class="remove-color" @click="removeColor(color)"> ✕</span>
      </div>
    </div>
    <select class="form-select" v-model="selectedOption" @change="addColor">
      <option value="" disabled>Select a color</option>
      <option v-for="([key, label], index) in Object.entries(colorOptions).filter(e => !selectedColors.includes(e[0]))"
        :key="key" :value="key" :disabled="selectedColors.includes(key)">
        {{ label }}
      </option>
    </select>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { colorOptions, colorRemovedAction, questionsConfig } from '../const'

export default {
  props: {
    answers: Array,
  },
  setup(props, { emit }) {
    const selectedColors = ref([]);
    const selectedOption = ref('');

    onMounted(() => {
      // get prev answers stored in memory
      props.answers[questionsConfig.select.index]?.forEach((color) => {
        selectedColors.value.push(color);
      });
      nextStepHandlerEffect()
    });

    const addColor = () => {
      if (selectedOption.value && !selectedColors.value.includes(selectedOption.value)) {
        selectedColors.value.push(selectedOption.value);
        selectedOption.value = '';
        emit('dataUpdate', selectedColors.value);
        nextStepHandlerEffect()
      }
    };

    const removeColor = (colorKey) => {
      selectedColors.value = selectedColors.value.filter((color) => color !== colorKey);
      emit('dataUpdate', selectedColors.value, colorRemovedAction, colorKey);
      nextStepHandlerEffect()
    };

    function nextStepHandlerEffect() {      
      if (!selectedColors.value.length) emit('forbidNext')
      else emit('allowNext')
    }

    return {
      selectedColors,
      selectedOption,
      colorOptions,
      addColor,
      removeColor,
    };
  },
};
</script>

<style scoped>
.selected-colors {
  display: flex;
  flex-wrap: wrap;
  margin-bottom: 1rem;
}

.selected-color {
  display: inline-block;
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 0.25rem 0.5rem;
  margin-right: 0.5rem;
  margin-bottom: 0.5rem;
  position: relative;
  transition: .5s;
  cursor: default;
}

.remove-color {
  cursor: pointer;
}

.selected-color:hover {
  background-color: #e0e0e0;
}
</style>
