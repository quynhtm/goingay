<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="?page=home" target="_blank">{$domain_site}</a>
        </div>
        {*Danh sách menu admin*}
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <li {if $page_action == 'admin'}class="active"{/if}><a href="?page=admin">Control panel</a></li>

                {if $is_manager == 1 || $is_manager_product == 1 || $is_shop == 1}
                    <li class="dropdown {if $page_action == 'mng_category' || $page_action == 'mng_product' }active{/if}">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">QL Sản phẩm<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li {if $page_action == 'mng_product'}class="active"{/if}><a href="?page=mng_product">Sản phẩm</a></li>
                            {if $is_manager == 1}
                                <li {if $page_action == 'mng_category'}class="active"{/if}><a href="?page=mng_category">Danh mục sản phẩm</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}

                {if $is_manager == 1 || $is_manager_new == 1}
                    <li class="dropdown {if $page_action == 'mng_category' || $page_action == 'mng_news' }active{/if}">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">QL Tin tức<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li {if $page_action == 'mng_news'}class="active"{/if}><a href="?page=mng_news">Tin tức</a></li>
                            {if $is_manager == 1}
                                <li {if $page_action == 'mng_category'}class="active"{/if}><a href="?page=mng_category">Danh mục tin tức</a></li>
                            {/if}
                        </ul>
                    </li>
                {/if}

                {if $is_manager == 1 || $is_sale == 1 || $is_shop == 1}
                    <li {if $page_action == 'mng_bill'}class="active"{/if}><a href="?page=mng_bill">Bán hàng</a></li>
                {/if}

                {if $is_manager == 1}
                <li class="dropdown {if $page_action == 'banner_adv' || $page_action == 'yahoo'}active{/if}">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Quản trị mở rộng<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li {if $page_action == 'banner_adv'}class="active"{/if}><a href="?page=banner_adv">QL quảng cáo</a></li>
                        <li {if $page_action == 'yahoo'}class="active"{/if}><a href="?page=yahoo">QL hỗ trợ yahoo</a></li>
                    </ul>
                </li>
                {/if}

                {if $is_root == 1 || $is_setup_permit == 1}
                <li class="dropdown {if $page_action == 'user' || $page_action == 'page'|| $page_action == 'module'}active{/if}">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Quản trị Admin<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        {if $is_root == 1 || $is_setup_permit == 1}
                            <li {if $page_action == 'user'}class="active"{/if}><a href="?page=user">QL người dùng</a></li>
                        {/if}
                        {if $is_root == 1}
                            <li {if $page_action == 'page'}class="active"{/if}><a href="?page=page">Cấu hình site</a></li>
                            <li {if $page_action == 'module'}class="active"{/if}><a href="?page=module">Quản trị Module</a></li>
                        {/if}
                    </ul>
                </li>
                {/if}
            </ul>

            {*Thông tin user*}
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Xin chào <b>{$admin_user}</b><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="?page=user&act=edit&id={$id_user}">Thông tin User</a></li>
                        <li><a href="?page=sign_out">Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

{literal}
    <style>
        .marginBottom-0 {margin-bottom:0;}
        .dropdown-submenu{position:relative;}
        .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
        .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
        .dropdown-submenu:hover>a:after{border-left-color:#555;}
        .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

    </style>
{/literal}
{literal}
    <script>
        (function($){
            $(document).ready(function(){
                $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    $(this).parent().siblings().removeClass('open');
                    $(this).parent().toggleClass('open');
                });
            });
        })(jQuery);

    </script>
{/literal}

