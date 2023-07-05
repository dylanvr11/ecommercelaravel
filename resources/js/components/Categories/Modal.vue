<template>
	<div class="modal fade" id="category_modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						{{ `${is_create ? 'Crear' : 'Actualizar'} Categoria` }}
					</h5>
					<button
						type="button"
						class="btn-close"
						data-bs-dismiss="modal"
						aria-label="Close"
					></button>
				</div>
				<div class="modal-body">
					<form @submit.prevent="storeCategory" enctype="multipart/form-data">
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input
								type="text"
								class="form-control"
								id="name"
								v-model="category.name"
							/>
						</div>
						<hr />
						<section class="d-flex justify-contend-end mt-3">
							<button
								type="button"
								class="btn btn-secondary me-1"
								data-bs-dismiss="modal"
							>
								Close
							</button>
							<button type="submit" class="btn btn-primary me-1">
								{{ `${is_create ? 'Crear' : 'Actualizar'}` }}
							</button>
						</section>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['category_data'],
		data() {
			return {
				is_create: true,
				categories: [],
				category: {}
			}
		},
		created() {
			this.index()
		},
		methods: {
			index() {
				this.getCategories()
				this.setCategory()
			},
			setCategory() {
				if (!this.category_data) return
				this.category = { ...this.category_data }
				this.is_create = false
			},
			loadFormData() {
				const form_data = new FormData()
				form_data.append('name', this.category.name)
				return form_data
			},
			async getCategories() {
				const { data } = await axios.get('Categories/GetAllCategories')
				this.categories = data.categories
			},
			async storeCategory() {
				try {
					const category = this.loadFormData()
					if (this.is_create) {
						//console.log(this.book)
						await axios.post('Categories/SaveCategory', category)
					} else {
						await axios.post(`Categories/UpdateCategory/${this.category.id}`, category)
					}
					swal.fire({
						icon: 'success',
						title: 'Felicidades!',
						text: 'Categoria almacenado!'
					})
					this.$parent.closeModal()
				} catch (error) {
					console.error(error)
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Algo salio mal!'
					})
				}
			}
		}
	}
</script>
