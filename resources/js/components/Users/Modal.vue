<template>
	<div class="modal fade" id="user_modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						{{ `${is_create ? 'Crear' : 'Actualizar'} Usuario` }}
					</h5>
					<button
						type="button"
						class="btn-close"
						data-bs-dismiss="modal"
						aria-label="Close"
					></button>
				</div>
				<div class="modal-body">
					<form @submit.prevent="storeUser">
						<div class="mb-3">
							<label for="roles" class="form-label">Rol</label>
							<v-select
								id="roles"
								:options="roles"
								v-model="user.role"
								label="name"
								:clearable="false"
							></v-select>
						</div>
						<div class="mb-3">
							<label for="number_id" class="form-label">Cedula</label>
							<input
								type="number"
								class="form-control"
								id="number_id"
								v-model="user.number_id"
							/>
						</div>
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="name" v-model="user.name" />
						</div>
						<div class="mb-3">
							<label for="last_name" class="form-label">Apellido</label>
							<input
								type="text"
								class="form-control"
								id="last_name"
								v-model="user.last_name"
							/>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Correo</label>
							<input
								type="email"
								class="form-control"
								id="email"
								v-model="user.email"
							/>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Contraseña</label>
							<input
								type="password"
								class="form-control"
								id="password"
								v-model="user.password"
							/>
						</div>
						<div class="mb-3">
							<label for="password_confirmation" class="form-label"
								>Confirmar contraseña</label
							>
							<input
								type="password"
								class="form-control"
								id="password_confirmation"
								v-model="user.password_confirmation"
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
		props: ['user_data'],
		data() {
			return {
				is_create: true,
				roles: [],
				user: {},
				errors_request: null,
				error_text: ''
			}
		},
		created() {
			this.index()
		},
		methods: {
			index() {
				this.getRoles()
				this.setUser()
			},
			setUser() {
				if (!this.user_data) return
				this.user = { ...this.user_data }
				this.is_create = false
			},
			async getRoles() {
				const { data } = await axios.get('Users/GetAllRoles')
				console.log(data)
				this.roles = data.roles
				//console.log(this.categories)
			},
			async storeUser() {
				try {
					if (this.is_create) {
						//console.log(this.book)
						await axios.post('Users/CreateUser', this.user)
					} else {
						await axios.post(`Users/UpdateUser${this.user.id}`)
					}
					swal.fire({
						icon: 'success',
						title: 'Felicidades!',
						text: 'Usuario almacenado!'
					})
					this.$parent.closeModal()
				} catch (error) {
					//console.error(error)
					if (error.response.status == 422) {
						this.errors_request = error.response.data.errors
						for (let field in this.errors_request) {
							if (this.errors_request.hasOwnProperty(field)) {
								this.error_text += this.errors_request[field][0] + '\n'
							}
						}
						console.log(this.error_text)
						swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: this.error_text
						})
					} else {
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
	}
</script>
