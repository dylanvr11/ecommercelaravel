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
					<button class="btn btn-warning">Editar</button>
					<button class="btn btn-danger">Eliminar</button>
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
				this.products = this.products_data
			}
		}
	}
</script>
