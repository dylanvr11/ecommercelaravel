import './bootstrap'
import { createApp } from 'vue'
import vSelect from 'vue-select'

// Components --------------------------------------------------
import ExampleComponent from './components/ExampleComponent.vue'
import ProductsList from './components/Products/Index.vue'
const app = createApp({
	components: {
		ExampleComponent,
		ProductsList
	}
})

app.component('v-select', vSelect)
app.mount('#app')
