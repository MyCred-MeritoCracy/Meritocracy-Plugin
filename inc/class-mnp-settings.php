<?php

if(class_exists('myCRED_Module')){
	class mnp_Settings extends myCRED_Module {
		
		function __construct() {
			add_action( 'mycred_after_core_prefs', array( $this, 'mnp_settings' ), 10, 1 );
			add_filter( 'mycred_save_core_prefs', array( $this, 'mnp_save_settings' ), 10, 3 );
		}
		
		function mnp_settings( $object ) {
			
			$mnp_settings=get_option( 'mnp_settings' );	
			//$mnp_settings['mnp']['private_key'] = isset($mnp_settings['mnp']['private_key']) ? esc_attr($mnp_settings['mnp']['private_key']) : '';
			$mnp_settings['mnp']['network'] = isset($mnp_settings['mnp']['network']) ? esc_attr($mnp_settings['mnp']['network']) : 'testnet';
			$mnp_settings['mnp']['admin_account'] = isset($mnp_settings['mnp']['admin_account']) ? esc_attr($mnp_settings['mnp']['admin_account']) : '';
			$mnp_settings['mnp']['exchange_rate'] = isset($mnp_settings['mnp']['exchange_rate']) ? esc_attr($mnp_settings['mnp']['exchange_rate']) : 1;
			$mycred = mycred( );
			?>
			<h4><span class="dashicons dashicons-admin-plugins static"></span><label><?php _e( 'Near Protocol', 'mycred-near-protocol' ); ?></label></h4>
				<div class="body" style="display:none;">

					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="shortcode">Shortcodes [mnp_purchase_points]</label>
									</div>
								</div>
							</div>
							<!--
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'mnp' => 'private_key' ) ); ?>"><?php _e( 'Private Key', 'mycred-near-protocol' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'mnp' => 'private_key' ) ); ?>" id="<?php echo $this->field_id( array( 'mnp' => 'private_key' ) ); ?>" class="form-control" value="<?php echo esc_attr( $mnp_settings['mnp']['private_key'] ); ?>" />
										<p><em><?php _e( 'Account Private Key', 'mycred-near-protocol' ); ?></em></p>
									</div>
								</div>
							</div>
							-->

							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'mnp' => 'network' ) ); ?>"><?php _e( 'Please enter your Near Protocol Network', 'mycred-near-protocol' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'mnp' => 'network' ) ); ?>" id="<?php echo $this->field_id( array( 'mnp' => 'network' ) ); ?>" class="form-control" value="<?php echo esc_attr( $mnp_settings['mnp']['network'] ); ?>" />
										<p><em><?php _e( 'Please add near protocol network, default is testnet', 'mycred-near-protocol' ); ?></em></p>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'mnp' => 'admin_account' ) ); ?>"><?php _e( 'Please enter your NEAR Wallet Account', 'mycred-near-protocol' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'mnp' => 'admin_account' ) ); ?>" id="<?php echo $this->field_id( array( 'mnp' => 'admin_account' ) ); ?>" class="form-control" value="<?php echo esc_attr( $mnp_settings['mnp']['admin_account'] ); ?>" />
										<p><em><?php _e( sprintf("When users purchase '%s', the near tokens will be transferred to admin" , $mycred->name['plural']), 'mycred-near-protocol' ); ?></em></p>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="<?php echo $this->field_id( array( 'mnp' => 'exchange_rate' ) ); ?>"><?php _e( 'Exchange Rate', 'mycred-near-protocol' ); ?></label>
										<input type="text" name="<?php echo $this->field_name( array( 'mnp' => 'exchange_rate' ) ); ?>" id="<?php echo $this->field_id( array( 'mnp' => 'exchange_rate' ) ); ?>" class="form-control" value="<?php echo esc_attr( $mnp_settings['mnp']['exchange_rate'] ); ?>" />
										<p><em><?php _e( sprintf("How many '%s' are equal to 1 near token" , $mycred->name['plural']), 'mycred-near-protocol' ); ?></em></p>
									</div>
								</div>
							</div>
							
						</div>
						
					</div>

				</div>
			<?php
		}
		
		function mnp_save_settings( $new_data, $post, $object ) {
			
			$mnp_settings = array();
			$mnp_settings['mnp'] = $post['mnp'];

			update_option( 'mnp_settings', $mnp_settings );
			
			return $new_data;
		}

	}

	$mnp_settings_Settings = new mnp_Settings();
}
