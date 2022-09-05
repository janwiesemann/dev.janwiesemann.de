<header>
	<h1>dev.JANWIESEMANN.de</h1>
	<span style="text-transform: UPPERCASE">a place from lazy people by lazy people</span>
</header>

<p>
	If you like being lazy and want to use some small helpers, this is the place to go. Here you can find a few tools which well help you to overcome the simplest but most annoying challenges of the day.
</p>

<h2>a list of tools</h2>
in whatever order the file system reports

<ul>
	<?php
		//this section is being called by using PHPs include('');. This is why we have access to all Parameters of the function Tool->IncludeTool(...);

		foreach($allTools as $tool)
		{
			?>
				<li><a href="index.php?id=<?php echo $tool->id ?>"><?php echo $tool->id; ?></a></li>
			<?php
		}
	?>
</ul>
