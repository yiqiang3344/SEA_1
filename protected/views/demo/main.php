<script type="text/javascript">//template
	var template = <?=json_encode($this->template)?>;//指定模板数据来源,开发的之后直接php赋值,发布时将其替换为外链
</script>
<script type="text/javascript">//static
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
</script>
<script type="text/javascript">
	//model
	var params = {};

	//view
	m_print();
</script>
