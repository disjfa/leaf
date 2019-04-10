import Vue from 'vue';
import Vuex from 'vuex';
import timetable from './../../../../public/bundles/disjfatimetable/js/store/index';
import map from './../../../../public/bundles/disjfamaps/vue/store/index';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    timetable,
    map,
  },
  strict: debug,
});
