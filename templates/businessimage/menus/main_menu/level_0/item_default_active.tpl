{if $wrapper}
	{$loc_js_toggle = "js-double-tap";}
	{$loc_item_arrow = "b-menu__item_arrow"}
{else:}
	{$loc_js_toggle = "";}
	{$loc_item_arrow = "";}
{/if}
{if $page_type = $CI->core->core_data['data_type']!='main'}
{$no = ' rel="noindex"'}
{/if}
{$link=str_replace('glavnaia','',$link)}
<li class="active">
	<a{$no} href="{$link}" >{$title}</a>
	{$wrapper}
</li>