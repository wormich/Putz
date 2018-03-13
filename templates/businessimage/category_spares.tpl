{$category = $CI->load->module('cfcm')->connect_fields($category, 'category')}
<div class="row">
  <div class="col-xs-6 col-sm-6 hidden-md hidden-lg pull-right">
    <div class="w-order2 cart">
      <a class="send-order __aligned">
        <span>Корзина</span>
        <span class="number">0</span>
      </a>
      <div class="cart-num"></div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="text-block">
      <h1>{$category.field_h1}</h1>
    </div>
  </div>
  <div class="col-xs-12">

{if $category.id == 12}
  {$catid = catfiltr(5)}
<form class="sort-form form-filter filtrspares filtrs" method="post" id="filtr">
<div class="form-group">
<label>Поиск по товару:</label>
<select class="ress resscat" name="cat">
<option class="next_out" value="">Выберите категорию...</option>
{$subcategoryarray = array()}
{$pagearray = array()}
{foreach get_sub_categories(5) as $cat}
{if in_array($cat["id"], $catid)}
<option value="{$cat["id"]}" data-id="i{$cat["id"]}">{$cat["name"]}</option>
{$subcategoryarray[] = $cat["id"]}
{$pagearray[] = $cat["id"]}
{/if}
{/foreach}
</select> 
<select class="ress resstype disabled" name="type">
<option class="next_out" value="">Выберите тип...</option>
{foreach $subcategoryarray as $subcategory}
{foreach get_sub_categories($subcategory) as $cat}


{if in_array($cat["id"], $catid)}
<option value="{$cat["id"]}" data-id="i{$subcategory}" class="i{$subcategory} empty">{$cat["name"]}</option>
{$pagearray[] = $cat["id"]}
{/if}
{/foreach}
{/foreach}
</select> 
<select class="ress ressmodel disabled" name="num">
<option class="next_out" value="none">Выберите модель...</option>
{foreach $pagearray as $pagearr}
{foreach category_pages($pagearr) as $item}
{if in_array($item["id"], $catid)}
<option value="{$item["id"]}" class="i{$pagearr} empty">{$item["title"]}</option>
{/if}
{/foreach}
{/foreach}
</select> 
</div>
<button class="send" type="submit">искать</button>
</form>    
{/if}

     {$products=category_pages($category.id)}
{$categories = get_sub_categories($category.id)}
{if count($categories) > 0}
    <ul class="row list-item{if $category.id==12} category{/if} new-list">
    {foreach $categories as $cat}
      <li class="col-xs-6 col-sm-6 col-md-3">
        <a class="item" href="{site_url($cat.path_url)}">
          <div class="img">
          {if $cat.image}
            <img src="{$cat.image}" alt="{$cat.name}" />
            {/if}
          </div>
          <div class="name gg">
            <span class="n2">{$cat.name}</span>
          </div>
        </a>
      </li>
    {/foreach}
    </ul>
    {/if}  
    

  
  {if count($products) > 0}
    <div class="row catalog-products">
    <div class="out_row">
    {foreach $pages as $it}
  {view('widgets/spare_in_list.tpl', ['it' => $it])}
    {/foreach}
    </div>
        {if $pagination}
        <div class="pag-cat">
    {$pagination}
    </div>
  {/if} 
  
   </div>  
                   
  {/if}   
  
  
    {if trim($category.short_desc)}
    <div class="text-block">
      {$category.short_desc}
    </div>
  {/if}
  </div>
</div>