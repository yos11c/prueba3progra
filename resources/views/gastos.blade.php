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
			<h2 style="text-align: center;margin-top: 5px;">Gastos</h2>
		</div>
		<div class="col l5 s12" style="text-align: center; margin-top: 15px;">
			<a class="waves-effect waves-light btn modal-trigger" href="#modal_nuevo_gasto">
				<i class="large material-icons" style="vertical-align: middle">add</i>
				<span style="vertical-align: middle">Agregar</span>
			</a>
		</div>
	</div>
	<table id="table_gastos" class="display striped responsive-table">
		<thead>
			<th>Precio</th>
			<th>Moneda</th>
			<th>Fecha</th>
			<th>Descripción</th>
			<th></th>
		</thead>
		<tbody>
			@foreach($gastos as $gasto)
				<tr>
					<td>{{ $gasto->precio }}</td>
					<td>{{ $gasto->moneda }}</td>
					<td>{{ $gasto->fecha }}</td>
					<td>{{ $gasto->descripcion }}</td>
					<td style="min-width: 60px;">
						<div class="tooltipped" data-position="top" data-tooltip="Editar" style="display: inline-block;">
							<a data-id="{{ $gasto->id }}" class="modal-trigger" href="#modal_editar_gasto"><i class="material-icons">edit</i></a>
						</div>

						<div  class="tooltipped" data-position="top" data-tooltip="Borrar" style="display: inline-block;">
							<form action="{{ route('gastos_destroy', $gasto->id) }}" method="POST">
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

	<!-- Modal - Nuevo egasto -->
	<form id="modal_nuevo_gasto" class="modal" action="{{ route('gastos_store') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Agregar un nuevo Gasto</h4>
			<div class="row">
				<div class="input-field col s6">
					<input name="precio" id="precio" type="number" min="1" max="100000" class="active">
					<label for="precio">Precio</label>
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
					<input name="fecha" id="fecha" type="date" class="active">
					<label for="fecha">Fecha</label>
				</div>
				<div class="input-field col s6">
					<input name="descripcion" id="descripcion" type="text" class="active">
					<label for="descripcion">Descripción</label>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<center><button class="btn waves-effect waves-light" type="submit" name="action">Agregar<i class="material-icons right">send</i></button></center>
		</div>
	</form>

	<!-- Modal - Editar gasto -->
	<form id="modal_editar_gasto" class="modal" action="{{ route('gastos_update') }}" method="POST">
		@csrf
		<div class="modal-content">
			<h4>Editar Gasto</h4>
			<div class="row">
				<input id="editar_id" type="hidden" name="id" value="">
				<div class="input-field col s6">
					<input name="precio" id="editar_precio" type="number" min="1" max="100000" class="active">
					<label for="editar_precio">Precio</label>
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
					<input name="fecha" id="editar_fecha" type="date" class="active">
					<label for="editar_fecha">Fecha</label>
				</div>
				<div class="input-field col s6">
					<input name="descripcion" id="editar_descripcion" type="text" class="active">
					<label for="editar_descripcion">Descripción</label>
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
            $('#table_gastos').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
            $('.modal').modal(); // Inicializar Modal
			$('.tooltipped').tooltip(); // Inicializar tooltips
        });
        $('a[href$="modal_editar_gasto"]').click(function() {
			$.ajax({
				type: "POST",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route('gastos_edit') }}',
				data: {"id": $(this).data('id')},
				success: function(data) {
					$('#editar_id').val(data['id']);
					$('#editar_precio').val(data['precio']);

					$('#editar_moneda').val(data['moneda']);
					$('#editar_moneda').formSelect();

					$('#editar_fecha').val(data['fecha']);
					$('#editar_descripcion').val(data['descripcion']);
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log("Ocurrió un error.");
				}
			});
		});
    </script>
@endsection
