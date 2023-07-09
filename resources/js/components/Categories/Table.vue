<template>
	<table class="table" id="categoryTable" @click="getEvent">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</template>

<script>
	export default {
		data() {
			return {
				categories: [],
				datatable: {}
			}
		},
		mounted() {
			this.index()
		},
		methods: {
			async index() {
				this.mountDataTable()
			},
			mountDataTable() {
				this.datatable = $('#categoryTable').DataTable({
					Processing: true,
					serverSide: true,
					ajax: {
						url: '/Categories/GetAllCategoriesDataTable'
					},
					columns: [{ data: 'name' }, { data: 'action' }],
					error: function (xhr, error, code) {
						console.log(xhr, code)
					}
				})
			},
			async getCategories() {
				try {
					const { data } = await axios.get('Categories/GetAllCategories')
					this.categories = data.categories
				} catch (error) {
					console.error(error)
				}
				this.mountDataTable()
			},
			getEvent(event) {
				const button = event.target
				if (button.getAttribute('role') == 'edit') {
					this.getCategory(button.getAttribute('data-id'))
				}
				if (button.getAttribute('role') == 'delete') {
					this.deleteCategory(button.getAttribute('data-id'))
				}
			},
			async getCategory(category_id) {
				try {
					this.datatable.destroy()
					const { data } = await axios.get(`Categories/GetACategory/${category_id}`)
					this.$parent.editCategory(data.category)
					this.index()
				} catch (error) {
					console.error(error)
				}
			},
			async deleteCategory(user_id) {
				try {
					const result = await swal.fire({
						icon: 'info',
						title: 'Quiere eliminar la categoria?',
						showCancelButton: true,
						confirmButtonText: 'Eliminar'
					})
					if (!result.isConfirmed) return
					this.datatable.destroy()
					await axios.delete(`Categories/DeleteACategory/${user_id}`)
					this.index()
					swal.fire({
						icon: 'success',
						title: 'Felicitaciones!',
						text: 'Categoria Eliminada!'
					})
				} catch (error) {
					console.error(error)
				}
			}
		}
	}
</script>
