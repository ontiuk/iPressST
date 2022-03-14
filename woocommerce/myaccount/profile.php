<?php 
/**
 * Add customer profile to Account navigation
 */

// Get current user
$current_user = wp_get_current_user();
?>

<div class="customer-profile">
    <h4 class="text-uppercase text-bold"><?php echo $current_user->display_name; ?></h4>
    <p class="text-muted text-small mb-0"><?php echo $current_user->user_email; ?></p>
</div>
