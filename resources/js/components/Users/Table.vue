<template>
	<table class="table" id="userTable" @click="getEvent">
		<thead>
			<tr>
				<th>CC</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Correo</th>
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
				users: [],
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
				this.datatable = $('#userTable').DataTable({
					Processing: true,
					serverSide: true,
					ajax: {
						url: '/Users/GetAllUsersDataTable'
					},
					columns: [
						{ data: 'number_id' },
						{ data: 'name' },
						{ data: 'last_name' },
						{ data: 'email' },
						{ data: 'action' }
					],
					error: function (xhr, error, code) {
						console.log(xhr, code)
					}
				})
			},
			async getUsers() {
				try {
					const { data } = await axios.get('Users/GetAllUsers')
					this.users = data.users
				} catch (error) {
					console.error(error)
				}
				this.mountDataTable()
			},
			getEvent(event) {
				const button = event.target
				if (button.getAttribute('role') == 'edit') {
					this.getUser(button.getAttribute('data-id'))
				}
				if (button.getAttribute('role') == 'delete') {
					this.deleteUser(button.getAttribute('data-id'))
				}
			},
			async getUser(user_id) {
				try {
					this.datatable.destroy()
					const { data } = await axios.get(`Users/GetAnUser/${user_id}`)
					this.$parent.editUser(data.user)
					this.index()
				} catch (error) {
					console.error(error)
				}
			},
			async deleteUser(user_id) {
				try {
					const result = await swal.fire({
						icon: 'info',
						title: 'Quiere eliminar el usuario?',
						showCancelButton: true,
						confirmButtonText: 'Eliminar'
					})
					if (!result.isConfirmed) return
					this.datatable.destroy()
					await axios.delete(`Users/DeleteAUser/${user_id}`)
					this.index()
					swal.fire({
						icon: 'success',
						title: 'Felicitaciones!',
						text: 'Usuario Eliminado!'
					})
				} catch (error) {
					console.error(error)
				}
			}
		}
	}
</script>
