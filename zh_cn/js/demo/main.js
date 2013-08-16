var template="<div class=\"mdemo\">\r\n\t<a class=\"js_pop\">\u5f39\u7a97<\/a>\r\n\t<a class=\"js_anim\">web app\u52a8\u753b<\/a>\r\n<\/div>";
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
			html += '<div class="title ms">web app动画</div>';
			html += '<div class="js_demo_1 w300 h150">';
			html += '	<div class="js_demo_1_img demo_1_img"></div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="mpop__close m0a w50"><a>确定</a></div>';
			var bind = function(){
				$('.js_demo_1_img').remove();
				draw_anim($('.js_demo_1'),getUrl('images/demo/demo3.png'),279,151,60).play(function(){$('.js_demo_1').append('<div class="js_demo_1_img demo_1_img"></div>')});
			}
			mpop(html,bind);
		});
	}