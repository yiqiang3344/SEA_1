var template="<div class=\"mblog\">\r\n\t<p class=\"title ac\">{{title}}<\/p>\r\n\t<p class=\"meta ar prs\">{{time}}<\/p>\r\n\t<div class=\"mblog__content\">{{{content}}}<\/div>\r\n<\/div>";
function m_print(){
		var html = Mustache.to_html(template, info);
		document.write(html);
	}