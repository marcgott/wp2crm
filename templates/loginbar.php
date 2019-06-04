<?php
global $wp2crm_option;
?>
  <div class="top-bar">
      <ul class="left-bar-side theme-color2-lt">
     <?php if($wp2crm_option["wp2crm_contactus_showhide"]): ?>
		<li id="contactusli"><a class="theme-color2-lt" href="<?php echo get_permalink($wp2crm_option['wp2crm_loginbar_contactus']);?>"><i class="theme-color2-lt fa fa-envelope"></i> <?php _e('Contact Us','wp2crm');?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li> 	
	<?php endif; ?>

     <?php if($wp2crm_option["wp2crm_phone_showhide"]): ?>
		<li id="contactusli"><a class="theme-color2-lt" href="tel:<?php echo $wp2crm_option['wp2crm_loginbar_phone']; ?>"><i class="theme-color2-lt fa fa-phone"></i> <?php echo $wp2crm_option['wp2crm_loginbar_phone'];  ?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li> 	
	<?php endif; ?>
     
     <?php if($wp2crm_option["wp2crm_fax_showhide"]): ?>
		<li id="contactusli"><a class="theme-color2-lt" href="tel:<?php echo $wp2crm_option['wp2crm_loginbar_fax']; ?>" ><i class="theme-color2-lt fa fa-fax"></i> <?php echo $wp2crm_option['wp2crm_loginbar_fax'];  ?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li> 	
	<?php endif; ?>

     <?php if($wp2crm_option["wp2crm_email_showhide"]): ?>
		<li id="contactusli"><a class="theme-color2-lt" href="mailto:<?php echo $wp2crm_option['wp2crm_loginbar_email']; ?>" ><i class="theme-color2-lt fa fa-envelope-o"></i> <?php echo $wp2crm_option['wp2crm_loginbar_email'];  ?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li> 	
	<?php endif; ?>

	<?php if(!is_user_logged_in() ): ?>
		<li><a class="theme-color2-lt" href="<?php echo get_permalink($wp2crm_option["wp2crm_pages_registration"]);?>"><i class="fa  fa-plus-circle"></i> <?php _e('Member Registration','wp2crm');?> </a> <span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li>
		<li id="loginli"><a href="#" class="loginlink theme-color2-lt"><i class="theme-color2-lt fa fa-lock"></i> <?php _e('Buyer Login','wp2crm');?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li>
<div class="theme-color2-lt" id="logindiv"><?php 
$args = array(
	'form_id' => 'headerloginform',
	'remember' => false,
	 'value_remember' => false,
	 'redirect' => get_permalink($wp2crm_option['wp2crm_loginbar_dataroom']) ,
'label_username' => __( 'Email Address' , 'wp2crm' ),
	'label_password' => __( 'Password' , 'wp2crm' ),
	'label_remember' => __( 'Remember Me' , 'wp2crm' ),
	'label_log_in'   => __( 'Log In' , 'wp2crm'),
	);
wp_login_form($args); ?>
<script>jQuery("#wp-submit").addClass('theme-background1-lt').css('border','none')</script>
</div>

<li><a class="theme-color2-lt" href="<?php echo wp_lostpassword_url(); ?>"><i class="theme-color2-lt fa  fa-question"></i> <?php _e('Forgot Password', 'wp2crm');?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li>
	 	<?php else: ?>
	 	<li><a class="theme-color2-lt" href="<?php echo get_permalink($wp2crm_option['wp2crm_loginbar_dataroom']);?>"><i class="theme-color2-lt fa fa-building-o"></i> <?php echo __('Your','wp2crm')." ".get_the_title($wp2crm_option['wp2crm_loginbar_dataroom']);?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li>
	 	<li><a class="theme-color2-lt" href="<?php echo get_permalink($wp2crm_option['wp2crm_pages_buyerprofile']);?>"><i class="theme-color2-lt fa fa-user"></i> <?php _e('Your Profile','wp2crm');?> </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span></li>
	 	<li><a class="theme-color2-lt" href="<?php echo wp_logout_url('/'); ?>"><i class="theme-color2-lt fa fa-arrow-circle-o-right"></i> <?php _e('Log Out','wp2crm');?> </a></li>	
		<?php endif; ?>		
      </ul> 
</div>
     <script>
     jQuery(document).ready(function(){
	jQuery(".loginlink").click(function(event){
	event.preventDefault();
	jQuery("#logindiv").css('display','inline-block');jQuery("#loginli").hide();})
     });     
     </script>
