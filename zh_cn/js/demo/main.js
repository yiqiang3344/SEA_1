var template="<div class=\"mdemo\">\r\n\t<a class=\"js_pop\">\u5f39\u7a97<\/a>\r\n<\/div>";
function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		bind_click($('.js_pop'),function(){
			State.forward('Demo','Pop');
		});
	}