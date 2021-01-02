<?php
/**
** A base module for [select] and [select*]
**/
 
/* Shortcode handler */
 
wpcf7_add_shortcode( 'select', 'wpcf7_select_shortcode_handler', true );
wpcf7_add_shortcode( 'select*', 'wpcf7_select_shortcode_handler', true );
 
function wpcf7_select_shortcode_handler( $tag ) {
if ( ! is_array( $tag ) )
return '';
 
$type = $tag['type'];
$name = $tag['name'];
$options = (array) $tag['options'];
$values = (array) $tag['values'];
$labels = (array) $tag['labels'];
 
if ( empty( $name ) )
return '';
 
$validation_error = wpcf7_get_validation_error( $name );
 
$atts = $id_att = $tabindex_att = '';
 
$defaults = array();
 
$class_att = wpcf7_form_controls_class( $type );
 
if ( $validation_error )
$class_att .= ' wpcf7-not-valid';
 
foreach ( $options as $option ) {
if ( preg_match( '%^id:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
$id_att = $matches[1];
 
} elseif ( preg_match( '%^class:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
$class_att .= ' ' . $matches[1];
 
} elseif ( preg_match( '/^default:([0-9_]+)$/', $option, $matches ) ) {
$defaults = explode( '_', $matches[1] );
 
} elseif ( preg_match( '%^tabindex:(\d+)$%', $option, $matches ) ) {
$tabindex_att = (int) $matches[1];
 
}
}
 
if ( $id_att )
$atts .= ' id="' . trim( $id_att ) . '"';
 
if ( $class_att )
$atts .= ' class="' . trim( $class_att ) . '"';
 
if ( '' !== $tabindex_att )
$atts .= sprintf( ' tabindex="%d"', $tabindex_att );
 
$multiple = (bool) preg_grep( '%^multiple$%', $options );
$include_blank = (bool) preg_grep( '%^include_blank$%', $options );
 
$empty_select = empty( $values );
if ( $empty_select || $include_blank ) {
array_unshift( $labels, '---' );
array_unshift( $values, '' );
}
 
$html = '';
 
$posted = wpcf7_is_posted();
 
$country_list = array (
'AC' => 'Ascension Island', 'AD' => 'Andorra', 'AE' => 'United Arab Emirates', 'AF' => 'Afghanistan', 'AG' => 'Antigua and Barbuda', 'AI' => 'Anguilla', 'AL' => 'Albania', 'AM' => 'Armenia', 'AN' => 'Netherlands Antilles', 'AO' => 'Angola', 'AQ' => 'Antarctica', 'AR' => 'Argentina', 'AS' => 'American Samoa', 'AT' => 'Austria', 'AU' => 'Australia', 'AW' => 'Aruba', 'AX' => 'Åland Islands', 'AZ' => 'Azerbaijan', 'BA' => 'Bosnia and Herzegovina', 'BB' => 'Barbados', 'BD' => 'Bangladesh', 'BE' => 'Belgium', 'BF' => 'Burkina Faso', 'BG' => 'Bulgaria', 'BH' => 'Bahrain', 'BI' => 'Burundi', 'BJ' => 'Benin', 'BL' => 'Saint Barthélemy', 'BM' => 'Bermuda', 'BN' => 'Brunei', 'BO' => 'Bolivia', 'BQ' => 'British Antarctic Territory', 'BR' => 'Brazil', 'BS' => 'Bahamas', 'BT' => 'Bhutan', 'BV' => 'Bouvet Island', 'BW' => 'Botswana', 'BY' => 'Belarus', 'BZ' => 'Belize', 'CA' => 'Canada', 'CC' => 'Cocos [Keeling] Islands', 'CD' => 'Congo - Kinshasa',
'CF' => 'Central African Republic', 'CG' => 'Congo - Brazzaville', 'CH' => 'Switzerland', 'CI' => 'Côte d’Ivoire', 'CK' => 'Cook Islands', 'CL' => 'Chile', 'CM' => 'Cameroon', 'CN' => 'China', 'CO' => 'Colombia', 'CP' => 'Clipperton Island', 'CR' => 'Costa Rica', 'CS' => 'Serbia and Montenegro', 'CT' => 'Canton and Enderbury Islands', 'CU' => 'Cuba', 'CV' => 'Cape Verde', 'CX' => 'Christmas Island', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DD' => 'East Germany', 'DE' => 'Germany', 'DG' => 'Diego Garcia', 'DJ' => 'Djibouti', 'DK' => 'Denmark', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'DZ' => 'Algeria', 'EA' => 'Ceuta and Melilla', 'EC' => 'Ecuador', 'EE' => 'Estonia', 'EG' => 'Egypt', 'EH' => 'Western Sahara', 'ER' => 'Eritrea', 'ES' => 'Spain', 'ET' => 'Ethiopia', 'EU' => 'European Union', 'FI' => 'Finland', 'FJ' => 'Fiji', 'FK' => 'Falkland Islands', 'FM' => 'Micronesia', 'FO' => 'Faroe Islands', 'FQ' => 'French Southern and Antarctic Territories', 'FR' => 'France', 'FX' => 'Metropolitan France', 'GA' => 'Gabon', 'GB' => 'United Kingdom', 'GD' => 'Grenada', 'GE' => 'Georgia',
'GF' => 'French Guiana', 'GG' => 'Guernsey', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GL' => 'Greenland', 'GM' => 'Gambia', 'GN' => 'Guinea', 'GP' => 'Guadeloupe', 'GQ' => 'Equatorial Guinea', 'GR' => 'Greece', 'GS' => 'South Georgia and the South Sandwich Islands', 'GT' => 'Guatemala', 'GU' => 'Guam', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HK' => 'Hong Kong SAR China', 'HM' => 'Heard Island and McDonald Islands', 'HN' => 'Honduras', 'HR' => 'Croatia', 'HT' => 'Haiti', 'HU' => 'Hungary', 'IC' => 'Canary Islands', 'ID' => 'Indonesia', 'IE' => 'Ireland', 'IL' => 'Israel', 'IM' => 'Isle of Man', 'IN' => 'India', 'IO' => 'British Indian Ocean Territory', 'IQ' => 'Iraq', 'IR' => 'Iran', 'IS' => 'Iceland', 'IT' => 'Italy', 'JE' => 'Jersey', 'JM' => 'Jamaica', 'JO' => 'Jordan', 'JP' => 'Japan', 'JT' => 'Johnston Island', 'KE' => 'Kenya', 'KG' => 'Kyrgyzstan', 'KH' => 'Cambodia',
'KI' => 'Kiribati', 'KM' => 'Comoros', 'KN' => 'Saint Kitts and Nevis', 'KP' => 'North Korea', 'KR' => 'South Korea', 'KW' => 'Kuwait', 'KY' => 'Cayman Islands', 'KZ' => 'Kazakhstan', 'LA' => 'Laos', 'LB' => 'Lebanon', 'LC' => 'Saint Lucia', 'LI' => 'Liechtenstein', 'LK' => 'Sri Lanka', 'LR' => 'Liberia', 'LS' => 'Lesotho', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'LV' => 'Latvia', 'LY' => 'Libya', 'MA' => 'Morocco', 'MC' => 'Monaco', 'MD' => 'Moldova', 'ME' => 'Montenegro', 'MF' => 'Saint Martin', 'MG' => 'Madagascar', 'MH' => 'Marshall Islands', 'MI' => 'Midway Islands', 'MK' => 'Macedonia', 'ML' => 'Mali',
'MM' => 'Myanmar [Burma]', 'MN' => 'Mongolia', 'MO' => 'Macau SAR China', 'MP' => 'Northern Mariana Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MS' => 'Montserrat', 'MT' => 'Malta', 'MU' => 'Mauritius', 'MV' => 'Maldives', 'MW' => 'Malawi', 'MX' => 'Mexico', 'MY' => 'Malaysia', 'MZ' => 'Mozambique', 'NA' => 'Namibia', 'NC' => 'New Caledonia', 'NE' => 'Niger', 'NF' => 'Norfolk Island', 'NG' => 'Nigeria', 'NI' => 'Nicaragua', 'NL' => 'Netherlands', 'NO' => 'Norway', 'NP' => 'Nepal', 'NQ' => 'Dronning Maud Land', 'NR' => 'Nauru', 'NT' => 'Neutral Zone', 'NU' => 'Niue', 'NZ' => 'New Zealand', 'OM' => 'Oman', 'PA' => 'Panama', 'PC' => 'Pacific Islands Trust Territory', 'PE' => 'Peru', 'PF' => 'French Polynesia', 'PG' => 'Papua New Guinea',
'PH' => 'Philippines', 'PK' => 'Pakistan', 'PL' => 'Poland', 'PM' => 'Saint Pierre and Miquelon', 'PN' => 'Pitcairn Islands', 'PR' => 'Puerto Rico', 'PS' => 'Palestinian Territories', 'PT' => 'Portugal', 'PU' => 'U.S. Miscellaneous Pacific Islands', 'PW' => 'Palau', 'PY' => 'Paraguay', 'PZ' => 'Panama Canal Zone', 'QA' => 'Qatar', 'QO' => 'Outlying Oceania', 'RE' => 'Réunion', 'RO' => 'Romania', 'RS' => 'Serbia', 'RU' => 'Russia', 'RW' => 'Rwanda', 'SA' => 'Saudi Arabia', 'SB' => 'Solomon Islands', 'SC' => 'Seychelles', 'SD' => 'Sudan', 'SE' => 'Sweden', 'SG' => 'Singapore', 'SH' => 'Saint Helena', 'SI' => 'Slovenia', 'SJ' => 'Svalbard and Jan Mayen', 'SK' => 'Slovakia', 'SL' => 'Sierra Leone', 'SM' => 'San Marino', 'SN' => 'Senegal', 'SO' => 'Somalia', 'SR' => 'Suriname', 'ST' => 'São Tomé and Príncipe', 'SU' => 'Union of Soviet Socialist Republics',
'SV' => 'El Salvador', 'SY' => 'Syria', 'SZ' => 'Swaziland', 'TA' => 'Tristan da Cunha', 'TC' => 'Turks and Caicos Islands', 'TD' => 'Chad', 'TF' => 'French Southern Territories', 'TG' => 'Togo', 'TH' => 'Thailand', 'TJ' => 'Tajikistan', 'TK' => 'Tokelau', 'TL' => 'Timor-Leste', 'TM' => 'Turkmenistan', 'TN' => 'Tunisia', 'TO' => 'Tonga', 'TR' => 'Turkey', 'TT' => 'Trinidad and Tobago', 'TV' => 'Tuvalu', 'TW' => 'Taiwan', 'TZ' => 'Tanzania', 'UA' => 'Ukraine', 'UG' => 'Uganda', 'UM' => 'U.S. Minor Outlying Islands', 'US' => 'United States',
'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VA' => 'Vatican City', 'VC' => 'Saint Vincent and the Grenadines', 'VD' => 'North Vietnam', 'VE' => 'Venezuela', 'VG' => 'British Virgin Islands', 'VI' => 'U.S. Virgin Islands', 'VN' => 'Vietnam', 'VU' => 'Vanuatu', 'WF' => 'Wallis and Futuna', 'WK' => 'Wake Island', 'WS' => 'Samoa', 'YD' => 'People\'s Democratic Republic of Yemen', 'YE' => 'Yemen', 'YT' => 'Mayotte', 'ZA' => 'South Africa', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe', 'ZZ' => 'Unknown Region',
);
 
if( stristr( $name, 'country' ) ){
$values = $country_list;
}
 
foreach ( $values as $key => $value ) {
$selected = false;
 
if ( $posted && ! empty( $_POST[$name] ) ) {
if ( $multiple && in_array( esc_sql( $value ), (array) $_POST[$name] ) )
$selected = true;
if ( ! $multiple && $_POST[$name] == esc_sql( $value ) )
$selected = true;
} else {
if ( ! $empty_select && in_array( $key + 1, (array) $defaults ) )
$selected = true;
}
 
$selected = $selected ? ' selected="selected"' : '';
 
if ( isset( $labels[$key] ) )
$label = $labels[$key];
else
$label = $value;
 
$html .= '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . esc_html( $label ) . '</option>';
}
 
if ( $multiple )
$atts .= ' multiple="multiple"';
 
$html = '<select name="' . $name . ( $multiple ? '[]' : '' ) . '"' . $atts . '>' . $html . '</select>';
 
$html = '<span class="wpcf7-form-control-wrap ' . $name . '">' . $html . $validation_error . '</span>';
 
return $html;
}
 
 
/* Validation filter */
 
add_filter( 'wpcf7_validate_select', 'wpcf7_select_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_select*', 'wpcf7_select_validation_filter', 10, 2 );
 
function wpcf7_select_validation_filter( $result, $tag ) {
$type = $tag['type'];
$name = $tag['name'];
 
if ( isset( $_POST[$name] ) && is_array( $_POST[$name] ) ) {
foreach ( $_POST[$name] as $key => $value ) {
if ( '' === $value )
unset( $_POST[$name][$key] );
}
}
 
if ( 'select*' == $type ) {
if ( ! isset( $_POST[$name] ) || empty( $_POST[$name] ) && '0' !== $_POST[$name] ) {
$result['valid'] = false;
$result['reason'][$name] = wpcf7_get_message( 'invalid_required' );
}
}
 
return $result;
}
 
 
/* Tag generator */
 
add_action( 'admin_init', 'wpcf7_add_tag_generator_menu', 25 );
 
function wpcf7_add_tag_generator_menu() {
wpcf7_add_tag_generator( 'menu', __( 'Drop-down menu', 'wpcf7' ),
'wpcf7-tg-pane-menu', 'wpcf7_tg_pane_menu' );
}
 
function wpcf7_tg_pane_menu( &$contact_form ) {
?>
<div id="wpcf7-tg-pane-menu" class="hidden">
<form action="">
<table>
<tr><td><input type="checkbox" name="required" />&nbsp;<?php echo esc_html( __( 'Required field?', 'wpcf7' ) ); ?></td></tr>
<tr><td><?php echo esc_html( __( 'Name', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>
</table>
 
<table>
<tr>
<td><code>id</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
<input type="text" name="id" class="idvalue oneline option" /></td>
 
<td><code>class</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
<input type="text" name="class" class="classvalue oneline option" /></td>
</tr>
 
<tr>
<td><?php echo esc_html( __( 'Choices', 'wpcf7' ) ); ?><br />
<textarea name="values"></textarea><br />
<span style="font-size: smaller"><?php echo esc_html( __( "* One choice per line.", 'wpcf7' ) ); ?></span>
</td>
 
<td>
<br /><input type="checkbox" name="multiple" class="option" />&nbsp;<?php echo esc_html( __( 'Allow multiple selections?', 'wpcf7' ) ); ?>
<br /><input type="checkbox" name="include_blank" class="option" />&nbsp;<?php echo esc_html( __( 'Insert a blank item as the first option?', 'wpcf7' ) ); ?>
</td>
</tr>
</table>
 
<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="select" class="tag" readonly="readonly" onfocus="this.select()" /></div>
 
<div class="tg-mail-tag"><?php echo esc_html( __( "And, put this code into the Mail fields below.", 'wpcf7' ) ); ?><br /><span class="arrow">&#11015;</span>&nbsp;<input type="text" class="mail-tag" readonly="readonly" onfocus="this.select()" /></div>
</form>
</div>
<?php
}
 
?>