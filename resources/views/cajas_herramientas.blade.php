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
						<li> {{ $error }}</li>
					</ul>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="row">
		<div class="col l7 s12">
			<h2 style="text-align: center;margin-top: 5px;">Cajas herramientas</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nueva_caja">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>

	<div>
		<table id="table_caja_herramientas" class="display striped responsive-table">
			<thead>
				<th>Caja</th>
				<th>Propietario(s)</th>
				<th>Notas</th>
				<th>Herramientas</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($caja_herramientas as $caja_herramienta)
					<tr>
						<td>Caja #{{ $caja_herramienta->id }}</td>
						<td>
							@forelse($caja_herramienta->empleados as $empleado)
								{{ $empleado->nombre }} {{ $empleado->primerApellido }}
								<br>
							@empty
								Ninguno
							@endforelse
						</td>
						<td>
							{{ $caja_herramienta->notas }}
						</td>
						<td style="width: 380px;">
							@forelse($caja_herramienta->herramientas as $herramientas)
								{{ $herramientas->nombre }} (<b>Marca:</b> {{ $herramientas->marca }}, <b>Cantidad:</b> {{ $herramientas->pivot->cantidad }})<br>
							@empty
								Ninguna
							@endforelse
						</td>
						<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $caja_herramienta->id }}" class="modal-trigger" href="#modal_editar_caja"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('caja_herramientas_destroy', $caja_herramienta->id) }}" method="POST">
								@csrf
								<input type="hidden" name="_method" value="delete" />
								<button type="submit" name="button" style="border: 0; background: transparent; color: #2195d6; cursor: pointer;" onclick="return confirm('�0�7Desea eliminar?')"><i class="material-icons">delete_forever</i></button>
							</form>
						</div>
					</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<!-- Modal - Nueva caja -->
	<form id="modal_nueva_caja" class="modal" action="{{ route('caja_herramientas_store') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Agregar nueva caja</h4>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">account_circle</i>
					<select name="empleado1" style="overflow-y: scroll">
						<option value="" selected>Ninguno</option>
						@foreach ($empleados as $empleado)
							<option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->primerApellido }}</option>
						@endforeach
					</select>
					<label>Propietario 1</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">account_circle</i>
					<select name="empleado2">
						<option value="" selected>Ninguno</option>
						@foreach ($empleados as $empleado)
							<option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->primerApellido }}</option>
						@endforeach
					</select>
					<label>Propietario 2</label>
				</div>
				<div class="input-field col s12">
					<input name="notas" id="notas" type="text" class="active">
					<label for="notas">Notas</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
		</div>
	</form>

	<!-- Modal - Editar caja -->
	<form id="modal_editar_caja" class="modal" action="{{ route('caja_herramientas_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar Caja</h4>
			<div class="row">
				<input id="editar_caja_id" type="hidden" name="id" value="">
				<div class="input-field col s6">
					<i class="material-icons prefix">account_circle</i>
					<select name="empleado1" id="editar_caja_empleado1">
						<option value="" selected>Ninguno</option>
						@foreach ($empleados as $empleado)
							<option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->primerApellido }}</option>
						@endforeach
					</select>
					<label>Propietario 1</label>
				</div>
				<div class="input-field col s6">
					<i class="material-icons prefix">account_circle</i>
					<select name="empleado2" id="editar_caja_empleado2">
						<option value="" selected>Ninguno</option>
						@foreach ($empleados as $empleado)
							<option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->primerApellido }}</option>
						@endforeach
					</select>
					<label>Propietario 2</label>
				</div>
				<div class="input-field col s12">
					<input name="notas" id="editar_notas" type="text" class="active">
					<label for="editar_notas">Notas</label>
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
            $('#table_caja_herramientas').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
			$('.modal').modal(); // Inicializar Modal
        });

		$('a[href$="modal_editar_caja"]').click(function() {
			$.ajax({
				type: "GET",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '/cajas_herramientas/edit/'+$(this).data('id'),
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_caja_id').val(data['id']);
					$('#editar_notas').val(data['notas']);

					if(data.empleados.length < 1)
					{
						$('#editar_caja_empleado1').val("");
						$('#editar_caja_empleado1').formSelect();
					}
					if (data.empleados.length < 2) {
						$('#editar_caja_empleado2').val("");
						$('#editar_caja_empleado2').formSelect();
					}

					for (var i = 0; i < data.empleados.length; i++) {
						if(i == 0)
						{
							$('#editar_caja_empleado1').val(data.empleados[i].empleado_id);
							$('#editar_caja_empleado1').formSelect();
						}
						if(i == 1)
						{
							$('#editar_caja_empleado2').val(data.empleados[i].empleado_id);
							$('#editar_caja_empleado2').formSelect();
						}
					}

				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurri�� un error.");
				}
			});
		});
    </script>
@endsection
