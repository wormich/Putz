{$category = $CI->load->module('cfcm')->connect_fields($category, 'category')}
<div class="row">  
  <div class="col-xs-12">
    <div class="text-block">
      <h1>{$category.field_h1}</h1>
    </div>
  {if count($pages) > 0}
    <div class="row news-b">
    {$i=0}{foreach $pages as $it}
    {$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
      {if $i==0}
      <div class="col-xs-12">
        <div class="item top-item">
      {else:}
      <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="item">
      {/if}
          <div class="img">
            <a href="{site_url($it.full_url)}">
              <img src="{$it.field_image}" alt="{$it.title}" />
            </a>
            <div class="date">
            {if $i==0}
             {locale_date("d F Y", $page.publish_date)}
            {else:}
             {date('d.m.y', $it.publish_date)}
            {/if}
            </div>
          </div>
          <div class="name">{$it.title}</div>
          <div class="desc">{$it.prev_text}</div>
          <a class="more" href="{site_url($it.full_url)}">
            <span>Читать дальше</span> »
          </a>
        </div>
      </div>
      {$i++}
    {/foreach}
    </div>
  {/if}
    {if $pagination}
    {$pagination}
  {/if}   
  </div>  
</div>