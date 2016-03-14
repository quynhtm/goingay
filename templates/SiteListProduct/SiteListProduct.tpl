<div class="center_content">
	<div class="div_content">
		<!-- list san pham phu kien -->
		<div class="box_center">
			<div class="box_title_center"> Phụ kiện điện thoại {$name_type} </div>
			<div class="clear"></div>
			{foreach from=$item_pro key=key item=itemsPro name=list_itemPro}
				<div class="item_product">
					<div class="imge_pro"><a href="{$itemsPro.link_detail}"><img src="{$itemsPro.images}" alt='{$itemsPro.name}'/></a></div>
					<div class="name_pro">{$itemsPro.name}</div>
					<div class="price_pro">{$itemsPro.price|bm_money_format} VND</div>
					<div class="box_buy_pro">
						<a href="{$itemsPro.link_detail}"> Chi tiết</a>
					</div>
				</div>
			{/foreach}
			{if $pagingDataPro}
			<div class="clear"></div>
			<div class="listing_paging">{$pagingDataPro}</div>
			<div class="clear"></div>
			{/if}
		</div>
	</div>
</div>
