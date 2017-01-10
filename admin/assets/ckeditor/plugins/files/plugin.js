CKEDITOR.plugins.add('files',
{
    icons: 'files',
    init: function(editor)
    {
		var pluginName = 'files';

		editor.addCommand( pluginName,
		{
			exec : function( editor )
			{
				var dialog = this;
				var reg_img = /(\.png|\.jpg|\.gif|\.jpeg)$/i;
				var reg_video = /(\.mp4|\.avi)$/i;
				
				$('body').append('<form method="post" id="fileinfo" style="display: none"><input type="file" name="fileimg" id="myfile" /></form>');
				$('#myfile').trigger('click');
				$(':file').on('change',function(){
					var file = this.files[0];
										
					$.ajax({
						//url: CKEDITOR.plugins.getPath(pluginName) + "upload.php",
						url: base_url +'upload',
						type: "POST",
						data: new FormData(document.getElementById("fileinfo")),
						dataType: 'json',
						enctype: 'multipart/form-data',
						processData: false,
						contentType: false,
						cache: false,
						xhr: function()
						{
							var xhr = new window.XMLHttpRequest();
							
							xhr.upload.addEventListener("progress", function(e){
								if (e.lengthComputable) {
									var percent = e.loaded / e.total;
										percent = percent.toFixed(2) * 100;
									$('.progress').show().width(percent +'%');
								}
							}, false);
							
							xhr.addEventListener("progress", function(e){
								if (e.lengthComputable) {
									var percent = e.loaded / e.total;
										percent = percent.toFixed(2) * 100;
									//console.log('Download '+ percent);
								}
							}, false);
							return xhr;
						},
					}).done(function( json ) {
					
						if(reg_img.test(file.name))
						{
							var obj = editor.document.createElement('img');
							obj.setAttribute( 'src', json.msg);
							editor.insertElement( obj );
						}
						else if(reg_video.test(file.name))
						{
							var html = '<video width="480" height="360" controls><source src="'+ json.msg +'" type="video/mp4"></video>';
							var obj = editor.document.createElement('span');
							obj.setHtml(html);
							editor.insertElement( obj );
						}
						else if(file.name)
						{
							var html = '<a href="'+ json.msg +'">'+ json.name +'</a>';
							var obj = editor.document.createElement('span');
							obj.setHtml(html);
							editor.insertElement( obj );
						}
						
						$('#fileinfo').remove();
					});
						
				});
			}
		});

		editor.ui.addButton('files',
		{
			label: 'Upload',
			command: pluginName,
			className : 'cke_upload_files',
			icon : this.path + 'images/icon.png'
		});
    }
});