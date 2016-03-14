</div>
</div>
<div>
{if $is_login}
	<div class="notify_bar" id="notify_bar">
		<div class="notify_bar_menu">
			<!--<div class="notify_bar_overlay"></div>-->
<!-- LEFT -->
			<div class="float_left">
<!--				SHOW TIN MUA BAN -->
				<div class="buy_sell float_left">
					<div>
						<a onclick="Bm.activeNotifyMenu(this,'link_cmd')" href="javascript:void(0)" class="link_cmd notify_muaban float_left">Tin mua bán</a>
						<div class="clear2"></div>
					</div>
				</div>
<!--				END SHOW TIN MUA BAN -->

<!--				SHOW UNG DUNG -->
				<div class="application float_left">
					<div>
						<a onclick="Bm.activeNotifyMenu(this,'link_cmd')" href="javascript:void(0)" class="link_cmd notify_app float_left" id="no_border">Ứng dụng</a>
						<div class="clear2"></div>
					</div>
				</div>
<!--			END SHOW UNG DUNG -->
				<div class="clear2"></div>
			</div>
<!-- END LEFT -->

<!-- RIGHT -->
<!--		SHOW CAP NHAT MOI-->
			<div class="float_right notify_notify">
				<div>
					<a href="javascript:void(0)" class="link_cmd notify_refresh"></a>
					<div class="clear2"></div>
				</div>
			</div>
<!--		END SHOW CAP NHAT MOI-->
<!-- END RIGHT -->
			<div class="clear"></div>
		</div>
	</div>
{/if}