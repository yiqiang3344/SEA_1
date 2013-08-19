<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link href="<?=$this->url('css/base.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?=$this->url('css/page.css')?>" rel="stylesheet" type="text/css" />
	<title><?=$this->pageTitle?></title>
	<script src="<?=$this->url('js/jquery.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('js/main.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('js/helper.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('widget/editor/kindeditor.js')?>" type="text/javascript"></script>
	<script type="text/javascript">
		var LANG = <?=json_encode(Yi::app()->lang)?>;
		var APP_DEBUG = <?=json_encode(APP_DEBUG)?>;
		var STIME = <?=getTime();?>;
		var CTIME = new Date().getTime();
		var BASEURL = <?=json_encode(Yi::app()->baseUrl)?>;
		var BASEURI = <?=json_encode(Yi::app()->baseUri)?>;
		$(function(){
			ybind('click',$('.jsto_home'),function(){
				State.forward('Main','Main');
			});
		});
	</script>
</head>
<body>
	<div class="pw m0a head">
		<h1 class="jsto_home">sidney</h1>
		<script type="text/javascript">showHead();</script>
	</div>
	<div id="maindiv" class="pw m0a page">
		<?=$content?>
	</div>
	<div class="pw msa foot ac">
		<p>Copyright © 2013-<?=date('Y')?> SidneyYi All Rights Reserved</p>
	</div>
</body>
