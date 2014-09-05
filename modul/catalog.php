<h1>Koleksi Buku Perpustakaan Impulse</h1><br/>
<div id="dynamic">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
		<thead>
			<tr>
				<th width="10px">No</th>
				<th width="50px">Kode Buku</th>
				<th width="200px">Judul</th>
				<th width="100px">Pengarang</th>
				<th width="100px">Penerbit</th>
				<th width="5%">Stok</th>
				<th width="5%">Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="7" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Kode</th>
				<th>Judul</th>
				<th>Pengarang</th>
				<th>Penerbit</th>
				<th>Stok</th>
				<th>Aksi</th>
			</tr>
		</tfoot>
	</table>
	
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$('#example').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "process/book-list.php",
		"aoColumns": [
			null,
			null,
			null,
			null,
			null,
			null,
			{
			"mData": null,
			"fnRender": function (oObj) 
				{
				return '<a href="?p=book&book_id=' + oObj.aData[1] + '" ><img src="images/mag.png"/></a>';
				}
			}
		]
	} );
} );



</script>

</div>
<div class="spacer"></div>
