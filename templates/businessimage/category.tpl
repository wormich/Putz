{$category = $CI->load->module('cfcm')->connect_fields($category, 'category')}
<div class="row">
  {include_tpl('widgets/sub_categories')}
  <div class="col-xs-12 col-sm-12 col-md-9">
    <div class="text-block">
      <h1>{$category.field_h1}</h1>
    </div>
{$categories = get_sub_categories($category.id)}
{if count($categories) > 0}
    <ul class="row list-item">
    {foreach $categories as $cat}
      <li class="col-xs-12 col-sm-6 col-md-3">
        <a class="item" href="{site_url($cat.path_url)}">
          <div class="img">
            <img src="{$cat.image}" alt="{$cat.name}" />
          </div>
          <div class="name gg">
            <span class="n2">{$cat.name}</span>
          </div>
        </a>
      </li>
    {/foreach}
    </ul>
  {if trim($category.short_desc)}
    <div class="text-block">
        {$category.short_desc}
    </div>
  {/if}
  {foreach $categories as $cat}    
    {$products = category_pages($cat.id)}
    {if count($products) > 0}
    <div class="row catalog-products">
      {foreach $products as $it}
        {$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
      <div class="col-xs-12 col-sm-6 col-md-3 list-item-product">
        <a class="item" href="{site_url($it.full_url)}">
          <div class="img">
            <img src="{$it.field_image}" alt="{$it.title}" />
            <div class="labels">
            {if $it.field_hit}
              <img class="label" src="{$THEME}images/stamps/hit.png" alt="" />
            {/if}
            {if $it.field_sale}
              <img class="label" src="{$THEME}images/stamps/sale.png" alt="" />
            {/if}
            {if $it.field_new}
              <img class="label" src="{$THEME}images/stamps/new.png" alt="" />
            {/if}
            </div>
          </div>
          <div class="name">
          {if $it.field_sku}
            <span class="list_art"><span>Артикул: </span>{$it.field_sku}</span>
          {/if}
            <span class="n2">{$cat.field_name} {$it.title}</span>
          </div>
        </a>
        <div class="list-item-product-price">
        {if $it.field_price}
          <div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <meta itemprop="price" content="{$it.field_price}" />
            <meta itemprop="priceCurrency" content="RUB" />
            <link itemprop="availability" href="http://schema.org/InStock" />
            <a class="catalog-products-item-nums-val js-get-form hren" data-page-id="{$it.id}">
              <span class="rur_price">{$it.field_price}</span>
              <span class="r"><img src="{$THEME}images/rubn.png" alt="рубль" /></span><br />
              <span class="eur-price __block">
                <span class="EURrate" style="display:none">69.458</span>
                <span class="eur_price" style="margin-right:5px;">355.25</span>€
              </span>
            </a>
          </div>
          {else:}
          <div class="w-order"></div>
          <div class="worder xx">
            <a class="send-order __aligned" href="{site_url($it.full_url)}">
              <span>Узнать цену</span>
            </a>
          </div>
          {/if}
        </div>
      </div>
      {/foreach}
    </div>
    {/if}
  {/foreach}
{else:}
  {if count($pages) > 0}
    <div class="row catalog-products">
    {foreach $pages as $it}
    {$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_rs}
    <div class="col-md-6 col-xs-12 big-i">
      <div class="catalog-products-item_big">
        <div class="catalog-products-item-image-block"><a href="{site_url($it.full_url)}"><img src="{$it.field_image}" alt="{$it.title}" class="catalog-products-item-image"></a></div>
        <div class="catalog-products-item-title"><a href="{site_url($it.full_url)}" class="catalog-products-item-title-link"><span>{$it.title}</span></a></div>
        <div class="catalog-products-item-nums"><div class="w-order"></div></div>
        <div class="catalog-products-item-info">
            {$it.prev_text}
        </div>
      </div>
    </div>
    {elseif $it.field_rssmall}
    <div class="col-xs-12 col-md-6">
  <div class="catalog-products-item_small">
    <div class="catalog-products-item-image-block"><a href="{site_url($it.full_url)}"><img src="{$it.field_image}" alt="{$it.title}" class="catalog-products-item-image"><span class="catalog-products-item-stamp"></span></a></div>
    <div class="catalog-products-item-info">
      <div class="catalog-products-item-info-line title"><a href="{site_url($it.full_url)}" class="catalog-products-item-title-link">{$it.title}</a></div>
        {str_replace('<p>&nbsp;</p>','',$it.prev_text)}
      <div class="catalog-products-item-nums">
        <div class="w-order"></div>
      </div>
    </div>
  </div>
    </div>
{else:}
      <div class="col-xs-12 col-sm-6 col-md-3 list-item-product">
        <a class="item" href="{site_url($it.full_url)}">
          <div class="img">
            <img src="{$it.field_image}" alt="{$it.title}" />
            <div class="labels">
            {if $it.field_hit}
              <img class="label" src="{$THEME}images/stamps/hit.png" alt="" />
            {/if}
            {if $it.field_sale}
              <img class="label" src="{$THEME}images/stamps/sale.png" alt="" />
            {/if}
            {if $it.field_new}
              <img class="label" src="{$THEME}images/stamps/new.png" alt="" />
            {/if}
            </div>
          </div>
          <div class="name">
          {if $it.field_sku}
            <span class="list_art"><span>Артикул: </span>{$it.field_sku}</span>
          {/if}
            <span class="n2">{$category.field_name} {$it.title}</span>
          </div>
        </a>
        <div class="list-item-product-price">
        {if $it.field_price}
          <div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <meta itemprop="price" content="{$it.field_price}" />
            <meta itemprop="priceCurrency" content="RUB" />
            <link itemprop="availability" href="http://schema.org/InStock" />
            <a class="catalog-products-item-nums-val js-get-form hren" data-page-id="{$it.id}">
              <span class="rur_price">{$it.field_price}</span>
              <span class="r"><img src="{$THEME}images/rubn.png" alt="рубль" /></span><br />
              <span class="eur-price __block">
                <span class="EURrate" style="display:none">69.458</span>
                <span class="eur_price" style="margin-right:5px;">355.25</span>€
              </span>
            </a>
          </div>
          {else:}
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
    <!--<div class="but_more more_ps">
      <a>Загрузить еще</a>
    </div>-->                  
  {/if}                     
  {if trim($category.short_desc)}
    <div class="text-block">
      {$category.short_desc}
    </div>
  {/if}
{/if}  
  </div>  
</div>