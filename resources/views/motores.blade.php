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
						<li>{{ $error }}</li>
					</ul>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="row">
		<div class="col l7 s12">
			<h2 style="text-align: center;margin-top: 5px;">Motores</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_motor">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_motores" class="display striped responsive-table">
		<thead>
			<th>Nombre</th>
			<th>Modelo</th>
			<th>Cantidad</th>
			<th>Marca</th>
			<th>Costo</th>
			<th>Descripción</th>
			<th>Modelos disponibles</th>
			<th>Cilíndros</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($motores as $motor)
				<tr>
					<td>{{ $motor->nombre }}</td>
					<td>{{ $motor->modelo }}</td>
					<td>{{ $motor->cantidad }}</td>
					<td>{{ $motor->marca }}</td>
					<td>{{ $motor->costo }} {{ $motor->moneda }}</td>
					<td>{{ $motor->descripcion }}</td>
					<td>{{ $motor->modelosDisponibles }}</td>
					<td>{{ $motor->cilindros }}</td>
					<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $motor->id }}" class="modal-trigger" href="#modal_editar_motor"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('motores_destroy', $motor->id) }}" method="POST">
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
	<form id="modal_nuevo_motor" class="modal" action="{{ route('motores_store') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Agregar nuevo motor</h4>
			<div class="row">
				<div class="input-field col s6">
					<input name="nombre" id="nombre" type="text" class="active">
					<label for="nombre">Nombre</label>
				</div>
				<div class="input-field col s6">
					<input name="modelo" id="modelo" type="text" class="active">
					<label for="modelo">Modelo</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidad" id="cantidad" type="number" class="active">
					<label for="cantidad">Cantidad</label>
				</div>
				<div class="input-field col s6">
					<input name="marca" id="marca" type="text" class="active">
					<label for="marca">Marca</label>
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

					<input name="descripcion" id="descripcion" type="text" class="active">
					<label for="descripcion">Descripción</label>
				</div>
				<div class="input-field col s6">
					<input name="modelos_disponibles" id="modelos_disponibles" type="text" class="active">
					<label for="modelos_disponibles">Modelos disponibles</label>
				</div>

				<div class="input-field col s6">
					<input name="cilindros" id="cilindros" type="number" class="active">
					<label for="cilindros">Cilindros</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
		</div>
	</form>

	<!-- Modal - Editar motor -->
	<form id="modal_editar_motor" class="modal" action="{{ route('motores_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar motor</h4>
			<div class="row">
				<input id="editar_id" type="hidden" name="id" value="">
				<div class="input-field col s6">
					<input name="nombre" id="editar_nombre" type="text" class="active" placeholder="">
					<label for="editar_nombre">Nombre</label>
				</div>
				<div class="input-field col s6">
					<input name="modelo" id="editar_modelo" type="text" class="active" placeholder="">
					<label for="editar_modelo">Modelo</label>
				</div>
				<div class="input-field col s6">
					<input name="cantidad" id="editar_cantidad" type="number" class="active" placeholder="">
					<label for="editar_cantidad">Cantidad</label>
				</div>
				<div class="input-field col s6">
					<input name="marca" id="editar_marca" type="text" class="active" placeholder="">
					<label for="editar_marca">Marca</label>
				</div>
				<div class="input-field col s6">
=
					<input name="costo" id="editar_costo" type="number" min="0.00" max="1000000.00" step="0.01" class="active" placeholder="">
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

					<input name="descripcion" id="editar_descripcion" type="text" class="active" placeholder="">
					<label for="editar_descripcion">Descripción</label>
				</div>
				<div class="input-field col s6">
					<input name="modelos_disponibles" id="editar_modelos_disponibles" type="text" class="active" placeholder="">
					<label for="editar_modelos_disponibles">Modelos disponibles</label>
				</div>

				<div class="input-field col s6">
					<input name="cilindros" id="editar_cilindros" type="text" class="active" placeholder="">
					<label for="editar_cilindros">Cilindros</label>
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
            $('#table_motores').DataTable({ // Inicializar tabla
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
			$('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });
		$('a[href$="modal_editar_motor"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('motores_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);
					$('#editar_nombre').val(data['nombre']);
					$('#editar_modelo').val(data['modelo']);
					$('#editar_cantidad').val(data['cantidad']);
					$('#editar_marca').val(data['marca']);
					$('#editar_costo').val(data['costo']);

					$('#editar_moneda').val(data['moneda']);
					$('#editar_moneda').formSelect();

					$('#editar_descripcion').val(data['descripcion']);
					$('#editar_modelos_disponibles').val(data['modelos_disponibles']);
					$('#editar_cilindros').val(data['cilindros']);
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection
