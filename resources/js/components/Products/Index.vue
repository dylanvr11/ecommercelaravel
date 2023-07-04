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
		<section v-if="load_modal">
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
				load: false,
				load_modal: false,
				modal: null
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
					this.load = false
					const { data } = await axios.get('/api/Products/GetAllProducts')
					this.products = data.products
					this.load = true
				} catch (error) {
					console.error(error)
				}
			},
			openModal() {
				this.load_modal = true
				setTimeout(() => {
					this.modal = new bootstrap.Modal(document.getElementById('product_modal'), {
						keyboard: false
					})
					this.modal.show()
					const modal = document.getElementById('product_modal')
					modal.addEventListener('hidden.bs.modal', () => {
						console.log('hola')
						this.load_modal = false
					})
				}, 200)
			},
			closeModal() {
				this.modal.hide()
				this.getProducts()
			}
		}
	}
</script>
