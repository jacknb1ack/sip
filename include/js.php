<?php header("Content-type: application/x-javascript"); ?>
	
			
			$(document).ready(function() {
				$('#example').dataTable( {
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"bProcessing": true,
					"bServerSide": true,
					//"sAjaxSource": "process/trans-list.php",
					"sAjaxSource": "process/sample-list.php",
					"aoColumns": [
						null,
						null,
						null,
						null,
						{ "bVisible":false },
						{
						"mData": null,
						"fnRender": function (oObj) 
							{
							
							return "<?php getBook("+ oObj.aData[4] +"); ?>"
						
							}
						}
						
					]
				} );
			} );


	</script>