var template="<form>\r\n\t<textarea name=\"content\" style=\"width:100%;height:500px;visibility:hidden;\"><\/textarea>\r\n\t<p>\r\n\t\t<input type=\"button\" name=\"getHtml\" value=\"\u53d6\u5f97HTML\" \/>\r\n\t\t<input type=\"button\" name=\"isEmpty\" value=\"\u5224\u65ad\u662f\u5426\u4e3a\u7a7a\" \/>\r\n\t\t<input type=\"button\" name=\"getText\" value=\"\u53d6\u5f97\u6587\u672c(\u5305\u542bimg,embed)\" \/>\r\n\t\t<input type=\"button\" name=\"selectedHtml\" value=\"\u53d6\u5f97\u9009\u4e2dHTML\" \/>\r\n\t\t<br \/>\r\n\t\t<br \/>\r\n\t\t<input type=\"button\" name=\"setHtml\" value=\"\u8bbe\u7f6eHTML\" \/>\r\n\t\t<input type=\"button\" name=\"setText\" value=\"\u8bbe\u7f6e\u6587\u672c\" \/>\r\n\t\t<input type=\"button\" name=\"insertHtml\" value=\"\u63d2\u5165HTML\" \/>\r\n\t\t<input type=\"button\" name=\"appendHtml\" value=\"\u6dfb\u52a0HTML\" \/>\r\n\t\t<input type=\"button\" name=\"clear\" value=\"\u6e05\u7a7a\u5185\u5bb9\" \/>\r\n\t\t<input type=\"reset\" name=\"reset\" value=\"Reset\" \/>\r\n\t<\/p>\r\n<\/form>";
function m_print(){
		var html = Mustache.to_html(template, params);
		document.write(html);

		var editor;
		KindEditor.ready(function(K) {
			editor = K.create('textarea[name="content"]', {
				allowFileManager : false,
				langType : dealLang(LANG),
				uploadJson : getUrl('AjaxMain','EditorUploadFile'),
			}).afterCreate(function(){
				this.focus();
			});
			K('input[name=getHtml]').click(function(e) {
				alert(editor.html());
			});
			K('input[name=isEmpty]').click(function(e) {
				alert(editor.isEmpty());
			});
			K('input[name=getText]').click(function(e) {
				alert(editor.text());
			});
			K('input[name=selectedHtml]').click(function(e) {
				alert(editor.selectedHtml());
			});
			K('input[name=setHtml]').click(function(e) {
				editor.html('<h3>Hello KindEditor</h3>');
			});
			K('input[name=setText]').click(function(e) {
				editor.text('<h3>Hello KindEditor</h3>');
			});
			K('input[name=insertHtml]').click(function(e) {
				editor.insertHtml('<strong>插入HTML</strong>');
			});
			K('input[name=appendHtml]').click(function(e) {
				editor.appendHtml('<strong>添加HTML</strong>');
			});
			K('input[name=clear]').click(function(e) {
				editor.html('');
			});
		});
	}