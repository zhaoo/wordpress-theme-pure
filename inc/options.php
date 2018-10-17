<?php
add_action('admin_menu','theme_setting');
function theme_setting(){
	add_theme_page(__('主题设置'),__('主题设置'),'edit_themes',basename(__FILE__),'setting');
	add_action('admin_init', 'register_theme_setting');
}
function register_theme_setting(){
	register_setting('settings_group','p_options');
}
function setting(){
?>
<link href="<?php bloginfo('template_url') ?>/inc/css/options.css" rel="stylesheet">
<div class="wrap">
	<div class="container">
		<?php
			if( 'reset' == isset($_REQUEST['reset']) ) {
				// include('options-default.php');
				// update_option('p_options', $default_options);
				delete_option('p_options');
				echo '<div id="message" class="updated fade"><p><strong>已重置</strong></p></div>';
			}
		?>
		<div class="navbar">
			<div class="item"><a class="underline active" id="item-1">基本设置</a></div>
			<div class="item"><a class="underline" id="item-2">功能设置</a></div>
			<div class="item"><a class="underline" id="item-3">代码追加</a></div>
			<div class="item"><a class="underline" id="item-4">其他设置</a></div>
		</div>
		<form method="post" action="options.php">
			<?php settings_fields('settings_group'); ?>
			<?php $options = get_option('p_options'); ?>
			<div class="page show" id="page-1">
				<div class="form-group">
					<label for="p_options[description]">描述</label>
					<input type="text" name="p_options[description]" id="p_options[description]" value="<?php echo $options['description']; ?>">
				</div>
				<div class="form-group">
					<label for="p_options[keywords]">关键词</label>
					<input type="text" name="p_options[keywords]" id ="p_options[keywords]" value="<?php echo $options['keywords']; ?>">
				</div>
				<div class="form-group">
					<label for="p_options[copyright]">版权信息</label>
					<input type="text" name="p_options[copyright]" id ="p_options[copyright]" value="<?php echo $options['copyright']; ?>">
				</div>
			</div>
			<div class="page" id="page-2">
				<div class="form-group">
					<label for="p_options[ajax]">文章列表分页</label>
					<div class="radio">
						<input type="radio" name="p_options[ajax]" value="1" <?php checked('1',$options['ajax']); ?> />Ajax
					</div>
					<div class="radio">
						<input type="radio" name="p_options[ajax]" value="" <?php checked('',$options['ajax']); ?> />Pagination
					</div>
				</div>
				<div class="form-group">
					<label for="p_options[pjax]">Pjax 加载</label>
					<div class="radio">
						<input type="radio" name="p_options[pjax]" value="1" <?php checked('1',$options['pjax']); ?> />开启
					</div>
					<div class="radio">
						<input type="radio" name="p_options[pjax]" value="" <?php checked('',$options['pjax']); ?> />关闭
					</div>
				</div>
				<div class="form-group">
					<label for="p_options[back-to-top]">返回顶部按钮</label>
					<div class="radio">
						<input type="radio" name="p_options[back-to-top]" value="1" <?php checked('1',$options['back-to-top']); ?> />开启
					</div>
					<div class="radio">
						<input type="radio" name="p_options[back-to-top]" value="" <?php checked('',$options['back-to-top']); ?> />关闭
					</div>
				</div>
				<div class="form-group">
					<label for="p_options[article-footer]">文章底栏</label>
					<div class="radio">
						<input type="radio" name="p_options[article-footer]" value="1" <?php checked('1',$options['article-footer']); ?> />开启
					</div>
					<div class="radio">
						<input type="radio" name="p_options[article-footer]" value="" <?php checked('',$options['article-footer']); ?> />关闭
					</div>
				</div>
				<div class="form-group">
					<label for="p_options[highlight]">代码高亮样式</label>
					<select name="p_options[highlight]" id="p_options[highlight]">
						<?php
							$dir =  dirname(__FILE__);
							$file = scandir($dir."/../css/highlight/");
							foreach($file as $name) {
								if(($name!=".") && ($name!="..")) {
									echo "<option value='".$name."'";
									if ($options['highlight'] == $name) {
										echo "selected";
									} 
									echo ">".$name."</option>";
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class="page" id="page-3">
				<div class="form-group">
					<label for="p_options[html]">HTML</label>
					<textarea name="p_options[html]" id="p_options[html]" rows="6"><?php echo $options['html']; ?></textarea>
				</div>
				<div class="form-group">
					<label for="p_options[css]">CSS</label>
					<textarea name="p_options[css]" id="p_options[css]" rows="6"><?php echo $options['css']; ?></textarea>
				</div>
				<div class="form-group">
					<label for="p_options[js]">JavaScript</label>
					<textarea name="p_options[js]" id="p_options[js]" rows="6"><?php echo $options['js']; ?></textarea>
				</div>
				<div class="form-group">
					<label for="p_options[php]">PHP</label>
					<textarea name="p_options[php]" id="p_options[php]" rows="6"><?php echo $options['php']; ?></textarea>
				</div>
			</div>
			<div class="page" id="page-4"></div>
			<input type="submit" name="submit" value="保存" class="btn btn-submit" />
		</form>
		<form method="post">
			<input type="submit" name="reset" class="btn btn-reset" value="重置"/>
			<input type="hidden" name="reset" value="reset" />
		</form>
	</div>
</div>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/inc/js/options.js"></script>
<?php } ?>