<div style="display:none">
    1
{if $_POST['num']=='none'}
{$_SESSION["FILTR"]='none'}
{/if}
{if $_POST['num']}
{session($_POST['num'])}
{/if}
</div>
{$num = ceil((float)count(fullid($_SESSION["FILTR"]))/16)}
{$tv = 16}
{$pag='yes'}
{$pg=2}
{if $num<=1}
{$pag='no'}
{/if}
{if $_GET['per_page']}
{$tv = 16*(float)$_GET['per_page']}
{$pg = (float)$_GET['per_page']+1}
{/if}
{if $_SESSION["FILTR"]&&$_SESSION["FILTR"]!='none'}
<div class="out_row">
{foreach fullid($_SESSION["FILTR"]) as $i=>$it}
{if $i>=$tv-16&&$i<=$tv-1}
{$it = get_page($it)}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if is_null($it.field_image)||$it.field_image==''}
{$it.field_image='/uploads/1-2.jpg'}
{/if}
<div class="col-xs-12 col-sm-6 col-md-3 list-item-product">
<a class="item" href="{site_url($it.full_url)}">
<div class="img">
<img src="{$it.field_image}" alt="{$it.title}" />
<div class="labels">
{if $it.field_hit}
<img class="label" src="{$THEME}images/stamps/hit.png" alt="Хит продаж" />
{/if}
{if $it.field_sale}
<img class="label" src="{$THEME}images/stamps/sale.png" alt="Распродажа" />
{/if}
{if $it.field_new}
<img class="label" src="{$THEME}images/stamps/new.png" alt="Новинка" />
{/if}
</div>
</div>
<div class="name">
{if $it.field_sku}
<span class="list_art"><span>Артикул: </span>{$it.field_sku}</span>
{/if}
<span class="n2">{$it.title}</span>
</div>
</a>
<div class="list-item-product-price">
{if $it.field_price}
<div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<meta itemprop="price" content="{$it.field_price}" />
<meta itemprop="priceCurrency" content="RUB" />
<link itemprop="availability" href="http://schema.org/InStock" />
<a class="catalog-products-item-nums-val js-get-form hren"  >
<span class="rur_price">{$it.field_price}</span>
<span class="r"><img src="{$THEME}images/rubn.png" alt="рубль" /></span><br />
<span class="eur-price __block">
<span class="eur_price" style="margin-right:5px;">{kurs($it.field_price)}{if strpos(kurs($it.field_price),".")==false}.00{/if}</span>€
</span>
</a>
</div>
{/if}
{if $it.field_price_EUR}
<div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<meta itemprop="price" content="{$it.field_price}" />
<meta itemprop="priceCurrency" content="RUB" />
<link itemprop="availability" href="http://schema.org/InStock" />
<a class="catalog-products-item-nums-val js-get-form hren" data-page-id="{$it.id}">
<span class="rur_price">{kurs2($it.field_price_EUR)}{if strpos(kurs2($it.field_price_EUR),".")==false}.00{/if}</span>
<span class="r"><img src="{$THEME}images/rubn.png" alt="рубль" /></span><br />
<span class="eur-price __block">
<span class="eur_price" style="margin-right:5px;">{$it.field_price_EUR}{if strpos($it.field_price_EUR,".")==false}.00{/if}</span>€
</span>
</a>
</div>
{/if}
{if !($it.field_price)&&!($it.field_price_EUR)}
<div class="w-order"></div>
<div class="worder xx">
<a class="send-order __aligned" href="{site_url($it.full_url)}">
<span>Узнать цену</span>
</a>
</div>
{/if}
</div>
</div>
{/if}
{/foreach}
</div>
{if $pag!='no'&&$num>=1&&$num>=$pg}
<div class="pag-cat">
<div class="but_more more_ps col-xs-12">
<span onclick="pagAJAX($(this));return false;">
<a href="/filtr?per_page={$pg}">Загрузить еще</a>
</span>
</div>
</div>
{/if}
{else:}
<div class="out_row">
<div class="col-xs-12">
<span class="text">
По Вашему запросу ничего не найденно!
</span>
</div>
</div>
{/if}
