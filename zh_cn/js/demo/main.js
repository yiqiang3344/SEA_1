template = new Hogan.Template();template.r =function(c,p,i){var _=this;_.b(i=i||"");_.b("<div class=\"mdemo\">\r");_.b("\n" + i);_.b("	<a class=\"js_pop\">弹窗</a>\r");_.b("\n" + i);_.b("	<a class=\"js_anim\">web app动画</a>\r");_.b("\n" + i);_.b("	<a class=\"js_editor\">富文本编辑器</a>\r");_.b("\n" + i);_.b("</div>");return _.fl();;};
page_controller = function(p){
	}

	page_bind = function(){
		ybind('click',$('.js_pop'),function(){
			var html = '';
			html += '<div class="mpop--normal m0a mbs w200">';
			html += '<div class="title ms">这里是标题</div>';
			html += '<div class="content">这里是内容这里是内容这里是内容这里是内容</div>';
			html += '</div>';
			html += '<div class="m0a w50"><a class="js_close">确定</a></div>';
			mpop(html);
		});

		ybind('click',$('.js_anim'),function(){
			var html = '';
			html += '<div class="mpop--normal m0a mbs w300">';
			html += '	<div class="title ms">web app动画</div>';
			html += '	<div class="js_demo_1 pr"></div>';
			html += '</div>';
			html += '<div class="m0a w50"><a class="js_close">确定</a></div>';
			mpop(html,function(){
				draw_anim($('.js_demo_1'),300,300,'anim_tank',60).play();
			});
		});

		ybind('click',$('.js_editor'),function(){
			State.forward('Demo','Editor');
		});
	}