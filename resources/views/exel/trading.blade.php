@extends('layouts.app')

@section('content')

            <div class="content">
                <div class="title m-b-md">
                   @if (!$closed) Открытые @else Закрытые @endif
                </div><hr>	<hr>
				
				@if (!$closed)
				
					<form action="/trading" method="POST">
								   {{ csrf_field() }}
					  <div class="form-group row">
						<label for="staticEmail" class="col-sm-2 col-form-label">Ticker</label>
						<div class="col-sm-10">
						  <input class="form-control" type="text" name="ticker" id="ticker">
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label">Order type</label>
						<div class="col-sm-10">
						  <select class="form-control" type="text" name="order_type" id="order_type">
							<option value="BUY">BUY</option>
									  <option value="SELL">SELL</option>
									  </select>
						</div>
					  </div>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Buy price</label>
							<div class="col-sm-10">
								<input class="form-control" type="text"required name="buy_price" id="buy_price">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Take profit</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="take_profit" id="take_profit">
							</div>
						</div>
					   <div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Stop loss</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="stop_loss" id="stop_loss">
							</div>
						</div> 
						  <div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Percent from Portfolio</label>
							<div class="col-sm-10">
								<input class="form-control" type="number" name="percent" id="percent">
							</div>
						</div>
						<input class="form-control" autofocus type="submit" id="sub" class="save-data" value="Сохранить">
					</form> 
					
					@endif
            </div>
			<hr>	<hr>
			
				<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
				<th>id</th>
					<th>ticker</th>
					<th>Order type</th>
						<th>Buy price</th>
							<th>Take profit</th>
							@if (!$closed)
								<th>Market Price</th>	
							@endif					
							<th>Stop loss</th>
							<th>Percent from Portfolio(%)</th>
							<th>Profit/Loss</th>
							<th>Дата закачивания</th>
							<th>Операции</th>
							<th>Close Price</th>
							
							<th>Percent from Close(%)</th>
							<th>Характеристики</th>
 
				</tr>
			</thead>                                   
			<tbody>			
			 @foreach ($trading as $trad)
				<tr>	
					<td>{{ $trad->id}}</td>				
					<td>{{ $trad->ticker}}</td>
					<td>{{ $trad->order_type}}</td>
					<td>{{ $trad->buy_price}}</td>
					<td>{{ $trad->take_profit}}</td>
					@if (!$closed)
						<td>{{ $trad->market_price}}</td>	
					@endif	
					<td>{{ $trad->stop_loss}}</td>
					<td>{{ $trad->percent}}</td>
					<td><?php
					if (isset($trad->market_price)) echo round((((double)$trad->market_price - (double)$trad->buy_price)/(double)$trad->market_price) * 100, 2);					
					?></td>
					<td>{{ $trad->created_at}}</td>
					<td>
					
					<a href="<?=url("/tradingupdate/$trad->id")?>"><i class="fas fa-edit mr-1"></i></a>
					<span onclick="trash(<?=$trad->id?>)"><i class="fas fa-trash mr-1"></i></span> 
					
					</td>
					<td>{{ $trad->close_price}}</td>
					<td>{{ $trad->percent_for_close}}</td>
					<td>
					<?php 
				//	var_dump($divisions);
					if (isset($divisions[$trad->id])) {
						echo 'Является родителем сделок:' . implode(',', $divisions[$trad->id]);
					}
					
					if (isset($divisions_[$trad->id])) {
						echo 'Является потомком сделок:' . implode(',', $divisions_[$trad->id]);
					}
					?>
					
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	</div>  	
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>    
<script>
	function trash(id){			
			  swal({
			  title: 'Вы уверены?',
			  text: "Удалить?",
			  type: 'warning',
			   icon: "success",
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete it!'
			}).then(function(res) {
				if(res){
					 var _token   = $('meta[name="csrf-token"]').attr('content');
					  $.ajax({
							type: 'POST',
									url:'/trading/delete',
							data:{_token: _token, id:id},				   
							success: function (data) 
							{ 
								if(data.msg)
								{
									  swal(
										'Удалено',
										'',
										'success'
									  );
									  
									  setTimeout(function() {window.location.reload();}, 2000);
								}  
							}
						})
				}
			})
		return false;
	}
</script>       	
@endsection