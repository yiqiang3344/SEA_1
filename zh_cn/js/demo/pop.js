var template="<div class=\"m0a w100\">\r\n\t<button id=\"pop\">\u5f39\u4e86\u4e2a\u7a97<\/button>\r\n<\/div>";
function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		ybind('click',$('#pop'),function(){
			var html = '';
			html += '<div class="mpop--normal m0a mbs w200">';
			html += '<div class="title ms">这里是标题</div>';
			html += '<div class="content">这里是内容这里是内容这里是内容这里是内容</div>';
			html += '</div>';
			html += '<div class="mpop__close m0a w50"><a>确定</a></div>';
			mpop(html);
		});
	}