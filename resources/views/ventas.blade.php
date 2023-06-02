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
			<h2 style="text-align: center;margin-top: 5px;">Ventas</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nueva_venta">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_ventas" class="display striped responsive-table">
		<thead>
			<th>Nombre del cliente</th>
			<th>Teléfono del cliente</th>
			<th>Descripción</th>
			<th>Costo total</th>
			<th>Fecha de venta</th>
			<th>Producto(s)</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($ventas as $venta)
				<tr>
					<td>{{ $venta->nombre }} {{ $venta->apellido }}</td>
					<td>{{ $venta->telefono }}</td>
					<td>{{ $venta->descripcion }}</td>
					<td>{{ $venta->costo }} {{ $venta->moneda }}</td>
					<td>{{ $venta->created_at }}</td>
					<td>
						@forelse($venta->motores as $motor)
							<b>Motor:</b> {{ $motor->nombre }}
							<br>
							<b>Marca:</b> {{ $motor->marca }}
							<br>
							<b>Cantidad:</b> {{ $motor->pivot->cantidad }}
							<br>
						@empty

						@endforelse
						@forelse($venta->transmisiones as $transmision)
							<b>Transmision:</b> {{ $transmision->nombre }}
							<br>
							<b>Marca:</b> {{ $transmision->marca }}
							<br>
							<b>Cantidad:</b> {{ $transmision->pivot->cantidad }}
							<br>
						@empty

						@endforelse
						@forelse($venta->autopartes as $autoparte)
							<b>Autoparte:</b> {{ $autoparte->parte }}
							<br>
							<b>Marca:</b> {{ $autoparte->marca }}
							<br>
							<b>Cantidad:</b> {{ $autoparte->pivot->cantidad }}
							<br>
						@empty

						@endforelse
					</td>
					<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $venta->id }}" class="modal-trigger" href="#modal_editar_venta"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('ventas_destroy', $venta->id) }}" method="POST">
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

	<!-- Modal - Nuevo motor -->
	<form id="modal_nueva_venta" class="modal" action="{{ route('ventas_store') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Agregar nueva venta</h4>
			<div class="row">
				<div class="input-field col s6">
					<input name="nombre" id="nombre" type="text" class="active">
					<label for="nombre">Nombre de Cliente</label>
				</div>
				<div class="input-field col s6">
					<input name="apellido" id="apellido" type="text" class="active">
					<label for="apellido">Apellido paterno</label>
				</div>
				<div class="input-field col s6">

					<input name="telefono" id="telefono" type="number" class="active">

					<input name="telefono" id="telefono" type="text" class="active">

					<label for="telefono">Telefono</label>
				</div>
				<div class="input-field col s6">
					<input name="descripcion" id="descripcion" type="text" class="active">
					<label for="descripcion">Descripcion</label>
				</div>
				<div class="input-field col s6">
					<input name="costo" id="costo" type="number" min="0.00" max="1000000.00" step="0.01" class="active">
					<label for="costo">Costo</label>
				</div>
				<div class="input-field col s6">
				    <select name="moneda">
				      <option value="" disabled selected>Elija el Tipo de Moneda</option>
				      <option value="GTQ">GTQ</option>
				      <option value="USD">USD</option>
				    </select>
				    <label>Tipo de Moneda</label>
				</div>
				<div class="input-field col s6">
					<select name="motor">
						<option value="" selected>Ninguno</option>
						@foreach ($motores as $motor)
							<option value="{{ $motor->id }}">{{ $motor->nombre." ".$motor->modelo }}</option>
						@endforeach
					</select>
					<label>Motor</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidadMotor" id="cantidadMotor" type="number" min="0" step="1" class="active">
					<label for="cantidadMotor">Cantidad del Motor</label>
				</div>
				<div class="input-field col s6">
					<select name="transmision">
						<option value="" selected>Ninguno</option>
						@foreach ($transmisiones as $transmision)
							<option value="{{ $transmision->id }}">{{ $transmision->nombre." ".$transmision->modelo }}</option>
						@endforeach
					</select>
					<label>Transmisión</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidadTransmision" id="cantidadTransmision" type="number" min="0" step="1" class="active">
					<label for="cantidadTransmision">Cantidad de la Transmision</label>
				</div>
				<div class="input-field col s6">
					<select name="autoparte">
						<option value="" selected>Ninguno</option>
						@foreach ($autopartes as $autoparte)
							<option value="{{ $autoparte->id }}">{{ $autoparte->parte." ".$autoparte->modelo }}</option>
						@endforeach
					</select>
					<label>Autoparte</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidadAutoparte" id="cantidadAutoparte" type="number" min="0" step="1" class="active">
					<label for="cantidadAutoparte">Cantidad de la Autoparte</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
		</div>
	</form>

	<!-- Modal - Editar venta-->
	<form id="modal_editar_venta" class="modal" action="{{ route('ventas_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar venta</h4>
			<div class="row">
				<input id="editar_id" type="hidden" name="id" value="" />
				<div class="input-field col s6">
					<input name="nombre" id="editar_nombre" type="text" class="active" placeholder="">
					<label for="editar_nombre">Nombre del Cliente</label>
				</div>
				<div class="input-field col s6">
					<input name="apellido" id="editar_apellido" type="text" class="active" placeholder="">
					<label for="editar_apellido">Apellido paterno</label>
				</div>
				<div class="input-field col s6">

					<input name="telefono" id="editar_telefono" type="number" class="active" placeholder="">

					<input name="telefono" id="editar_telefono" type="text" class="active" placeholder="">

					<label for="editar_telefono">Telefono</label>
				</div>
				<div class="input-field col s6">
					<input name="descripcion" id="editar_descripcion" type="text" class="active" placeholder="">
					<label for="editar_descripcion">Descripcion</label>
				</div>
				<div class="input-field col s6">
					<input name="costo" id="editar_costo" type="number" min="0.00" max="1000000.00" step="0.01" class="active" placeholder="">
					<label for="editar_costo">Costo</label>
				</div>
				<div class="input-field col s6">
				    <select name="moneda" id="editar_moneda">
				      <option value="">Elija el Tipo de Moneda</option>
				      <option value="GTQ">GTQ</option>
				      <option value="USD">USD</option>
				    </select>
				    <label for="editar_moneda">Tipo de Moneda</label>
				</div>
				<div class="input-field col s6">
					<select name="motor" id="editar_motor">
						<option value="" >Ninguno</option>
						@foreach ($motoresall as $motor)
							<option value="{{ $motor->id }}">{{ $motor->nombre." ".$motor->modelo }}</option>
						@endforeach
					</select>
					<label>Motor</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidadMotor" id="editar_cantidadMotor" type="number" min="0" step="1" class="active">
					<label for="editar_cantidadMotor">Cantidad del Motor</label>
				</div>
				<div class="input-field col s6">
					<select name="transmision" id="editar_transmision">
						<option value="" selected>Ninguno</option>
						@foreach ($transmisionesall as $transmision)
							<option value="{{ $transmision->id }}">{{ $transmision->nombre." ".$transmision->modelo }}</option>
						@endforeach
					</select>
					<label>Transmisión</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidadTransmision" id="editar_cantidadTransmision" type="number" min="0" step="1" class="active">
					<label for="editar_cantidadTransmision">Cantidad de la Transmision</label>
				</div>
				<div class="input-field col s6">
					<select name="autoparte" id="editar_autoparte">
						<option value="" selected>Ninguno</option>
						@foreach ($autopartesall as $autoparte)
							<option value="{{ $autoparte->id }}">{{ $autoparte->parte." ".$autoparte->modelo }}</option>
						@endforeach
					</select>
					<label>Autoparte</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidadAutoparte" id="editar_cantidadAutoparte" type="number" min="0" step="1" class="active">
					<label for="editar_cantidadAutoparte">Cantidad de la Autoparte</label>
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
            $('#table_ventas').DataTable({ // Inicializar tabla
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
			$('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });

		$('a[href$="modal_editar_venta"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('ventas_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					document.getElementById('modal_editar_venta').reset();

					$('#editar_id').val(data['id']);
					$('#editar_nombre').val(data['nombre']);
					$('#editar_apellido').val(data['apellido']);
					$('#editar_telefono').val(data['telefono']);
					$('#editar_descripcion').val(data['descripcion']);
					$('#editar_costo').val(data['costo']);

					$('#editar_moneda').val(data['moneda']);
					$('#editar_moneda').formSelect();

					if(data.id_motor.length > 0)
					{
						$('#editar_cantidadMotor').val(data['cantidadMotor'][0].cantidad);

						$('#editar_motor').val(data.id_motor[0].motor_id);
						$('#editar_motor').formSelect();
					}

					if(data.id_transmision.length > 0)
					{
						$('#editar_cantidadTransmision').val(data['cantidadTransmision'][0].cantidad);

						$('#editar_transmision').val(data.id_transmision[0].transmision_id);
						$('#editar_transmision').formSelect();
					}

					if(data.id_autoparte.length > 0)
					{
						$('#editar_cantidadAutoparte').val(data['cantidadAutoparte'][0].cantidad);

						$('#editar_autoparte').val(data.id_autoparte[0].autoparte_id);
						$('#editar_autoparte').formSelect();
					}
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection
