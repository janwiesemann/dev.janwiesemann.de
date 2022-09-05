<?php

include_once('tool.php');

$allTools = GetAllTools();
if(isset($_GET["json"]))
{
	//a special switch to get all tools as JSON. Used on https://janwiesemann.de/#devtools.

	header('Content-Type', 'application/json');
	echo json_encode($allTools);
	exit();
}


$currentTool = GetCurrentTool($allTools);
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
									<a href="index.php?id=<?php echo $currentTool->id; ?>" class="logo"><strong>/dev_tools/<?php echo $currentTool->id; ?></strong><span style="margin-left: 1em;">the ART of being lazy*</span></a>
									<ul class="icons">
										<li><a href="https://github.com/janwiesemann/dev.janwiesemann.de" target="_blank" class="icon brands fa-github"><span class="label">Source on GitHub</span></a></li>
										<li><a href="https://janwiesemann.de" target="_blank" class="icon fa-globe-europe"><span class="label">JANWIESEMANN.de</span></a></li>
									</ul>
								</header>

							<!-- Page Content -->
								<section>
									<?php
										if($currentTool->name != null)
										{
											?>
												<header class="major">
													<h2><?php echo $currentTool->name; ?></h2>
												</header>
											<?php
										}
									?>
																	
									<?php
										$currentTool->IncludeTool($allTools);
									?>
								</section>
								
								<section>
									<header class="major">
										<h2>Open source</h2>
									</header>
									<p>Found a bug or want to add something? No problem! Access the full source code at <a href="https://github.com/janwiesemann/dev.janwiesemann.de" target="_blank">GitHub</a>!</p>
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
								<!--<section id="search" class="alt">
									<form method="post" action="#">
										<input type="text" name="query" id="query" placeholder="Search" />
									</form>
								</section>-->

							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2><a href="index.php">/dev_tools</a></h2>
									</header>

									<ul>
										<?php



											$grouped = array();
											foreach($allTools as $tool)
											{
												if(!array_key_exists($tool->language, $grouped)) {
													$grouped[$tool->language] = array();
												}

												array_push($grouped[$tool->language], $tool);
											}

											foreach($grouped as $key => $group)
											{
												?>
													<li>
														<span class="opener">/<?php echo $key; ?></span>
														<ul>
															<?php
																foreach($group as $tool)
																{
																	?>
																		<li><a href="index.php?id=<?php echo $tool->id ?>">/<?php echo $tool->name; ?></a></li>
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