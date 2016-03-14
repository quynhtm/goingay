{literal}
<script>
	jssor_1_slider_init = function() {
		var jssor_1_SlideshowTransitions = [
			{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$Jease$.$InWave,$Top:$Jease$.$InWave,$Clip:$Jease$.$OutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}},
			{$Duration:1500,x:0.3,y:-0.3,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.1,0.9],$Top:[0.1,0.9]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$Jease$.$InJump,$Top:$Jease$.$InJump,$Clip:$Jease$.$OutQuad},$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
			{$Duration:1500,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$Jease$.$InWave,$Top:$Jease$.$InWave,$Clip:$Jease$.$OutQuad},$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
			{$Duration:1500,x:0.3,y:-0.3,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Easing:{$Left:$Jease$.$InJump,$Top:$Jease$.$InJump,$Clip:$Jease$.$OutQuad},$Outside:true,$Round:{$Left:0.8,$Top:2.5}},
			{$Duration:1800,x:1,y:0.2,$Delay:30,$Cols:10,$Rows:5,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Reverse:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:2050,$Easing:{$Left:$Jease$.$InOutSine,$Top:$Jease$.$OutWave,$Clip:$Jease$.$InOutQuad},$Outside:true,$Round:{$Top:1.3}},
			{$Duration:1000,$Delay:30,$Cols:8,$Rows:4,$Clip:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:2049,$Easing:$Jease$.$OutQuad},
			{$Duration:1000,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$SlideOut:true,$Easing:$Jease$.$OutQuad},
			{$Duration:1000,y:-1,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$ChessMode:{$Column:12}},
			{$Duration:1000,x:-0.2,$Delay:40,$Cols:12,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5}},
			{$Duration:2000,y:-1,$Delay:60,$Cols:15,$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:$Jease$.$OutJump,$Round:{$Top:1.5}}
		];
		var jssor_1_options = {
			$AutoPlay: true,
			$SlideshowOptions: {
				$Class: $JssorSlideshowRunner$,
				$Transitions: jssor_1_SlideshowTransitions,
				$TransitionsOrder: 1
			},
			$ArrowNavigatorOptions: {
				$Class: $JssorArrowNavigator$
			},
			$BulletNavigatorOptions: {
				$Class: $JssorBulletNavigator$
			}
		};
		var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
		function ScaleSlider() {
			var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
			if (refSize) {
				refSize = Math.min(refSize, 998);
				jssor_1_slider.$ScaleWidth(refSize);
			}
			else {
				window.setTimeout(ScaleSlider, 30);
			}
		}
		ScaleSlider();
		$Jssor$.$AddEvent(window, "load", ScaleSlider);
		$Jssor$.$AddEvent(window, "resize", ScaleSlider);
		$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
		//responsive code end
	};
</script>

<style>
	.jssorb01 {
		position: absolute;
	}
	.jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
		position: absolute;
		/* size of bullet elment */
		width: 12px;
		height: 12px;
		filter: alpha(opacity=70);
		opacity: .7;
		overflow: hidden;
		cursor: pointer;
		border: #000 1px solid;
	}
	.jssorb01 div { background-color: gray; }
	.jssorb01 div:hover, .jssorb01 .av:hover { background-color: #d3d3d3; }
	.jssorb01 .av { background-color: #fff; }
	.jssorb01 .dn, .jssorb01 .dn:hover { background-color: #555555; }

	.jssora05l, .jssora05r {
		display: block;
		position: absolute;
		/* size of arrow element */
		width: 40px;
		height: 40px;
		cursor: pointer;
		/*background: url('img/a17.png') no-repeat;*/
		overflow: hidden;
	}
	.jssora05l { background-position: -10px -40px; }
	.jssora05r { background-position: -70px -40px; }
	.jssora05l:hover { background-position: -130px -40px; }
	.jssora05r:hover { background-position: -190px -40px; }
	.jssora05l.jssora05ldn { background-position: -250px -40px; }
	.jssora05r.jssora05rdn { background-position: -310px -40px; }
</style>
{/literal}

<div class="top_bg">
	<div class="clear"></div>
	<div class="div_banner">
		<div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 998px; height: 300px; overflow: hidden; visibility: hidden;">
			<div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 998px; height: 300px;overflow: hidden;">
				{foreach from = $arrImageHeader key= k_img item = img_header}
					<div data-p="112.50" style="display: none;">
						<img data-u="image" src="{$img_header}"/>
					</div>
				{/foreach}
			</div>
		</div>
	</div>

	<div class="clear"></div>
	<!-- Banner flash top
	<div class="div_banner">
		<img src="{$url_banner}" width="998px" height="250px"/>
	</div> -->

	<div class="div_menu_top">
		<ul class="menu">
			{foreach from = $arrMenu item = arr_menu}
				<li><a href="{$arr_menu.link}" {if $arr_menu.active}class="active_menu" {/if}>{$arr_menu.title}</a>
					{if $arr_menu.sub}
						<ul>
							{foreach from = $arr_menu.sub key=ke_2 item =sub_menu}
								<li><a href="{$sub_menu.linkview}">{$sub_menu.name}</a></li>
							{/foreach}
						</ul>
					{/if}
				</li>
			{/foreach}

		</ul> <!-- end .menu -->
	</div>
	<div class="clear"></div>
{literal}  
    <script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-50745155-1', 'langquetoi.com');
		ga('send', 'pageview');
    </script>
	<script>
		jssor_1_slider_init();
	</script>
{/literal}

