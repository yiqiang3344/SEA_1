template = new Hogan.Template();template.r =function(c,p,i){var _=this;_.b(i=i||"");_.b("<div>\r");_.b("\n" + i);_.b("	<span><input id=\"tmp_html\" type=\"button\" value=\"html模板\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"get_time\" type=\"button\" value=\"时间戳\"></span>\r");_.b("\n" + i);_.b("</div>\r");_.b("\n" + i);_.b("<div>\r");_.b("\n" + i);_.b("	<textarea id=\"source\" class=\"wfull h150\"></textarea>\r");_.b("\n" + i);_.b("</div>\r");_.b("\n" + i);_.b("<div>\r");_.b("\n" + i);_.b("	<span><input id=\"clear_source\" type=\"button\" value=\"还原\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"swap\" type=\"button\" value=\"互换\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"date_format\" type=\"button\" value=\"日期格式化\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"execute_js\" type=\"button\" value=\"执行js\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"execute_html\" type=\"button\" value=\"执行html\"></span>\r");_.b("\n" + i);_.b("	<span>\r");_.b("\n" + i);_.b("		<select id=\"encrypt_type\" type=\"button\">\r");_.b("\n" + i);_.b("			<option value=\"json_encode\">数组转json</option>\r");_.b("\n" + i);_.b("			<option value=\"json_decode\">json转数组</option>\r");_.b("\n" + i);_.b("			<option value=\"md5\">md5</option>\r");_.b("\n" + i);_.b("			<option value=\"base64_encode\">转base64</option>\r");_.b("\n" + i);_.b("			<option value=\"base64_decode\">解base64</option>\r");_.b("\n" + i);_.b("			<option value=\"addslashes\">转义</option>\r");_.b("\n" + i);_.b("			<option value=\"stripslashes\">反转义</option>\r");_.b("\n" + i);_.b("			<option value=\"htmlentities\">转实体</option>\r");_.b("\n" + i);_.b("			<option value=\"html_entity_decode\">反转实体</option>\r");_.b("\n" + i);_.b("			<option value=\"jsencodeuri\">转jsURI</option>\r");_.b("\n" + i);_.b("			<option value=\"jsdecodeuri\">解jsURI</option>\r");_.b("\n" + i);_.b("			<option value=\"jsencodeuricomponent\">转jsURIComponent</option>\r");_.b("\n" + i);_.b("			<option value=\"jsdecodeuricomponent\">解jsURIComponent</option>\r");_.b("\n" + i);_.b("		</select>\r");_.b("\n" + i);_.b("		<input id=\"encrypt\" type=\"button\" value=\"执行\">\r");_.b("\n" + i);_.b("	</span>\r");_.b("\n" + i);_.b("	<span><input id=\"format_css\" type=\"button\" value=\"css格式化\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"compress_css\" type=\"button\" value=\"css压缩\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"format_js\" type=\"button\" value=\"js格式化\"></span>\r");_.b("\n" + i);_.b("	<span><input id=\"compress_js\" type=\"button\" value=\"js压缩\"></span>\r");_.b("\n" + i);_.b("</div>\r");_.b("\n" + i);_.b("<div id=\"output_html\" class=\"dn\">\r");_.b("\n" + i);_.b("</div>\r");_.b("\n" + i);_.b("<div>\r");_.b("\n" + i);_.b("	<textarea id=\"output\" class=\"wfull h150\"></textarea>\r");_.b("\n" + i);_.b("</div>");return _.fl();;};
page_controller = function(p){
	}
	page_bind = function(){
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

		ybind('click',$('#compress_js'),function(){
			var s_val = source.val();
			yajax('AjaxMain','Compress',{type:'js',source:source.val()},function(obj){
				if(obj.code==1){
					output_html.hide();
					output.show().val(obj.ret);
				}
			},this);
		});
		ybind('click',$('#format_js'),function(){
			var s_val = source.val();
			output_html.hide();
			output.show().val(jsBeautify(s_val));
		});
		ybind('click',$('#compress_css'),function(){
			var s_val = source.val();
			yajax('AjaxMain','Compress',{type:'css',source:source.val()},function(obj){
				if(obj.code==1){
					output_html.hide();
					output.show().val(obj.ret);
				}
			},this);
		});
		ybind('click',$('#format_css'),function(){
			var s_val = source.val();
			yajax('AjaxMain','Format',{type:'css',source:source.val()},function(obj){
				if(obj.code==1){
					output_html.hide();
					output.show().val(obj.ret);
				}
			},this);
		});
		ybind('click',$('#encrypt'),function(){
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
		ybind('click',$('#swap'),function(){
			var s_val = source.val();
			output_html.hide()
			source.val(output.val());
			output.show().val(s_val);
			return;
		});
		ybind('click',$('#execute_html'),function(){
			var s = document.getElementById("source");
			output.hide();
			output_html.show().html(s.value);
			return;
		});
		ybind('click',$('#execute_js'),function(){
			var s = document.getElementById("source");
			eval(s.value);
			return;
		});
		ybind('click',$('#tmp_html'),function(){
			source.val(tmp_html);
		});
		ybind('click',$('#clear_source'),function(){
			source.val('');
			output.show().val('');
			output_html.hide().html('');
		});
		ybind('click',$('#get_time'),function(){
			source.val(time());
		});
		ybind('click',$('#date_format'),function(){
			var date = source.val();
			output_html.hide();
			output.show().val(dateFormat(date,2));
		});
	}