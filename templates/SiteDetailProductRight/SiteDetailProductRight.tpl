<div class="right_content">
	{if $aryNews}
	<div class="sum_list_menu">
		<div class="div_title_menu">Tin mới nhận</div>
		
			{foreach from = $aryNews item = newsNew name = new}
				<div class="div_news">
					<div class="div_img_news">
						<a href="{$newsNew.view_news}" title="{$newsNew.name}">
							<img src="{$newsNew.images_100}" border="0"/>
						</a>
					</div>
					<div class="div_title_news">
						<a href="{$newsNew.view_news}">
							<h2>{$newsNew.name}</h2>
						</a>
						<span style="font-size: 11px; font-weight: inherit">
							<a href="{$newsNew.view_news}" style="color: #4C4E5A">{$newsNew.description}</a>
						</span>
					</div>
				</div>
			{/foreach}
	</div>
	{/if}
	
	<div class="sum_list_menu">
		<div class="div_title_menu">Đối tác - liên kết</div>
		{foreach from = $banner_right item = banner2 name = bann2}
			<a href="{$banner2.link_view}" title="{$banner2.title}" target="_blank"><img style="padding-bottom: 15px"  src="{$banner2.image_right}"/></a>
		{/foreach}
		
		<div class="div_yh_supoot">
			<span class="img_yh">
				<a href="ymsgr:sendIM?quynh_arsenal_133&m=Chào bạn." title="Liên hệ với Quản trị site.">
					<img src="http://opi.yahoo.com/online?u=quynh_arsenal_133&m=g&t=2&l=us" border="0"/>
				</a>
			</span>
		</div>
	</div>
</div>


