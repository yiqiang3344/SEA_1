<script type="text/javascript">//template
	var template = <?=json_encode($this->template)?>;//指定模板数据来源,开发的之后直接php赋值,发布时将其替换为外链
</script>
<script type="text/javascript">//static
	function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		bind_click($('.js_pop'),function(){
			State.forward('Demo','Pop');
		});
	}
</script>
<script type="text/javascript">
	//model
	var params = {};

	//view
	m_print();
</script>
