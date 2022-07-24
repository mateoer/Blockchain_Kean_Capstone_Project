<html>

<head>
	<!-- JQUERY CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

	<!-- Datatable JS CDN -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

	<!-- JS CDN-->
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>


</head>

<body>
	<div class="container">
		<div class="card card-heading">
			<h4>CRYPTOCURRENCY</h4>
		</div>
		<div class="card card-success">
			<div class="card-body">
				<div class="table-responsive col-lg-12">
					<span id="count"></span>
					<table class="table table-hover table-condensed table-bordered" id="tableCrypto">
						<thead>
							<tr>
								<th>CRYPTOCURRENCY SYMBOL</th>
								<th>CRYPTOCURRENCY NAME</th>
								<th>PRICE</th>
								<th>CHANGE 24 HOURS</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<div class="col-lg-12">
					<input type="button" id="refresh" value="Refresh" class="form-control btn btn-primary">
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<script>
	var table,i;

	$(document).ready(function() {
		crypto() //Calling the Crypto function since the page has finished loading when entering it
	})

	$("#refresh").on('click', function() { // Calling the Crypto function and resetting the counter by clicking the "Refresh" button
		i = 10;
		crypto()
	})

	$("#tableCrypto").ready(function() { 
		table = $("#tableCrypto").removeAttr('width').DataTable({ //Initializing the table that will contain the information, using the Javascript DataTables framework
			"deferRender": true, //Indicating that this table could be created Rows dynamically 
			destroy: true, //Indicating that the entire table will be destroyed first and then it will be regenerated and reinitialized
			dom: 'RSltpri', //Indicating which DOM options will be used when generating the table with DataTables
			"columns": [{  //Defining the columns and the identifiers that you will receive to fill with the request through AJAX
					"data": "symbol"
				},
				{
					"data": "name"
				},
				{
					"data": "price"
				},
				{
					"data": "change"
				}
			]
		});
	})

	function crypto() { //Crypto function that is responsible for making the AJAX request to the PHP server that requests the information of the cryptocurrencies
		var parametros = {
			'crypto': 1
		}
		$.ajax({
			type: 'post',
			url: 'ajax/crypto.php',
			data: parametros
		}).done(function(data) {
			var result = JSON.parse(data);
			table.clear(); //clean the table
			table.rows.add(result.data).draw(); //Shows the data received from the PHP server

		})
	}
	i = 10; //Starts a counter from 10
	setInterval(function() { //Create an interval of every 1 second that will reduce the counter until it reaches 0 and then call the Crypto function and reset the counter at 10
		i--;
		console.log(i)
		$("#count").text("Next Update in " + i + " Seconds");
		if (i == 0) {
			crypto();
			i = 10;
		}
	}, 1000);

</script>
