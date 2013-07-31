<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<link href="<?=Yi::app()->url('css/base.css')?>" rel="stylesheet" type="text/css" />
	<link href="<?=Yi::app()->url('css/page.css')?>" rel="stylesheet" type="text/css" />
	<title><?=$this->pageTitle?></title>
	<script src="<?=Yi::app()->url('script/jquery-1.9.0.min.js')?>" type="text/javascript"></script>
	<script src="<?=Yi::app()->url('script/base.js')?>" type="text/javascript"></script>
	<script type="text/javascript">
		var STIME = <?=getTime();?>;
		var CTIME = new Date().getTime();
		var BASEURL = <?=json_encode(Yi::app()->baseUrl)?>;
		var BASEURI = <?=json_encode(Yi::app()->baseUri)?>;
		$(function(){
			$('.jsto_home').click(function(){
				State.forward('Main','Main');
			});
		});
	</script>
</head>
<body>
	<div class="pw m0a head">
		<h1 class="jsto_home">sidney</h1>
		<div>
			<a href="<?=Yi::app()->url('Main','Tools')?>">web开发工具</a>
		</div>
	</div>
	<div id="maindiv" class="pw m0a page">
		<?=$content?>
	</div>
	<div class="pw msa foot ac">
		<p>Copyright © 2013-<?=date('Y')?> SidneyYi All Rights Reserved</p>
	</div>
</body>
