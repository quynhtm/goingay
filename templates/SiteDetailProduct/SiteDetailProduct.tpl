<div class="center_content">
	<div class="div_content">
	<!-- Box tim kiem -->
	{if $new}
		<div class="box_center">
			<div class="box_search">
				<div class="title_new">
					<h1>
						{$new.name}
						<div style="float:right; margin-left: 20px">
							<div class="fb-like fb-share-button" data-href="{$new.view}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
						</div>
					</h1>
					<i>Ngày {$new.create_time|date_format:"%d/%m/%Y %H:%M"}</i>
				</div>
				<div class="content_new">
					{$new.content}
				</div>
			</div>

		{*List san pham cung loai*}
		{if $item_pro|@count gt 0}
			<div class="list_new">
			<div class="item_new" style="border-bottom:1px solid #ccc; font-size: 14px"><b>Tin liên quan</b></div>
				{foreach from=$item_pro key=key item=itemsPro name=list_itemPro}
					<div class="item_new">
						<a href="{$itemsPro.view}">{$itemsPro.name}</a>
					</div>
				{/foreach}	
			</div>		
		{/if}
		</div>
                
	{/if}
	</div>
</div>


<div id="sys_tab_detail_info" class="tab-common sys_tabbable sys_tab_detail_info">
	<div class="tab-lbls">
		@if(isset($product['product_extra_desc']) && $product['product_extra_desc'] != '')
		<a href="#thong-tin-chung" class="t-lbl cl-trans active">Thông tin chung</a>
		@endif
		@if(isset($product['technical_description']) && $product['technical_description'] != '')
		<a href="#thong-so-ky-thuat" class="t-lbl cl-trans ">Thông số kỹ thuật</a>
		@endif
		@if($product['supplier_extra_policy'] != '')
		<a href="#chinh-sach-doi-tra" class="t-lbl cl-trans" id="sys_policy_tab">Chính sách đổi trả</a>
		@endif
		@if(isset($product['brand_warranty_content']) && $product['brand_warranty_content'] != '')
		<a href="#chinh-sach-bao-hanh" class="t-lbl cl-trans" id="sys_warranty_tab">Chính sách bảo hành</a>
		@endif
	</div>
	<div class="tab-content">
		@if(isset($product['product_extra_desc']) && $product['product_extra_desc'] != '')
		<div id="thong-tin-chungx" class="tab-content-item active">
			<div id="sys_wd_fulltext_content" class="wd-fulltext-content">
				{{$product['product_extra_desc']}}
			</div>
			<div id="sys_btn_more_full_desc" class="btn-more-full-desc hide-elem"><span class="lbl-show">Xem thêm</span> <span class="lbl-hide">Thu gọn</span> mô tả</div>
		</div>
		@endif
		@if(isset($product['technical_description']) && $product['technical_description'] != '')
		<div id="thong-so-ky-thuatx" class="tab-content-item">
			<div class="tech-spec-heading">Thông số kỹ thuật {{$product['product_name']}}</div>
			<div id="demo-thong-so-ky-thua">
				{{$product['technical_description']}}
			</div>
		</div>
		@endif
		@if($product['supplier_extra_policy'] != '')
		<div id="chinh-sach-doi-trax" class="tab-content-item">
			{{$product['supplier_extra_policy']}}
		</div>
		@endif
		@if(isset($product['brand_warranty_content']) && $product['brand_warranty_content'] != '')
		<div id="chinh-sach-bao-hanhx" class="tab-content-item">
			<div id="demo-bao-hanh">
				{{$product['brand_warranty_content']}}
			</div>
		</div>
		@endif
	</div>
</div>


{literal}
    <script type="text/javascript">
        function onclikShareFacebook(url_share){
            window.open(''+url_share+'', 'sharer', 'toolbar=0,status=0,width=548,height=325');
        }
		var arr4Tab = ['#thong-tin-chung','#thong-so-ky-thuat','#chinh-sach-doi-tra','#chinh-sach-bao-hanh'];
		$(document).ready(function() {
			// check Hash: 4 tab
			var getHash = window.location.hash;
			if (arr4Tab.indexOf(getHash) >= 0) {
				var tabIdx = arr4Tab.indexOf(getHash);
				var sys_tab_detail_info = $("#sys_tab_detail_info");
				var getHeadHeight = $("#header").find(".header-mid").outerHeight();
				sys_tab_detail_info.find(".t-lbl").removeClass("active").eq(tabIdx).addClass("active");
				sys_tab_detail_info.find(".tab-content-item").removeClass("active").eq(tabIdx).addClass("active");
				$("html, body").animate({scrollTop: sys_tab_detail_info.offset().top - getHeadHeight}, 0);
			}
		});

    </script>
 {/literal}       
<!-- end noi dung o giua -->
