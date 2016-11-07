/**
 * Created by Tuan on 10/07/2015.
 */
$(document).ready(function () {
    $(".sys_delete_user").on('click',function(){
        var $this = $(this);
        var id = $(this).attr('data-id');
		jConfirm('Bạn muốn xóa [OK]:Đồng ý [Cancel]:Bỏ qua?)', 'Xác nhận', function(r) {
			if(r){
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: WEB_ROOT + '/admin/user/remove/'+id,
					data: {},
					beforeSend: function () {
						$('.modal').modal('hide')
					},
					error: function () {
						jAlert('Lỗi hệ thống!', 'Thông báo');
					},
					success: function (data) {
						if(data.success == 1){
							jAlert('Xóa tài khoản thành công!', 'Thông báo');
							$this.parents('tr').remove();
						}else{
							jAlert('Lỗi cập nhật!', 'Thông báo');
						}
					}
				});
			}
		});
    });
})
