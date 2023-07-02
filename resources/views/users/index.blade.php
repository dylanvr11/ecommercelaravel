<x-app>
    <section class="container">
        <div class="card mx-5 my-5">
            <div class="card-header d-flex justify-content-between">
                <h2>Users</h2>
                <a href="{{route('user.create')}}" class="btn btn-primary">Crear usuario</a>
            </div>
            <div class="card-body">
                <table class="table mx-3 my-4">
                    <thead>
                        <tr>
                            <th scope="col">CC</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->number_id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app>
