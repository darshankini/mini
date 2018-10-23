<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
<div class="col-md-offset-4 col-md-4 col-sm-12 formDiv">
  <h3 class="text-center">Mini Car Inventory System</h3>
	<input type="hidden" name="base_url" value="<?php echo base_url(); ?>" id="base_url">
  <div class="messageDiv"></div>
  <form action="<?php echo base_url('AdminController/login')?>" method="post" id="loginForm" >
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <button type="submit" class="btn btn-default col-sm-12 formSubmit">Submit</button>
  </form>
  </div>
</div>

</body>
</html>
<script>
	$('#loginForm').submit(function(e){
		e.preventDefault();

		var me = $(this);

		//ajax
		$.ajax({
			url:me.attr('action'),
			type:'post',
			data:me.serialize(),
			dataType:'json',
			success:function(response){
				if(response.success == true){
					$('.messageDiv').empty();
				    var e = $('.messageDiv');
						e.append('<h4 class="alert alert-success text-center">Login Successfully.</h4>')
						e.fadeOut(2000);
						
						$('form-group').removeClass('has-success')
													 .removeClass('has-error');

						var base_url = $('#base_url').val();
						
						
						setTimeout(function(){ 
							window.location.href = base_url+'AdminController/manufacturerForm'; 
							}, 2000);							 
						
				}else if(response.success == 2)
				{
					$('.messageDiv').empty();
				    var e = $('.messageDiv');
						e.append('<h4 class="alert alert-danger text-center">Credentials does not match.</h4>')
						
						
						$('form-group').removeClass('has-success')
													 .removeClass('has-error');	
				}
				else{
					
					$.each(response.messages ,function(key,value){
						var element = $('#'+key);
						element.closest('div.form-group')
						.removeClass('has-error')
						.addClass(value.length > 0 ? 'has-error':'has-success')
						.find('.text-danger').remove();
						element.after(value);

					});
				}
			}
		});
	})
</script>

