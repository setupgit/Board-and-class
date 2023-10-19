<?php
/*
 * Plugin Name:       Board and Class
 * Plugin URI:        https://github.com/setupgit/Board-and-class
 * Description:       The following code will add a custome input type Class And Board on "My-Account>Account Details Page".
 * Version:           0.2
 * Requires at least: 4.0
 * Requires PHP:      5.6
 * Author:            Vishal Verma
 * Author URI:        https://sites.google.com/view/ervishalverma/
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       add-fee
 * Domain Path:       /languages
 */
defined( 'ABSPATH' ) or die( "Really? Can't Access" );


//To set up an activation hook
function vishal_add_Board_and_class_input_active() {
   // register_post_type( 'book', ['public' => true ] ); 
} 
register_activation_hook( __FILE__, 'vishal_add_Board_and_class_input_active' );

//To set up a deactivation hook
function vishal_add_Board_and_class_input_deactive() {
   // register_post_type( 'book', ['public' => true ] ); 
} 
register_deactivation_hook( __FILE__, 'vishal_add_Board_and_class_input_deactive' );






//add class board input type field in my account section============================================================================
/**
 * Step 1. Add your field - Age Range
 */
function action_woocommerce_edit_account_form() {
	//echo "<fieldset>";
    //echo "<legend> Please fill in the following details for better services </legend>";
    
	// Select field Board
    woocommerce_form_field( 'certified_board_range', array(
        'type'      => 'select',
        'class'     => array( 'form-row-last' ),
        'label'     => __( 'Your Board', 'woocommerce' ),
        'required'  => false, // remember, this doesn't make the field required, just adds an "*"
        'options'   => array(
            ''          => __( 'Select your board', 'woocommerce' ),
            'CBSE'     => 'CBSE',
            'ICSE'     => 'ICSE',
            'ISC'     => 'ISC',
            'UP BOARD'     => 'UP BOARD',
            'MH BOARD'     => 'MH BOARD',
            'HP BOARD'       => 'HP BOARD',
			'OTHER'       => 'OTHER',
        )
    ), get_user_meta( get_current_user_id(), 'certified_board_range', true ) );
    
	// Select field Class
    woocommerce_form_field( 'certified_class_range', array(
        'type'      => 'select',
        //'class'     => array( 'form-row-wide' ),
        'class'     => array( 'form-row-first' ),
        'label'     => __( 'Your Class', 'woocommerce' ),
        'required'  => false, // remember, this doesn't make the field required, just adds an "*"
        'options'   => array(
            ''          => __( 'Select your class', 'woocommerce' ),
            '1'     => '1',
            '2'     => '2',
            '3'     => '3',
            '4'     => '4',
            '5'     => '5',
            '6'     => '6',
			'7'     => '7',
            '8'     => '8',
            '9'     => '9',
            '10'     => '10',
            '11'     => '11',
            '12'     => '12',
        )
    ), get_user_meta( get_current_user_id(), 'certified_class_range', true ) );
	//echo "</fieldset>";
}
//add_action( 'woocommerce_edit_account_form', 'action_woocommerce_edit_account_form', 10, 0 );
add_action( 'woocommerce_edit_account_form_start', 'action_woocommerce_edit_account_form', 10, 0 );


/**
 * Step 2. Make it required
 */
/*
function filter_woocommerce_save_account_details_required_fields( $required_fields ) {
    $required_fields['certified_class_range'] = __( 'Age', 'woocommerce' );
    
    return $required_fields; 
}
add_filter( 'woocommerce_save_account_details_required_fields', 'filter_woocommerce_save_account_details_required_fields', 10, 1 );
*/


/**
 * Step 3. Save field value
 */
function action_woocommerce_save_account_details( $user_id ) {
    if ( isset( $_POST['certified_class_range'] ) ) 
	{
        // Update field
        update_user_meta( $user_id, 'certified_class_range', sanitize_text_field( $_POST['certified_class_range'] ) );
    }
	if ( isset( $_POST['certified_board_range'] ) ) 
	{
        // Update field
        update_user_meta( $user_id, 'certified_board_range', sanitize_text_field( $_POST['certified_board_range'] ) );
    }
}
add_action( 'woocommerce_save_account_details', 'action_woocommerce_save_account_details', 10, 1 );



/**
 * Step 4. Get address fields for the edit user pages.
 */
function filter_woocommerce_customer_meta_fields( $args ) {
    $args['billing']['fields']['certified_class_range'] = array(
        'label'         => __( 'Class', 'woocommerce' ),
        'description'   => __( 'Enter only number: 1,2,3,4,5,6,7,8,9,10,11,12 (One class at a time, Ex. 10)', 'woocommerce' ),
    );
	$args['billing']['fields']['certified_board_range'] = array(
		'label'         => __( 'Board', 'woocommerce' ),
        'description'   => __( 'Enter only those inputs: "CBSE","ICSE","ISC","UP BOARD","MH BOARD","HP BOARD","OTHER" (One board at a time, Ex. CBSE)', 'woocommerce' ),
    );
	
    return $args;
}
add_filter( 'woocommerce_customer_meta_fields', 'filter_woocommerce_customer_meta_fields', 10, 1 );