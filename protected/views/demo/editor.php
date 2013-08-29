<script type="text/javascript">//template
	var template = Hogan.compile(<?=json_encode($this->template)?>);
</script>
<script type="text/javascript">//static
	page_controller = function(p){
	}

	page_bind = function(){
		var editor = KindEditor.create('textarea[name="content"]', {
			allowFileManager : false,
			langType : dealLang(LANG),
			uploadJson : getUrl('AjaxMain','EditorUploadFile'),
		}).afterCreate(function(){
			this.focus();
		});
		KindEditor('input[name=getHtml]').click(function(e) {
			alert(editor.html());
		});
		KindEditor('input[name=isEmpty]').click(function(e) {
			alert(editor.isEmpty());
		});
		KindEditor('input[name=getText]').click(function(e) {
			alert(editor.text());
		});
		KindEditor('input[name=selectedHtml]').click(function(e) {
			alert(editor.selectedHtml());
		});
		KindEditor('input[name=setHtml]').click(function(e) {
			editor.html('<h3>Hello KindEditor</h3>');
		});
		KindEditor('input[name=setText]').click(function(e) {
			editor.text('<h3>Hello KindEditor</h3>');
		});
		KindEditor('input[name=insertHtml]').click(function(e) {
			editor.insertHtml('<strong>插入HTML</strong>');
		});
		KindEditor('input[name=appendHtml]').click(function(e) {
			editor.appendHtml('<strong>添加HTML</strong>');
		});
		KindEditor('input[name=clear]').click(function(e) {
			editor.html('');
		});
	}
</script>
<script type="text/javascript">
	page_params = <?=json_encode($params)?>;
	maindiv.page_print();
</script>
