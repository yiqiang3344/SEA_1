<script type='text/javascript' src='<?=$this->url("js/main/main.js")?>'></script>
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
