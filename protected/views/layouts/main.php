<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link href="<?=$this->url('css/base.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?=$this->url('css/page.css')?>" rel="stylesheet" type="text/css" />
	<title><?=$this->pageTitle?></title>
	<script type="text/javascript">
		var LANG = <?=json_encode(Yi::app()->lang)?>;
		var APP_DEBUG = <?=json_encode(APP_DEBUG)?>;
		var STIME = <?=getTime();?>;
		var CTIME = new Date().getTime();
		var BASEURL = <?=json_encode(Yi::app()->baseUrl)?>;
		var BASEURI = <?=json_encode(Yi::app()->baseUri)?>;
		var USER = <?=json_encode($this->getUserData())?>;
	</script>
	<script src="<?=$this->url('js/jquery.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('js/url.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('js/main.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('js/helper.js')?>" type="text/javascript"></script>
	<script src="<?=$this->url('widget/editor/kindeditor.js')?>" type="text/javascript"></script>
</head>
<body>
	<div class="pw m0a head">
		<h1 class="js_to_home">sidney</h1>
		<script type="text/javascript">var hdMod = new Header();hdMod.show();</script>
	</div>
	<div id="maindiv" class="pw m0a page">
		<?=$content?>
	</div>
	<div class="pw msa foot ac">
		<p>Copyright © 2013-<?=date('Y')?> SidneyYi All Rights Reserved</p>
	</div>
	<script type="text/javascript">
		var mloading = new Mloading;
		ybind('click',$('.js_to_home'),function(){
			State.forward('Main','Main');
		});
	</script>
</body>
