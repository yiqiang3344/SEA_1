<script type="text/javascript">
	function print(){
		var html = '';
		html+='<ul class="mblogs">';
		$.each(info,function(k,v){
			html+='	<li id="jsblog_'+v.id+'">';
			html+='		<p class="title jsto_blog">'+v.title+'</p>';
			html+='		<p class="meta">'+dateFormat(v.record_time)+'</p>';
			html+='		<p class="summary ellipsis">'+v.content+'</p>';
			html+='		<p class="more"><s class="more--s jsto_blog">阅读全文>></s></p>';
			html+='	</li>';
		});
		html+='</ul>';
		document.write(html);

		$('.jsto_blog').click(function(){
			var id = $(this).parents('li').attr('id').replace('jsblog_','');
			State.forward('Main','Blog',{id:id});
		});
	}
</script>
<script type="text/javascript">
	var info = <?=json_encode($info)?>;
	print();
</script>
