{if $wrapper}
	{$loc_js_toggle = "js-double-tap";}
	{$loc_item_arrow = "b-menu__item_arrow"}
{else:}
	{$loc_js_toggle = "";}
	{$loc_item_arrow = "";}
{/if}
<li class="active">
	<a class="active" href="{$link}" {$target}>{$title}</a>
	{$wrapper}
</li>