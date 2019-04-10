require('bootstrap');
require('./../css/admin.scss');
import Vue from 'vue';
import Example from './../../../templates/admin/dashboard/example';
import './../../../public/bundles/disjfamedia/js/media';

new Vue({
  el: '#base',
  components: {
    Example
  }
});
