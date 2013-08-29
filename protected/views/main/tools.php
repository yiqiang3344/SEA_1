<script type="text/javascript">//template
	template = Hogan.compile(<?=json_encode($this->template)?>);
</script>
<script type="text/javascript">//static
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
</script>
<script type="text/javascript">//print
	page_params = <?=json_encode($params)?>;
	maindiv.page_print();
</script>