@extends('layouts.master')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Necesario para usar ajax -->
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
			<h2 style="text-align: center;margin-top: 5px;">Empleados</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_empleado">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_empleados" class="display striped responsive-table">
		<thead>
			<th>Nombre</th>
			<th>Apellido paterno</th>
			<th>Fecha de agregado</th>
			<th>Teléfono</th>
			<th>Caja asignada</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($empleados as $empleado)
				<tr>
					<td>{{ $empleado->nombre }}</td>
					<td>{{ $empleado->primerApellido }}</td>
					<td>{{ $empleado->created_at }}</td>
					<td>{{ $empleado->telefono }}</td>
					<td>
						@forelse($empleado->cajaHerramientas as $caja)
							{{ $caja->id }}. 	
						@empty
							Ninguna
						@endforelse
					</td>
					<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $empleado->id }}" class="modal-trigger" href="#modal_editar_empleado"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('empleados_destroy', $empleado->id) }}" method="POST">
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

	<!-- Modal - Nuevo empleado -->
	<form id="modal_nuevo_empleado" class="modal" action="{{ route('empleados_store') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Agregar un nuevo Empleado</h4>
			<div class="row">
				<div class="input-field col s6">
					<input name="nombre" id="nombre" type="text" class="active">
					<label for="nombre">Nombre</label>
				</div>
				<div class="input-field col s6">
					<input name="primerApellido" id="primerApellido" type="text" class="active">
					<label for="primerApellido">Primer Apellido</label>
				</div>
				<div class="input-field col s6">
					<input name="telefono" id="telefono" type="text" class="active">
					<label for="telefono">Telefono</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
		</div>
	</form>

	<!-- Modal - Editar empleado -->
	<form id="modal_editar_empleado" class="modal" action="{{ route('empleados_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar Empleado</h4>
			<div class="row">
				<input id="editar_id" type="hidden" name="id" value="">
				<div class="input-field col s6">
					<input name="nombre" id="editar_nombre" type="text" class="active" placeholder="">
					<label for="editar_nombre">Nombre</label>
				</div>
				<div class="input-field col s6">
					<input name="primerApellido" id="editar_primerApellido" type="text" class="active" placeholder="">
					<label for="editar_primerApellido">Primer Apellido</label>
				</div>
				<div class="input-field col s6">
					<input name="telefono" id="editar_telefono" type="text" class="active" placeholder="">
					<label for="editar_telefono">Telefono</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Editar<i class="material-icons right">send</i></button></center>
		</div>
	</form>
@endsection

@section('footer')
	<script type="text/javascript">
        $(document).ready(function() {
            $('#table_empleados').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
            $('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });
        $('a[href$="modal_editar_empleado"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('empleados_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);
					$('#editar_nombre').val(data['nombre']);
					$('#editar_primerApellido').val(data['primerApellido']);
					$('#editar_telefono').val(data['telefono']);
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection
