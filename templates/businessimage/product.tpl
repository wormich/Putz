<div class="row main-lt-side">
  {include_tpl('widgets/sub_categories')}
  <div class="col-xs-12 col-sm-12 col-md-9">
    <div class="text-block">
      <h1>{$page.title}</h1>
      <div class="print">
        <noindex><a onclick="return window.print();">Распечатать</a></noindex>
      </div>
    </div>
    <div class="clearfix gallery-item-b">
    {$photos = explode(',',$page.field_gallery)}
    {$videos = explode(',',$page.field_you)}
    {if $page.field_gallery && $page.field_you}
      <ul class="type-gallery nav-tabs">
        <li class="active"><a href="#photos" data-toggle="tab">Фото</a></li>
        <li><a href="#videos" data-toggle="tab">Видео</a></li>
      </ul>
    {/if}     
    {if $page.field_gallery}
      <div id="photos" class="tabs active">
      {$j=1}{foreach $photos as $image}
        <a href="{$image}" title="{$page.title} - фото №{$j}">
          <img src="{$image}" alt="Купить {$page.title} - {$category.field_name} – цена и описание - фото №{$j}" />
        </a>
        {$j++}
      {/foreach}
      </div>
    {/if}
    {if $page.field_you}
      <div id="videos" class="tabs">
      {$j=1}{foreach $videos as $video}        
        <a href="{$video}" title="{$page.title} - видео №{$j}">
          <img src="http://img.youtube.com/vi/{explode('=',$video)[1]}/0.jpg" alt="Купить {$page.title} - {$category.field_name} – цена и описание - видео №{$j}" />
        </a>
        {$j++}
      {/foreach} 
      </div>
    {/if}
      <div class="r-fl"><noindex>
      {if $page.field_docks}
        <a href="/service/documentation/?scroll-id={$page.id}" rel="nofollow" class="link-doc">Документация</a>
      {/if}
      {if $page.field_related_articles}
        <a href="/scopes/?scroll-id={$page.id}" rel="nofollow" class="link-doc scope">Сферы применения</a>
      {/if}
      </noindex></div>
    {if $page.field_price || $page.field_price_EUR}
      {if !($page.field_price)}
        {$page.field_price = kurs2($page.field_price_EUR)}
      {/if}
      {if !($page.field_price_EUR)}
        {$page.field_price_EUR = kurs($page.field_price)}
      {/if}
      <div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <meta itemprop="price" content="{number_format($page.field_price,2,'.','')}" />
        <meta itemprop="priceCurrency" content="RUB" />
        <link itemprop="availability" href="http://schema.org/InStock" />
        <span class="rur_price">{$page.field_price}{if strpos($page.field_price,".")==false}.00{/if}</span>
        <span class="r"><img src="{$THEME}/images/rubn.png" alt="рубль" /></span><br />
        <span class="eur-price __block">
          <span class="eur_price" style="margin-right:5px;">{$page.field_price_EUR}{if strpos($page.field_price_EUR,".")==false}.00{/if}</span>€
        </span>
      </div>
    {else:}
    <div class="w-order spare-one prods-one"> 
      <a class="send-order __aligned"><span>Узнать цену</span></a>
