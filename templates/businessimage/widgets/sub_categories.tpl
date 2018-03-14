{$cats = get_sub_categories(5)}
{if count($cats) > 0}
<div class="col-md-3 hidden-xs hidden-sm lt-side">
  <ul id="open_menu" class="menu-catalog">
  {foreach $cats as $cat}
    <li{if $category.id == $cat.id} class="active"{/if}{if $category.parent_id == $cat.id} class="active"{/if}>
      <a href="{site_url($cat.path_url)}"{if $category.id == $cat.id} class="active" style="font-weight:bold"{/if}{if $category.parent_id == $cat.id} class="active"{/if}>{$cat.name}</a>
    {$subcats = get_sub_categories($cat.id)}
    {if count($subcats) > 0}
      <ul class="first-child">
      {foreach $subcats as $subcat}
        <li{if $category.id == $subcat.id} class="active"{/if}{if $page.category == $subcat.id} class="active"{/if}>
          <a href="{site_url($subcat.path_url)}"{if $category.id == $subcat.id && !$page} class="active" style="font-weight:bold"{/if}{if $page.category == $subcat.id} class="active"{/if}>{$subcat.name}</a>
        {$products = category_pages($subcat.id)}
        {if count($products) > 0}
          <ul class="second-child">
          {foreach $products as $it}
            <li{if $page.id == $it.id} class="active"{/if}>
              <a href="{site_url($it.full_url)}"{if $page.id == $it.id} class="active" style="font-weight:bold"{/if}>{$it.title}</a>
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