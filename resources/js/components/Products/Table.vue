<template>
	<table class="table">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Stock</th>
				<th>Descripcion</th>
				<th>Precio</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(product, index) in products" :key="index">
				<th>{{ product.name }}</th>
				<td>{{ product.stock }}</td>
				<td>{{ product.price }}</td>
				<td>
					<button class="btn btn-warning me-2" @click="getProduct(product)">
						Editar
					</button>
					<button class="btn btn-danger" @click="deleteProduct(product)">Eliminar</button>
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	export default {
		props: ['products_data'],
		//components: {},
		data() {
			return {
				products: []
			}
		},
		created() {
			this.index()
		},
		methods: {
			index() {
				// this.products = this.products_data
				this.products = [...this.products_data]
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
						text: 'Libro Eliminado!'
					})
				} catch (error) {
					console.error(error)
				}
			}
		}
	}
</script>
