<script type="text/javascript">//template
	var template = Hogan.compile(<?=json_encode($this->template)?>);
</script>
<script type="text/javascript">//static
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
</script>
<script type="text/javascript">
	page_params = <?=json_encode($params)?>;
	maindiv.page_print();
</script>