<div class="order-b drop-down row" style="display: none;"><a
href="#" class="close">x</a>
<form method="post" class="js-add-webforms form ajax_true" enctype="multipart/form-data">
<input type="hidden" name="name_form" value="Заказ запчастей - {$page.title}">
<input type="hidden" name="url" value="{site_url()}{$page.full_url}"
<input type="hidden" name="admin_email" value="{siteinfo('email_cons')}">
<div class="w-field col-xs-12 form-group required" dala-label="Имя">
<label for="full_name_consult">Имя
<span class="required">*</span>
</label>
<input type="text" name="name" id="full_name_consult" class="form-control" placeholder="Представьтесь, пожалуйста">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 form-group">
<label for="firm_consult">Фирма</label>
<input type="text" name="firm" id="firm_consult" class="form-control" placeholder='ООО "Путцмайстер-Рус"'>
</div>
<div class="w-field col-xs-12 required form-group" dala-label="Город">
<label for="city_consult">Город
<span class="required">*</span>
</label>
<input type="text" name="city" id="city_consult" class="form-control" placeholder="">
<div class="errorMessage"></div>
</div>
<input type="hidden" name="real_city" class="real_city">
<div class="w-field col-xs-12 required form-group" dala-label="Телефон">
<label for="phone_consult">Телефон
<span class="required">*</span>
</label>
<input type="tel" name="phone" id="phone_consult" class="form-control" placeholder="">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 form-group">
<label for="email_consult">E-mail</label>
<input type="email" name="email" id="email_consult" class="form-control" placeholder="info@putzmeister.ru">
</div>
<div class="w-field col-xs-12 form-group">
<label for="message_consult">Сообщение</label>
<textarea name="comment" id="message_consult" class="form-control" placeholder="Ваш комментарий, если необходимо"></textarea>
</div>
<div class="w-field col-xs-12 news-check">
<input type="checkbox" name="check" value="1">
<label for="check">Я хочу получать новости от Putzmeister</label>
</div>
<input type="hidden" name="" id="test_captcha" value="">
<div class="w-field col-xs-12 linenews">
<label for="ress">Новости</label>
<select name="news" class="ress">
<option >Выберите категорию...</option>
<option value="Бетононасосы">Бетононасосы</option>
<option value="Горно-Шахтное оборудование">Горно-Шахтное оборудование</option>
<option value="Растворонасосы">Растворонасосы</option>
<option value="Торкрет оборудование">Торкрет оборудование</option>
<option value="Шламовые насосы">Шламовые насосы</option>
</select>
</div>
<div class="w-field required captcha-b form-group col-xs-12" dala-label="Капча">
<label>Решите пример <span class="required">*</span>
</label>
<div class="cpic"></div>
<input type="text" name="captcha" class="field captcha form-control">
<div class="errorMessage"></div>
<div class="cap_er"></div>
<a class="new" style="cursor:pointer">Получить новый код</a>
</div>
<div class="form_element col-xs-12">
<input type="submit" class="send btn" value="Отправить запрос">
<img class="pgbar" style="display:none" src="{$THEME}images/progress-bar.gif" alt="" />
</div>
<div class="sogl col-xs-12">Нажимая на кнопку, вы даете согласие на обработку своих персональныхданных</div>
<div class="col-xs-12 succes"></div>
{form_csrf()}
</form>
</div>
    </div>   
      {/if}
    </div>
    <div class="text-block">
      {$page.full_text}
    </div>
    <div class="item-details">
      <ul class="tab-list">
        <li class="active"><a href="#technical" data-toggle="tab">Технические характеристики</a></li>
      {if $page.field_features}
        <li><a href="#features" data-toggle="tab">Особенности модели</a></li>
      {/if}
      </ul>
      <div class="tabs active" id="technical">
        {$page.field_tech}
      </div>
    {if $page.field_features}
      <div class="tabs" id="features">
        <div class="interesting-links">
          {$page.field_features}
        </div>
      </div>
    {/if}
    </div><noindex>
    <div class="text-block">
      <p>Внимание: Компания оставляет за собой право внесения изменений. Информация, предоставляемая во всех разделах сайта www.putzmeister.ru, является справочной и не может служить основанием для предъявления претензий.&nbsp;Перед началом использования оборудования обязательно ознакомьтесь с инструкцией по применению.&nbsp;Оборудование на фото может отображаться с опциями не входящими в стандартную поставку, фактическую комплектацию уточняйте у специалистов нашей компании.&nbsp;</p>
    </div></noindex>
{if count(fullid($page.id))>0}
    <h2>Запчасти</h2>
    <div class="row catalog-products catalog-realated">
{foreach fullid($page.id) as $i=>$it}
{$it = get_page(trim($it))}
{$it = $CI->load->module('cfcm')->connect_fields($it, 'page')}
{if is_null($it.field_image)||$it.field_image==''}
{$it.field_image='/uploads/1-2.jpg'}
{/if}
<div class="col-xs-12 col-sm-6 col-md-3 list-item-product">
<a class="item" href="{site_url($it.full_url)}">
<div class="img">
<img src="{$it.field_image}" alt="{$it.title}" />
<div class="labels">
{if $it.field_hit}
<img class="label" src="{$THEME}images/stamps/hit.png" alt="Хит продаж" />
{/if}
{if $it.field_sale}
<img class="label" src="{$THEME}images/stamps/sale.png" alt="Распродажа" />
{/if}
{if $it.field_new}
<img class="label" src="{$THEME}images/stamps/new.png" alt="Новинка" />
{/if}
</div>
</div>
<div class="name">
{if $it.field_sku}
<span class="list_art"><span>Артикул: </span>{$it.field_sku}</span>
{/if}
<span class="n2">{$it.title}</span>
</div>
</a>
<div class="list-item-product-price">
{if $it.field_price}
<div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<meta itemprop="price" content="{$it.field_price}" />
<meta itemprop="priceCurrency" content="RUB" />
<link itemprop="availability" href="http://schema.org/InStock" />
<a class="catalog-products-item-nums-val js-get-form hren"  >
<span class="rur_price">{$it.field_price}</span>
<span class="r"><img src="{$THEME}images/rubn.png" alt="рубль" /></span><br />
<span class="eur-price __block">
<span class="eur_price" style="margin-right:5px;">{kurs($it.field_price)}{if strpos(kurs($it.field_price),".")==false}.00{/if}</span>€
</span>
</a>
</div>
{/if}
{if $it.field_price_EUR}
<div class="w-order" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<meta itemprop="price" content="{$it.field_price}" />
<meta itemprop="priceCurrency" content="RUB" />
<link itemprop="availability" href="http://schema.org/InStock" />
<a class="catalog-products-item-nums-val js-get-form hren" data-page-id="{$it.id}">
<span class="rur_price">{kurs2($it.field_price_EUR)}{if strpos(kurs2($it.field_price_EUR),".")==false}.00{/if}</span>
<span class="r"><img src="{$THEME}images/rubn.png" alt="рубль" /></span><br />
<span class="eur-price __block">
<span class="eur_price" style="margin-right:5px;">{$it.field_price_EUR}{if strpos($it.field_price_EUR,".")==false}.00{/if}</span>€
</span>
</a>
</div>
{/if}
{if !($it.field_price)&&!($it.field_price_EUR)}
<div class="w-order"></div>
<div class="worder xx">
<a class="send-order __aligned" href="{site_url($it.full_url)}">
<span>Узнать цену</span>
</a>
</div>
{/if}
</div>
</div>
{/foreach}
    </div>
    <div class="but_more more_ps realated-ps">
      <a>Загрузить еще</a>
    </div>  
     
