<?php
/**
 * Countries
 *
 * Returns an array of countries and codes.
 *
 * @category    i18n
 * @package     WPERP/i18n
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//  All countries
function idonate_all_countries(){
	return array(
		'' => __( 'Select a country', 'idonate' ),
		'AF' => __( 'Afghanistan', 'idonate' ),
		'AX' => __( '&#197;land Islands', 'idonate' ),
		'AL' => __( 'Albania', 'idonate' ),
		'DZ' => __( 'Algeria', 'idonate' ),
		'AD' => __( 'Andorra', 'idonate' ),
		'AO' => __( 'Angola', 'idonate' ),
		'AI' => __( 'Anguilla', 'idonate' ),
		'AQ' => __( 'Antarctica', 'idonate' ),
		'AG' => __( 'Antigua and Barbuda', 'idonate' ),
		'AR' => __( 'Argentina', 'idonate' ),
		'AM' => __( 'Armenia', 'idonate' ),
		'AW' => __( 'Aruba', 'idonate' ),
		'AU' => __( 'Australia', 'idonate' ),
		'AT' => __( 'Austria', 'idonate' ),
		'AZ' => __( 'Azerbaijan', 'idonate' ),
		'BS' => __( 'Bahamas', 'idonate' ),
		'BH' => __( 'Bahrain', 'idonate' ),
		'BD' => __( 'Bangladesh', 'idonate' ),
		'BB' => __( 'Barbados', 'idonate' ),
		'BY' => __( 'Belarus', 'idonate' ),
		'BE' => __( 'Belgium', 'idonate' ),
		'PW' => __( 'Belau', 'idonate' ),
		'BZ' => __( 'Belize', 'idonate' ),
		'BJ' => __( 'Benin', 'idonate' ),
		'BM' => __( 'Bermuda', 'idonate' ),
		'BT' => __( 'Bhutan', 'idonate' ),
		'BO' => __( 'Bolivia', 'idonate' ),
		'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'idonate' ),
		'BA' => __( 'Bosnia and Herzegovina', 'idonate' ),
		'BW' => __( 'Botswana', 'idonate' ),
		'BV' => __( 'Bouvet Island', 'idonate' ),
		'BR' => __( 'Brazil', 'idonate' ),
		'IO' => __( 'British Indian Ocean Territory', 'idonate' ),
		'VG' => __( 'British Virgin Islands', 'idonate' ),
		'BN' => __( 'Brunei', 'idonate' ),
		'BG' => __( 'Bulgaria', 'idonate' ),
		'BF' => __( 'Burkina Faso', 'idonate' ),
		'BI' => __( 'Burundi', 'idonate' ),
		'KH' => __( 'Cambodia', 'idonate' ),
		'CM' => __( 'Cameroon', 'idonate' ),
		'CA' => __( 'Canada', 'idonate' ),
		'CV' => __( 'Cape Verde', 'idonate' ),
		'KY' => __( 'Cayman Islands', 'idonate' ),
		'CF' => __( 'Central African Republic', 'idonate' ),
		'TD' => __( 'Chad', 'idonate' ),
		'CL' => __( 'Chile', 'idonate' ),
		'CN' => __( 'China', 'idonate' ),
		'CX' => __( 'Christmas Island', 'idonate' ),
		'CC' => __( 'Cocos (Keeling) Islands', 'idonate' ),
		'CO' => __( 'Colombia', 'idonate' ),
		'KM' => __( 'Comoros', 'idonate' ),
		'CG' => __( 'Congo (Brazzaville)', 'idonate' ),
		'CD' => __( 'Congo (Kinshasa)', 'idonate' ),
		'CK' => __( 'Cook Islands', 'idonate' ),
		'CR' => __( 'Costa Rica', 'idonate' ),
		'HR' => __( 'Croatia', 'idonate' ),
		'CU' => __( 'Cuba', 'idonate' ),
		'CW' => __( 'Cura&Ccedil;ao', 'idonate' ),
		'CY' => __( 'Cyprus', 'idonate' ),
		'CZ' => __( 'Czech Republic', 'idonate' ),
		'DK' => __( 'Denmark', 'idonate' ),
		'DJ' => __( 'Djibouti', 'idonate' ),
		'DM' => __( 'Dominica', 'idonate' ),
		'DO' => __( 'Dominican Republic', 'idonate' ),
		'EC' => __( 'Ecuador', 'idonate' ),
		'EG' => __( 'Egypt', 'idonate' ),
		'SV' => __( 'El Salvador', 'idonate' ),
		'GQ' => __( 'Equatorial Guinea', 'idonate' ),
		'ER' => __( 'Eritrea', 'idonate' ),
		'EE' => __( 'Estonia', 'idonate' ),
		'ET' => __( 'Ethiopia', 'idonate' ),
		'FK' => __( 'Falkland Islands', 'idonate' ),
		'FO' => __( 'Faroe Islands', 'idonate' ),
		'FJ' => __( 'Fiji', 'idonate' ),
		'FI' => __( 'Finland', 'idonate' ),
		'FR' => __( 'France', 'idonate' ),
		'GF' => __( 'French Guiana', 'idonate' ),
		'PF' => __( 'French Polynesia', 'idonate' ),
		'TF' => __( 'French Southern Territories', 'idonate' ),
		'GA' => __( 'Gabon', 'idonate' ),
		'GM' => __( 'Gambia', 'idonate' ),
		'GE' => __( 'Georgia', 'idonate' ),
		'DE' => __( 'Germany', 'idonate' ),
		'GH' => __( 'Ghana', 'idonate' ),
		'GI' => __( 'Gibraltar', 'idonate' ),
		'GR' => __( 'Greece', 'idonate' ),
		'GL' => __( 'Greenland', 'idonate' ),
		'GD' => __( 'Grenada', 'idonate' ),
		'GP' => __( 'Guadeloupe', 'idonate' ),
		'GT' => __( 'Guatemala', 'idonate' ),
		'GG' => __( 'Guernsey', 'idonate' ),
		'GN' => __( 'Guinea', 'idonate' ),
		'GW' => __( 'Guinea-Bissau', 'idonate' ),
		'GY' => __( 'Guyana', 'idonate' ),
		'HT' => __( 'Haiti', 'idonate' ),
		'HM' => __( 'Heard Island and McDonald Islands', 'idonate' ),
		'HN' => __( 'Honduras', 'idonate' ),
		'HK' => __( 'Hong Kong', 'idonate' ),
		'HU' => __( 'Hungary', 'idonate' ),
		'IS' => __( 'Iceland', 'idonate' ),
		'IN' => __( 'India', 'idonate' ),
		'ID' => __( 'Indonesia', 'idonate' ),
		'IR' => __( 'Iran', 'idonate' ),
		'IQ' => __( 'Iraq', 'idonate' ),
		'IE' => __( 'Republic of Ireland', 'idonate' ),
		'IM' => __( 'Isle of Man', 'idonate' ),
		'IL' => __( 'Israel', 'idonate' ),
		'IT' => __( 'Italy', 'idonate' ),
		'CI' => __( 'Ivory Coast', 'idonate' ),
		'JM' => __( 'Jamaica', 'idonate' ),
		'JP' => __( 'Japan', 'idonate' ),
		'JE' => __( 'Jersey', 'idonate' ),
		'JO' => __( 'Jordan', 'idonate' ),
		'KZ' => __( 'Kazakhstan', 'idonate' ),
		'KE' => __( 'Kenya', 'idonate' ),
		'KI' => __( 'Kiribati', 'idonate' ),
		'KW' => __( 'Kuwait', 'idonate' ),
		'KG' => __( 'Kyrgyzstan', 'idonate' ),
		'LA' => __( 'Laos', 'idonate' ),
		'LV' => __( 'Latvia', 'idonate' ),
		'LB' => __( 'Lebanon', 'idonate' ),
		'LS' => __( 'Lesotho', 'idonate' ),
		'LR' => __( 'Liberia', 'idonate' ),
		'LY' => __( 'Libya', 'idonate' ),
		'LI' => __( 'Liechtenstein', 'idonate' ),
		'LT' => __( 'Lithuania', 'idonate' ),
		'LU' => __( 'Luxembourg', 'idonate' ),
		'MO' => __( 'Macao S.A.R., China', 'idonate' ),
		'MK' => __( 'Macedonia', 'idonate' ),
		'MG' => __( 'Madagascar', 'idonate' ),
		'MW' => __( 'Malawi', 'idonate' ),
		'MY' => __( 'Malaysia', 'idonate' ),
		'MV' => __( 'Maldives', 'idonate' ),
		'ML' => __( 'Mali', 'idonate' ),
		'MT' => __( 'Malta', 'idonate' ),
		'MH' => __( 'Marshall Islands', 'idonate' ),
		'MQ' => __( 'Martinique', 'idonate' ),
		'MR' => __( 'Mauritania', 'idonate' ),
		'MU' => __( 'Mauritius', 'idonate' ),
		'YT' => __( 'Mayotte', 'idonate' ),
		'MX' => __( 'Mexico', 'idonate' ),
		'FM' => __( 'Micronesia', 'idonate' ),
		'MD' => __( 'Moldova', 'idonate' ),
		'MC' => __( 'Monaco', 'idonate' ),
		'MN' => __( 'Mongolia', 'idonate' ),
		'ME' => __( 'Montenegro', 'idonate' ),
		'MS' => __( 'Montserrat', 'idonate' ),
		'MA' => __( 'Morocco', 'idonate' ),
		'MZ' => __( 'Mozambique', 'idonate' ),
		'MM' => __( 'Myanmar', 'idonate' ),
		'NA' => __( 'Namibia', 'idonate' ),
		'NR' => __( 'Nauru', 'idonate' ),
		'NP' => __( 'Nepal', 'idonate' ),
		'NL' => __( 'Netherlands', 'idonate' ),
		'AN' => __( 'Netherlands Antilles', 'idonate' ),
		'NC' => __( 'New Caledonia', 'idonate' ),
		'NZ' => __( 'New Zealand', 'idonate' ),
		'NI' => __( 'Nicaragua', 'idonate' ),
		'NE' => __( 'Niger', 'idonate' ),
		'NG' => __( 'Nigeria', 'idonate' ),
		'NU' => __( 'Niue', 'idonate' ),
		'NF' => __( 'Norfolk Island', 'idonate' ),
		'KP' => __( 'North Korea', 'idonate' ),
		'NO' => __( 'Norway', 'idonate' ),
		'OM' => __( 'Oman', 'idonate' ),
		'PK' => __( 'Pakistan', 'idonate' ),
		'PS' => __( 'Palestinian Territory', 'idonate' ),
		'PA' => __( 'Panama', 'idonate' ),
		'PG' => __( 'Papua New Guinea', 'idonate' ),
		'PY' => __( 'Paraguay', 'idonate' ),
		'PE' => __( 'Peru', 'idonate' ),
		'PH' => __( 'Philippines', 'idonate' ),
		'PN' => __( 'Pitcairn', 'idonate' ),
		'PL' => __( 'Poland', 'idonate' ),
		'PT' => __( 'Portugal', 'idonate' ),
		'QA' => __( 'Qatar', 'idonate' ),
		'RE' => __( 'Reunion', 'idonate' ),
		'RO' => __( 'Romania', 'idonate' ),
		'RU' => __( 'Russia', 'idonate' ),
		'RW' => __( 'Rwanda', 'idonate' ),
		'BL' => __( 'Saint Barth&eacute;lemy', 'idonate' ),
		'SH' => __( 'Saint Helena', 'idonate' ),
		'KN' => __( 'Saint Kitts and Nevis', 'idonate' ),
		'LC' => __( 'Saint Lucia', 'idonate' ),
		'MF' => __( 'Saint Martin (French part)', 'idonate' ),
		'SX' => __( 'Saint Martin (Dutch part)', 'idonate' ),
		'PM' => __( 'Saint Pierre and Miquelon', 'idonate' ),
		'VC' => __( 'Saint Vincent and the Grenadines', 'idonate' ),
		'SM' => __( 'San Marino', 'idonate' ),
		'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'idonate' ),
		'SA' => __( 'Saudi Arabia', 'idonate' ),
		'SN' => __( 'Senegal', 'idonate' ),
		'RS' => __( 'Serbia', 'idonate' ),
		'SC' => __( 'Seychelles', 'idonate' ),
		'SL' => __( 'Sierra Leone', 'idonate' ),
		'SG' => __( 'Singapore', 'idonate' ),
		'SK' => __( 'Slovakia', 'idonate' ),
		'SI' => __( 'Slovenia', 'idonate' ),
		'SB' => __( 'Solomon Islands', 'idonate' ),
		'SO' => __( 'Somalia', 'idonate' ),
		'ZA' => __( 'South Africa', 'idonate' ),
		'GS' => __( 'South Georgia/Sandwich Islands', 'idonate' ),
		'KR' => __( 'South Korea', 'idonate' ),
		'SS' => __( 'South Sudan', 'idonate' ),
		'ES' => __( 'Spain', 'idonate' ),
		'LK' => __( 'Sri Lanka', 'idonate' ),
		'SD' => __( 'Sudan', 'idonate' ),
		'SR' => __( 'Suriname', 'idonate' ),
		'SJ' => __( 'Svalbard and Jan Mayen', 'idonate' ),
		'SZ' => __( 'Swaziland', 'idonate' ),
		'SE' => __( 'Sweden', 'idonate' ),
		'CH' => __( 'Switzerland', 'idonate' ),
		'SY' => __( 'Syria', 'idonate' ),
		'TW' => __( 'Taiwan', 'idonate' ),
		'TJ' => __( 'Tajikistan', 'idonate' ),
		'TZ' => __( 'Tanzania', 'idonate' ),
		'TH' => __( 'Thailand', 'idonate' ),
		'TL' => __( 'Timor-Leste', 'idonate' ),
		'TG' => __( 'Togo', 'idonate' ),
		'TK' => __( 'Tokelau', 'idonate' ),
		'TO' => __( 'Tonga', 'idonate' ),
		'TT' => __( 'Trinidad and Tobago', 'idonate' ),
		'TN' => __( 'Tunisia', 'idonate' ),
		'TR' => __( 'Turkey', 'idonate' ),
		'TM' => __( 'Turkmenistan', 'idonate' ),
		'TC' => __( 'Turks and Caicos Islands', 'idonate' ),
		'TV' => __( 'Tuvalu', 'idonate' ),
		'UG' => __( 'Uganda', 'idonate' ),
		'UA' => __( 'Ukraine', 'idonate' ),
		'AE' => __( 'United Arab Emirates', 'idonate' ),
		'GB' => __( 'United Kingdom (UK)', 'idonate' ),
		'US' => __( 'United States (US)', 'idonate' ),
		'UY' => __( 'Uruguay', 'idonate' ),
		'UZ' => __( 'Uzbekistan', 'idonate' ),
		'VU' => __( 'Vanuatu', 'idonate' ),
		'VA' => __( 'Vatican', 'idonate' ),
		'VE' => __( 'Venezuela', 'idonate' ),
		'VN' => __( 'Vietnam', 'idonate' ),
		'WF' => __( 'Wallis and Futuna', 'idonate' ),
		'EH' => __( 'Western Sahara', 'idonate' ),
		'WS' => __( 'Western Samoa', 'idonate' ),
		'YE' => __( 'Yemen', 'idonate' ),
		'ZM' => __( 'Zambia', 'idonate' ),
		'ZW' => __( 'Zimbabwe', 'idonate' )
	);
}

// idonate countries
function idonate_countries(){
	
	$opt = get_option('idonate_general_option_name');
	
	$countries = idonate_all_countries();
	
	if( !empty( $opt['idonate_country'] ) && $opt['idonate_country'] != 'all' ){
		$coubntrycode = $opt['idonate_country'];
		$countries = array( $coubntrycode => $countries[$coubntrycode]  );
	}
	
	return $countries;
	
}
// Country name by country code
function idonate_country_name_by_code( $code = '' ){
	$cnty = idonate_countries();
	
	$cntyName = '';
	if( $code  ){
		if( !empty( $cnty[$code] ) ){
			$cntyName = $cnty[$code];
		}
	}

	return $cntyName;
	
}

// State Name by country and state code
function idonate_states_name_by_code( $countryCode, $statesCode ){
	
	global $states;
	
	$sendstate = '';
	
	if( $countryCode ){
		
		if( file_exists( IDONATE_COUNTRIES.'states/'.$countryCode.'.php' ) ){
			
			include( IDONATE_COUNTRIES.'states/'.$countryCode.'.php' );
			//
			if( !empty(  $states[$countryCode][$statesCode] ) ){
				$sendstate = $states[$countryCode][$statesCode];
			}
				
		}
		
	}
	
	return $sendstate;
	
}

// Countries Options
function idonate_countries_options( $selected = '' ){
	echo $selected;
	$countries = idonate_countries();
		
	$opt = '';
	foreach( $countries as $key => $country ){
	
		// 
		$selectedcount = '';
		if( $selected ){
			if( $key === $selected ){
				$selectedcount = 'selected';
			}
		}
								
		$opt .= sprintf( '<option value="%s" %s>%s</option>', esc_attr( $key ), $selectedcount ,esc_html( $country ) );
	}
	
	return $opt;
}


