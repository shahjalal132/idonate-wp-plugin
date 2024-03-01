<?php

/**
 * Display donors shortcode.
 *
 * This function retrieves and displays information about donors in a WordPress site.
 * It generates HTML output containing details like serial number, name, blood group, availability, mobile number, and state name of each donor.
 *
 * @return string The HTML output of the donors' information.
 */
function display_donors_shortcode_callback() {
    ob_start();

    // Query to get users with role 'donor'
    $args  = array(
        'role' => 'donor',
    );
    $users = get_users( $args );

    // Start output buffer
    ?>

    <?php
    $i = 1;
    foreach ( $users as $user ) :
        // Get donor's country code and state code
        $countrycode = get_user_meta( $user->ID, 'idonate_donor_country', true );
        $stateCode   = get_user_meta( $user->ID, 'idonate_donor_state', true );

        // Get state name from country code and state code
        $statename = idonate_states_name_by_code( $countrycode, $stateCode );

        ?>

        <!-- Output donor information -->
        <div class="donor-info">

            <?php
            $image_id  = get_user_meta( $user->ID, 'idonate_donor_profilepic', true ) ?? 0;
            $image_url = wp_get_attachment_url( $image_id ) ?? '';
            ?>

            <img class="donor-profile-picture" src="<?php if ( !is_wp_error( $image_url ) )
                echo $image_url; ?>" alt="picture">

            <h4>Serial:
                <?php echo esc_html( $i ); ?>
            </h4>
            <h4>Name:
                <?php echo get_user_meta( $user->ID, 'idonate_donor_full_name', true ); ?>
            </h4>
            <h4>Blood Group:
                <?php echo get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ); ?>
            </h4>
            <h4>Available:
                <?php echo get_user_meta( $user->ID, 'idonate_donor_availability', true ); ?>
            </h4>
            <h4>Mobile:
                <?php echo get_user_meta( $user->ID, 'idonate_donor_mobile', true ); ?>
            </h4>
            <h4>State Name:
                <?php echo $statename; ?>
            </h4>
        </div>

        <?php
        // Increment serial number
        $i++;
    endforeach;
    ?>

    <?php
    // Return the buffered content as a string
    return ob_get_clean();
}

// Register shortcode for displaying donors
add_shortcode( 'display_donors_shortcode', 'display_donors_shortcode_callback' );