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
	<span><input id="compress_css" type="button" value="css压缩"></span>
</div>
<div id="output_html" class="dn">
</div>
<div>
	<textarea id="output" class="wfull h150"></textarea>
</div>