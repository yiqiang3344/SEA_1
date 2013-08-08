<script type='text/javascript' src='<?=$this->url("js/main/blog.js")?>'></script>
<script type="text/javascript">
	var info = <?=json_encode($info)?>;
	info.time = dateFormat(info.record_time,1);
	m_print();
</script>