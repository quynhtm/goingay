jQuery(document).ready(function($){
	ADMIN.back();
	ADMIN.checkAllItem();
	ADMIN.deleteItem();
	ADMIN.restoreItem();
});

ADMIN = {
	deleteItem:function(){
		jQuery('a#deleteMoreItem').click(function(){
			var total = jQuery( "input:checked" ).length;
			if(total==0){
				jAlert('Vui lòng chọn ít nhất 1 bản ghi để xóa!', 'Thông báo');
				return false;
			}else{
				if (confirm('Bạn muốn xóa [OK]:Đồng ý [Cancel]:Bỏ qua?)')){
					jQuery('form#formListItem').submit();
					return true;
				}
				return false;
			}
		});
	},
	restoreItem:function(){
		jQuery('a#restoreMoreItem').click(function(){
			var total = jQuery( "input:checked" ).length;
			if(total==0){
				jAlert('Vui lòng chọn ít nhất 1 bản ghi để khôi phục!', 'Thông báo');
				return false;
			}else{
				if (confirm('Bạn muốn khôi phục [OK]:Đồng ý [Cancel]:Bỏ qua?)')){
					jQuery('form#formListItem').attr("action", WEB_ROOT+"/admin/trash/restore");
					jQuery('form#formListItem').submit();
					return true;
				}
				return false;
			}
		});
	},
	back:function(){
		jQuery("button[type=reset]").click(function(){
	   		window.history.back();
	   });
	},
	checkAllItem:function(){
		jQuery("input#checkAll").click(function(){
            var checkedStatus = this.checked;
            jQuery("input.checkItem").each(function(){
                this.checked = checkedStatus;
            });
        });
	},
	checkAllClass:function(strs){
		if(strs != ''){
			jQuery("input." + strs).click(function(){
				var checkedStatus = this.checked;
				jQuery("input.item_" + strs).each(function(){
					this.checked = checkedStatus;
				});
			});
		}
	},	
}