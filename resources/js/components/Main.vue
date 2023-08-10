<template>
  <div class="container mt-5">
    <div v-if="status === 'intro'">
      <div class="card">
        <div class="card-header">Survey</div>
        <div class="card-body">
          <p>We'd like to ask you several questions.</p>
          <button class="btn btn-primary" @click="startSurvey">Start survey</button>
        </div>
      </div>
    </div>
    <div v-else-if="status === 'inProgress'">
      <Wizard :currentStep="currentStep" :answers="answers" :questionComponents="questionComponents" @nextStep="nextStep"
        @prevStep="prevStep" @finishSurvey="finishSurvey" />
    </div>
    <div v-else-if="status === 'finished'">
      <SurveyFinished :status="requestStatus"/>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import Wizard from './Wizard.vue';
import SurveyFinished from './SurveyFinished.vue';
import { questionComponents } from '../const';

export default {
  components: {
    Wizard,
    SurveyFinished,
  },
  setup() {
    const status = ref('intro'); // 'intro' | 'inProgress' | 'finished'
    const requestStatus = ref('') // '' | 'loading' | 'success' | 'error'
    const currentStep = ref(0); // 0 | 1 | 2
    const answers = ref([]); // array of answers

    const startSurvey = () => {
      status.value = 'inProgress';
    };

    const finishSurvey = () => {
      status.value = 'finished';
      const results = answers.value

      requestStatus.value = 'loading'
      axios.post('/api/submit-survey', { results }) // Replace with your Laravel API endpoint
        .then(response => {
          console.log('Survey submitted successfully:', response.data);
          requestStatus.value = 'success'
        })
        .catch(error => {
          console.error('Error submitting survey:', error);          
          requestStatus.value = 'error'
        });
    };

    const nextStep = () => {
      currentStep.value += 1;
    };

    const prevStep = () => {
      currentStep.value -= 1;
    };

    return {
      status,
      requestStatus,
      currentStep,
      answers,
      startSurvey,
      finishSurvey,
      questionComponents,
      nextStep,
      prevStep
    };
  },
};
</script>
