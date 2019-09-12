	<div class="clear"></div>
	<div class="footer">
		<div class="seo_footer">
			<a href="#" title="بروبالا" class="topbutton"><img src="<?php bloginfo('template_url'); ?>/assets/img/top.png" title="برو بالا" alt="برو بالا"></a>
			<p></p>
			<h1>آموزش برنامه نویسی</h1>
		</div>
		<div class="footer_content">
			<div class="right_footer">
				<img width="200" src="<?php bloginfo('template_url'); ?>/assets/img/logo.png" title="آموزش برنامه نویسی" alt="آموزش برنامه نویسی">
				<p><span class="convert_style1">CamelCase.ir</span> ، یک وبسایت فارسی زبان می باشد که با انتشار مقالات، آموزش ها، مطالب و کتابچه های الکترونیکی شما را با خود همراه کند و به عنوان یک مرجع معتبر شناخته می شود.</p>
				<p class="convert_style2">کلیه ی حقوق داده ای این سایت برای ( <span class="convert_style3">CamelCase.ir</span> ) محفوظ می باشد.</p>
			</div>
			<div class="left_footer">
				<h4>دیگر مطالب برنامه نویسی را از دست نمی دهید</h4>
				<form id="form" method="post" action="http://camelcase.ir/feed/index.php">
					<p>با وارد کردن ایمیل خود از مقالات، آموزش ها و مطالب ما با خبر شوید.</p>
					<input type="text" onblur="if (this.value == '') this.value = 'آدرس ایمیل شما...';" onfocus="if (this.value == 'آدرس ایمیل شما...') this.value = '';" value="آدرس ایمیل شما..." maxlength="100" name="email" />
					<input type="submit" value="دریافت مقالات، آموزش ها و مطالب" />
					<p class="convert_style4">ایمیل شما برای هیچ منظور دیگری استفاده نخواهد شد زیرا ما خود از اسپم بیزاریم.</p>
<?php
@session_start();
if(isset($_SESSION['feedregister']))
{
if($_SESSION['feedregister']==1)
{
echo "<p class='convert_style5'>عضویت شما با موفقیت انجام شد.</p>";
}
elseif($_SESSION['feedregister']==0)
{
echo "<p class='convert_style6'>مشکلی رخ داده است، لطفا دوباره تلاش کنید.</p>";
}
}
unset($_SESSION['feedregister']);
?>
				</form>
			</div>
			<div class="clear"></div>
			<div class="footer_bottom">
				<p class="convert_style7">Designed By <a href="http://camelcase.ir/about/" title="MailTo A.Shokri" rel="publisher">A.Shokri</a></p>
				<p>I</p>
				<p><img src="<?php bloginfo('template_url'); ?>/assets/img/heart.png" title="I Love Iran" alt="I Love Iran" /></p>
				<p>Iran</p>
			</div>
			<div class="clear"></div>
		</div>
	</div>