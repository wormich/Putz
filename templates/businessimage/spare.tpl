<div class="row">      
  <div class="col-xs-6 col-sm-6 col-md-3 pull-right">
   {widget('cart')}
   {if is_null($page.field_image)||$page.field_image==''}
     {$page.field_image='/uploads/1-2.jpg'}
   {/if}
  </div>
  <div class="col-xs-12 col-sm-12 col-md-9">
    <div class="text-block">
    {$page.h1=ext_h1($page.title,$page.full_url)}
      <h1>{$page.h1}</h1>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-5 gallery-item-b">
    <div id="photos">
    {$x=explode(',',$page.field_gallery)}
    {foreach $x as $image}  
      <img src="{$image}" alt="{$page.title}" />
    {/foreach}
    {if is_null($page.field_gallery)||$page.field_gallery==''}
      <a href="{$page.field_image}" title="{$page.title}">
        <img src="{$page.field_image}" alt="{$page.title}" />
      </a>
    {/if}
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-4 prem">
  {if $it.field_sku}
    <p class="art"><span>Артикул:</span> {$it.field_sku}</p>
    {/if}
    {$page.field_sv}
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 num">
    <span><img src="{$THEME}images/ok.png" alt="Ок" /><span>Есть в наличии</span></span>
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
      <a class="catalog-products-item-nums-val js-get-form hren" data-page-id="{$page.id}">
        <span class="rur_price">{$page.field_price}{if strpos($page.field_price,".")==false}.00{/if}</span>
        <span class="r"><img src="{$THEME}/images/rubn.png" alt="рубль" /></span><br />
        <span class="eur-price __block">
          <span class="EURrate" style="display:none"></span>
          <span class="eur_price" style="margin-right:5px;">{$page.field_price_EUR}</span>€
        </span>
      </a>
    </div>
    <form id="add_basket_{$page.id}" class="options" method="get" action="/emarket/basket/put/element/{$page.id}/" style="margin-top:20px;">
      <div class="input-group">
        <labeL>Количество:</labeL>
        <input type="text" name="amount" id="num" value="1" data-rub="{$page.field_price}" data-eur="{$page.field_price_EUR}" />
        <input type="hidden" name="change_item" id="change_item" value="1" />
        <a data-p="mns"></a>
        <a data-p="pls"></a>
      </div>
      <div class="tvc">
        <a onclick="Cart.add_cart('{$page.id}','{$page.title}','{$page.field_price}',$('#num').val());" class="send-order __aligned">
          <span>В корзину</span>
        </a>
      </div>
    </form>
  {else:}
    <div class="w-order spare-one"> 
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

  <div class="col-xs-12">
  
  {if $page.field_related_products}
    <h2>Сопуствующие товары</h2>
    <div class="row catalog-products catalog-realated">
    {$sp = explode(',',$page.field_related_products)}
{foreach $sp as $i=>$it}
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
    
                
    <div class="r-fl"><noindex>
      <a href="/service/documentation/?scroll-id={$page.id}" rel="nofollow" class="link-doc">Документация</a>
      <a href="/scopes/?scroll-id={$page.id}" rel="nofollow" class="link-doc scope">Сферы применения</a></noindex>
    </div>
  </div>
</div>

    <script src="{$THEME}js/galleria-1.2.9.min.js"></script>
    {literal}
    <script>
      var galleriaNavTimeout = null;
      var _countPhotos = 1;
      var _countVideo = 0;
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
      $('.gallery-item-b .nav-tabs a').on('show',function(){
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