<template>
	<table class="table" id="productTable" v-if="load">
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
				load: true
			}
		},
		mounted() {
			this.index()
		},
		methods: {
			async index() {
				//await this.getProducts()
				this.mountDataTable()
			},
			async getProducts() {
				try {
					this.load = false
					const { data } = await axios.get('Products/GetAllProducts')
					this.products = data.products
					console.log(this.products)
					this.load = true
				} catch (error) {
					console.error(error)
				}
				this.mountDataTable()
			},
			mountDataTable() {
				$('#productTable').DataTable({
					Processing: true,
					serverSide: true,
					ajax: {
						url: '/Products/GetAllBooksDataTable'
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
			async getProduct(product) {
				try {
					//const { data } = await axios.get(`Products/GetAProduct/${product_id}`)
					// this.$parent.product = data.product
					this.$parent.editProduct(product)
				} catch (error) {
					console.error(error)
				}
			},
			async deleteProduct(product) {
				try {
					const result = await swal.fire({
						icon: 'info',
						title: 'Quiere eliminar el libro?',
						showCancelButton: true,
						confirmButtonText: 'Eliminar'
					})
					if (!result.isConfirmed) return
					await axios.delete(`Products/DeleteAProduct/${product.id}`)
					this.$parent.getProducts()
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
