
<nav class="navbar navbar-default">
<!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header new-but">
    <button type="button" class="navbar-toggle collapsed cmn-toggle-switch cmn-toggle-switch__htx" data-toggle="collapse" data-target="" aria-expanded="false">
      <span></span>
    </button>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse menu-fix" id="bs-example-navbar-collapse-1">
  {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '<noindex>'}
{$no = ' rel="noindex"'}
{/if}
<ul class="nav navbar-nav">
<li{if $_SERVER['REQUEST_URI']==str_replace(site_url(''),'/',site_url(''))} class="active"{/if}><a{$no} href="{str_replace(site_url(''),'/',site_url(''))}">Главная</a></li>
<li{if stristr($_SERVER['REQUEST_URI'],str_replace(site_url(''),'',site_url('catalog')))} class="active"{/if}><a{$no} href="{str_replace(site_url(''),'/',site_url('catalog'))}">Оборудование</a>
<noindex>
{$cats = get_sub_categories(5)}
{if count($cats) > 0}
<div class="visible-xs visible-sm menu-dp-mob">
  <ul id="open_menu" class="menu-catalog">
  {foreach $cats as $cat}
    <li{if $category.id == $cat.id} class="active"{/if}{if $category.parent_id == $cat.id} class="active"{/if}>
      <a rel="nofollow" href="{site_url($cat.path_url)}"{if $category.id == $cat.id} class="active" style="font-weight:bold"{/if}{if $category.parent_id == $cat.id} class="active"{/if}>{$cat.name}</a>
    {$subcats = get_sub_categories($cat.id)}
    {if count($subcats) > 0}
      <ul class="first-child">
      {foreach $subcats as $subcat}
        <li{if $category.id == $subcat.id} class="active"{/if}{if $page.category == $subcat.id} class="active"{/if}>
          <a rel="nofollow" href="{site_url($subcat.path_url)}"{if $category.id == $subcat.id && !$page} class="active" style="font-weight:bold"{/if}{if $page.category == $subcat.id} class="active"{/if}>{$subcat.name}</a>
        {$products = category_pages($subcat.id)}
        {if count($products) > 0}
          <ul class="second-child">
          {foreach $products as $it}
            <li{if $page.id == $it.id} class="active"{/if}>
              <a rel="nofollow" href="{site_url($it.full_url)}"{if $page.id == $it.id} class="active" style="font-weight:bold"{/if}>{$it.title}</a>
            </li>
          {/foreach}
          </ul>
        {/if}
        </li>
      {/foreach}
      </ul>
    {/if}
    </li>
  {/foreach}
  </ul>
  <p><a href="/service/documentation/" class="link-doc">Документация</a></p>
  <p><a href="/scopes/" class="link-doc scope">Сферы применения</a></p>
</div>
{/if}
</noindex>
</li>
<li{if stristr($_SERVER['REQUEST_URI'],str_replace(site_url(''),'',site_url('about')))} class="active"{/if}><a{$no} href="{str_replace(site_url(''),'/',site_url('about'))}">О компании</a>
<noindex>
<div class="visible-xs visible-sm menu-dp-mob">
{load_menu('about_menu')}
<p><a href="/service/documentation/" class="link-doc">Документация</a></p>
<p><a href="/scopes/" class="link-doc scope">Сферы применения</a></p>
</div>
</noindex>
</li>
    {load_menu('main_menu')}
  </ul>
{if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '</noindex>'}
{/if}  
  </div><!-- /.navbar-collapse -->
</nav>
<!-- Конец меню-->
