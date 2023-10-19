<?php
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}
?>


<div class="margin-top">
	<div class="container">
		<div class="checkout-form m-form ">
			<?php woocommerce_breadcrumb(); ?>
		</div>
		<?php
		do_action('woocommerce_before_checkout_form', $checkout);
		?>
		<form name="checkout" method="POST" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()) ?>" enctype="multipart/form-data">

			<div class="parent-row">
				<div class="col-lg-8 checkout-form ">
					<?php do_action('woocommerce_checkout_billing'); ?>
					<?php do_action('woocommerce_checkout_shipping'); ?>

				</div>
				<div class="col-lg-4 checkout-form " id="order_review">
					<?php do_action('woocommerce_checkout_order_review'); ?>
				</div>
			</div>

		</form>
	</div>
</div>
<script>
	$(document).ready(function() {
		let items = $('.woocommerce-shipping-methods').children('li');
		$(items).each(function() {
			$(this).children('label').append('<div class="shipping-methods-check-box"><span class="shipping-methods-check"></span></div>');
			let check = $(this).children('input').attr('checked')
			if (check != undefined) {
				$(this).find('.shipping-methods-check-box').addClass('js-chekced');
			}
		})
	})
</script>