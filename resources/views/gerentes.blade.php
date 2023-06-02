@extends('layouts.master')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @if(count($errors) > 0)
        <div style="background-color: #f15858; border-radius: 4px; border: 1px solid #de3c3c; color: #FFF; font-family: 'Roboto'; margin-top: 10px; padding: 0px 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <ul>
                        <li>• {{ $error }}</li>
                    </ul>
                @endforeach
            </ul>
        </div>
    @endif
	<div class="row">
		<div class="col l7 s12">
			<h2 style="text-align: center;margin-top: 5px;">Gerentes</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_gerente">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_gerentes" class="display striped responsive-table">
		<thead>
			<th>Nombre</th>
			<th>Apellido paterno</th>
			<th>Correo electrónico</th>
            <th>Rol</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($gerentes as $gerente)
				<tr>
					<td>{{ $gerente->name }}</td>
					<td>{{ $gerente->primerApellido }}</td>
					<td>{{ $gerente->email }}</td>
                    @if($gerente->is_admin == 1)
                        <td>Administrador</td>
                    @else
                        <td>Gerente</td>
                    @endif
					<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $gerente->id }}" class="modal-trigger" href="#modal_editar_gerente"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('gerentes_destroy', $gerente->id) }}" method="POST">
								@csrf
								<input type="hidden" name="_method" value="delete" />
								<button type="submit" name="button" style="border: 0; background: transparent; color: #2195d6; cursor: pointer;" onclick="return confirm('¿Desea eliminar?')"><i class="material-icons">delete_forever</i></button>
							</form>
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<!-- Modal - Nuevo gerente -->
	<form id="modal_nuevo_gerente" class="modal" action="{{ route('gerentes_store') }}" method="POST">
		@csrf
		<div class="modal-content">
                <h4>Agregar nuevo gerente</h4>
                <div class="row">
                    <div class="input-field col s6">
                        <input name="name" id="name" type="text" class="active">
                        <label for="name">Nombre</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="primerApellido" id="primerApellido" type="text" class="active">
                        <label for="primerApellido">Primer apellido</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="email" id="email" type="email" class="active">
                        <label for="email">Correo electronico</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix" style="cursor: pointer;" aria-hidden="true" onClick="viewPassword()">remove_red_eye</i>
                        <input name="password" id="password" type="password" class="active">
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix" style="cursor: pointer;" aria-hidden="true" onClick="viewPassword2()">remove_red_eye</i>
                        <input name="password_confirmation" id="password-confirm" type="password" class="active">
                        <label for="password-confirm">Confirmar contraseña</label>
                    </div>
                    <div class="input-field col s6">
                        <p>
                          <label>
                            <input name="is_admin" type="checkbox" id="defaultCheck1">
                            <span>¿El usuario será administrador?</span>
                          </label>
                        </p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
            </div>
    </form>

	<!-- Modal - Editar gerente -->
	<form id="modal_editar_gerente" class="modal" action="{{ route('gerentes_update') }}" method="POST">
		@csrf
            <div class="modal-content">
                <h4>Editar gerente</h4>
                <div class="row">
                    <input id="editar_id" type="hidden" name="id" value="">
                    <div class="input-field col s6">
                        <input name="name" id="editar_name" type="text" class="active" placeholder="">
                        <label for="name">Nombre</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="primerApellido" id="editar_primerApellido" type="text" class="active" placeholder="">
                        <label for="primerApellido">Primer apellido</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="email" id="editar_email" type="email" class="active" placeholder="">
                        <label for="email">Correo electronico</label>
                    </div>
                    <div class="input-field col s6">
                        <p>
                          <label>
                            <input name="is_admin" type="checkbox" id="editar_defaultCheck1">
                            <span>¿El usuario será administrador?</span>
                          </label>
                        </p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
            </div>
	</form>
@endsection

@section('footer')
	<script type="text/javascript">
        $(document).ready(function() {
            $('#table_gerentes').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
            $('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });
        $('a[href$="modal_editar_gerente"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('gerentes_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);
					$('#editar_name').val(data['name']);
					$('#editar_primerApellido').val(data['primerApellido']);
					$('#editar_email').val(data['email']);

                    if(data.is_admin == 1)
                        $('#editar_defaultCheck1').prop("checked",true);
                    else
                        $('#editar_defaultCheck1').prop("checked",false);

				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});

        function viewPassword() {
            // password-confirm
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function viewPassword2() {
            var x = document.getElementById("password-confirm");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
