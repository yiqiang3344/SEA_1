template = new Hogan.Template();template.r =function(c,p,i){var _=this;_.b(i=i||"");_.b("<div class=\"mblog\">\r");_.b("\n" + i);_.b("	<p class=\"title ac\">");_.b(_.v(_.f("title",c,p,0)));_.b("</p>\r");_.b("\n" + i);_.b("	<p class=\"meta ar prs\"><a class=\"dn\" id=\"edit_blog\">编辑</a> ");_.b(_.v(_.f("time",c,p,0)));_.b("</p>\r");_.b("\n" + i);_.b("	<div class=\"mblog__content\">");_.b(_.t(_.f("content",c,p,0)));_.b("</div>\r");_.b("\n" + i);_.b("</div>");return _.fl();;};
page_controller = function(p){
		page_params.time = dateFormat(page_params.record_time,1);
	}

	page_bind = function(){
		highlighter();
		if(USER){
			var obj = $('#edit_blog').show();
			ybind('click',obj,function(){
				State.forward('Blog','EditBlog',{id:page_params.id});
			});
		}
	}