{$act=''}
{$pos=strpos($link,'glavnaia')}
{$link=str_replace('glavnaia','',$link)}
{if $pos>0&&$_SERVER['REQUEST_URI']=='/'}

{$act='class="active"'}
{/if}
{if $page_type = $CI->core->core_data['data_type']!='main'}
{$no = ' rel="noindex"'}
{/if}
<li {$act}>
	<a{$no} href="{$link}" >{$title}</a>
	{$wrapper}
</li>