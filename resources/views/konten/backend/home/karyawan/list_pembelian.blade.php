<div class="row">


	@if(Cart::count() != 0 )
		<div class="col-md-6">
			<button id="kosongkan_cart" class="btn btn-primary pull-right">
				<i class="fa fa-refresh"></i> Kosongkan
			</button>
				<table class="table table-bordered table-hover">
					<thead>
						<tr class="alert-info">
							<th>Nama</th>
							<th>Jml</th>
							<th>harga</th>
							<th>subtotal</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@foreach(Cart::content() as $list)
						<tr>
							<td>{!! $list->name !!}</td>
							<td>{!! $list->qty !!}</td>
							<td>
								{!! fungsi()->rupiah($list->price) !!}
							</td>
							<td>
								{!! fungsi()->rupiah($list->subtotal) !!}				
							</td>
							<td class="text-center">
								@include($base_view.'karyawan.action')
							</td>
						</tr> 
					@endforeach
					</tbody>
				</table>


			<div class="col-md-12">
				<h3 style="text-decoration:underline" class="text-right">
					Total : {!! fungsi()->rupiah(Cart::total()) !!}
				</h3>
			</div>		
		</div>

 		
		<script type="text/javascript">
		
		$('#kosongkan_cart').click(function(){
			swal({   
				title: "Are you sure?",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				closeOnConfirm: false }, function(){   
		
				$('#pesan').removeClass('alert alert-danger animated shake').html('');

			form_data ={
				kosongkan : 1,
			 	_token : '{!! csrf_token() !!}'
			}
		$('#kosongkan_cart').attr('disabled', 'disabled');
			$.ajax({
				url : '{{ route("backend_home.kosongkan_cart") }}',
				data : form_data,
				type : 'post',
				error:function(xhr, status, error){
					$('#kosongkan_cart').removeAttr('disabled');
				 	$('#pesan').addClass('alert alert-danger animated shake').html('<b>Error : </b><br>');
			        datajson = JSON.parse(xhr.responseText);
			        $.each(datajson, function( index, value ) {
			       		$('#pesan').append(index + ": " + value+"<br>")
			          });
				},
				success:function(ok){
					swal('data telah dikosongkan');
					 $('#list_pembelian').html(ok);
					 //window.location.reload();
				}
			});

			});
		
		});
		
 
 

</script>




	@else
		
			<div class="col-md-6">
				<div class="alert alert-info">
					<h3>Pesanan masih kosong</h3>
				</div>		
			</div>
			
		
	@endif

</div>