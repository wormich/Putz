{if $page_type = $CI->core->core_data['data_type']!='main'}
{$no = ' rel="noindex"'}
{/if}
<div class="row rowmenufut">
<div class="col-xs-12">
    <button type="button" class="navbar-toggle collapsed cmn-toggle-switch cmn-toggle-switch__htx">
      <span></span>
    </button>
</div>
</div>
<div class="row bot-menu">
  <div class="col-xs-12 col-md-5ths">
    <div class="item-b">
      <div class="caption">Оборудование:</div>
      {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '<noindex>'}
{/if}
      <ul>
      {$cats = get_sub_categories(5)}
      {foreach $cats as $cat}
        <li><span>―</span> <a{$no} href="{site_url($cat.path_url)}">{$cat.name}</a></li>
        {/foreach}
              {foreach get_sub_categories(3) as $cat}
        <li><span>―</span> <a{$no} href="{site_url($cat.path_url)}">{$cat.name}</a></li>
        {/foreach}
      </ul>
      {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '</noindex>'}
{/if}
    </div>
  </div>
  <div class="col-xs-12 col-md-5ths">
    <div class="item-b">
      <div class="caption">О компании:</div>
      {load_menu('abouts_menu')}
    </div>
  </div>
  <div class="col-xs-12 col-md-5ths">
    <div class="item-b">
      <div class="caption">Сервис:</div>
      {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '<noindex>'}
{/if}
      <ul>
      {foreach get_sub_categories(3) as $cat}
        <li><span>―</span> <a{$no} href="{site_url($cat.path_url)}">{$cat.name}</a></li>
        {/foreach}
        {foreach category_pages(3) as $item}
        <li><span>―</span> <a{$no} href="{site_url($item.full_url)}">{$item.title}</a></li>
        {/foreach}
      </ul>
      {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '</noindex>'}
{/if}
    </div>
  </div>
  <div class="col-xs-12 col-md-5ths">
        {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '<noindex>'}
{/if}
  {load_menu('sp_menu')}
        {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '</noindex>'}
{/if}
  </div>
  <div class="col-xs-12 col-md-5ths">
    <div class="journals-b">
           {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '<noindex>'}
{/if} 
      <div class="caption"><a href="/putzmeister-post/">Журнал Putzmeister Post:</a></div>
      <div class="img-b">
        <a{$no} href="/putzmeister-post/"><img src="{$THEME}images/img-2.jpg"></a>
        <div class="bottom-angle">
          <a href="http://www.putzmeister.com/deu/putzmeister-post.htm" rel="nofollow"><img src="{$THEME}images/de.png"></a>
          <a href="http://www.putzmeister.com/enu/putzmeister-post.htm" rel="nofollow"><img src="{$THEME}images/en.png"></a>
        </div>
      </div>
            {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '</noindex>'}
{/if}
    </div>
  </div>
