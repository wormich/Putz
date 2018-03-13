{$category = $CI->load->module('cfcm')->connect_fields($category, 'category')}
<div class="row">
<div class="col-xs-12">
<div class="text-block">
<h1>{$category.field_h1}</h1>
</div>
<form class="sort-form form-filter doc" action="?" method="post" id="filtr">
<div class="form-group">
<label>Поиск по товару:</label>
<select class="ress resscat" name="cat">
<option class="next_out" value="">Выберите категорию...</option>
{$subcategoryarray = array()}
{$pagearray = array()}
{$categories = get_sub_categories(5)}
{if count($categories) > 0}
{foreach $categories as $cat}
{$subcategories = get_sub_categories($cat.id)}
{if count($subcategories) > 0}
{if $cat.id!=28}
<option value="{$cat["id"]}" data-id="i{$cat["id"]}">{$cat["name"]}</option>
{$subcategoryarray[] = $cat["id"]}
{$pagearray[] = $cat["id"]}
{/if}
{else:}
{$products = category_pages($cat.id)}
{$arrI=array()}
{foreach $products as $it}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_related_articles}
{$arrI[]=$it.field_related_articles}
{/if}
{/foreach}
{if count($arrI)>0}
{if count($products) > 0}
<option value="{$cat["id"]}" data-id="i{$cat["id"]}">{$cat["name"]}</option>
{$subcategoryarray[] = $cat["id"]}
{$pagearray[] = $cat["id"]}           
{/if}
{/if}
{/if}
{if $cat.id == 33}
<option value="{$cat.id}" data-id="{$cat.id}">Бетонные заводы</option>
{/if}
{if $cat.id == 34}
<option value="{$cat.id}" data-id="{$cat.id}">Промышленные шламовые насосы</option>
{/if}
{/foreach}
{/if}
</select> 
<select class="ress resstype disabled" name="type">
<option class="next_out" value="">Выберите тип...</option>
{foreach $subcategoryarray as $subcategory}
{foreach get_sub_categories($subcategory) as $cat}
{$products = category_pages($cat.id)}
<!--Условие наличия доп материалов у страниц категории-->
{$arrI=array()}
{foreach $products as $it}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_related_articles}
{$arrI[]=$it.field_related_articles}
{/if}
{/foreach}
<!--END-->  
{if count($arrI)>0}
<option value="{$cat["id"]}" data-id="i{$subcategory}" class="i{$subcategory} empty">{$cat["name"]}</option>
{$pagearray[] = $cat["id"]}
{/if}
{/foreach}
{/foreach}
</select> 
<select class="ress ressmodel disabled" name="model">
<option class="next_out" value="">Выберите модель...</option>
{foreach $pagearray as $pagearr}
{foreach category_pages($pagearr) as $item}
{$item = $CI->load->module('cfcm')->connect_fields($item, 'page')}
{if $item.field_related_articles}
<option value="{$item["id"]}" class="i{$pagearr} empty">{$item["title"]}</option>
{/if}
{/foreach}
{/foreach}
</select> 
</div>
<button class="send" type="submit">искать</button>
</form>
{$categories = get_sub_categories(5)}
{if count($categories) > 0}
<div class="document-archive">
{foreach $categories as $cat}
{$subcategories = get_sub_categories($cat.id)}
{if count($subcategories) > 0}
{if $cat.id!=28}
<div class="item-archive ss{$cat.id}">
<a id="i{$cat.id}" class="name clickss">{$cat.name}</a>
<div class="drop-archive">   
{foreach $subcategories as $subcat}
{$products = category_pages($subcat.id)}
<!--Условие наличия доп материалов у страниц категории-->
{$arrI=array()}
{foreach $products as $it}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_related_articles}
{$arrI[]=$it.field_related_articles}
{/if}
{/foreach}
<!--END-->  
{if count($arrI)>0}
<div class="item-archive ss{$subcat.id}">
<a id="i{$subcat.id}" class="name clickss">{$subcat.name}</a>
{if count($products) > 0}
<div class="drop-archive">
{foreach $products as $it}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_related_articles}
<div class="item-archive">
<a id="{$it.id}" class="name clickss">{$it.title}</a>
<div class="drop-archive">
<ul class="list-article">
{$fullart=explode(',',$it.field_related_articles)}
{foreach $fullart as $oneart}
{$pageart = get_page(trim($oneart))}
{$pageart = $CI->load->module('cfcm')->connect_fields($pageart, 'page')}
<li class="ss{$it.id}"><a id="i{$it.id}" href="/{$pageart['full_url']}">{$pageart["title"]}</a></li>
{/foreach}
</ul>
</div>
</div>
{/if}
{/foreach}
</div>
{/if}
</div>
{/if}
{/foreach}
</div>
</div>
{/if}
{else:}
{$products = category_pages($cat.id)}
{$arrI=array()}
{foreach $products as $it}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_related_articles}
{$arrI[]=$it.field_related_articles}
{/if}
{/foreach}
{if count($arrI)>0}
{if count($products) > 0}
<div class="item-archive ss{$cat.id}">
<a id="i{$cat.id}" class="name clickss">{$cat.name}</a>
<div class="drop-archive">
{foreach $products as $it}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if $it.field_related_articles}  
<div class="item-archive">
<a class="name clickss">{$it.title}</a>
<div class="drop-archive">
<ul class="list-article">
{$fullart=explode(',',$it.field_related_articles)}
{foreach $fullart as $oneart}
{$pageart = get_page(trim($oneart))}
{$pageart = $CI->load->module('cfcm')->connect_fields($pageart, 'page')}
<li class="ss{$it.id}"><a id="i{$it.id}" href="/{$pageart['full_url']}">{$pageart["title"]}</a></li>
{/foreach}
</ul>
</div>
</div>
{/if}
{/foreach}
</div>
</div> 
{/if}
{/if}
{/if}
{if $cat.id == 33}
<div class="item-archive">
<a class="name clickss">Бетонные заводы</a>
<div class="drop-archive">
<ul class="list-article">
<li class="ss{$cat.id}"><a id="i{$cat.id}" href="/scopes/mini_betonnye_zavody">Мини бетонные заводы</a></li>
</ul>
</div>
</div>
{/if}
{if $cat.id == 34}
<div class="item-archive">
<a class="name clickss">Промышленные шламовые насосы</a>
<div class="drop-archive">
<ul class="list-article">
<li class="ss{$cat.id}"><a id="i{$cat.id}" href="/scopes/pumps/">Промышленные шламовые насосы</a></li>
</ul>
</div>
</div>
{/if}
{/foreach}
</div>
{/if}