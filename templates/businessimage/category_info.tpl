{$category = $CI->load->module('cfcm')->connect_fields($category, 'category')}
<div class="row">  
  <div class="col-xs-12 col-sm-12 col-md-9">
    <div class="text-block">
    {if !isset($category.field_h1)}
    {$category.field_h1=$category.name}
    
    {/if}
      <h1>{$category.field_h1}</h1>
    </div>
  {$categories = get_sub_categories($category.id)}
  {if count($pages) > 0}
    <ul class="row list-item">
    {foreach $pages as $page}
      <li class="col-xs-12 col-sm-6 col-md-3">
        <a class="item" href="{site_url($page.full_url)}">
          <div class="img">
            <img src="{$page.field_image}" alt="{$page.title}" />
          </div>
          <div class="name gg">
            <span class="n2">{$page.title}</span>
          </div>
        </a>
      </li>
    {/foreach}    
    {if $category.id==172}    
      {$page=array_merge($pages[0],array())}
      <li class="col-xs-12 col-sm-6 col-md-3">
        <a class="item" href="">
          <div class="img">
            <img src="{$page.field_image}" alt="Химическая и нефтехимическая промышленность" />
          </div>
          <div class="name gg">
            <span class="n2">Химическая и нефтехимическая промышленность</span>
          </div>
        </a>
      </li>
      <li class="col-xs-12 col-sm-6 col-md-3">
        <a class="item" href="">
          <div class="img">
            <img src="{$page.field_image}" alt="Лакокрасочная промышленность" />
          </div>
          <div class="name gg">
            <span class="n2"> Лакокрасочная промышленность</span>
          </div>
        </a>
      </li>    
    {/if}
    </ul>
  {/if}
    <div class="text-block">
      {$category.short_desc}
    </div>

    <div class="social-bottom">
      <div class="social-block addthis_toolbox">
        <a class="addthis_button_google_plusone_share gp"><span></span></a>
        <a class="addthis_button_facebook fb"><span></span></a>
        <a class="addthis_button_twitter tw"><span></span></a>
        <a class="addthis_button_vk vk"><span></span></a>
      </div>
      {literal}<script>var addthis_config = {"data_track_addressbar":true};</script>{/literal}
    </div>
  </div>  
  <div class="col-md-3 hidden-xs hidden-sm">
    <div class="top-news">
      <div class="main-title"><ins>Другие статьи:</ins></div>
      <ul>
      {foreach get_sub_categories(44) as $it}
        <li>
          <a href="{site_url($it.path_url)}">{$it.name}</a>
        </li>
      {/foreach}
      </ul>
    </div>
  </div>
</div>