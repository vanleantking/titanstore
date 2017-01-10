

function getnumber(obj){
	var str = obj.val().replace(/ /g, "");
	for(var i = 0; i < str.length; i++){
		var temp = str.substring(i, i + 1);
		if(!(temp == "." || (temp >= 0 && temp <=9))){
			obj.focus();
			return str.substring(0, i);
		}
	}
	return str;
};

function autonumber(obj){
	var strTemp = getnumber(obj);
	if(strTemp.length <= 3)
		return strTemp;
	strResult = "";
	for(var i =0; i< strTemp.length; i++)
		strTemp = strTemp.replace("", "");
	for(var i = strTemp.length; i>=0; i--){
		if(strResult.length >0 && (strTemp.length - i -1) % 3 == 0)
			strResult = "" + strResult;
		strResult = strTemp.substring(i, i + 1) + strResult;
	}
	return strResult;
};


function ChangeToSlug(title)
{
    var slug;
 
    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();
 
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\’|\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    return slug;
}


function submitUpload(preview) {
    $.ajax({
      url: base_url +"upload",
      type: "POST",
      data: new FormData(document.getElementById("fileinfo")),
      dataType: 'json',
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
    }).done(function( json ) {
	    if(json.res){
		    if(preview == 'picture'){
		    	$('#'+ preview).html('<span><i class="fa fa-close deleteImg"></i><img src="'+ json.msg +'" width="50" height="50"><input type="hidden" name="photo" value="'+ json.name +'"></span>');
		    }
		    else{
		    	$('#'+ preview).append('<span><i class="fa fa-close deleteImg"></i><img src="'+ json.msg +'" width="50" height="50"><input type="hidden" name="gallery[]" value="'+ json.name +'"></span>');
		    }
	    }
	    else{
		    alert(json.msg);
	    }
	    $('#fileinfo').remove();
    });
    return false;
}

function sendFile(me, file) {
    data = new FormData();
    data.append("fileimg", file);
    $.ajax({
	    url: base_url +"upload",
        data: data,
        dataType: 'json',
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        success: function(json) {
            me.summernote('insertImage', json.msg, json.name);
        }
    });
}

$(function(){
	$(document).on('keyup', '.price', function() {
		var str = autonumber($(this));
		$(this).val(str);
	});
	
	$('#chkAll').click(function(){
		$('input[name*=\'id\']').attr('checked', this.checked);
	});
	
	$('#btDelete').click(function(){
		var id = '';
		$("input[name^=id]").each(function() {
			if( $(this).prop('checked') ){
				id = $(this).val();
			}
		});
		
		if( !id ) {
			alert('Vui lòng chọn một');
		}
		else {
			if(confirm('Bạn có chắc chắn xóa?')){
				document.adminForm.submit();
			}
		}
	});

	$("#txtTitle").keyup(function (e) {
		$("#txtSlug").val( ChangeToSlug($(this).val()) );
	});

	$("body").delegate(".deleteImg", "click", function() {
		var me = $(this);
		var name = me.parents('span').find('input').val();
		$.post(base_url +'deletefile', 'name='+ name, function(){
			me.parents('span').remove();
		});
	});
	
	$('.uploadFile').click(function(){
		var preview = $(this).attr('preview');
		$('body').append('<form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitUpload(\''+ preview +'\');" class="hidden"><input type="file" name="fileimg" id="fileimg" /><input type="submit" value="Upload" /></form>');
		$('#fileimg').trigger('click');
		$('#fileimg').change(function (e) {
			$('#fileinfo').submit();
		});
	});
	
	$('.summernote').summernote({
        height: 350,
        lang: 'vi-VN',
		callbacks: {
			onImageUpload: function(files) {
				sendFile($('.summernote'), files[0]);
			}
		},
		toolbar: [
			['height', ['height', 'style', 'color']],
			['fontname', ['fontname', 'fontsize']],
			['font', ['bold', 'italic', 'underline', 'clear']],
		 	['style', ['strikethrough', 'superscript', 'subscript', 'hr']],
			['para', ['ul', 'ol', 'paragraph']],
			['table', ['table', 'undo', 'redo']],
	        ['insert', ['link', 'picture', 'video']],
	        ['view', ['fullscreen', 'codeview', 'help']]
		]
    });
	
	$('.manific-image').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}
	});
	
	$('[data-toggle="tooltip"]').tooltip();
	
	$('.toggle').click(function(e){
		e.preventDefault();
		$(this).next('ul').slideToggle();
	});
	
	$('#fisize').change(function(){
		var id = $(this).val();
	    $.ajax({
	        type: "POST",
		    url: base_url +"fisize",
	        data: {
		        id: id
	        },
	        success: function(json) {
		        $('#result-size').html(json);
	        }
	    });
	});
	
	$('.filter-category').click(function(e){
		e.preventDefault();
		var name = $(this).text();
		var parent = $(this).attr('id');
		$('.filter-category-name').text(name);
		$('.filter-category-result').val(parent);
	});
	
});