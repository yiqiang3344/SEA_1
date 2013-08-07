<script type="text/javascript">
	function print(){
		var html = '';	
		html +='<div class="mblog">';
		html +='	<p class="title ac">'+info.title+'</p>';
		html +='	<p class="meta ar prs">'+dateFormat(info.record_time,1)+'</p>';
		html +='	<div class="mblog__content">'+info.content+'</div>';
		html +='</div>';
		document.write(html);
	}
</script>
<script type="text/javascript">
	var info = <?=json_encode($info)?>;
	print();
</script>