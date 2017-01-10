/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// config.uiColor 		= '#AADC6E';
	config.language 		= 'vi';
	config.height 			= 500;
	
	config.extraPlugins 	= 'youtube,video,files';
	config.youtube_width 	= '640';
	config.youtube_height 	= '480';
	config.youtube_related 	= true;
	config.youtube_older 	= false;
	config.youtube_privacy 	= false;
	config.allowedContent 	= true;
	
	config.smiley_path 		= CKEDITOR.basePath + 'plugins/smiley/images/yahoo/';
	config.smiley_images 	= ['17.gif','51.gif','111.gif','43.gif','103.gif','35.gif','75.gif','27.gif','67.gif','19.gif','59.gif','1.gif','54.gif','114.gif','46.gif','106.gif','38.gif','78.gif','30.gif','70.gif','22.gif','62.gif','7.gif','3.gif','14.gif','49.gif','109.gif','41.gif','101.gif','33.gif','73.gif','25.gif','65.gif','10.gif','57.gif','13.gif','52.gif','112.gif','44.gif','104.gif','36.gif','76.gif','28.gif','68.gif','20.gif','60.gif','5.gif','55.gif','12.gif','15.gif','47.gif','107.gif','39.gif','79.gif','31.gif','71.gif','23.gif','63.gif','8.gif','2.gif','16.gif','50.gif','110.gif','42.gif','102.gif','34.gif','74.gif','26.gif','66.gif','11.gif','58.gif','53.gif','113.gif','45.gif','105.gif','37.gif','77.gif','29.gif','69.gif','21.gif','61.gif','6.gif','56.gif','4.gif','18.gif','48.gif','108.gif','40.gif','100.gif','32.gif','72.gif','24.gif','64.gif','9.gif'];
	config.smiley_descriptions = [':-S',':(|)','\m/','@-)',':-h','8-}','(%)','=;',':)>-','>:)','8-X',':)','%%-','^#(^',':-<',':-??','=P~',':-j','L-)','>:/',':|',':-L',':-/',';)','X(',':@)','X_X','=D>',':-c','[-(','o=>','O:-)',':-"',':P','~O)',':-O','~:>',':-q',':^o',':-t','<:-P',':-@','I-)','[-X',':((','=:)',';;)','**==','=((',':>','>:P','%-(',':-?','(*)',':-&',';))','/:)','[-O<',':x',':(','B-)','3:-O',':!!',':-SS','~X(',':O)','o-+',':-B','b-(',':-*','*-:)','@};-',':-bd',':-w','8->','(:|','^:)^','8-|','\:D/',':))','>-)','>:D<','(~~)',':D','#:-S','<):)',':o3','#-o',':)]',':-$','o->','=))','$-)',':"'];
	
	//config.filebrowserBrowseUrl = base_url + "assets/ckfinder/ckfinder.html";
	//config.filebrowserImageBrowseUrl = base_url + "assets/ckfinder/ckfinder.html?type=Images";
	//config.filebrowserFlashBrowseUrl = base_url + "assets/ckfinder/ckfinder.html?type=Flash";
	//config.filebrowserUploadUrl = base_url + "assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
	//config.filebrowserImageUploadUrl = base_url + "assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
	//config.filebrowserFlashUploadUrl = base_url + "assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
};