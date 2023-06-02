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
			<h2 style="text-align: center;margin-top: 5px;">Trabajos</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_trabajo">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_servicios" class="display striped responsive-table">
		<thead>
			<th>Trabajador</th>
			<th>Descripción</th>
			<th>Fecha de Llegada</th>
			<th>Fecha de Inicio</th>
			<th>Fecha de Finalización</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($trabajos as $trabajo)
				<tr>
					<td>
						@forelse($trabajo->empleados as $empleado)
							{{ $empleado->nombre }} {{ $empleado->primerApellido }}
						@empty
							Ninguno
						@endforelse
					</td>
					<td>{{ $trabajo->descripcion }}</td>
					<td>{{ $trabajo->fechaLlegada }}</td>
					<td>{{ $trabajo->fechaInicio }}</td>
					<td>{{ $trabajo->fechaFinal }}</td>
					<td style="min-width: 70px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $trabajo->id }}" class="modal-trigger" href="#modal_editar_trabajo"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('trabajos_destroy', $trabajo->id) }}" method="POST">
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

	<!-- Modal - Nuevo trabajo -->
		<form id="modal_nuevo_trabajo" class="modal" action="{{ route('trabajos_store') }}" method="POST">
			@csrf
			<div class="modal-content">
				<h4>Agregar un nuevo Trabajo</h4>
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">account_circle</i>
						<select name="empleado">
							<option value="" selected>Ninguno</option>
							@foreach ($empleados as $empleado)
								<option value="{{ $empleado->id }}">{{ $empleado->nombre .' '. $empleado->primerApellido }}</option>
							@endforeach
						</select>
						<label>Trabajador</label>
					</div>
					<div class="input-field col s6">
						<input name="descripcion" id="descripcion" type="text" class="active">
						<label for="descripcion">Descripción</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaLlegada" id="fechaLlegada" type="date" class="active">
						<label for="fechaLlegada">Fecha de Llegada</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaInicio" id="fechaInicio" type="date" class="active">
						<label for="fechaInicio">Fecha de Inicio</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaFinal" id="fechaFinal" type="date" class="active">
						<label for="fechaFinal">Fecha de Finalización</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
			</div>
		</form>

	<!-- Modal - Editar trabajo -->
	<form id="modal_editar_trabajo" class="modal" action="{{ route('trabajos_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar Trabajo</h4>
			<div class="row">
				<input id="editar_id" type="hidden" name="id" value="">
					<div class="input-field col s6">
						<i class="material-icons prefix">account_circle</i>
						<select name="empleado" id="editar_empleado">
							<option value="" selected>Ninguno</option>
							@foreach ($empleados as $empleado)
								<option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->primerApellido }}</option>
							@endforeach
						</select>
						<label>Trabajador</label>
					</div>
					<div class="input-field col s6">
						<input name="descripcion" id="editar_descripcion" type="text" class="active">
						<label for="editar_descripcion">Descripción</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaLlegada" id="editar_fechaLlegada" type="date" class="active">
						<label for="editar_fechaLlegada">Fecha de Llegada</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaInicio" id="editar_fechaInicio" type="date" class="active">
						<label for="editar_fechaInicio">Fecha de Inicio</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaFinal" id="editar_fechaFinal" type="date" class="active">
						<label for="editar_fechaFinal">Fecha de Finalización</label>
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
            $('#table_servicios').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
            $('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });
        $('a[href$="modal_editar_trabajo"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('trabajos_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);

					console.log(data.empleado.length);
					if(data.empleado.length > 0)
					{
						$('#editar_empleado').val(data.empleado[0].empleado_id);
						$('#editar_empleado').formSelect();
					}
					else
					{
						$('#editar_empleado').val("");
						$('#editar_empleado').formSelect();
					}


					$('#editar_descripcion').val(data['descripcion']);
					$('#editar_fechaLlegada').val(data['fechaLlegada']);
					$('#editar_fechaInicio').val(data['fechaInicio']);
					$('#editar_fechaFinal').val(data['fechaFinal']);
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection