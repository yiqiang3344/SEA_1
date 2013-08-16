var template="<div>\r\n\t<span><input id=\"tmp_html\" type=\"button\" value=\"html\u6a21\u677f\"><\/span>\r\n\t<span><input id=\"get_time\" type=\"button\" value=\"\u65f6\u95f4\u6233\"><\/span>\r\n<\/div>\r\n<div>\r\n\t<textarea id=\"source\" class=\"wfull h150\"><\/textarea>\r\n<\/div>\r\n<div>\r\n\t<span><input id=\"clear_source\" type=\"button\" value=\"\u8fd8\u539f\"><\/span>\r\n\t<span><input id=\"swap\" type=\"button\" value=\"\u4e92\u6362\"><\/span>\r\n\t<span><input id=\"date_format\" type=\"button\" value=\"\u65e5\u671f\u683c\u5f0f\u5316\"><\/span>\r\n\t<span><input id=\"execute_js\" type=\"button\" value=\"\u6267\u884cjs\"><\/span>\r\n\t<span><input id=\"execute_html\" type=\"button\" value=\"\u6267\u884chtml\"><\/span>\r\n\t<span>\r\n\t\t<select id=\"encrypt_type\" type=\"button\">\r\n\t\t\t<option value=\"json_encode\">\u6570\u7ec4\u8f6cjson<\/option>\r\n\t\t\t<option value=\"json_decode\">json\u8f6c\u6570\u7ec4<\/option>\r\n\t\t\t<option value=\"md5\">md5<\/option>\r\n\t\t\t<option value=\"base64_encode\">\u8f6cbase64<\/option>\r\n\t\t\t<option value=\"base64_decode\">\u89e3base64<\/option>\r\n\t\t\t<option value=\"addslashes\">\u8f6c\u4e49<\/option>\r\n\t\t\t<option value=\"stripslashes\">\u53cd\u8f6c\u4e49<\/option>\r\n\t\t\t<option value=\"htmlentities\">\u8f6c\u5b9e\u4f53<\/option>\r\n\t\t\t<option value=\"html_entity_decode\">\u53cd\u8f6c\u5b9e\u4f53<\/option>\r\n\t\t\t<option value=\"jsencodeuri\">\u8f6cjsURI<\/option>\r\n\t\t\t<option value=\"jsdecodeuri\">\u89e3jsURI<\/option>\r\n\t\t\t<option value=\"jsencodeuricomponent\">\u8f6cjsURIComponent<\/option>\r\n\t\t\t<option value=\"jsdecodeuricomponent\">\u89e3jsURIComponent<\/option>\r\n\t\t<\/select>\r\n\t\t<input id=\"encrypt\" type=\"button\" value=\"\u6267\u884c\">\r\n\t<\/span>\r\n\t<span><input id=\"format_css\" type=\"button\" value=\"css\u683c\u5f0f\u5316\"><\/span>\r\n\t<span><input id=\"compress_css\" type=\"button\" value=\"css\u538b\u7f29\"><\/span>\r\n\t<span><input id=\"format_js\" type=\"button\" value=\"js\u683c\u5f0f\u5316\"><\/span>\r\n\t<span><input id=\"compress_js\" type=\"button\" value=\"js\u538b\u7f29\"><\/span>\r\n<\/div>\r\n<div id=\"output_html\" class=\"dn\">\r\n<\/div>\r\n<div>\r\n\t<textarea id=\"output\" class=\"wfull h150\"><\/textarea>\r\n<\/div>";
function m_print(){
		var html = Mustache.to_html(template, {});
		document.write(html);

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