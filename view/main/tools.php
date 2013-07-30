<div>
	<span><input id="tmp_html" type="button" value="html模板"></span>
	<span><input id="get_time" type="button" value="时间戳"></span>
</div>
<div>
	<textarea id="source" class="wfull h150"></textarea>
</div>
<div>
	<span><input id="clear_source" type="button" value="还原"></span>
	<span><input id="swap" type="button" value="互换"></span>
	<span><input id="date_format" type="button" value="日期格式化"></span>
	<span><input id="execute_js" type="button" value="执行js"></span>
	<span><input id="execute_html" type="button" value="执行html"></span>
	<span>
		<select id="encrypt_type" type="button">
			<option value="json_encode">数组转json</option>
			<option value="json_decode">json转数组</option>
			<option value="md5">md5</option>
			<option value="base64_encode">转base64</option>
			<option value="base64_decode">解base64</option>
			<option value="addslashes">转义</option>
			<option value="stripslashes">反转义</option>
			<option value="htmlentities">转实体</option>
			<option value="html_entity_decode">反转实体</option>
			<option value="jsencodeuri">转jsURI</option>
			<option value="jsdecodeuri">解jsURI</option>
			<option value="jsencodeuricomponent">转jsURIComponent</option>
			<option value="jsdecodeuricomponent">解jsURIComponent</option>
		</select>
		<input id="encrypt" type="button" value="执行">
	</span>
	<span><input id="format_css" type="button" value="css格式化"></span>
</div>
<div id="output_html" class="dn">
</div>
<div>
	<textarea id="output" class="wfull h150"></textarea>
</div>
<script type="text/javascript">
	$('#format_css').click(function(){
		var s_val = source.val();
		yajax('AjaxMain','Format',{type:'css',source:source.val()},function(obj){
			if(obj.code==1){
				output_html.hide();
				output.show().val(obj.ret);
			}
		},this);
	});
	$('#encrypt').click(function(){
		var type = $('#encrypt_type').val();
		var ret;
		if(type in {md5:1,base64_encode:1,base64_decode:1,addslashes:1,stripslashes:1,htmlentities:1,html_entity_decode:1,json_encode:1,json_decode:1}){
			yajax('AjaxMain','Encrypt',{type:type,source:source.val()},function(obj){
				if(obj.code==1){
					output_html.hide();
					output.show().val(obj.ret);
				}
			},this);
		}else{
			if(type=='jsencodeuri'){
				ret = encodeURI(source.val());
			}else if(type=='jsdecodeuri'){
				ret = decodeURI(source.val());
			}else if(type=='jsencodeuricomponent'){
				ret = decodeURIComponent(source.val());
			}else if(type=='jsdecodeuricomponent'){
				ret = encodeURIComponent(source.val());
			}
			output_html.hide();
			output.show().val(ret);
		}
	});
	$('#swap').click(function(){
		var s_val = source.val();
		output_html.hide()
		source.val(output.val());
		output.show().val(s_val);
		return;
	});
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