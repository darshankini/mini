
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
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body>
	<?php include_once('common/header.php'); ?>
	<section>
		<?php include_once('common/aside.php'); ?>
	<div class="container">
<div class="col-md-offset-2 col-md-10 col-sm-12 mformDiv">
<h3 class="text-center">Manufacturer LIst</h3>
<a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" href="#" id="modalid" style="display:none;">Open Modal</a>
<div class="table-responsive">          
  <table class="table" id="myTable">
    <thead>
      <tr>
        <th>Id</th>
        <th>Manufacturer Name</th>
        <th>Model Name</th>
				<th>Registration Number</th>
        <th>Count</th>
      </tr>
    </thead>
    <tbody>
		<?php if($result){ 
				foreach($result as $row){
					
				?>

      <tr class="clickable-row"  id="<?php echo $row['modelid']?>">		
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['mName']; ?></td>
        <td><?php echo $row['model']; ?></td>
				<td><?php echo $row['rNumber']?></td>
        <td><?php echo $row['Number_of_cars']; ?></td>
      </tr>
			<?php 
				}
				}else{ ?>
					<tr><td colspan="3">No records Found</td></tr>
				<?php 
				}	
			 ?>
    </tbody>
  </table>
  </div>

	</section>
	<footer></footer>
</body>
</html>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
				<input type="hidden" class="id">
          <table class="table table-responsive">
						<tr>
							<td>Model</td>
							<td class="model"></td>
						</tr>
						<tr>
							<td>Manufacturer Name</td>
							<td class="mName"> </td>
						</tr>
						<tr>
							<td>Color</td>
							<td class="color"></td>
						</tr>
						<tr>
							<td>Year</td>
							<td class="year"></td>
						</tr>
						<tr>
							<td>Registration Number</td>
							<td class="rNumber"></td>
						</tr>
						<tr>
							<td>Note</td>
							<td class="note"></td>
						</tr>
					</table>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-primary" id="sold" href="#">Sold</a>
        </div>
      </div>
      
    </div>
  </div>
  
<script>
$( document ).ready(function() {

	$(document).ready( function () {
    $('#myTable').DataTable();
} );

	$('.clickable-row').on('click',function(){
		
		var base_url = $('#base_url').val();
		var id = $(this).attr('id');

		//ajax
		$.ajax({
			url:base_url + 'AdminController/modelDetails',
			type:'post',
			data:{id:id},
			// dataType:'json',
			success:function(response){
				var obj = $.parseJSON(response);
					$.each(obj, function(k,v) {
						$('.id').val(v.modelid);
						$('.model').html(v.model);
						$('.mName').html(v.mName);
						$('.color').html(v.color);
						$('.year').html(v.year);
						$('.rNumber').html(v.rNumber);
						$('.note').html(v.note);
					});

					$('#modalid').click();
				
			}
		});
	
	});

	$('#sold').on('click',function(){
		var base_url = $('#base_url').val();
		var id = $('.id').val();


		$.ajax({
			url:base_url + 'AdminController/deleteModel',
			type:'post',
			data:{id:id},
			success:function(response){
					var obj = $.parseJSON(response);
					if(obj.success == true){
						alert('Sold successfully');
					}else{
						alert('Please try again');
					}
			}
		});
	});

});
</script>

