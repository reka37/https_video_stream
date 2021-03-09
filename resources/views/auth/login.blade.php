<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Администратор</title>
            <link href="{{ asset('public/css/styles.css')}}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Вход</h3></div>
                                    <div class="card-body">                                   
										<form role="form" method="POST" action="{{ url('/login') }}">
										{{ csrf_field() }}
											<div class="form-group">
												<label class="small mb-1" for="email">Email</label>
												<input class="form-control py-4" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="Введите email адресс" />
												

												@if ($errors->has('email'))
													<span class="help-block">
														<strong>{{ $errors->first('email') }}</strong>
													</span>
												@endif
																
																
															</div>
															<div class="form-group">
																<label class="small mb-1" for="password">Пароль</label>
																<input class="form-control py-4" id="password" type="password" name="password" required placeholder="Введите пароль" />
																
													

																@if ($errors->has('password')) 
																	<span class="help-block">
																		<strong>{{ $errors->first('password') }}</strong>
																	</span>
																@endif	
																
																
															</div>
															<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
																  <button type="submit" class="btn btn-primary">
																	Вход
																</button>
															</div>
														</form>		
													</div>
												</div>
											</div>
										</div>
									</div>
								</main>
							</div>
        
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
		<script src="{{ asset('public/js/scripts.js')}}"></script>
    </body>
</html>