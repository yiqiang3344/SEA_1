template = new Hogan.Template();template.r =function(c,p,i){var _=this;_.b(i=i||"");_.b("<form>\r");_.b("\n" + i);_.b("	<textarea name=\"content\" style=\"width:100%;height:500px;visibility:hidden;\"></textarea>\r");_.b("\n" + i);_.b("	<p>\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"getHtml\" value=\"取得HTML\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"isEmpty\" value=\"判断是否为空\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"getText\" value=\"取得文本(包含img,embed)\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"selectedHtml\" value=\"取得选中HTML\" />\r");_.b("\n" + i);_.b("		<br />\r");_.b("\n" + i);_.b("		<br />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"setHtml\" value=\"设置HTML\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"setText\" value=\"设置文本\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"insertHtml\" value=\"插入HTML\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"appendHtml\" value=\"添加HTML\" />\r");_.b("\n" + i);_.b("		<input type=\"button\" name=\"clear\" value=\"清空内容\" />\r");_.b("\n" + i);_.b("		<input type=\"reset\" name=\"reset\" value=\"Reset\" />\r");_.b("\n" + i);_.b("	</p>\r");_.b("\n" + i);_.b("</form>");return _.fl();;};
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