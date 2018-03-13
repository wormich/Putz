{$page = $CI->load->module('cfcm')->connect_fields($page, 'page')}
<div class="row">  
  <div class="col-xs-12 col-sm-12 col-md-9">
    <div class="text-block">
      <h1>{$page.title}</h1>
      {$page.prev_text}
       {$page.full_text}
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
      {$i=0}{foreach category_pages($page.category) as $it}
        {if $it.id!=$page.id}{if $i<7}
        <li>
          <a href="{site_url($it.full_url)}">{$it.title}</a>
        </li>
          {$i++}
        {/if}{/if}
      {/foreach}
      </ul>
    </div>
  </div>
</div>