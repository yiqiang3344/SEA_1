<script >
	var template = <?=json_encode($this->template)?>;//指定模板数据来源,开发的之后直接php赋值,发布时将其替换为外链
</script>
<script>//逻辑处理,发布时也会被装入外链文件中
	function m_print(){
	    var html = Mustache.to_html(template, params);
	    document.write(html);
	}
</script>
<script>//php代码只能出现在这个脚本中
	var params = <?=json_encode($params)?>;

	m_print();
</script>