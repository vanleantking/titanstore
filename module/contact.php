<?php
	$metatitle = 'Liên hệ';
	
	
	include dirname(__FILE__) .'/header.php';
?>
<!-- breadcrumbs -->
  
  <div class="breadcrumbs">
    <div class="container">
      <div class="row">
        <ul>
          <li class="home"> <a href="<?=base_url()?>">Trang chủ</a><span>&mdash;›</span></li>
          <li class="category13"><strong>Liên hệ</strong></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- main-container -->
  <div class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
        <section class="col-main col-sm-9 wow bounceInUp animated">
          <div class="page-title">
            <h2>Liên hệ</h2>
          </div>
          <div class="static-contain">
			<form method="post" id="form-contact">
            <fieldset class="group-select">
              <ul>
                <li>
                  <fieldset>
                    <legend>Thông tin liên hệ</legend>
                    <ul>
                      <li>
                          <div class="input-box">
                            <label>Họ tên <span class="required">*</span></label>
                            <br>
                            <input type="text" name="name" value="" class="input-text" required="">
                          </div>
                          <div class="input-box">
                            <label>Email <span class="required">*</span></label>
                            <br>
                            <input type="email" name="email" value="" class="input-text" required="">
                          </div>
                      </li>
                      <li>
                        <div class="input-box">
                          <label>Địa chỉ</label>
                          <br>
                          <input type="text" name="address" value=""  class="input-text">
                        </div>
                        <div class="input-box">
                          <label>Điện thoại</label>
                          <br>
                          <input type="text" name="phone" value="" class="input-text">
                        </div>
                      </li>
                      <li>
                        <label for="comment">Lời nhắn <em class="required">*</em></label>
                        <br>
                        <div class="">
                          <textarea name="message" class="input-text" cols="5" rows="3" required=""></textarea>
                        </div>
                      </li>
                    </ul>
                  </fieldset>
                </li>
                <li>
                <p class="require"><em class="required">* </em>Yêu cầu nhập đầy đủ</p>
                <div class="buttons-set">
                  <button type="submit" class="button submit"> <span> Gửi yêu cầu </span> </button>
				  <input type="hidden" name="task" value="contact">
                </div>
                </li>
              </ul>
            </fieldset>
			</form>
          </div>
        </section>
        <aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
		  <?php $sidebar = 'contact'; include dirname(__FILE__) .'/sidebar.php'; ?>
        </aside>
      </div>
    </div>
  </div>
  <!--End main-container --> 

<?php include dirname(__FILE__) .'/footer.php'; ?>