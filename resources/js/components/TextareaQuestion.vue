<template>
  <div class="question p-4 mb-4">
    <h3 class="mb-3">Question 1: What sources are you using when creating a new color palette?</h3>
    <textarea class="form-control" v-model="response" @input="handleInput" rows="4"></textarea>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { questionsConfig } from '../const'

export default {
  props: {
    answers: Array,
  },
  setup(props, { emit }) {
    const response = ref('');

    onMounted(() => {
      const prevResponse = props.answers[questionsConfig.textarea.index]
      if (prevResponse) response.value = prevResponse
      nextStepHandlerEffect()
    });

    const handleInput = (event) => {
      const newResponse = event.target.value;
      response.value = newResponse;
      emit('dataUpdate', newResponse);
      nextStepHandlerEffect()
    };

    
    function nextStepHandlerEffect() {      
      if (!response.value.length) emit('forbidNext')
      else emit('allowNext')
    }

    return {
      response,
      handleInput,
    };
  },
};
</script>

<style scoped>
.question {
  border: 1px solid #ccc;
  border-radius: 0.25rem;
  padding: 1rem;
  margin-bottom: 1rem;
}
</style>
