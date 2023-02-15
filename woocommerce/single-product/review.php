<?php
global $product;
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
?>
<div class="feedback-item">
	<div class="feedback-item__head">
		<!-- <img src="img/feedback-user.png" class="avatar" alt="feedback-user"> -->
		<?php do_action('woocommerce_review_before', $comment); ?>
		<div class="feedback-item__heading">
			<?php
			do_action('woocommerce_review_meta', $comment);
			do_action('woocommerce_review_before_comment_meta', $comment);
			?>
			<div class="name-star">
				<span class="name">

				</span>
				<!-- <div class="stars">
					<img src="img/star.svg" alt="icon star">
					<img src="img/star.svg" alt="icon star">
					<img src="img/star.svg" alt="icon star">
					<img src="img/star.svg" alt="icon star">
					<img src="img/star.svg" alt="icon star">
				</div> -->
			
				
				
	
			</div>
		</div>
		<!-- <div class="date">
			29.06.2022
		</div> -->
	</div>
	<div class="item-body">
		<?php
		do_action('woocommerce_review_comment_text', $comment);
		do_action('woocommerce_review_before_comment_text', $comment);
		do_action('woocommerce_review_after_comment_text', $comment);
		?>
	</div>
</div>