<?php
require_once('HiddenTool.php');

//Home page
class Home extends HiddenTool
{
	function Include(): void
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
				in whatever A order.
			</p>

			<ul id="toolList">
				<?php
				//this section is being called by using PHPs include('');. This is why we have access to all Parameters of the function Tool->IncludeTool(...);

				//Print all child nodes recursive
				function AppendRecursive(array $arr)
				{
					foreach ($arr as $group => $entry)
					{
						if (is_array($entry))
						{
				?>
							<li>
								<span style="text-transform: UPPERCASE"><?php echo $group; ?></span>
								<ul>
									<?php AppendRecursive($entry); ?>
								</ul>
							</li>
						<?php
						}
						else if (is_subclass_of($entry, ToolBase::class))
						{
						?>
							<li>
								<a href="<?php echo $entry->linkInternal; ?>"><?php echo $entry->name; ?></a>
								<article><?php echo $entry->description; ?></article>
							</li>
				<?php
						}
					}
				}

				$tools = Tools::GetAllTools();
				AppendRecursive($tools);
				?>
			</ul>
		</section>
<?php
	}
}
