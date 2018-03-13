
<ul class="services-top-img">
<li><a href="/service/documentation/"><div class="img"><img src="/uploads/cms/thumbs/9afdf14a43cdd36ff5d9a820b76bc288de2746c1/doc_auto_auto.png" alt="" /></div>Документация</a></li>
<li><a href="/service/spares/"><div class="img"><img src="/uploads/cms/thumbs/9afdf14a43cdd36ff5d9a820b76bc288de2746c1/zapchasty_auto_auto.png" alt="" /></div>Заказ запчастей</a></li>
<li><a href="/service/order/"><div class="img"><img src="/uploads/cms/thumbs/9afdf14a43cdd36ff5d9a820b76bc288de2746c1/zaproc_auto_auto.png" alt="" /></div>Запрос на технику</a></li>
</ul>
<div class="row">
<div class="col-xs-12">
<form class="sort-form form-filter doc" action="?" method="post" id="filtr">
<div class="form-group">
<label>Поиск по товару:</label>
<select class="ress resscat" name="cat">
<option class="next_out" value="">Выберите категорию...</option>
{$subcategoryarray = array()}
{$pagearray = array()}
{foreach get_sub_categories(5) as $cat}
<option value="{$cat["id"]}" data-id="i{$cat["id"]}">{$cat["name"]}</option>
{$subcategoryarray[] = $cat["id"]}
{$pagearray[] = $cat["id"]}
{/foreach}
</select> 
<select class="ress resstype disabled" name="type">
<option class="next_out" value="">Выберите тип...</option>
{foreach $subcategoryarray as $subcategory}
{foreach get_sub_categories($subcategory) as $cat}
<option value="{$cat["id"]}" data-id="i{$subcategory}" class="i{$subcategory} empty">{$cat["name"]}</option>
{$pagearray[] = $cat["id"]}
{/foreach}
{/foreach}
</select> 
<select class="ress ressmodel disabled" name="model">
<option class="next_out" value="">Выберите модель...</option>
{foreach $pagearray as $pagearr}
{foreach category_pages($pagearr) as $item}
<option value="{$item["id"]}" class="i{$pagearr} empty">{$item["title"]}</option>
{/foreach}
{/foreach}
</select> 
</div>
<button class="send" type="submit">искать</button>
</form>
</div>
<div class="col-xs-12">
<div class="document-archive">
{foreach get_sub_categories(5) as $cat}
<div class="item-archive">
<a class="name clickss">{$cat["name"]}</a>
<div class="drop-archive">
<ul class="list-archive">
{if $cat["field_docks"]!=false}
{$docks=explode('##',$cat["field_docks"])}
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$cat["id"]}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$cat["id"]}" target="_blank">{if $ddline[1]!=''}{$ddline[1]}{else:}{$cat["name"]}{/if}</a>
</li>
{/foreach}
{/if}
{foreach category_pages($cat["id"]) as $item}
{$item = $CI->load->module('cfcm')->connect_fields($item, 'page')}
<div class="item-archive">
<a class="name clickss">{$item["title"]}</a>
<div class="drop-archive">
<!-- Проверка условия наличия документов -->
{if $item["field_docks"]!=''}
{$docks=explode('##',$item["field_docks"])}
<ul class="list-archive">
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$item['id']}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$item["id"]}" target="_blank" class="ss{$item["id"]}">{if $ddline[1]!=false}{$ddline[1]}{else:}{$item["title"]}{/if}</a>
</li>
{/foreach}
</ul>
{/if}
<!-- END -->
<!-- Проверка условия наличия документов верхней категории -->
{if $cat["field_docfull"]!=false}
{$docks=explode('##',$cats["field_docfull"])}
<ul class="list-archive">
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$item["id"]}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$item["id"]}"  target="_blank">{if $ddline[1]!=false}{$ddline[1]}{else:}{$cat["name"]}{/if}</a>
</li>
{/foreach}
</ul>
{/if}
<!-- END -->
</div>
</div>
{/foreach}
</ul>
{foreach get_sub_categories($cat["id"]) as $cats}
<div class="item-archive">
<a class="name clickss">{$cats["name"]}</a>
<div class="drop-archive">
<!-- Проверка условия наличия документов -->
{if $cats["field_docks"]!=false}
{$docks=explode('##',$cats["field_docks"])}
<ul class="list-archive">
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$cats["id"]}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$cats["id"]}"  target="_blank">{if $ddline[1]!=false}{$ddline[1]}{else:}{$cats["name"]}{/if}</a>
</li>
{/foreach}
</ul>
{/if}
<!-- END -->
<!-- Проверка условия наличия документов верхней категории -->
{if $cat["field_docfull"]!=false}
{$docks=explode('##',$cats["field_docfull"])}
<ul class="list-archive">
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$cats["id"]}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$cats["id"]}"  target="_blank">{if $ddline[1]!=false}{$ddline[1]}{else:}{$cat["name"]}{/if}</a>
</li>
</ul>
{/foreach}
{/if}
<!-- END -->
{foreach category_pages($cats["id"]) as $item}
{$item = $CI->load->module('cfcm')->connect_fields($item, 'page')}
<div class="item-archive">
<a class="name clickss">{$item["title"]}</a>
<div class="drop-archive">
<!-- Проверка документов у страницы -->
{if $item["field_docks"]!=false}
{$docks=explode('##',$item["field_docks"])}
<ul class="list-archive">
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$item['id']}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$item["id"]}" target="_blank" class="ss{$item["id"]}">{if $ddline[1]!=false}{$ddline[1]}{else:}{$item["title"]}{/if}</a>
</li>
{/foreach}
</ul>
{/if} 
<!-- END -->  
<!-- Проверка общих документов у самого верхнего раздела-->   
{if $cat["field_docfull"]!=false}
<ul class="list-archive">
{$docks=explode('##',$cats["field_docfull"])}
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$item['id']}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$item['id']}"  target="_blank">{if $ddline[1]!=false}{$ddline[1]}{else:}{$cats["name"]}{/if}</a>
</li>
{/foreach}
</ul>
{/if}                            
<!-- END -->  
<!-- Проверка общих документов у родительского раздела-->   
{if $cats["field_docfull"]!=false}
<ul class="list-archive">
{$docks=explode('##',$cats["field_docfull"])}
{foreach $docks as $dd}
{$ddline=explode('||',$dd)}
<li class="ss{$item['id']}">
<div class="r-fl">
<span class="pdf-size">{get_filesize($ddline[0])}</span>
<a href="{$ddline[0]}" target="_blank" class="update">скачать</a>
</div>
<a href="{$ddline[0]}" id="i{$item['id']}"  target="_blank">{if $ddline[1]!=false}{$ddline[1]}{else:}{$cats["name"]}{/if}</a>
</li>
{/foreach}
</ul>
{/if}                            
<!-- END -->
</div>
</div>
{/foreach}
</ul>
</div>
</div>
{/foreach}
</div>
</div>
{/foreach}
</div>
</div>
</div>