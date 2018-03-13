<h1>{$page.title}</h1>

<div class="row products">

{$subcats = get_sub_categories(5)}

{foreach $subcats as $c}
<div class="col-xs-12 col-md-5ths">
<a href="{site_url($c.path_url)}">
<span class="imgp">
   {if is_null($c.image)||$c.image==''}
{$c.image='/uploads/1-2.jpg'}
{/if}
<img src="{$c.image}" alt="{$c.name}">
</span>
<span class="textp">
{$c.name}</span>
</a>
</div>


{/foreach}

<div class="col-xs-12 col-md-5ths">
<a href="{site_url('service/spares')}">
<span class="imgp">
<img src="/uploads/cms/thumbs/9799c8258567b66fc1873aa4697de592b97d61ed/zapchasty_auto_auto_161_208.png" alt="Заказ запчастей">
</span>
<span class="textp">
Заказ запчастей</span>
</a>
</div>



</div>


<div class="arrow"></div>

<!--Начало текста-->
<div class="text-block">
{$page.prev_text}
{$page.full_text}
</div>
<!--Конец текста-->

<!--нижнее меню-->

{include_tpl('widgets/main_banner')}
{widget('polez')}