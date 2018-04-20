<?php theme_print_sidebar('header-widget-area'); ?>



    <div class="art-shapes">
<div class="art-object1" data-left="100%"></div>
<div class="art-textblock art-object0" data-left="0%">
        <div class="art-object0-text-container">
        <div class="art-object0-text"></div>
    </div>
    
</div>
            </div>
<?php if(theme_get_option('theme_header_show_headline')): ?>
	<?php $headline = theme_get_option('theme_'.(is_home()?'posts':'single').'_headline_tag'); ?>
	<<?php echo $headline; ?> class="art-headline" data-left="4.5%">
    <a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a>
</<?php echo $headline; ?>>
<?php endif; ?>
<?php if(theme_get_option('theme_header_show_slogan')): ?>
	<?php $slogan = theme_get_option('theme_'.(is_home()?'posts':'single').'_slogan_tag'); ?>
	<<?php echo $slogan; ?> class="art-slogan" data-left="3.99%"><?php bloginfo('description'); ?></<?php echo $slogan; ?>>
<?php endif; ?>




                        
                    
