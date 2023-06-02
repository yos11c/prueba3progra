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
			<h2 style="text-align: center;margin-top: 5px;">Servicios</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_servicio">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_servicios" class="display striped responsive-table">
		<thead>
			<th>Servicio</th>
			<th>Costo</th>
			<th>Tipo de Moneda</th>
			<th>Nombre del Cliente</th>
			<th>Apellido del Cliente</th>
			<th>Teléfono del Cliente</th>
			<th>Carro</th>
			<th>Fecha</th>
			<th>Siguiente Cita</th>
			<th>Descripción</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($servicios as $servicio)
				<tr>
					<td>{{ $servicio->servicio }}</td>
					<td>{{ $servicio->costo }}</td>
					<td>{{ $servicio->moneda }}</td>
					<td>{{ $servicio->nombreCliente }}</td>
					<td>{{ $servicio->apellidoCliente }}</td>
					<td>{{ $servicio->telCliente }}</td>
					<td>{{ $servicio->carro }}</td>
					<td>{{ $servicio->fecha }}</td>
					<td>{{ $servicio->fechaSiguiente }}</td>
					<td>{{ $servicio->descripcion }}</td>
					<td style="min-width: 70px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $servicio->id }}" class="modal-trigger" href="#modal_editar_servicio"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('servicios_destroy', $servicio->id) }}" method="POST">
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

	<!-- Modal - Nuevo servicio -->
		<form id="modal_nuevo_servicio" class="modal" action="{{ route('servicios_store') }}" method="POST">
			@csrf
			<div class="modal-content">
				<h4>Agregar un nuevo Servicio</h4>
				<div class="row">
					<div class="input-field col s6">
						<input name="servicio" id="servicio" type="text" class="active">
						<label for="servicio">Servicio</label>
					</div>
					<div class="input-field col s6">
						<input name="costo" id="costo" type="number" min="0.00" max="100000.00" step="0.01" class="active">
						<label for="costo">Costo</label>
					</div>
					<div class="input-field col s6">
					    <select name="moneda">
					      <option value="" disabled selected>Elija el Tipo de Moneda</option>
					      <option value=GTQ>GTQ</option>
					      <option value="USD">USD</option>
					    </select>
					    <label>Tipo de Moneda</label>
					</div>
					<div class="input-field col s6">
						<input name="nombreCliente" id="nombreCliente" type="text" class="active">
						<label for="nombreCliente">Nombre del Cliente</label>
					</div>
					<div class="input-field col s6">
						<input name="apellidoCliente" id="apellidoCliente" type="text" class="active">
						<label for="apellidoCliente">Apellido del Cliente</label>
					</div>
					<div class="input-field col s6">

						<input name="telCliente" id="telCliente" type="number" class="active">

						<input name="telCliente" id="telCliente" type="text" class="active">

						<label for="telCliente">Telefono del Cliente</label>
					</div>
					<div class="input-field col s6">
						<input name="carro" id="carro" type="text" class="active">
						<label for="carro">Carro</label>
					</div>
					<div class="input-field col s6">
						<input name="fecha" id="fecha" type="date" class="active">
						<label for="fecha">Fecha</label>
					</div>
					<div class="input-field col s6">
						<input name="fechaSiguiente" id="fechaSiguiente" type="date" class="active">
						<label for="fechaSiguiente">Siguiente Cita</label>
					</div>
					<div class="input-field col s6">
						<input name="descripcion" id="descripcion" type="text" class="active">
						<label for="descripcion">Descripcion</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
			</div>
		</form>

	<!-- Modal - Editar servicio -->
	<form id="modal_editar_servicio" class="modal" action="{{ route('servicios_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar Servicio</h4>
			<div class="row">
				<input id="editar_id" type="hidden" name="id" value="">
				<div class="input-field col s6">
					<input name="servicio" id="editar_servicio" type="text" class="active" placeholder="">
					<label for="editar_servicio">Servicio</label>
				</div>
				<div class="input-field col s6">
					<input name="costo" id="editar_costo" type="number" min="0.00" max="10000.00" step="0.01" class="active" placeholder="">
					<label for="editar_costo">Costo</label>
				</div>
				<div class="input-field col s6">
				    <select name="moneda" id="editar_moneda">
				      <option value="" disabled selected>Elija el Tipo de Moneda</option>
				      <option value="GTQ">GTQ</option>
				      <option value="USD">USD</option>
				    </select>
				    <label for="editar_moneda">Tipo de Moneda</label>
				</div>
				<div class="input-field col s6">
					<input name="nombreCliente" id="editar_nombreCliente" type="text" class="active" placeholder="">
					<label for="editar_nombreCliente">Nombre del Cliente</label>
				</div>
				<div class="input-field col s6">
					<input name="apellidoCliente" id="editar_apellidoCliente" type="text" class="active" placeholder="">
					<label for="editar_apellidoCliente">Apellido del Cliente</label>
				</div>
				<div class="input-field col s6">
					<input name="telCliente" id="editar_telCliente" type="text" class="active" placeholder="">
					<label for="editar_telCliente">Telefono del Cliente</label>
				</div>
				<div class="input-field col s6">
					<input name="carro" id="editar_carro" type="text" class="active" placeholder="">
					<label for="editar_carro">Carro</label>
				</div>
				<div class="input-field col s6">
					<input name="fecha" id="editar_fecha" type="date" class="active" placeholder="">
					<label for="editar_fecha">Fecha</label>
				</div>
				<div class="input-field col s6">
					<input name="fechaSiguiente" id="editar_fechaSiguiente" type="date" class="active" placeholder="">
					<label for="editar_fechaSiguiente">Siguiente Cita</label>
				</div>
				<div class="input-field col s6">
					<input name="descripcion" id="editar_descripcion" type="text" class="active" placeholder="">
					<label for="editar_descripcion">Descripcion</label>
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
        $('a[href$="modal_editar_servicio"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('servicios_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);
					$('#editar_servicio').val(data['servicio']);
					$('#editar_costo').val(data['costo']);

					$('#editar_moneda').val(data['moneda']);
					$('#editar_moneda').formSelect();

					$('#editar_nombreCliente').val(data['nombreCliente']);
					$('#editar_apellidoCliente').val(data['apellidoCliente']);
					$('#editar_telCliente').val(data['telCliente']);
					$('#editar_carro').val(data['carro']);
					$('#editar_fecha').val(data['fecha']);
					$('#editar_fechaSiguiente').val(data['fechaSiguiente']);
					$('#editar_descripcion').val(data['descripcion']);
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection
