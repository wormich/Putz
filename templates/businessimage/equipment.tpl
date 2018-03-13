<ul class="services-top-img">
<li><a href="/service/documentation/"><div class="img"><img src="/uploads/cms/thumbs/9afdf14a43cdd36ff5d9a820b76bc288de2746c1/doc_auto_auto.png" alt="" umi:empty="фото"></div>Документация</a></li>
<li><a href="/service/spares/"><div class="img"><img src="/uploads/cms/thumbs/9afdf14a43cdd36ff5d9a820b76bc288de2746c1/zapchasty_auto_auto.png" alt="" umi:empty="фото"></div>Заказ запчастей</a></li>
<li><a href="/service/order/"><div class="img"><img src="/uploads/cms/thumbs/9afdf14a43cdd36ff5d9a820b76bc288de2746c1/zaproc_auto_auto.png" alt="" umi:empty="фото"></div>Запрос на технику</a></li>
</ul>
<div class="row">
<div class="col-md-6 col-xs-12">
<form method="post" class="js-add-webforms form ajax_true row" enctype="multipart/form-data">
<input type="hidden" name="name_form" value="Запрос на технику">
<input type="hidden" name="admin_email" value="{siteinfo('email_cons')}">
<div class="w-field col-xs-12">
<label for="ress">Категория</label>
<select name="cats" class="ress resscat-s">
<option >Выберите категорию...</option>
{foreach get_sub_categories(5) as $cat}
<option value="{$cat["name"]}" data-id="{$cat['id']}" class="level2">{$cat["name"]}</option>
{foreach get_sub_categories($cat["id"]) as $cats}
<option value="{$cats["name"]}" data-id="{$cats['id']}" class="level3">{$cats["name"]}</option>
{/foreach}
{/foreach}
</select>
</div>
<div class="w-field col-xs-12">
<label for="ress">Модель</label>
<select name="model" class="ress ressmodel-s disabled">
<option class="next_out">Выберите модель...</option>
{foreach get_sub_categories(5) as $cat}
{foreach category_pages($cat["id"]) as $item}
<option value="{$item["id"]}" class="i{$cat["id"]} empty">{$item["title"]}</option>
{/foreach}
{foreach get_sub_categories($cat["id"]) as $cats}
{foreach category_pages($cats["id"]) as $item}
<option value="{$item["id"]}" class="i{$cat["id"]} i{$cats["id"]} empty">{$item["title"]}</option>
{/foreach}
{/foreach}
{/foreach}
</select>
</div>
<div class="w-field col-xs-12 form-group required" dala-label="Имя">
<label for="full_name_consult">Имя
<span class="required">*</span>
</label>
<input type="text" name="name" id="full_name_consult" class="form-control" placeholder="Представьтесь, пожалуйста">
<div class="errorMessage"></div>
</div>
<div class="w-field col-xs-12 form-group">
<label for="firm_consult">Фирма</label>
<input type="text" name="firm" id="firm_consult" class="form-control" placeholder="ООО &quot;Путцмайстер-Рус&quot;">
</div>
<div class="w-field col-xs-12 required form-group" dala-label="Город">
<label for="city_consult">Город
<span class="required">*</span>
</label>
<input type="text" name="city" id="city_consult" class="form-control" placeholder="">
<div class="errorMessage"></div>
</div>
<input type="hidden" name="real_city" class="real_city" id="real_city">
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
<div class="cpic">6 минус 3 = </div>
<input type="text" name="captcha" class="field captcha form-control">
<div class="errorMessage"></div>
<div class="cap_er"></div>
<a class="new" style="cursor:pointer">Получить новый код</a>
</div>
<div class="form_element col-xs-12">
<input type="submit" class="send btn" value="Отправить запрос">
<img class="pgbar" style="display: none" src="images/progress-bar.gif" alt="gif">
</div>
<div class="sogl col-xs-12">Нажимая на кнопку, вы даете согласие на обработку своих персональныхданных</div>
<div class="col-xs-12 succes"></div>
</form>
</div>
<div class="col-md-6 col-xs-12">
<div class="order-b r-fl">
<div class="info-order">
{$page.prev_text}
</div>
<div class="main-title line"><h1>{$page.title}</h1></div>
<div><div style="text-align: justify;">{$page.full_text}</div></div>
</div>
</div>
</div>