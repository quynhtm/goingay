//Function 	
function checkform(){
	var boolCheck=true;
	var objThisNum;
	var cat_product_id = 0;
	jQuery("td #require_number").each(function (index) {
		if(isNaN(jQuery(this).val())){
			boolCheck=false;
			objThisNum=this;		
		}
     });
	var form=document.AdminForm;
	if(form.name.value==''){
		alert('Vui lòng nhập vào tên');
		form.name.focus();
	}else if(form.category_id.value==0){
		alert('Vui lòng chọn nhóm sản phẩm cho sản phẩm này');
	}else if(!boolCheck){
		alert("Vui lòng nhập vào giá trị là số");
		objThisNum.focus();
	}
	else{
		form.submit();
	}
}
function checkFormNews(){
	var boolCheck=true;
	var objThisNum;
	var cat_product_id = 0;
	jQuery("td #require_number").each(function (index) {
		if(isNaN(jQuery(this).val())){
			boolCheck=false;
			objThisNum=this;		
		}
     });
	var form=document.AdminForm;
	if(form.name.value==''){
		alert('Vui lòng nhập vào tiêu đề');
		form.name.focus();
	}
	else{
		form.submit();
	}
}
//insert image cho editor
function insertImg(src, name){
	CKEDITOR.instances.description_comment.insertHtml('<img src="'+src+'" alt="'+name+'" />');
}
