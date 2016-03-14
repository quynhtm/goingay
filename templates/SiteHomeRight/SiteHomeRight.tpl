<div class="right_content">
	<div class="sum_list_menu">
		<div class="div_title_menu">Liên hệ</div>
			<b>Email:</b> nguoilemat@gmail.com<br/>
			<b>Mobile Phone: </b>093.8413368<br/>
			<b>Liên hệ online:</b>
            <div id="SkypeButton_Call_quynh_arsenal133_1">
                {literal}
                    <script type="text/javascript">
                        Skype.ui({
                            "name": "chat",
                            "element": "SkypeButton_Call_quynh_arsenal133_1",
                            "participants": ["quynh_arsenal133"],
                            "imageSize": 32
                        });
                    </script>
                {/literal}
            </div>
			<a href="ymsgr:sendIM?quynh_arsenal_133&m=Chào bạn." title="Liên hệ với Quản trị site.">
				<img src="http://opi.yahoo.com/online?u=quynh_arsenal_133&m=g&t=2&l=us" border="0"/>
			</a>
	    </div>
	
        {if $newsNewNoibat}
        <div class="sum_list_menu">
            <div class="div_title_menu">Tin nổi bật</div>
            {foreach from = $newsNewNoibat item = newsNewNoibat name = NewNoibat}
                <div class="div_news">
                    <div class="div_img_news">
                        <a href="{$newsNewNoibat.view_news}" title="{$newsNewNoibat.name}">
                            <img src="{$newsNewNoibat.images_80}" border="0"/>
                        </a>
                    </div>
                    <div class="div_title_news">
                        <a href="{$newsNewNoibat.view_news}">
                            <h2>{$newsNewNoibat.title_cut}</h2>
                        </a>
                        <span style="font-size: 11px; font-weight: inherit">
                            <a href="{$newsNewNoibat.view_news}" style="color: #4C4E5A">{$newsNewNoibat.description}</a>
                        </span>
                    </div>
                </div>
            {/foreach}
        </div>
        {/if}

        {if $banner_right}
            <div class="sum_list_menu">
            <div class="div_title_block">Đối tác - liên kết</div>
            {foreach from = $banner_right item = banner2 name = bann2}
                <a href="{$banner2.link_view}" title="{$banner2.title}" target="_blank" ><img src="{$banner2.image_right}" style="padding-bottom: 15px"/></a>
            {/foreach}
        </div>
        {/if}
</div>
