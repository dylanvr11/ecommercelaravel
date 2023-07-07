<template>
	<div class="card mx-5 my-5">
		<div class="card-header d-flex justify-content-between">
			<h2>Carrito de compra</h2>
		</div>
		<div class="card-body">
			<section class="table-responsive" v-if="load">
				<table-component :orders_data="orders" :total="total_price" />
			</section>
			<!-- load -->
			<section v-else class="d-flex justify-content-center my-3">
				<div class="spinner-border" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</section>
		</div>
	</div>
</template>

<script>
	import TableComponent from './Table.vue'
	export default {
		props: [],
		components: {
			TableComponent
		},
		data() {
			return {
				orders: [],
				total_price: 0,
				load: false,
				order: null
			}
		},
		created() {
			this.index()
		},
		methods: {
			async index() {
				await this.getOrders()
			},
			//async getOrders()
			async getOrders() {
				try {
					this.load = false
					const { data } = await axios.get('Users/GetAllOrdersByUserAuth')
					console.log(data)
					//const { data } = await axios.get('api/Users/GetAllOrdersByUser/3')
					this.orders = data.customer_orders
					await this.calculationPrice()
					this.load = true
				} catch (error) {
					console.error(error)
				}
			},
			async calculationPrice() {
				this.total_price = this.orders.reduce((accumulator, order) => {
					return accumulator + order.price
				}, 0)
			}
		}
	}
</script>
