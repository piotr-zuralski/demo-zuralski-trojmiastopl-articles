<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl_PL" dir="ltr" lang="pl_PL">
	<head>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<title>{$pageName|escape} - {$siteName}</title>
		<meta name="author" content="zuralski.net (http://zuralski.net)"/>
		<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen,print"/>
	</head>
	<body>
		<div class="page_margins">
			<div class="page">

				<div id="header" role="banner">
					<h1 class="pageName">{$pageName|escape}</h1>
					<h2 class="siteName"><span>{$siteName}</span></h2>
				</div>

				<div id="nav">
					<div class="hlist">
						<ul>
							<li><a href="/" title="Strona główna">Strona główna</a></li>
						</ul>
					</div>
				</div>

				<div id="main">
					
					<div id="col1" role="main">
						<div id="col1_content" class="clearfix">
							{$content|default:''}
						</div>
					</div>

				</div>
				
				<div id="footer">
					<p class="copyright notranslate">
						Copyright &copy; {$smarty.now|date_format:'%Y'} <strong>DemoSite</strong>
					</p>
					<p class="powered-by notranslate">
						Powered by: <a href="http://zuralski.net" title="zuralski.net" rel="external"><strong>zuralski.net</strong></a>
					</p>
				</div>

			</div>
		</div>
	</body>
</html>
