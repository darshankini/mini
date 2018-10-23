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
	<?php include_once('common/header.php'); ?>
	<section>
		<?php include_once('common/aside.php'); ?>
	<div class="container">
<div class="col-md-offset-2 col-md-8 col-sm-12 mformDiv">
<h3 class="text-center">Model Form</h3>
<div class="messageDiv"></div>
	<form action="<?php echo base_url('AdminController/addModel')?>" method="post" id="modelForm" class="mForm" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group col-md-6">
      <label for="model">Model Name</label>
      <input type="text" class="form-control" id="model" placeholder="Enter Model Name" name="model">
		</div>
		<div class="form-group col-md-6">
      <label for="mName">Manufacturer Name</label>
		<select class="form-control" name="mName" id="mName">
			<option selected value="">Please Select Manufacturer Name</option>
			<?php if($mList){
			foreach($mList as $row){?>
			<option value="<?php echo $row['id']; ?>"><?php echo ucfirst($row['mName']); ?></option>
			<?php } } ?>
		</select>
		</div>
		<div class="form-group col-md-6 col-sm-12">
      <label for="color">Color</label><br>
      <input type="color"  class="form-control" id="color" name="color">
		</div>
		<div class="form-group col-md-6 col-sm-12">
      <label for="mYear">Manufacturer Year</label>
      <!-- <input type="text" class="form-control" id="mYear" placeholder="Enter Manufacturer Year" name="mYear"> -->
	  <select class="form-control" name="mYear" id="mYear"></select>
		</div>
		<div class="form-group col-md-6">
      <label for="rNumber">Registration Number</label>
      <input type="text" class="form-control" id="rNumber" placeholder="Enter Registration Number" name="rNumber">
		</div>
		<div class="form-group col-md-6">
      <label for="note">Note</label>
      <input type="text" class="form-control" id="note" placeholder="Enter Note" name="note">
		</div>
		<div class="form-group col-md-6">
      <label for="image1">Image 1</label>
      <input type="file" id="image1" name="image1">
		</div>
		<div class="form-group col-md-6">
      <label for="image2">Image 2</label>
      <input type="file"  id="image2" name="image2">
		</div>
		<div class="form-group col-md-12">
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
$( document ).ready(function() {

	for (i = new Date().getFullYear(); i > 1900; i--)
{
    $('#mYear').append($('<option />').val(i).html(i));
}


var files;

$('input[type=file]').on('change',prepareUpload);

function prepareUpload(event){
	files = event.target.files;
}


	$('#modelForm').submit(function(e){
		e.stopPropagation();
		e.preventDefault();

		var formdata = new FormData(this);

		$.each(files, function(key,value)
    	{
        	formdata.append(key,value);
    	});

		var me = $(this);

		//ajax
		$.ajax({
			url:me.attr('action'),
			type:'post',
			data:formdata,
			dataType:'json',
			processData: false,
			contentType: false,
			success:function(response){
				
				if(response.success == true){
					$('.messageDiv').empty();
				    var e = $('.messageDiv');
						e.append('<h4 class="alert alert-success text-center">Model Added Successfully.</h4>')
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
	});

});
</script>

