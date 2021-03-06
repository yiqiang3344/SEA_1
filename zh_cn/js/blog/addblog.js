template = new Hogan.Template();template.r =function(c,p,i){var _=this;_.b(i=i||"");_.b("<form>\r");_.b("\n" + i);_.b("	<p>\r");_.b("\n" + i);_.b("		<input class=\"wfull\" type=\"text\" id=\"title\" placeholder=\"标题\"/>\r");_.b("\n" + i);_.b("	</p>\r");_.b("\n" + i);_.b("	<textarea name=\"content\" style=\"width:100%;height:500px;visibility:hidden;\"></textarea>\r");_.b("\n" + i);_.b("	<p>\r");_.b("\n" + i);_.b("		<input type=\"text\" id=\"highlight\" placeholder=\"高亮行号，如: 1,2\"/>\r");_.b("\n" + i);_.b("		<input type=\"button\" id=\"add_blog\" value=\"提交\"/>\r");_.b("\n" + i);_.b("	</p>\r");_.b("\n" + i);_.b("</form>");return _.fl();;};
page_controller = function(p){
		if(!USER){
			State.back(1);
		}
	}

	page_bind = function(){
		var editor = KindEditor.create('textarea[name="content"]', {
			allowFileManager : false,
			langType : dealLang(LANG),
			uploadJson : getUrl('AjaxMain','EditorUploadFile'),
		}).afterCreate(function(){
			this.focus();
		});
		editor.focus();

		ybind('click',$('#add_blog'),function(){
			var highlight = $('#highlight').val();
			var title = $('#title').val();
			var content = editor.html().replace(/<pre class="(.*?)prettyprint lang-(.*?)">/g,'<pre class="$1brush:$2;highlight:['+highlight+']">');
			if(title==''){
				alert('标题不能为空！');
				return;
			}else if(content==''){
				alert('内容不能为空！');
				return;
			}
			yajax('AjaxBlog','AddBlog',{title:title,content:content},function(obj){
				if(obj.code==1){
					showTip('发布成功！',function(){
						State.forward('Blog','Blog',{id:obj.id});
					});
				}
			},this);
		});
	}