<!--ТЕКСТ страницы-->
<div class="row">

<div class="col-md-3 col-xs-12 menu-about-company">
{load_menu('about_menu')}
<p><a href="/service/documentation/" class="link-doc">Документация</a></p>
<p><a href="/scopes/" class="link-doc scope">Сферы применения</a></p>
</div>
<div class="col-md-9 col-xs-12">
<div class="text-block"><h1>{$page.title}</h1></div>
<div class="text-block">
    <div class="main-side"><div class="w-history">
            <div class="nav-item">
                <a href="#" class="prev disable"></a><a href="#" class="next active"></a>
            </div>
            <ul class="menu-history">
                {foreach array_reverse(category_pages($category.id))as $i=>$item}
                    <li {if ++$i==1} class="active"{/if}><a href="#data-{echo $i}" data-toggle="tab"><div class="point border-r"><span class="border-r"></span></div>{$item.title}</a></li>
                    {/foreach}
            </ul>
            {foreach array_reverse(category_pages($category.id)) as $i=>$item}
                {$item = $CI->load->module('cfcm')->connect_fields($item, 'page')}
                <div id="data-{echo ++$i}" class="tabs{if $i==1} active{/if}">
                    <div class="history-events">
                        <h2 class="caption">{$item.title}</h2>
                        {$item.prev_text}
                    </div>
                    <div class="photo-b">
{$gal = explode(',',$item.field_gallery)}
                        {foreach $gal as $oneimg}
                            <img src="{echo $oneimg}" alt="{$item.title}">
                        {/foreach}
                    </div>
                </div>
                {/foreach}

        </div>
    </div>
</div>
</div>
</div>
<!--ТЕКСТ страницы-->