</div>

    <!--Нижние контакты-->

    <div class="row cont-btm">

        <div class="col-md-6 col-xs-6">


            <div class="info-b map">
                <p><span>ООО "Путцмайстер-Рус"</span></p>
                <p>129343, Россия, {siteinfo('siteinfo_address')}</p>
                        {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '<noindex>'}
{/if}
                <a{$no} href="/contacts/" class="directions">Схема проезда</a>
                        {if $page_type = $CI->core->core_data['data_type']!='main'}
{echo '</noindex>'}
{/if}
            </div>
        </div>


        <div class="col-md-3 col-xs-6">
            <div class="info-b tels"><p><span>Телефон:</span><br/>  8 (800) 707-19-58<br/> +7 (495) 775-22-37</p>
                <p><span>Факс:</span><br/> +7 (495) 775-22-34</p>
                <p><a class="mail" href="mailto:info@putzmeister.ru">info@putzmeister.ru</a></p></div>
        </div>


        <div class="col-md-3 col-xs-6">
            <div class="info-b last"><p><span>График работы:</span></p>
                <p>Офис, по будням с 8:00 до 18:00 Склад и Сервис с 8:00 до 17:00</p></div>
        </div>


    </div>

    <!--Футер-->

    <div class="footer">


        <div class="row">


            <div class="col-md-7 col-xs-12">

                <div class="text-coopy">
                    <p>Данный cайт и размещенная на нём информация являются собственностью компании.</p>
                    <p>При использовании материалов сайта ссылка обязательна.</p>
                    <br>
                    <p>Ваши вопросы, комментарии и замечания Вы можете направить по адресу <a
                            href="mailto:info@putzmeister.ru?subject=%D0%A1%D0%BE%D0%BE%D0%B1%D1%89%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%81%20%D1%81%D0%B0%D0%B9%D1%82%D0%B0">info@putzmeister.ru</a>
                    </p>
                    <br>
                    <p><a rel="nofollow" href="{base_url('privacy-policy')}">Соглашение об использовании
                        сайта</a></p>
                    <br>
                    <p>Мы в соцсетях:
                        <a href="https://www.facebook.com/putzmeisterrus/" target="_blank">
                            <img src="{$THEME}images/fb.png" alt="Putzmeister в Facebook" align="absmiddle" hspace="5" style="border-radius:5px"></a>

                        <a href="https://vk.com/putzmeisterrus" target="_blank">
                            <img src="{$THEME}images/vk.png" alt="Putzmeister в ВКонтакте" align="absmiddle" hspace="5"></a>


                        <a href="https://www.youtube.com/channel/UCp61k8xK9avlchWLl2dY2qg" target="_blank">            
                            <img src="{$THEME}images/yt.png" alt="Putzmeister на YouTube" align="absmiddle" hspace="5" style="border-radius:5px"></a></p>
                </div>

            </div>


            <div class="col-xs-12 col-md-5">
            	<!-- AddThis Button BEGIN -->
              	<div class="social-block addthis_toolbox">
               	    <span>Поделиться:</span>
                    <a class="addthis_button_google_plusone_share gp at300b" href="http://www.addthis.com/bookmark.php?v=300&amp;winname=addthis&amp;pub=ra-5295e43f48b67026&amp;source=tbx-300&amp;lng=en-us&amp;s=google_plusone_share&amp;url=http%3A%2F%2Fwww.putzmeister.ru%2Fcontacts%2F&amp;title=%D0%9A%D0%BE%D0%BD%D1%82%D0%B0%D0%BA%D1%82%D1%8B%20%7C%20Putzmeister%20%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F%20-%20%D0%9E%D1%84%D0%B8%D1%86%D0%B8%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9%20%D1%81%D0%B0%D0%B9%D1%82&amp;ate=AT-ra-5295e43f48b67026/-/-/54c9e3dd725dc670/2&amp;frommenu=1&amp;uid=54c9e3ddc61105da&amp;ct=1&amp;pre=http%3A%2F%2Fwww.putzmeister.ru%2F&amp;tt=0&amp;captcha_provider=nucaptcha" target="_blank" title="Google+">
                  	<span></span>
	            </a>
        	    <a class="addthis_button_facebook fb at300b" title="Facebook" href="#">
                	<span></span>
	            </a>
        	    <a class="addthis_button_twitter tw at300b" title="Tweet" href="#">
                	<span></span>
	            </a>
        	    <a class="addthis_button_vk vk at300b" target="_blank" title="VKontakte" href="#">
                	<span></span>
	            </a>
        	    <div class="clearfix"></div>
	        </div>
                {literal}<script>var addthis_config = {"data_track_addressbar":false};</script>{/literal}
                <!-- AddThis Button END -->                                                    
                <div class="clearfix"></div>
                <div class="copyright">
                    © 2003-{date('Y')} Putzmeister Concrete Pumps GmbH
                    <span>бетононасосы, автобетоносмесители, штукатурные станции, бетонные заводы и другая бетонная техника Путцмайстер в Москве</span>                                
                </div>
                <ul class="list-border">
                    <li><a href="/sitemap/" style="color: #676767;">Карта сайта</a></li>
                    <li>
                        <a href="http://realweb.ru/" target="_blank">Оптимизация и продвижение сайта</a>
                        – RealWeb
                    </li>
                </ul>

            </div>

        </div>


    </div>


</div>


<!-- Наверх-->

<p id="back-top" style="display: block;"><a href="#top"><span></span></a></p>

<!-- Наверх-->


<!-- Latest compiled and minified JavaScript -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
<script src="{$THEME}js/bootstrap.min.js"></script>
<script src="{$THEME}dist/jquery.formstyler.js"></script>
<script src="{$THEME}js/selectbox.js"></script>
<script src="{$THEME}js/script.js"></script>
<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5295e43f48b67026"></script>
{literal}
<script>
  window.onload = function(){
      jQuery(".real_city").val(ymaps.geolocation.city);
  }
</script>
{/literal}

</body>
</html>