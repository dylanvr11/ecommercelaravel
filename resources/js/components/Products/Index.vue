<template>
	<div class="card mx-5 my-5">
		<div class="card-header d-flex justify-content-between">
			<h2>Productos</h2>
			<button @click="openModal" class="btn btn-primary">Crear Producto</button>
		</div>
		<div class="card-body">
			<section class="table-responsive" v-if="load">
				<table-component :products_data="products" />
			</section>

			<!-- load -->
			<section v-else class="d-flex justify-content-center my-3">
				<div class="spinner-border" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</section>
		</div>
		<section>
			<modal />
		</section>
	</div>
</template>

<script>
	import TableComponent from './Table.vue'
	import Modal from './Modal.vue'
	export default {
		props: [],
		components: {
			TableComponent,
			Modal
		},
		data() {
			return {
				products: [],
				load: false
			}
		},
		created() {
			this.index()
		},
		methods: {
			async index() {
				await this.getProducts()
			},
			async getProducts() {
				try {
					const { data } = await axios.get('/api/Products/GetAllProducts')
					this.products = data.products
					this.load = true
				} catch (error) {
					console.error(error)
				}
			},
			openModal() {}
		}
	}
</script>
