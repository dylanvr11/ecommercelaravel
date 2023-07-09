import './bootstrap'
import { createApp } from 'vue'
import vSelect from 'vue-select'

// Components --------------------------------------------------
import ProductsList from './components/Products/Index.vue'
import CategoriesList from './components/Categories/Index.vue'
import CartsList from './components/Carts/Index.vue'
import UsersList from './components/Users/Index.vue'
const app = createApp({
	components: {
		UsersList,
		ProductsList,
		CategoriesList,
		CartsList
	}
})

app.component('v-select', vSelect)
app.mount('#app')
