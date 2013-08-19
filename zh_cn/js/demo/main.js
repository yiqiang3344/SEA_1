var template="<div class=\"mdemo\">\r\n\t<a class=\"js_pop\">\u5f39\u7a97<\/a>\r\n\t<a class=\"js_anim\">web app\u52a8\u753b<\/a>\r\n\t<a class=\"js_editor\">\u5bcc\u6587\u672c\u7f16\u8f91\u5668<\/a>\r\n\t<!-- <a class=\"js_scroll\">\u6ed1\u52a8\u7a97\u53e3<\/a> -->\r\n<\/div>";
function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		ybind('click',$('.js_pop'),function(){
			var html = '';
			html += '<div class="mpop--normal m0a mbs w200">';
			html += '<div class="title ms">这里是标题</div>';
			html += '<div class="content">这里是内容这里是内容这里是内容这里是内容</div>';
			html += '</div>';
			html += '<div class="mpop__close m0a w50"><a>确定</a></div>';
			mpop(html);
		});

		ybind('click',$('.js_anim'),function(){
			var html = '';
			html += '<div class="mpop--normal m0a mbs w300">';
			html += '	<div class="title ms">web app动画</div>';
			html += '	<div class="js_demo_1 pr"></div>';
			html += '</div>';
			html += '<div class="mpop__close m0a w50"><a>确定</a></div>';
			var bind = function(){
				draw_anim($('.js_demo_1'),300,300,'anim_tank',60).play();
			}
			mpop(html,bind);
		});

		ybind('click',$('.js_editor'),function(){
			State.forward('Demo','Editor');
		});
	}