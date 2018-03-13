<!--Полезная информация -->
<div class="news_block">
<div class="row">
<div class="col-xs-12">
<h2>
Полезная информация
</h2>
</div>
</div>
<div class="row">
{foreach $recent_news as $item}
<div class="col-md-4 col-xs-12 news_item">
<a href="{site_url($item.full_url)}">
<img src="{$item.field_image}" alt="{$item.title}">
<span class="news_title">{$item.title}</span>
</a>
</div>
{/foreach}
</div>
</div>
<!--Полезная информация -->