<?php
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}
?>
<?php
do_action('woocommerce_before_checkout_form', $checkout);
?>
<form name="checkout" method="POST" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()) ?>" enctype="multipart/form-data">
	<div class="container">
		<div class="header">
			<?php the_title(); ?>
		</div>
		<div class="parent-row">
			<div class="col-6">
				<?php do_action('woocommerce_checkout_billing'); ?>
			</div>
			<div class="col-4" id="order_review">
				<?php do_action('woocommerce_checkout_order_review'); ?>
			</div>
		</div>
	</div>
</form>
<script>
        $(document).ready(function(){
            let items = $('.woocommerce-shipping-methods').children('li');
            $(items).each(function(){
                $(this).children('label').append('<div class="shipping-methods-check-box"><span class="shipping-methods-check"></span></div>');
                let check = $(this).children('input').attr('checked')
                if(check != undefined){
                    $(this).find('.shipping-methods-check-box').addClass('js-chekced');
                }
            })
        })
    </script>