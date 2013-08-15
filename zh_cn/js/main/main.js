var template="<ul class=\"mblogs\">\r\n{{#list}}\r\n\t<li id=\"jsblog_{{id}}\">\r\n\t\t<p class=\"\"><span class=\"title jsto_blog\">{{title}}<\/span><\/p>\r\n\t\t<p class=\"meta\">{{time}}<\/p>\r\n\t\t<p class=\"summary ellipsis\">{{content}}<\/p>\r\n\t\t<p class=\"more\"><s class=\"more--s jsto_blog\">\u9605\u8bfb\u5168\u6587>><\/s><\/p>\r\n\t<\/li>\r\n{{\/list}}\r\n<\/ul>";
function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		bind_click($('.jsto_blog'),function(){
			var id = $(this).parents('li').attr('id').replace('jsblog_','');
			State.forward('Main','Blog',{id:id});
		});
	}