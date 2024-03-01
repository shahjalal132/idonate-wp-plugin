<?php

defined( "ABSPATH" ) || exit( "Direct Access Not Allowed" );

/**
 * Display donors shortcode.
 *
 * This function retrieves and displays information about donors in a WordPress site.
 * It generates HTML output containing details like serial number, name, blood group, availability, mobile number, and state name of each donor.
 *
 * @return string The HTML output of the donors' information.
 */

// Register shortcode for displaying donors
add_shortcode( 'display_donors_shortcode', 'display_donors_shortcode_callback' );

function display_donors_shortcode_callback() {

    $donor_number = get_option( 'idonate_general_option_name' );
    $formText     = textset_option();

    if ( !empty( $text = $formText['donor_vmt'] ) ) {
        $formText = $text;
    } else {
        $formText = __( 'Donor Details', 'idonate' );
    }

    ob_start();

    if ( !idonate_user_logged_in_donor_show() ) {
        return '<h3 class="alert text-center alert-danger">' . esc_html__( 'You have to logged in to see donor', 'idonate' ) . '</h3>';
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="donor-search">
                    <form method="get">
                        <?php
                        echo '<h5>' . esc_html__( 'Donor Filter:', 'idonate' ) . '</h5>';
                        ?>
                        <div class="row">
                            <div class="col-sm-4">

                                <select class="form-control" name="bloodgroup">
                                    <option>
                                        <?php esc_html_e( 'Select Blood Group', 'idonate' ); ?>
                                    </option>
                                    <?php
                                    $bloodgroup = idonate_blood_group();
                                    foreach ( $bloodgroup as $group ) {

                                        echo '<option value="' . esc_attr( $group ) . '">' . esc_html( $group ) . '</option>';
                                    }
                                    ?>
                                </select>

                                <select class="form-control" name="availability">
                                    <option>
                                        <?php esc_html_e( 'Select Availability', 'idonate' ); ?>
                                    </option>
                                    <option value="Available">
                                        <?php esc_html_e( 'Available', 'idonate' ); ?>
                                    </option>
                                    <option value="unavailable">
                                        <?php esc_html_e( 'Unavailable', 'idonate' ); ?>
                                    </option>
                                </select>

                            </div>
                            <div class="col-sm-4">
                                <select id="country" class="form-control country" name="country">
                                    <?php
                                    echo idonate_countries_options();
                                    ?>
                                </select>
                                <select class="form-control state" id="state" name="state">
                                    <option>
                                        <?php esc_html_e( 'Select Country First', 'idonate' ); ?>
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" name="city" class="form-control"
                                    placeholder="<?php esc_attr_e( 'Write city name', 'idonate' ); ?>" />
                                <input type="submit" class="btn btn-primary"
                                    value="<?php esc_html_e( 'Search Donor', 'idonate' ); ?>" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="donors">
            <?php

            if (
                isset( $_GET['bloodgroup'] ) ||
                isset( $_GET['availability'] ) ||
                isset( $_GET['country'] ) ||
                isset( $_GET['state'] )

            ) {

                $metaquery = array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'idonate_donor_bloodgroup',
                            'value'   => sanitize_text_field( isset( $_GET['bloodgroup'] ) ? $_GET['bloodgroup'] : '' ),
                            'compare' => '=',
                        ),
                        array(
                            'key'     => 'idonate_donor_availability',
                            'value'   => sanitize_text_field( isset( $_GET['availability'] ) ? $_GET['availability'] : '' ),
                            'compare' => '=',
                        ),
                    ),
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'idonate_donor_country',
                            'value'   => sanitize_text_field( isset( $_GET['country'] ) ? $_GET['country'] : '' ),
                            'compare' => '=',
                        ),
                        array(
                            'key'     => 'idonate_donor_state',
                            'value'   => esc_attr( isset( $_GET['state'] ) ? $_GET['state'] : '' ),
                            'compare' => '=',
                        ),
                        array(
                            'key'     => 'idonate_donor_city',
                            'value'   => esc_attr( isset( $_GET['city'] ) ? $_GET['city'] : '' ),
                            'compare' => '=',
                        ),

                    ),

                );

            } else {
                $metaquery = '';
            }

            // donor_per_page
            $number = !empty( $donor_number['donor_per_page'] ) ? $donor_number['donor_per_page'] : 10; // ie. users per page  

            // Total approved donor
            $totaldonor_args = array(
                'role'       => 'donor',
                'meta_key'   => 'idonate_donor_status',
                'meta_value' => '1',
            );

            // get total donors
            $get_donor       = get_users( $totaldonor_args );
            $total_donor     = count( $get_donor );
            
            // Pagination
            $paged = get_query_var( 'paged' );
            $args  = array(
                'role'       => 'donor',
                'meta_key'   => 'idonate_donor_status',
                'meta_value' => '1',
                'meta_query' => $metaquery,
                'order'      => 'ASC',
                'offset'     => $paged ? ( $paged - 1 ) * $number : 0,
                'number'     => $number,

            );

            // Get donor
            $users = get_users( $args );

            if ( is_array( $users ) && count( $users ) > 0 ) :
                echo '<div class="row">';
                foreach ( $users as $user ) :
                    $uid = uniqid();

                    $countryCode = get_user_meta( $user->ID, 'idonate_donor_country', true );
                    $statecode   = get_user_meta( $user->ID, 'idonate_donor_state', true );

                    $country = idonate_country_name_by_code( $countryCode );

                    $state = idonate_states_name_by_code( $countryCode, $statecode );

                    // availability
                    $av = get_user_meta( $user->ID, 'idonate_donor_availability', true );

                    if ( 'available' == $av ) {
                        $abclass = 'available';
                        $signal  = '<i class="fa fa-check"></i>';
                    } else {
                        $abclass = 'unavailable';
                        $signal  = '<i class="fa fa-times"></i>';
                    }

                    ?>
                    
                    <div class="jalal">
                        <div class="donor-item">

                            <div class="donors-img">
                                <?php if ( idonate_profile_img( $user->ID ) ) : ?>
                                    <?php
                                    echo idonate_profile_img( $user->ID );
                                    ?>
                                <?php else : ?>
                                    <img src="<?php
                                    echo plugin_dir_url( __DIR__ ) . 'img/donorplaceholder.jpeg' ?>" />
                                <?php endif; ?>
                            </div>

                            <div class="donors-info">
                                <p><i class="fa-solid fa-user"></i>
                                    <?php echo get_user_meta( $user->ID, 'idonate_donor_full_name', true ); ?>
                                </p>
                                <p><i class="fa fa-object-group"></i>
                                    <?php echo get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ); ?>
                                </p>
                                <p><i class="fa fa-universal-access"></i><span class="ms-5px <?php echo esc_attr( $abclass ); ?>">
                                        <?php echo esc_html( $av ) . wp_kses_post( $signal ); ?>
                                    </span></p>
                                <p><i class="fa fa-map-marker"></i>
                                    <?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_city', true ) ); ?>
                                </p>
                                <p><i class="fa fa-mobile"></i>
                                    <?php echo get_user_meta( $user->ID, 'idonate_donor_mobile', true ); ?>
                                </p>
                                <!-- Button trigger modal -->
                                <?php
                                $buttonType = get_option( 'idonate_general_option_name' );

                                if ( !empty( $buttonType['donor_view_button'] ) && $buttonType['donor_view_button'] == 'link' ) :
                                    ?>
                                    <a href="<?php echo site_url( 'donor-info?donor_id=' . $user->ID ); ?>" class="btn btn-primary">
                                        <?php esc_html_e( 'View Details', 'idonate' ); ?>
                                    </a>
                                </div>
                                <?php
                                else :
                                    ?>
                                <button type="button" href="#<?php echo esc_attr( $uid ); ?>" class="btn btn-primary open-popup-link"
                                    data-target="#<?php echo esc_attr( $uid ); ?>">
                                    <?php esc_html_e( 'View Details', 'idonate' ); ?>
                                </button>
                                <?php
                                endif;
                                ?>


                        </div>


                        <!-- Modal -->
                        <div id="<?php echo esc_attr( $uid ); ?>" class="white-popup mfp-hide">
                            <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="popupContentWrapper" role="document">
                                    <div class="modal-body">
                                        <div class="donor-profile">
                                            <div class="donor-img">
                                                <?php if ( idonate_profile_img( $user->ID ) ) : ?>
                                                    <?php
                                                    echo idonate_profile_img( $user->ID );
                                                    ?>
                                                <?php else : ?>
                                                    <img src="<?php
                                                    echo plugin_dir_url( __DIR__ ) . 'img/donorplaceholder.jpeg' ?>" />
                                                <?php endif; ?>
                                            </div>
                                            <div class="modalContentDetails">
                                                <div class="personal-info text-center">
                                                    <h3>
                                                        <?php echo get_user_meta( $user->ID, 'idonate_donor_full_name', true ); ?>
                                                    </h3>
                                                    <p>
                                                        <?php echo $user->user_email; ?>
                                                    </p>
                                                    <p>
                                                        <?php echo get_user_meta( $user->ID, 'idonate_donor_mobile', true ); ?>
                                                    </p>
                                                    <p><span class="<?php echo esc_attr( $abclass ); ?>">
                                                            <?php echo esc_html( $av ) . wp_kses_post( $signal ); ?>
                                                        </span></p>
                                                    <p>
                                                        <?php echo get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ); ?>
                                                    </p>
                                                </div>
                                                <div class="address text-center">

                                                    <?php
                                                    $lastdonate = get_user_meta( $user->ID, 'idonate_donor_lastdonate', true );
                                                    if ( $lastdonate ) :
                                                        ?>
                                                        <p><strong>
                                                                <?php esc_html_e( 'Last Donate :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php echo esc_html( $lastdonate ); ?>
                                                        </p>
                                                    <?php endif; ?>

                                                    <?php
                                                    $gender = get_user_meta( $user->ID, 'idonate_donor_gender', true );
                                                    if ( $gender ) :
                                                        ?>
                                                        <p><strong>
                                                                <?php esc_html_e( 'Gender :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php echo esc_html( $gender ); ?>
                                                        </p>
                                                    <?php endif; ?>

                                                    <?php
                                                    $dob = get_user_meta( $user->ID, 'idonate_donor_date_birth', true );
                                                    if ( $dob ) : ?>
                                                        <p><strong>
                                                                <?php esc_html_e( 'Date Of Birth :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php echo esc_html( $dob ); ?>
                                                        </p>
                                                    <?php endif; ?>

                                                    <?php
                                                    $landline = get_user_meta( $user->ID, 'idonate_donor_landline', true );
                                                    if ( $landline ) : ?>
                                                        <p><strong>
                                                                <?php esc_html_e( 'Land Line Number :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php echo esc_html( $landline ); ?>
                                                        </p>
                                                    <?php endif; ?>

                                                    <?php
                                                    if ( $country ) :
                                                        ?>
                                                        <p><strong>
                                                                <?php esc_html_e( 'Country :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php echo esc_html( $country ); ?>
                                                        </p>
                                                        <?php
                                                    endif;
                                                    if ( $state ) :
                                                        ?>
                                                        <p><strong>
                                                                <?php esc_html_e( 'State :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php echo esc_html( $state ); ?>
                                                        </p>
                                                        <?php
                                                    endif;
                                                    ?>
                                                    <p><strong>
                                                            <?php esc_html_e( 'City :', 'idonate' ); ?>
                                                        </strong>
                                                        <?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_city', true ) ); ?>
                                                    </p>
                                                    <p><strong>
                                                            <?php esc_html_e( 'Address :', 'idonate' ); ?>
                                                        </strong>
                                                        <?php echo get_user_meta( $user->ID, 'idonate_donor_address', true ); ?>
                                                    </p>

                                                    <p><strong>
                                                            <?php esc_html_e( 'Email :', 'idonate' ); ?>
                                                        </strong>
                                                        <?php echo $user->user_email; ?>
                                                    </p>
                                                    <?php
                                                    $fb      = get_user_meta( $user->ID, 'idonate_donor_fburl', true );
                                                    $twitter = get_user_meta( $user->ID, 'idonate_donor_twitterurl', true );

                                                    if ( $fb || $twitter ) {
                                                        ?>
                                                        <p class="social-icon"><strong>
                                                                <?php esc_html_e( 'Social Media :', 'idonate' ); ?>
                                                            </strong>
                                                            <?php
                                                            // FB Url 
                                                            if ( $fb ) {
                                                                echo '<a target="_blank" href="' . esc_url( $fb ) . '"><i class="fa fa-facebook"></i></a>';
                                                            }
                                                            // Twitter
                                                            if ( $twitter ) {
                                                                echo '<a target="_blank" href="' . esc_url( $twitter ) . '"><i class="fa fa-twitter"></i></a>';
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                echo '</div>';
                idonate_donor_pagination( $total_donor, $number, $paged );
            else :
                echo '<h3 class="notmatch">' . esc_html__( 'Sorry. Not match anyone !!!.', 'idonate' ) . '</h3>';
            endif;
            ?>
        </div>
    </div>


    <?php
    return ob_get_clean();
}