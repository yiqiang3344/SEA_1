<script type="text/javascript">//template
	var template = Hogan.compile(<?=json_encode($this->template)?>);
</script>
<script type="text/javascript">//static
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
</script>
<script type="text/javascript">
	page_params = <?=json_encode($params)?>;
	maindiv.page_print();
</script>