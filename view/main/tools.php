<div>
	<span><input id="tmp_html" type="button" value="html模板"></span>
	<span><input id="get_time" type="button" value="时间戳"></span>
</div>
<div>
	<textarea id="source" class="wfull h150"></textarea>
</div>
<div>
	<span><input id="clear_source" type="button" value="还原"></span>
	<span><input id="date_format" type="button" value="日期格式化"></span>
	<span><input id="execute_js" type="button" value="执行js"></span>
	<span><input id="execute_html" type="button" value="执行html"></span>
</div>
<div id="output_html" class="dn">
</div>
<div>
	<textarea id="output" class="wfull h150"></textarea>
</div>
<script type="text/javascript">
	$('#execute_html').click(function(){
		var s = document.getElementById("source");
		output.hide();
		output_html.show().html(s.value);
		return;
	});
	$('#execute_js').click(function(){
		var s = document.getElementById("source");
		eval(s.value);
		return;
	});
	$('#tmp_html').click(function(){
		source.val(tmp_html);
	});
	$('#clear_source').click(function(){
		source.val('');
		output.show().val('');
		output_html.hide().html('');
	});
	$('#get_time').click(function(){
		source.val(time());
	});
	$('#date_format').click(function(){
		var date = source.val();
		output_html.hide();
		output.show().val(dateFormat(date,2));
	});
	var	source = $('#source');
	var	output = $('#output');
	var	output_html = $('#output_html');
	var tmp_html = '<!doctype html>\r\n';
		tmp_html+='<html lang="en">\r\n';
		tmp_html+='<head>\r\n';
		tmp_html+='    <meta charset="UTF-8">\r\n';
		tmp_html+='    <title>Document\</title>\r\n';
		tmp_html+='</head>\r\n';
		tmp_html+='<body>\r\n';
		tmp_html+='</body>\r\n';
		tmp_html+='</html>';
</script>