<template>
	<table class="table" id="productTable" @click="getEvent">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Stock</th>
				<th>Precio</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</template>

<script>
	export default {
		//components: {},
		data() {
			return {
				products: [],
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
				this.datatable = $('#productTable').DataTable({
					Processing: true,
					serverSide: true,
					ajax: {
						url: '/Products/GetAllProductsDataTable'
					},
					columns: [
						{ data: 'name' },
						{ data: 'stock' },
						{ data: 'price' },
						{ data: 'action' }
					],
					error: function (xhr, error, code) {
						console.log(xhr, code)
					}
				})
			},
			async getProducts() {
				try {
					const { data } = await axios.get('Products/GetAllProducts')
					this.products = data.products
				} catch (error) {
					console.error(error)
				}
				this.mountDataTable()
			},
			getEvent(event) {
				const button = event.target
				if (button.getAttribute('role') == 'edit') {
					this.getProduct(button.getAttribute('data-id'))
				}
				if (button.getAttribute('role') == 'delete') {
					this.deleteProduct(button.getAttribute('data-id'))
				}
			},
			async getProduct(product_id) {
				try {
					this.datatable.destroy()
					const { data } = await axios.get(`Products/GetAProduct/${product_id}`)
					this.$parent.editProduct(data.product)
					this.index()
				} catch (error) {
					console.error(error)
				}
			},
			async deleteProduct(product_id) {
				try {
					const result = await swal.fire({
						icon: 'info',
						title: 'Quiere eliminar el producto?',
						showCancelButton: true,
						confirmButtonText: 'Eliminar'
					})
					if (!result.isConfirmed) return
					this.datatable.destroy()
					await axios.delete(`Products/DeleteAProduct/${product_id}`)
					this.index()
					swal.fire({
						icon: 'success',
						title: 'Felicitaciones!',
						text: 'Producto Eliminado!'
					})
				} catch (error) {
					console.error(error)
				}
			}
		}
	}
</script>
