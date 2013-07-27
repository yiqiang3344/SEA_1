

<script type="text/javascript">
	function print(){
		var html = '';
		html+=info;
		document.write(html);
	}
</script>
<script type="text/javascript">
	var info = <?=json_encode($info)?>;
	// print();
</script>