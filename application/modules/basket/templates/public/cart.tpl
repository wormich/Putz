<div class="bsc">
<div class="basket">
<div class="item_cart">
<div class="text-block block_item nz_cart"><h1>
<a href="{base_url('service/spares')}"><span class="dp_str">Назад к каталогу</span></a><span>Ваш заказ</span>
</h1></div>
<div class="row-line"></div>
</div>
<div class="row_tv">

{foreach $items as $item}
{switch $format}
{case "1"}{$item.price = number_format($item.price);break;}
{case "2"}{$item.price = number_format($item.price,2,',',' ');break;}
{case "3"}{$item.price = str_replace(',',' ',number_format($item.price,0));break;}
{/switch}

{$page=get_page($item.item_id)}

{$page = $CI->load->module('cfcm')->connect_fields($page, 'page')}

<div class="one_tv " id="cart_{$item.id}">

{if $page.field_image==''}
{$page.field_image='/uploads/1-2.jpg'}

{/if}
<img src="{$page.field_image}" alt="{$item.item_title}">
<div class="desc_cart_one">
<h2><a href="{site_url($page.full_url)}">{$item.item_title}</a></h2>
<p>Количество: </p>
<input type="text" value="{$item.number}" class="amount" id="count_{$item.id}">



<span class="change-amount"><span onclick="Cart.delete_item('{$item.id}');$('.item_{$item.id}').empty();" class="delete">x</span>
<a class="bottom" onclick="Cart.update_number(1,{$item.id},parseFloat($('#count_{$item.id}').val())-parseFloat(1))"><span class="glyphicon glyphicon-minus"></span></a>
<a class="top" onclick="Cart.update_number(1,{$item.id},parseFloat($('#count_{$item.id}').val())+parseFloat(1))"><span class="glyphicon glyphicon-plus"></span></a></span><div class="prr">



{if !($item.price_EUR)}
{$item.price_EUR = kurs($item.price)}
{/if}


<div class="prr">

<span class="price_one">Цена: </span><span class="price_one_cart">


<span class="price_one_cart">
<span class="rur_price">{$item.price}{if strpos($item.price,".")==false}.00{/if}</span>
<span class="r"><img src="{$THEME}images/rubn.png" alt="рубль"></span>




<span class="eur-price __block">

<span class="eur_price" style="margin-right:5px;">{$item.price_EUR}{if strpos($item.price_EUR,".")==false}.00{/if} </span>€</span></span></span>

</div>
</div>
</div>
</div>







{/foreach}






</div>
<div id="empty">
{if count($items)==0}<p>Ваша корзина пуста</p>{/if}
</div>
{if count($items)>0}

<div class="row row_final"><p>Итого:</p>  <span class="pfull"><span class="totalx">{$total}{if strpos($total,".")==false}.00{/if}</span> <img src="{$THEME}images/rubn.png" alt="Руб"></span></div>
<div class="row"><div class="order-b"></div></div>
<div class="clear"></div>
</div>









<div class="row">
<div class="col-md-6 col-xs-12 cart-info">
<div class="order-b r-fl">
<div class="info-order">
<p><span>*</span> Обязательное поле для заполнения</p>
<p>- Ваши контактные данные нужны нам для связи с Вами</p>
<p>- После отправки мы свяжемся с вами в течение суток</p>
</div>
</div>
</div>
<div class="col-md-6 col-xs-12 formscart">
<form method="post" class="js-add-webforms-cart form ajax_true" enctype="multipart/form-data">
<input type="hidden" name="name_form" value="Консультация">
<input type="hidden" name="admin_email" value="{siteinfo('email_cons')}">
<div class="w-field col-xs-12 form-group required" dala-label="Имя">
<label for="full_name_consult">Имя
<span class="required">*</span>
</label>
<input type="text" name="name" id="full_name_consult" class="form-control" placeholder="Представьтесь, пожалуйста">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 form-group required" dala-label="Фамилия">
<label for="full_name_consult">Фамилия
<span class="required">*</span>
</label>
<input type="text" name="index" id="full_name_consult" class="form-control" placeholder="">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 form-group required" dala-label="E-mail">
<label for="email_consult">E-mail
<span class="required">*</span>
</label>
<input type="email" name="email" id="email_consult" class="form-control" placeholder="info@putzmeister.ru">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 required form-group" dala-label="Телефон">
<label for="phone_consult">Телефон
<span class="required">*</span>
</label>
<input type="tel" name="phone" id="phone_consult" class="form-control" placeholder="">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 form-group" dala-label="Город">
<label for="city_consult">Город
</label>
<input type="text" name="area" id="city_consult" class="form-control" placeholder="">
<div class="errorMessage"></div>
</div>
<input type="hidden" name="home" class="real_city">
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
<div class="sogl col-xs-12">Нажимая на кнопку, вы даете согласие на обработку своих персональных данных</div>
<div class="col-xs-12 succes"></div>
{form_csrf()}
</form>
</div>
<div class="col-md-6 col-xs-12">
<div class="order-b r-fl">
<div class="info-order">
<p><span>*</span> Обязательное поле для заполнения</p>
<p>- Ваши контактные данные нужны нам для связи с Вами</p>
</div>
<div class="main-title line"><h1>Запчасти для бетононасосов</h1></div>
<div><div class="info-b" style="text-align: justify;">
<p>Строительную технику Putzmeister легко и приятно эксплуатировать: она подходит для решения большинства строительных задач, может работать в тяжелых условиях, надежно защищена от преждевременного износа фирменными разработками немецких инженеров и качеством материалов используемых в производстве.</p>
<p>Однако любое оборудование со временем изнашивается. Разработчики Putzmeister позаботились о том, чтобы максимальное число деталей оборудования можно было легко и недорого заменить прямо на строительной площадке, а также износ таких деталей происходил максимально равномерно.</p>
<p>Российское представительство Putzmeister, в свою очередь, позаботилось о том, чтобы нужные запчасти всегда были на складах в Москве или у дилеров. Кроме запчастей, там всегда представлен большой ассортимент дополнительного оборудования, которое расширит возможности техники и упрастит повседневную работу. Вы можете заказать необходимую Вам деталь на наших складах и получить ее в короткие сроки.</p>
<p>Ассортимент компании включает большое количество высококачественных оригинальных аксессуаров для любых областей применения бетонной, растворной, торкрет установок, тоннельной техники и другой техники Putzmeister.</p>
<p>Консультации по заказу запчастей: 8800 707 19 58 или +7 (495) 775 22 37</p>
</div></div>
</div>
</div>
</div>


{/if}


</div>