{/if}
  </div>
</div>

    <script src="{$THEME}js/galleria-1.2.9.min.js"></script>
    {literal}
    <script>
      var galleriaNavTimeout = null;
      var _countPhotos = {/literal}{echo count($photos)}{literal};
      var _countVideo = {/literal}{echo count($videos)}{literal};
      var _photoConfig = {
        thumbnails: (_countPhotos > 1),
        carousel: (_countPhotos > 1),
        showImagenav: (_countPhotos > 1),
        thumbCrop: false
      };
      var _videoConfig = {
        thumbnails: (_countVideo > 1),
        carousel: (_countVideo > 1),
        showImagenav: (_countVideo > 1),
        thumbCrop: false
      };
      Galleria.loadTheme('/templates/businessimage/js/galleria.classic.min.js');
      Galleria.configure({
        lightbox: true,
        imageCrop: false,
        transition: 'fade',
        youtube: {
          //controls: 0,
        },
      });
      Galleria.run('#photos', _photoConfig);
      Galleria.ready(function(){
        this.bind("loadstart", function(e){
          if(this._thumbnails.length == 1){
            this.$('thumbnails-container').remove();
            this.$('container').parent().height(this._stageHeight);
          }
        });
      });
      $('.gallery-item-b .nav-tabs a').on('click',function(){
        $($(this).attr('href')).removeAttr("style");
        var _dataConfig = ($(this).attr('href') == '#photos') ? _photoConfig : _videoConfig;
        Galleria.run($(this).attr('href'), _dataConfig);
        if($(this).attr('href') == '#videos'){

          $('body').off("mouseover mouseleave",'.galleria-stage').on('mouseover mouseleave','.galleria-stage',function(e){
            if(!$(this).find('iframe').size()) return;
            if(e.type == 'mouseover'){
              clearTimeout(galleriaNavTimeout);
              $('.type-gallery.nav-tabs').fadeIn(200);
            }else{
              galleriaNavTimeout = setTimeout(function(){
                $('.type-gallery.nav-tabs').fadeOut(200)
              },1000);
            }
          });
          $('.type-gallery.nav-tabs').off('mouseenter mouseleave').on('mouseenter mouseleave',function(e){
            if(e.type == 'mouseenter')
              clearTimeout(galleriaNavTimeout);
            else
              galleriaNavTimeout = setTimeout(function(){
                $('.type-gallery.nav-tabs').fadeOut(200)
              },1000);
          });
        }else{
          clearTimeout(galleriaNavTimeout);
          $('body').off("mouseover mouseleave",'.galleria-stage');
          $('.type-gallery.nav-tabs').off('mouseenter mouseleave').fadeIn(200);
        }
      });
    </script>    
    {/literal}