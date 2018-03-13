{$loc_last_item = array_pop($navi_cats)}
<ul class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <a itemprop="item" href="{site_url('')}"><span itemprop="name">{tlang('Home')}</span></a>
    <meta itemprop="position" content="1" />
  </li>
{$j=1}

{foreach $navi_cats as $item}

  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
    <a itemprop="item" href="{site_url($item.path_url)}"><span itemprop="name">{$item.name}</span></a>
    <meta itemprop="position" content="{$j+1}" />
  </li>

{$j++}

{/foreach}

  <li class="active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
    <span itemprop="item"><span itemprop="name">   {$loc_last_item.name}</span></span>
    <meta itemprop="position" content="{count($navi_cats)+2}" />
  </li>
</ul>
