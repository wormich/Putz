{$loc_main_banner_list = getBanner('main_banner', 'object')}
{if count($loc_main_banner_list) > 0}
<!--Слайдер-->
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">
{$i=0}

{foreach $loc_main_banner_list->getBannerImages() as $item}
{$loc_url_target = $item->getTarget() == 1 ? "blk" : ""}
{$x=explode('||',$item->getDescription())}
<div class="item {if $i==0}active{/if}">
<img src="{echo $item->getImageOriginPath()}"
alt="{echo $item->getName()}">
<div class="carousel-caption">
<div class="h1 	{$loc_url_target}">{echo $item->getName()}</div>
<div class="desc {$loc_url_target}">{echo trim($x[0])}</div>
<div class="h2 {$loc_url_target}"><a href="{echo $item->getStatisticUrl()}" class="slide-link {$loc_url_target}">{echo trim($x[1])}</a></div>
</div>
</div>
{$i++}
{/foreach}
<!-- Indicators -->
<ol class="carousel-indicators">
{$i=0}
{foreach $loc_main_banner_list->getBannerImages() as $item}
<li data-target="#carousel-example-generic" data-slide-to="{$i} " {if $i==0}class="active"{/if}></li>
{$i++}
{/foreach}
</ol>
</div></div>
{/if}