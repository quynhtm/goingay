<div class="right_content content_left_home">
	<div class="sum_list_menu">
		{if $aryNews}
			{foreach from = $aryNews item = newsFontHome name = newfont}
				<div class="news_home">
					<div class="title_news">
						<a href="{$newsFontHome.view_news}">{$newsFontHome.name}&nbsp;&nbsp;<span class="timedate">{$newsFontHome.create_time|date_format:" %H:%M %d/%m/%Y"}</span></a>
					</div>
					<div class="block_image_news">
						<div class="thumb_img">
							<a href="{$newsFontHome.view_news}" title="{$newsFontHome.name}">
								<img src="{$newsFontHome.images_150}" alt="" width="180" height="108"/>
							</a>
						</div>
						<div class="news_lead">
							{$newsFontHome.description}
						</div>
					</div>
				</div>
			{/foreach}
		{/if}
        <div class="clrb"></div>
        <div class="listing_paging">{$pagingData}</div>
        <div class="clrb"></div>
	</div>
</div>

{*Tin lang que toi*}
<div class="right_content content_center_home">
    {if $aryNewsLangNghe}
        <div class="sum_list_menu">
            <div class="div_title_menu">Tin làng nghề rắn</div>
            {foreach from = $aryNewsLangNghe item = NewsLangNghe name = NewLangNghe}
                <div class="div_news">
                    <div class="div_img_news">
                        <a href="{$NewsLangNghe.view_news}" title="{$NewsLangNghe.name}">
                            <img src="{$NewsLangNghe.images_80}" border="0"/>
                        </a>
                    </div>
                    <div class="div_title_news">
                        <a href="{$NewsLangNghe.view_news}">
                            <h2>{$NewsLangNghe.title_cut}</h2>
                        </a>
                    <span style="font-size: 11px; font-weight: inherit">
                        <a href="{$NewsLangNghe.view_news}" style="color: #4C4E5A">{$NewsLangNghe.description}</a>
                    </span>
                    </div>
                </div>
            {/foreach}
        </div>
    {/if}

    {if $banner_left}
        <div class="sum_list_menu">
            {foreach from = $banner_left item = banner1 name = bann2}
                <a href="{$banner1.link_view}" title="{$banner1.title}" target="_blank" ><img src="{$banner1.image_right}" style="padding-bottom: 15px"/></a>
            {/foreach}
        </div>
    {/if}
</div>



