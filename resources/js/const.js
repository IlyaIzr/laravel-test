
import TextareaQuestion from './components/TextareaQuestion.vue';
import SelectQuestion from './components/SelectQuestion.vue';
import RateQuestion from './components/RateQuestion.vue';

export const colorOptions = {
  red: 'Red',
  blue: 'Blue',
  green: 'Green',
  yellow: 'Yellow',
  wheat: 'Wheat',
  orange: 'Orange'
};

export const defaultColorRating = 1

export const questionsConfig = {
  textarea: { component: TextareaQuestion, index: 0 },
  select: { component: SelectQuestion, index: 1 },
  rate: { component: RateQuestion, index: 2 }
}
export const questionComponents = Object.values(questionsConfig)
  .sort((a, b) => a.index - b.index)
  .map((question) => question.component);

export const colorRemovedAction = 'colorRemoved'