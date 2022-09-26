<?php
require_once('HiddenTool.php');

//Home page
class Home extends HiddenTool
{
	function Include() : void
	{
		?>
			<section>
				<header>
					<h1>dev.JANWIESEMANN.de</h1>
					<span style="text-transform: UPPERCASE">a place from lazy people by lazy people</span>
				</header>

				If you like being lazy and want to use some small helpers, this is the place to go. Here you can find a few tools which well help you to overcome the simplest but most annoying challenges of the day.
			</section>

			<section>
                <header class="major">
                    <h2>a list of tools</h2>
                </header>
				<p>
					in whatever order the file system reports
				</p>

				<ul id="toolList">
					<?php
						//this section is being called by using PHPs include('');. This is why we have access to all Parameters of the function Tool->IncludeTool(...);

						foreach(Tools::GetAllTools() as $tool)
						{
							?>
								<li>
									<a href="<?php echo $tool->linkInternal; ?>"><?php echo $tool->id; ?></a>
									<article><?php echo $tool->description; ?></article>
								</li>
							<?php
						}
					?>
				</ul>
			</section>
		<?php
	}
}
