<div class="right_content">
	{if $aryNews}
	<div class="left_home_top">
		<div id="featured" >
		{*list ảnh to*}
		  <ul class="ui-tabs-nav">
			{foreach from = $aryNews item = newsNew name = newhome1 key=k_newhome1}
	        <li class="ui-tabs-nav-item {if $smarty.foreach.newhome1.index == 0}ui-tabs-selected{/if}" id="nav-fragment-{$newsNew.id}">
				<a href="#fragment-{$newsNew.id}" title="{$newsNew.name}">
					<img src="{$newsNew.images_small}" alt="{$newsNew.name}"width="80" height="50"/>
					<span>{$newsNew.title_cut}</span>
				</a>
			</li>
			{/foreach}
	      </ul>
		  
		{*list ảnh nhỏ*}
		{foreach from = $aryNews item = newsNew2 name = newhome2 key=k_newhome2}
	    <div id="fragment-{$newsNew2.id}" {if $smarty.foreach.newhome2.index == 0}class="ui-tabs-panel"{else} class="ui-tabs-panel ui-tabs-hide"{/if}  style="">
			<a href="{$newsNew2.view_news}" ><img src="{$newsNew2.images_big}" alt="{$newsNew2.name}"  width="450" height="300"/></a>
			 <div class="info" >
				<a class="hideshow" href="#" >Hide</a>
				<h2><a href="{$newsNew2.view_news}" >{$newsNew2.name}</a></h2>
				<p style="text-align: left;">{$newsNew2.description_cut}
					<a href="{$newsNew2.view_news}" style="color: #418738">read more</a>
				</p>
			 </div>
	    </div>
		{/foreach}
		</div>
	</div>
	{/if}
	
	{*Quảng cáo*}
	<div class="right_home_top">
		{*imgae: width: 280px; height: 90px;*}
        <span class="batdongsanhungvuong">
            <a href="http://batdongsanhungvuong.com/" target="_blank" title="Bất động sản Hùng Vương"><image src="{$src_img_adv_1}"  width="280" height="180"/></a>
        </span>
        <span class="batdongsanhungvuong">
            <a href="#" target="_blank" title="Mời quảng cáo"><image src="{$src_img_adv_2}"  width="280" height="90"/></a>
        </span>
		
		<span class="image_adv"></span>
	</div>
</div>
{literal}	
	<script type="text/javascript">
	$(document).ready(function(){
		$("#featured").tabs({fx:[{opacity: "toggle", duration: 'slow'}, {opacity: "toggle", duration: 'normal'}],
			show: function(event, ui){
				$('#featured .ui-tabs-panel .info').hide();
				var infoheight=$('.info', ui.panel).height();
				$('.info', ui.panel).css('height', '0px').animate({ 'height': infoheight }, 500);
			}
		}).tabs("rotate", 5000, true);
		$('#featured').hover(
			function(){ $('#featured').tabs('rotate', 0, true); },
			function(){ $('#featured').tabs('rotate', 5000, true); }
		);
		$('#featured .ui-tabs-panel a.hideshow').click(function(){
			if($(this).text()=='Hide'){
				$(this).parent('.info').animate({ 'height': '0px' }, 500);
				$(this).text('Show');
			}
			else{
				$(this).parent('.info').animate({ 'height': '70px' }, 500);
				$(this).text('Hide');
			}
			return false;
		});
	});
</script>
{/literal}

