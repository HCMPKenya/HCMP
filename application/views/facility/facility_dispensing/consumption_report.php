<?php 	
//Pick values from the seesion 	
$facility_code=$this -> session -> userdata('facility_id');
$district_id=$this -> session -> userdata('district_id');
$county_id =$this -> session -> userdata('county_id'); 

?>
<style>
	.input-small{
		width: 100px !important;
	}
	.input-small_{
		width: 230px !important;
	}
</style>
<div class="row-fluid">
	
<h1 class="page-header" style="margin: 0;font-size: 1.6em;">Consumption</h1>
<div class="alert alert-info" style="width: 100%">
	<b>Proceed to Filter for Commodity Consumption </b>
</div>

<div class="col-md-12" style="padding-left: 1%; right:0; float:right; margin-bottom:5px;margin-left:1%;">
	<select id="commodity_id" class="form-control" style="width:30%;float:left">
		<option value="">Select Commodity</option>
		<?php 			
			foreach ($commodities as $key => $value) {
				$id =$value['commodity_id'];
				$commodity_name =$value['commodity_name'];
				?>
				<option value="<?php echo $id;?>"><?php echo $commodity_name;?></option>	
		<?php }

		?>
	</select>	
	<button class="btn btn-primary" id="filter_consumption" style="float:left">
		<span class="glyphicon glyphicon-search"></span>Find
	</button>
</div>
<div class="col-md-12">
	
<div id="graph_consumption" class="clearfix" style="border:1px solid #ccc;padding:1px;min-height:250px;height:auto;">	

</div>

<!-- <div class='graph-section' id='graph-section'></div> -->

<script>
	$(document).ready(function() 
	{

		var search_table = $('#search_results,.datatable').dataTable( {
	   "sDom": "T lfrtip",
	     "sScrollY": "150px",
	     "sScrollX": "100%",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ Records per page",
                        "sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
                    },
			      "oTableTools": {
                 "aButtons": [
				"copy",
				"print",
				{
					"sExtends":    "collection",
					"sButtonText": 'Save',
					"aButtons":    [ "csv", "xls", "pdf" ]
				}
			],

			"sSwfPath": "<?php echo base_url(); ?>assets/datatable/media/swf/copy_csv_xls_pdf.swf"
		}
	} );

	$('#filter_consumption').click(function () {
		var commodity_id = $('#commodity_id').val();		
		update_consumption_table(commodity_id);      
    });

	function update_consumption_table(commodity_id){		
  		var url = "<?php echo base_url()."dispensing/consumption_ajax";?>";      
		$.ajax({
        type: "POST",
        url: url,
        data:{'commodity_id': commodity_id},       
        success: function(msg) {
        	// console.log(msg);return;
      	$('#graph_consumption').html(msg);
      	$('#ajax_commodity_table').dataTable();
       		
      	},
        error: function() {
            alert('Error occured');
        }
    });

    }//end of update history table


	});
</script>