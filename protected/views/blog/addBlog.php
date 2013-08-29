<script type="text/javascript">//template
	var template = Hogan.compile(<?=json_encode($this->template)?>);
</script>
<script type="text/javascript">//static
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
</script>
<script type="text/javascript">
	page_params = <?=json_encode($params)?>;
	maindiv.page_print();
</script>
