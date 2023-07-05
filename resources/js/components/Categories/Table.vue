<template>
	<table class="table">
		<thead>
			<tr>
				<th>Nombre</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(category, index) in categories" :key="index">
				<th>{{ category.name }}</th>
				<td>
					<button class="btn btn-warning me-2" @click="getCategory(category)">
						Editar
					</button>
					<button class="btn btn-danger" @click="deleteCategory(category)">
						Eliminar
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	export default {
		props: ['categories_data'],
		//components: {},
		data() {
			return {
				categories: []
			}
		},
		created() {
			this.index()
		},
		methods: {
			index() {
				// this.products = this.products_data
				this.categories = [...this.categories_data]
			},
			async getCategory(category) {
				try {
					//const { data } = await axios.get(`Products/GetAProduct/${product_id}`)
					// this.$parent.product = data.product
					this.$parent.editCategory(category)
				} catch (error) {
					console.error(error)
				}
			},
			async deleteCategory(category) {
				try {
					const result = await swal.fire({
						icon: 'info',
						title: 'Quiere eliminar el libro?',
						showCancelButton: true,
						confirmButtonText: 'Eliminar'
					})
					if (!result.isConfirmed) return
					await axios.delete(`Categories/DeleteACategory/${category.id}`)
					this.$parent.getCategories()
					swal.fire({
						icon: 'success',
						title: 'Felicitaciones!',
						text: 'Libro Eliminado!'
					})
				} catch (error) {
					console.error(error)
				}
			}
		}
	}
</script>
