require('bootstrap');
require('./../css/site.scss');
import Vue from 'vue';
import store from './store';
// import a component from a bundle, when needed
import Timetable from '../../../public/bundles/disjfatimetable/js/Timetable.vue';
import TheMap from '../../../public/bundles/disjfamaps/vue/components/TheMap.vue';

new Vue({
  el: '#base',
  store,
  components: {
    // connect component
    Timetable,
    TheMap
  }
});

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js').then(registration => {
      console.log('SW registered: ', registration);
    }).catch(registrationError => {
      console.log('SW registration failed: ', registrationError);
    });
  });
}
