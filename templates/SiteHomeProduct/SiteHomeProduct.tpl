{*Tin lang que toi*}
<div class="right_content">
    {if $aryHomeProduct}
        <div class="sum_list_menu">
            <div class="div_title_menu">Chợ quê</div>
            {foreach from = $aryHomeProduct item = product name = name_pro}
                <div class="div_product">
                    <div class="block_img">
                        <div class="div_img_product">
                            <a href="{$product.link_detail}" title="{$product.name}">
                                <img src="{$product.images}" alt="{$product.name}"/>
                            </a>
                        </div>
                    </div>
                    <div class="div_title_product"><a href="{$product.link_detail}" title="{$product.name}">{$product.title_cut}</a></div>
                    <div class="div_price_product">Giá: <span class="price_sell">{$product.price|bm_money_format}đ</span></div>
                </div>
            {/foreach}
        </div>
    {/if}
</div>