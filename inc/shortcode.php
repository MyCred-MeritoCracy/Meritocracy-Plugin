<?php


function  mnp_purchase_points_callback() {
    wp_enqueue_script( 'near-api-js' );
    wp_enqueue_script( 'mycred-np-js' );
    $mycred_np=get_option( 'mnp_settings' );
	$network=(isset($mycred_np['mnp']['network']) ? $mycred_np['mnp']['network'] : '');
	$exchange_rate=(isset($mycred_np['mnp']['exchange_rate']) ? $mycred_np['mnp']['exchange_rate'] : '');
    $mycred = mycred( );
	ob_start();

    if ( is_user_logged_in() ) {

    ?>
    <div class="mnp_purchase_points">
        <p class="additional-info"><?php 
        
        if(isset($_GET['account_id']) && isset($_GET['public_key']) && isset($_GET['all_keys'])) {
            _e( 'Access Succfully granted, now you can go with the purchase.', 'mycred-near-protocol' ); 
        }
        
        ?></p>
        <div class="form-group">
            <input type="number" name="mnp_points" id="mnp_points" class="form-control" placeholder="Coins to Purchase" />
            <p><em><?php _e( sprintf ("Please enter the %s you want to purchase" ,$mycred->name['plural']), 'mycred-near-protocol' ); ?></em></p>
        </div>
        <div class="form-group">
            <input type="text" name="mnp_near_contact" id="mnp_near_contact" class="form-control" placeholder="Near Wallet ID" />
            <p><em><?php _e( 'Please enter your near wallet ID (without network)', 'mycred-near-protocol' ); ?></em></p>
            <p><em><?php _e( sprintf('1 Near Equals %d %s',$exchange_rate, $mycred->name['plural']), 'mycred-near-protocol' ); ?></em></p>
            <p><em><?php _e( sprintf("Network in use is '%s'",$network), 'mycred-near-protocol' ); ?></em></p>
        </div>
        <div class="form-group">
            <p class="submit"><input type="button" id="mnp_points_purchase" class="button button-primary button-large" value="Purchase" onclick="mnp_purchase_points()"></p>
        </div>

    </div>


    <?php
    } else {
        ?>
        <div class="mnp_purchase_points">
        <p class="additional-info"><?php 
         _e( 'User needs to be looged in to purchase points.', 'mycred-near-protocol' ); 
        ?></p>

       <?php
    }

    $html = ob_get_contents();
    ob_end_clean();
	return $html;
}


add_shortcode( 'mnp_purchase_points', 'mnp_purchase_points_callback' );
