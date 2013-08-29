<div id="blog_list" class="h580 pr">
	<div>
		<div id="pullDown">
			<p class="pullDownLabel ac fhm">Pull down to refresh...</p>
		</div>
		<ul class="mblogs prs">
		{{#list}}
			<li id="jsblog_{{id}}">
				<p class=""><span class="title js_to_blog">{{title}}</span></p>
				<p class="meta">{{time}}</p>
				<p class="summary ellipsis">{{content}}</p>
				<p class="more"><s class="more--s dn" id="edit_blog_{{id}}">编辑</s> <s class="more--s js_to_blog">阅读全文>></s></p>
			</li>
		{{/list}}
		</ul>
		<div id="pullUp">
			<p class="pullUpLabel ac fhm">Pull up to load more..</p>
		</div>
	</div>
</div>