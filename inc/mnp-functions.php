<?php


add_action( 'wp_ajax_mnp_purchase_points', 'mnp_purchase_points_ajax_callback' );

function mnp_purchase_points_ajax_callback() {
	$response = array(
		'msg' => __('An error occurred, please contact admin', 'mycred-near-protocol')
	);
	if( wp_verify_nonce( $_POST['mrp_nonce'], 'myCred-NP-nonce' ) ) {
		$points_to_award = sanitize_text_field($_POST['pointsToPurchase']);
		$tx_receipt_id = sanitize_text_field($_POST['tx_receipt_id']);
		$tx_response = sanitize_text_field($_POST['tx_response']);

		
		$user_id = get_current_user_id();

		$data = array(
			'tx_response' => $tx_response,
			'tx_receipt_id' => $tx_receipt_id,
		);
		$log = 'Purchase mycred points from Near Tokens, Tx = '.$tx_receipt_id;
		if(!empty($user_id)) {
			if( mycred_add('purchase_from_near',$user_id,$points_to_award,$log,0, array()) ) {
				$response['msg'] = __('Points Successfully Purchased', 'mycred-near-protocol');
			}
		}
		
	}

	echo json_encode($response);
	die();
}