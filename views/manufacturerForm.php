<?php 
if($id == "new"){
	$mName = '';
}else{
	foreach($result as $row){
		$mName = $row['mName'];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Index</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
	<?php include_once('common/header.php');?>
	<section>
		<?php echo include_once('common/aside.php'); ?>
	<div class="container">
<div class="col-md-offset-2 col-md-8 col-sm-12 mformDiv">
<h3 class="text-center">Manufacturer Form</h3>
<div class="messageDiv"></div>
	<form action="<?php echo base_url('AdminController/addManufacturer')?>" method="post" id="mNameForm" class="mForm">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group">
      <label for="mName">Manufacturer Name</label>
      <input type="text" class="form-control" id="mName" placeholder="Enter Manufacturer Name" name="mName">
		</div>
		<div class="form-group">
    <button type="submit" class="btn btn-default col-sm-12 ">Submit</button>
		</div>
	</form>
  </div>
</div>
	</section>
	<footer></footer>
</body>
</html>
<script>
	$('#mNameForm').submit(function(e){
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
						e.append('<h4 class="alert alert-success text-center">Name Added Successfully.</h4>')
						
						$('form-group').removeClass('has-success')
													 .removeClass('has-error');
						 
						
				}else if(response.success == 2)
				{
					$('.messageDiv').empty();
				    var e = $('.messageDiv');
						e.append('<h4 class="alert alert-danger text-center">Some Error Occur.</h4>')
						
						
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

