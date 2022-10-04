<?php
require_once('backend/Tools.php');

Tools::SetWebRoot(__DIR__);

if (isset($_GET["json"]))
{
	//A special switch to get all available tools as JSON. Used on https://janwiesemann.de/#devtools.

	header('Content-Type', 'application/json');

	echo json_encode(Tools::GetAllTools());

	exit();
}

$currentTool = Tools::GetCurrentTool();
?>

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
	<title>/dev_tools/<?php echo $currentTool->id; ?> - JAN WIESEMANN.de</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<header id="header">
					<span class="logo"><strong>/dev_tools/<?php echo $currentTool->id; ?></strong><span style="margin-left: 1em;">the ART of being lazy*</span></span>
					<ul class="icons">
						<li><a href="<?php echo $currentTool->linkGitHub; ?>" target="_blank" class="icon brands fa-github"><span class="label">Source on GitHub</span></a></li>
						<li><a href="https://janwiesemann.de" target="_blank" class="icon fa-globe-europe"><span class="label">JANWIESEMANN.de</span></a></li>
					</ul>
				</header>

				<!-- Page Content -->
				<?php $currentTool->Include(); ?>

				<section>
					<header class="major">
						<h2>open source</h2>
					</header>
					<p>found a bug or want to add something?</p>
					<ul>
						<li><a href="https://github.com/janwiesemann/dev.janwiesemann.de" target="_blank">full repository</a></li>
						<li><a href="<?php echo $currentTool->linkGitHub; ?>" target="_blank">current tool (<?php echo $currentTool->id; ?>)</a></li>
					</ul>
				</section>

				<section>
					<header class="major">
						<h2>the ART of being lazy*</h2>
					</header>
					<p>* and spending a few hours to develop a tool for a simple task, which would take only a few seconds.</p>
				</section>

			</div>
		</div>

		<!-- Sidebar -->
		<div id="sidebar">
			<div class="inner">

				<header class="major">
					<h2><a href="index.php">dev.JANWIESEMANN.de</a></h2>
				</header>

				<!-- Search -->
				<section class="search alt">
					<form method="get">
						<input type="text" name="tool" id="tool" placeholder="Search" />
					</form>
				</section>

				<!-- Menu -->
				<nav id="menu">
					<header class="major">
						<h2><a href="?">/dev_tools</a></h2>
					</header>

					<ul>
						<?php
						//Grouping all tools by langauge
						$groups = array();
						foreach (Tools::GetAllTools() as $tool)
						{
							if (!array_key_exists($tool->language, $groups))
							{
								$groups[$tool->language] = array();
							}

							array_push($groups[$tool->language], $tool);
						}

						//Adding entries for the menu system
						foreach ($groups as $language => $tools)
						{
						?>
							<li>
								<span class="opener<?php if ($language === $currentTool->language) echo " active"; ?>">/<?php echo $language; ?></span>
								<ul>
									<?php
									foreach ($tools as $tool)
									{
									?>
										<li <?php if ($tool === $currentTool) echo 'class="active"'; ?>><a href="<?php echo $tool->linkInternal; ?>">/<?php echo $tool->name; ?></a></li>
									<?php
									}
									?>
								</ul>
							</li>
						<?php
						}
						?>
					</ul>
				</nav>

				<!-- Footer -->
				<footer id="footer">
					<p class="copyright">by <a href="https://janwiesemann.de" target="_blank">JANWIESEMANN.de</a></p>
					<p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
					<p class="copyright">even tho I like cookies, I hate the European union's stupid cookie messages. This is why this page does not use any cookies and does not collect any data.</p>
				</footer>

			</div>
		</div>

	</div>

	<!-- Scripts -->
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>

</body>

</html>
