{if $page_type = $CI->core->core_data['data_type']!='main'}
{$no = ' rel="noindex"'}
{/if}
<li><span>―</span> <a{$no} href="{$link}"{$target}>{$title}</a></li>