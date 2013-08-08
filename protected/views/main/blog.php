<script type="text/javascript">//template
	var template = <?=json_encode($this->template)?>;//指定模板数据来源,开发的之后直接php赋值,发布时将其替换为外链
</script>
<script type="text/javascript">//static
	function m_print(){
		var html = Mustache.to_html(template, info);
		document.write(html);
	}
</script>
<script type="text/javascript">
	var info = <?=json_encode($info)?>;
	info.time = dateFormat(info.record_time,1);
	m_print();
</script>