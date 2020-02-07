/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
import router from './router.js'
import utils from './helpers/utilities'
import ThemeSwitcher from './components/ThemeSwitcher'
import pagination from 'laravel-vue-pagination'
import { TableComponent, TableColumn } from 'vue-table-component'


require('./bootstrap')

// Added components by dev(James Budlong, 01-07-2020)

// For table pagination
Vue.component('pagination', pagination)
Vue.use(pagination)

// For tables
Vue.component('TableComponent', TableComponent)
Vue.use(TableComponent)
Vue.component('TableColumn', TableColumn)
Vue.use(TableColumn)

//For Graphs
import apexchart from 'vue-apexcharts'
Vue.component('apexchart', apexchart)
Vue.use(apexchart)


Vue.prototype.$utils = utils

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
  router,
  // Theme Swiching Demo Component (You can remove it if not required)
  components: {
	ThemeSwitcher,
	pagination,
	TableComponent,
	TableColumn
  }
}).$mount('#app')
