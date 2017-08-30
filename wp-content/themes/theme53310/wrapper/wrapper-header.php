<div class="header-wrapper1">
	<div class="row">
		<div class="span12">
			<div class="shop-menu-wrapper">
				<?php get_template_part("static/static-shop-nav"); ?>
			</div>
			<div class="search-cart-wrapper">
				<div class="search-wrapper">
					<?php get_template_part("static/static-search"); ?>
				</div>
				<div class="cart-wrapper">
                    <?php dynamic_sidebar( 'cart-holder' ); ?>
                    <i id="shopping-amount" class="ci-count"><?php echo WC()->cart->get_cart_contents_count(); ?></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="header-wrapper2">
	<div class="row">
		<div class="span12">
			<div class="logo-wrapper">
				<?php get_template_part("static/static-logo"); ?>
			</div>
			<div class="menu-wrapper">
				<?php get_template_part("static/static-nav"); ?>
			</div>
		</div>
	</div>
</div>