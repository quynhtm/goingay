<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper marginTop_60">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="text_center">Control panel</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <hr>
        <div class="">

            {if $check_permit_product == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=mng_product" style="height: auto!important;">
                        <i class="admin-icon-pro"></i>
                        <span>Sản phẩm</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_manager == 1 || $is_manager_new == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=mng_news" style="height: auto!important;">
                        <i class="admin-icon-news"></i>
                        <span>Tin tức</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_manager == 1 || $is_sale == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=mng_bill" style="height: auto!important;">
                        <i class="admin-icon-shopping"></i>
                        <span>Đơn hàng</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_manager == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=mng_category" style="height: auto!important;">
                        <i class="admin-icon-category"></i>
                        <span>Danh mục</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_manager == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=yahoo" style="height: auto!important;">
                        <i class="admin-icon-support"></i>
                        <span>Nick hỗ trợ</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_manager == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=banner_adv" style="height: auto!important;">
                        <i class="admin-icon-adver"></i>
                        <span>Quảng cáo</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_root == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=user" style="height: auto!important;">
                        <i class="admin-icon-user"></i>
                        <span>Account User</span>
                    </a>
                </div>
            </div>
            {/if}

            {if $is_root == 1}
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail" >
                    <a class="quick-btn" href="?page=page" style="height: auto!important;">
                        <i class="admin-icon-setup"></i>
                        <span>Setting Page</span>
                    </a>
                </div>
            </div>
            {/if}
        </div>
        <hr>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
{literal}
<script type="text/javascript">
    $(function () {

    });
</script>
{/literal}