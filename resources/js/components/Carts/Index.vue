<template>
	<div class="card mx-5 my-5">
		<div class="card-header d-flex justify-content-between">
			<h2>Carrito de compra</h2>
		</div>
		<div class="card-body">
			<section @click="openModal">
				<modal />
			</section>
		</div>
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
				categories: [],
				load: false,
				load_modal: false,
				modal: null,
				category: null
			}
		},
		created() {
			this.index()
		},
		methods: {
			async index() {
				await this.getCategories()
			},
			async getCategories() {
				try {
					this.load = false
					const { data } = await axios.get('Categories/GetAllCategories')
					this.categories = data.categories
					this.load = true
				} catch (error) {
					console.error(error)
				}
			},
			openModal() {
				this.load_modal = true
				setTimeout(() => {
					this.modal = new bootstrap.Modal(document.getElementById('carts_modal'), {
						keyboard: false
					})
					this.modal.show()
					const modal = document.getElementById('carts_modal')
					modal.addEventListener('hidden.bs.modal', () => {
						console.log('hola')
						this.load_modal = false
						this.category = null
					})
				}, 200)
			},
			closeModal() {
				this.modal.hide()
				this.getCategories()
			},
			editCategory(category) {
				this.category = category
				this.openModal()
			}
		}
	}
</script>
