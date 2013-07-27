<script type="text/javascript">
	function print(){
		var html = '';
		html+='<ul class="mblogs">';
		$.each(info,function(k,v){
			html+='	<li>';
			html+='		<p class="title">'+v.title+'</p>';
			html+='		<p class="meta">'+dateFormat(v.record_time)+'</p>';
			html+='		<p class="summary">'+v.content+'</p>';
			html+='		<p class="more"><s class="more--s">阅读全文>></s></p>';
			html+='	</li>';
		});
		html+='</ul>';
		document.write(html);
	}
</script>
<script type="text/javascript">
	var info = <?=json_encode($info)?>;
	print();
</script>
