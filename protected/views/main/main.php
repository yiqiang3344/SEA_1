<script type="text/javascript">//template
	var template = <?=json_encode($this->template)?>;//指定模板数据来源,开发的之后直接php赋值,发布时将其替换为外链
</script>
<script type="text/javascript">//static
	function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		$('.jsto_blog').click(function(){
			var id = $(this).parents('li').attr('id').replace('jsblog_','');
			State.forward('Main','Blog',{id:id});
		});
	}
</script>
<script type="text/javascript">
	//model
	var list = <?=json_encode($list)?>;

	//controller
	$.each(list,function(k,v){
		list[k].time = dateFormat(v.record_time);
		list[k].content = v.content.replace(/<p>|<\/p>/g,'');
	});
	var params = {list:list};

	//view
	m_print();
</script>
