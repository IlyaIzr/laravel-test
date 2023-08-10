<template>
  <div class="wizard">
    <div class="step mb-4">
      <component :is="currentQuestionComponent" :answers="answers" @dataUpdate="dataUpdate" @allowNext="allowNext"
        @forbidNext="forbidNext" />
    </div>
    <div class="actions">
      <button @click="prevStep" :disabled="currentStep === 0" class="btn btn-secondary me-2">Previous</button>
      <template v-if="currentStep < questionComponents.length - 1">
        <button @click="nextStep" class="btn btn-primary" :disabled="!nextStepAllowed">Next</button>
      </template>
      <template v-else>
        <button @click="finishSurvey" class="btn btn-success">Finish</button>
      </template>
    </div>
  </div>
</template>


<script>
import { ref, shallowRef, watch } from 'vue';
import { colorRemovedAction, questionsConfig } from '../const';

export default {
  props: {
    currentStep: Number,
    answers: Array,
    questionComponents: Array,
  },
  setup(props, { emit }) {
    const nextStepAllowed = ref(true)
    const currentQuestionComponent = shallowRef(props.questionComponents[0]);

    const allowNext = () => nextStepAllowed.value = true
    const forbidNext = () => nextStepAllowed.value = false

    watch(
      () => props.currentStep,
      (newStep) => {
        currentQuestionComponent.value = props.questionComponents[newStep];
      }
    );

    const nextStep = () => emit('nextStep');
    const prevStep = () => emit('prevStep');
    const finishSurvey = () => emit('finishSurvey');
    const dataUpdate = (data, action, payload) => {
      props.answers[props.currentStep] = data
      if (action === colorRemovedAction) {
        const ratedColors = props.answers[questionsConfig.rate.index]
        if (ratedColors) delete ratedColors[payload]
      }
    }

    return {
      currentQuestionComponent,
      nextStep,
      prevStep,
      finishSurvey,
      dataUpdate,
      allowNext,
      forbidNext,
      nextStepAllowed
    };
  },
};
</script>
