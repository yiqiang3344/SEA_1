<script type="text/javascript">//template
	template = Hogan.compile(<?=json_encode($this->template)?>);
</script>
<script type="text/javascript">//static
	page_controller = function(p){
		$.each(p.list,function(k,v){
			p.list[k].time = dateFormat(v.record_time);
		});
	}
	page_bind = function(){
		function bind(){
			ybind('click',$('.js_to_blog'),function(){
				var id = $(this).parents('li').attr('id').replace('jsblog_','');
				State.forward('Blog','Blog',{id:id});
			});

			if(USER){
				var obj = $('[id^="edit_blog_"]').show();
				ybind('click',obj,function(){
					var id = $(this).attr('id').replace('edit_blog_','');
					State.forward('Blog','EditBlog',{id:id});
				});
			}
		}
		bind();

		var myScroll,
			pullDownEl, pullDownOffset,
			pullUpEl, pullUpOffset,
			generatedCount = 0;
		document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
		setTimeout(loaded, 200);

		function pullDownAction () {
			yajax('AjaxBlog','GetNewBlogs',{id:page_params.list[0].id},function(obj){
				if(obj.code==1){
					var html = '';
					obj.list.reverse().forEach(function(v){
						v.time = dateFormat(v.record_time);
						page_params.list.unshift(v);
						html+='<li id="jsblog_'+v.id+'">';
						html+='	<p class=""><span class="title js_to_blog">'+v.title+'</span></p>';
						html+='	<p class="meta">'+v.time+'</p>';
						html+='	<p class="summary ellipsis">'+v.content+'</p>';
						html+='	<p class="more"><s class="more--s dn" id="edit_blog_'+v.id+'}">编辑</s> <s class="more--s js_to_blog">阅读全文>></s></p>';
						html+='</li>';
					});
					$('#blog_list ul:first').prepend(html);
					bind();
					myScroll.refresh();
				}
			},$('#pullDown'));
		}

		function pullUpAction () {
			yajax('AjaxBlog','GetMoreBlogs',{id:page_params.list[page_params.list.length-1].id},function(obj){
				if(obj.code==1){
					var html = '';
					obj.list.forEach(function(v){
						v.time = dateFormat(v.record_time);
						page_params.list.push(v);
						html+='<li id="jsblog_'+v.id+'">';
						html+='	<p class=""><span class="title js_to_blog">'+v.title+'</span></p>';
						html+='	<p class="meta">'+v.time+'</p>';
						html+='	<p class="summary ellipsis">'+v.content+'</p>';
						html+='	<p class="more"><s class="more--s dn" id="edit_blog_'+v.id+'}">编辑</s> <s class="more--s js_to_blog">阅读全文>></s></p>';
						html+='</li>';
					});
					$('#blog_list ul:first').append(html);
					bind();
					myScroll.refresh();
				}
			},$('#pullUp'));
		}

		function loaded() {
			pullDownEl = document.getElementById('pullDown');
			pullDownOffset = pullDownEl.offsetHeight;
			pullUpEl = document.getElementById('pullUp');	
			pullUpOffset = pullUpEl.offsetHeight;
			
			myScroll = new iScroll('blog_list', { 
	        	scrollbarClass: 'myScrollbar',
				useTransition: true,
				topOffset: pullDownOffset,
				onRefresh: function () {
					if (pullDownEl.className.match('Iloading')) {
						pullDownEl.className = '';
						pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Pull down to refresh...';
					} else if (pullUpEl.className.match('Iloading')) {
						pullUpEl.className = '';
						pullUpEl.querySelector('.pullUpLabel').innerHTML = 'Pull up to load more...';
					}
					mloading.end();
				},
				onScrollMove: function () {
					if (this.y > 5 && !pullDownEl.className.match('flip')) {
						pullDownEl.className = 'flip';
						pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Release to refresh...';
						this.minScrollY = 0;
					} else if (this.y < 5 && pullDownEl.className.match('flip')) {
						pullDownEl.className = '';
						pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Pull down to refresh...';
						this.minScrollY = -pullDownOffset;
					} else if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
						pullUpEl.className = 'flip';
						pullUpEl.querySelector('.pullUpLabel').innerHTML = 'Release to refresh...';
						this.maxScrollY = this.maxScrollY;
					} else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
						pullUpEl.className = '';
						pullUpEl.querySelector('.pullUpLabel').innerHTML = 'Pull up to load more...';
						this.maxScrollY = pullUpOffset;
					}
				},
				onScrollEnd: function () {
					if (pullDownEl.className.match('flip')) {
						pullDownEl.className = 'Iloading';
						pullDownEl.querySelector('.pullDownLabel').innerHTML = 'Loading...';				
						mloading.start();
						pullDownAction();
					} else if (pullUpEl.className.match('flip')) {
						pullUpEl.className = 'Iloading';
						pullUpEl.querySelector('.pullUpLabel').innerHTML = 'Loading...';				
						mloading.start();
						pullUpAction();
					}
				}
			});
		}
	}
</script>
<script type="text/javascript">//print
	page_params = <?=json_encode($params)?>;
	maindiv.page_print();
</script>
