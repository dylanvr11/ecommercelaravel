<template>
	<div class="card mx-5 my-5">
		<div class="card-header d-flex justify-content-between">
			<h2>Categorias</h2>
			<button @click="openModal" class="btn btn-primary">Crear Categoria</button>
		</div>
		<div class="card-body">
			<section class="table-responsive">
				<table-component ref="table" />
			</section>
		</div>
		<section v-if="load_modal">
			<modal :category_data="category" />
		</section>
	</div>
</template>

<script>
	import TableComponent from './Table.vue'
	import Modal from './Modal.vue'
	export default {
		components: {
			TableComponent,
			Modal
		},
		data() {
			return {
				load_modal: false,
				modal: null,
				category: null
			}
		},
		methods: {
			openModal() {
				this.load_modal = true
				setTimeout(() => {
					this.modal = new bootstrap.Modal(document.getElementById('category_modal'), {
						keyboard: false
					})
					this.modal.show()
					const modal = document.getElementById('category_modal')
					modal.addEventListener('hidden.bs.modal', () => {
						this.load_modal = false
						this.category = null
					})
				}, 200)
			},
			closeModal() {
				this.modal.hide()
				this.$refs.table.datatable.destroy()
				this.$refs.table.index()
			},
			editCategory(category) {
				this.category = category
				this.openModal()
			}
		}
	}
</script>
