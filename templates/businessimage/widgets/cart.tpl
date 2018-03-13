<div class="w-order2 cart">
<a class="send-order __aligned" href="{base_url('/basket/')}" >
{if $cnt>0}
<span>Корзина</span>
<span class="number">{$cnt}</span>
{else:}
<span>Корзина</span>
<span class="number">0</span>
{/if}
</a>
{if $cnt>0}
<div class="cart-num">
<div>Товаров в корзине: {$cnt} шт.</div>
<div>На сумму: {$total} руб.</div>
<hr />
<div>У вас в корзине:</div>
<ul>
{foreach $items as $item}
<li>{$item.item_title}</li>
{/foreach}
</ul>
</div>
{/if}
</div>