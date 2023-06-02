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
			<h2 style="text-align: center;margin-top: 5px;">Faltas</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_falta">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_faltas" class="display striped responsive-table">
		<thead>
			<th>Empleado</th>
			<th>Justificación</th>
			<th>Fecha</th>
			<th>Razón</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($faltas as $falta)
				<tr>
					<td>
						@forelse($falta->empleados as $empleado)
							{{ $empleado->nombre }} {{ $empleado->primerApellido }}
						@empty
						@endforelse
					</td>
					@if($falta->justificacion == 1)
						<td>Sí</td>
					@else
						<td>No</td>
					@endif
					<td>{{ $falta->fecha }}</td>
					<td>{{ $falta->razon }}</td>
					<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $falta->id }}" class="modal-trigger" href="#modal_editar_falta"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('faltas_destroy', $falta->id) }}" method="POST">
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

	<!-- Modal - Nuevo efalta -->
	<form id="modal_nuevo_falta" class="modal" action="{{ route('faltas_store') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Agregar un nuevo Falta</h4>
			<div class="row">
				<div class="input-field col s6">
					<i class="material-icons prefix">account_circle</i>
					<select name="empleado">
						<option value="" selected>Ninguno</option>
						@foreach ($empleados as $empleado)
							<option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->primerApellido }}</option>
						@endforeach
					</select>
					<label>Empleado</label>
				</div>
				<div class="input-field col s6">
				    <p>
				      <label>
				        <input name="justificacion" type="checkbox"/>
				        <span>Justificación</span>
				      </label>
				    </p>
				</div>
				<div class="input-field col s6">
					<input name="fecha" id="fecha" type="date" class="active">
					<label for="fecha">Fecha</label>
				</div>
				<div class="input-field col s6">
					<input name="razon" id="razon" type="text" class="active">
					<label for="razon">Razón</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
		</div>
	</form>

	<!-- Modal - Editar falta -->
	<form id="modal_editar_falta" class="modal" action="{{ route('faltas_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar Falta</h4>
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
					<label>Empleado</label>
				</div>
				<div class="input-field col s6">
				    <p>
				      <label>
				        <input name="justificacion" id="editar_justificacion" type="checkbox"/>
				        <span>Justificación</span>
				      </label>
				    </p>
				</div>
				<div class="input-field col s6">
					<input name="fecha" id="editar_fecha" type="date" class="active">
					<label for="editar_fecha">Fecha</label>
				</div>
				<div class="input-field col s6">
					<input name="razon" id="editar_razon" type="text" class="active">
					<label for="editar_razon">Razón</label>
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
            $('#table_faltas').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
            $('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });
        $('a[href$="modal_editar_falta"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('faltas_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);

					console.log(data.empleado[0].empleado_id);
					$('#editar_empleado').val(data.empleado[0].empleado_id);
					$('#editar_empleado').formSelect();

					if(data.justificacion == 1)
						$('#editar_justificacion').prop("checked",true);
					else
						$('#editar_justificacion').prop("checked",false);

					$('#editar_fecha').val(data['fecha']);
					$('#editar_razon').val(data['razon']);					
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection
