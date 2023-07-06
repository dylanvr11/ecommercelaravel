<template>
	<table class="table">
		<thead>
			<tr>
				<th>Precio</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(order, index) in orders" :key="index">
				<th>{{ order.price }}</th>
				<td>
					<button class="btn btn-danger" @click="deleteOrder(order)">Eliminar</button>
				</td>
			</tr>
		</tbody>
	</table>
	<div>
		<td>Precio Total:</td>
		<td>{{ total }}</td>
	</div>
</template>

<script>
	export default {
		props: ['orders_data', 'total'],
		//components: {},
		data() {
			return {
				orders: []
			}
		},
		created() {
			this.index()
		},
		methods: {
			index() {
				// this.products = this.products_data
				this.orders = [...this.orders_data]
			},
			async getOrder(category) {
				try {
					//const { data } = await axios.get(`Products/GetAProduct/${product_id}`)
					// this.$parent.product = data.product
					this.$parent.editCategory(category)
				} catch (error) {
					console.error(error)
				}
			},
			async deleteOrder(order) {
				try {
					const result = await swal.fire({
						icon: 'info',
						title: 'Quiere eliminar el producto del carrito?',
						showCancelButton: true,
						confirmButtonText: 'Eliminar'
					})
					if (!result.isConfirmed) return
					await axios.delete(`api/Orders/DeleteOrder/${order.id}`)
					this.$parent.getOrders()
					swal.fire({
						icon: 'success',
						title: 'Felicitaciones!',
						text: 'producto del carrito Eliminado!'
					})
				} catch (error) {
					console.error(error)
				}
			}
		}
	}
</script>
