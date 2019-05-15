<?php

function vh_get_country_by_country_code($country_code)
{
    $countries = vh_get_country_list();

    $country = vh_search_country($countries, 'country_code', $country_code);

    return $country;
}
//---------------------------------------------------
function vh_get_country_by_country_name($country_name)
{
    $countries = vh_get_country_list();

    $country = vh_search_country($countries, 'name', $country_name);

    return $country;
}
//---------------------------------------------------
function vh_get_country_by_calling_code($calling_code)
{
    $countries = vh_get_country_list();

    $country = vh_search_country($countries, 'calling_code', $calling_code);

    return $country;
}
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
function vh_search_country($array, $key_name, $value)
{
    foreach($array as $key => $array_item)
    {
        if ( $array_item[$key_name] === $value )
            return $array[$key];
    }

    return false;
}
//---------------------------------------------------
function vh_get_country_list_select_options($show='country_name')
{
    $html = "";
    $list = vh_get_country_list();

    $html .= '<option value="">Select</option>';

    foreach ($list as $item)
    {
        if($show == 'country_name')
        {
            $html .= '<option value="'.$item['code'].'">'.$item['name'].'</option>';
        } else if($show == 'country_code')
        {
            $html .= '<option value="'.$item['code'].'">'.$item['code'].'</option>';
        }else if($show == 'calling_code')
        {
            $html .= '<option value="'.$item['calling_code'].'">'.$item['calling_code'].'</option>';
        }
    }

    return $html;
}
//---------------------------------------------------

//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------

function vh_get_country_list()
{

    $countries = [];
    $countries[] = array("code" => "IN", "name" => "India", "calling_code" => "+91");
    $countries[] = array("code" => "US", "name" => "United States", "calling_code" => "+1");

    $countries[] = array("code" => "AF", "name" => "Afghanistan", "calling_code" => "+93");
    $countries[] = array("code" => "AL", "name" => "Albania", "calling_code" => "+355");
    $countries[] = array("code" => "DZ", "name" => "Algeria", "calling_code" => "+213");
    $countries[] = array("code" => "AS", "name" => "American Samoa", "calling_code" => "+1");
    $countries[] = array("code" => "AD", "name" => "Andorra", "calling_code" => "+376");
    $countries[] = array("code" => "AO", "name" => "Angola", "calling_code" => "+244");
    $countries[] = array("code" => "AI", "name" => "Anguilla", "calling_code" => "+1");
    $countries[] = array("code" => "AG", "name" => "Antigua", "calling_code" => "+1");
    $countries[] = array("code" => "AR", "name" => "Argentina", "calling_code" => "+54");
    $countries[] = array("code" => "AM", "name" => "Armenia", "calling_code" => "+374");
    $countries[] = array("code" => "AW", "name" => "Aruba", "calling_code" => "+297");
    $countries[] = array("code" => "AU", "name" => "Australia", "calling_code" => "+61");
    $countries[] = array("code" => "AT", "name" => "Austria", "calling_code" => "+43");
    $countries[] = array("code" => "AZ", "name" => "Azerbaijan", "calling_code" => "+994");
    $countries[] = array("code" => "BH", "name" => "Bahrain", "calling_code" => "+973");
    $countries[] = array("code" => "BD", "name" => "Bangladesh", "calling_code" => "+880");
    $countries[] = array("code" => "BB", "name" => "Barbados", "calling_code" => "+1");
    $countries[] = array("code" => "BY", "name" => "Belarus", "calling_code" => "+375");
    $countries[] = array("code" => "BE", "name" => "Belgium", "calling_code" => "+32");
    $countries[] = array("code" => "BZ", "name" => "Belize", "calling_code" => "+501");
    $countries[] = array("code" => "BJ", "name" => "Benin", "calling_code" => "+229");
    $countries[] = array("code" => "BM", "name" => "Bermuda", "calling_code" => "+1");
    $countries[] = array("code" => "BT", "name" => "Bhutan", "calling_code" => "+975");
    $countries[] = array("code" => "BO", "name" => "Bolivia", "calling_code" => "+591");
    $countries[] = array("code" => "BA", "name" => "Bosnia and Herzegovina", "calling_code" => "+387");
    $countries[] = array("code" => "BW", "name" => "Botswana", "calling_code" => "+267");
    $countries[] = array("code" => "BR", "name" => "Brazil", "calling_code" => "+55");
    $countries[] = array("code" => "IO", "name" => "British Indian Ocean Territory", "calling_code" => "+246");
    $countries[] = array("code" => "VG", "name" => "British Virgin Islands", "calling_code" => "+1");
    $countries[] = array("code" => "BN", "name" => "Brunei", "calling_code" => "+673");
    $countries[] = array("code" => "BG", "name" => "Bulgaria", "calling_code" => "+359");
    $countries[] = array("code" => "BF", "name" => "Burkina Faso", "calling_code" => "+226");
    $countries[] = array("code" => "MM", "name" => "Burma Myanmar", "calling_code" => "+95");
    $countries[] = array("code" => "BI", "name" => "Burundi", "calling_code" => "+257");
    $countries[] = array("code" => "KH", "name" => "Cambodia", "calling_code" => "+855");
    $countries[] = array("code" => "CM", "name" => "Cameroon", "calling_code" => "+237");
    $countries[] = array("code" => "CA", "name" => "Canada", "calling_code" => "+1");
    $countries[] = array("code" => "CV", "name" => "Cape Verde", "calling_code" => "+238");
    $countries[] = array("code" => "KY", "name" => "Cayman Islands", "calling_code" => "+1");
    $countries[] = array("code" => "CF", "name" => "Central African Republic", "calling_code" => "+236");
    $countries[] = array("code" => "TD", "name" => "Chad", "calling_code" => "+235");
    $countries[] = array("code" => "CL", "name" => "Chile", "calling_code" => "+56");
    $countries[] = array("code" => "CN", "name" => "China", "calling_code" => "+86");
    $countries[] = array("code" => "CO", "name" => "Colombia", "calling_code" => "+57");
    $countries[] = array("code" => "KM", "name" => "Comoros", "calling_code" => "+269");
    $countries[] = array("code" => "CK", "name" => "Cook Islands", "calling_code" => "+682");
    $countries[] = array("code" => "CR", "name" => "Costa Rica", "calling_code" => "+506");
    $countries[] = array("code" => "CI", "name" => "Côte d'Ivoire", "calling_code" => "+225");
    $countries[] = array("code" => "HR", "name" => "Croatia", "calling_code" => "+385");
    $countries[] = array("code" => "CU", "name" => "Cuba", "calling_code" => "+53");
    $countries[] = array("code" => "CY", "name" => "Cyprus", "calling_code" => "+357");
    $countries[] = array("code" => "CZ", "name" => "Czech Republic", "calling_code" => "+420");
    $countries[] = array("code" => "CD", "name" => "Democratic Republic of Congo", "calling_code" => "+243");
    $countries[] = array("code" => "DK", "name" => "Denmark", "calling_code" => "+45");
    $countries[] = array("code" => "DJ", "name" => "Djibouti", "calling_code" => "+253");
    $countries[] = array("code" => "DM", "name" => "Dominica", "calling_code" => "+1");
    $countries[] = array("code" => "DO", "name" => "Dominican Republic", "calling_code" => "+1");
    $countries[] = array("code" => "EC", "name" => "Ecuador", "calling_code" => "+593");
    $countries[] = array("code" => "EG", "name" => "Egypt", "calling_code" => "+20");
    $countries[] = array("code" => "SV", "name" => "El Salvador", "calling_code" => "+503");
    $countries[] = array("code" => "GQ", "name" => "Equatorial Guinea", "calling_code" => "+240");
    $countries[] = array("code" => "ER", "name" => "Eritrea", "calling_code" => "+291");
    $countries[] = array("code" => "EE", "name" => "Estonia", "calling_code" => "+372");
    $countries[] = array("code" => "ET", "name" => "Ethiopia", "calling_code" => "+251");
    $countries[] = array("code" => "FK", "name" => "Falkland Islands", "calling_code" => "+500");
    $countries[] = array("code" => "FO", "name" => "Faroe Islands", "calling_code" => "+298");
    $countries[] = array("code" => "FM", "name" => "Federated States of Micronesia", "calling_code" => "+691");
    $countries[] = array("code" => "FJ", "name" => "Fiji", "calling_code" => "+679");
    $countries[] = array("code" => "FI", "name" => "Finland", "calling_code" => "+358");
    $countries[] = array("code" => "FR", "name" => "France", "calling_code" => "+33");
    $countries[] = array("code" => "GF", "name" => "French Guiana", "calling_code" => "+594");
    $countries[] = array("code" => "PF", "name" => "French Polynesia", "calling_code" => "+689");
    $countries[] = array("code" => "GA", "name" => "Gabon", "calling_code" => "+241");
    $countries[] = array("code" => "GE", "name" => "Georgia", "calling_code" => "+995");
    $countries[] = array("code" => "DE", "name" => "Germany", "calling_code" => "+49");
    $countries[] = array("code" => "GH", "name" => "Ghana", "calling_code" => "+233");
    $countries[] = array("code" => "GI", "name" => "Gibraltar", "calling_code" => "+350");
    $countries[] = array("code" => "GR", "name" => "Greece", "calling_code" => "+30");
    $countries[] = array("code" => "GL", "name" => "Greenland", "calling_code" => "+299");
    $countries[] = array("code" => "GD", "name" => "Grenada", "calling_code" => "+1");
    $countries[] = array("code" => "GP", "name" => "Guadeloupe", "calling_code" => "+590");
    $countries[] = array("code" => "GU", "name" => "Guam", "calling_code" => "+1");
    $countries[] = array("code" => "GT", "name" => "Guatemala", "calling_code" => "+502");
    $countries[] = array("code" => "GN", "name" => "Guinea", "calling_code" => "+224");
    $countries[] = array("code" => "GW", "name" => "Guinea-Bissau", "calling_code" => "+245");
    $countries[] = array("code" => "GY", "name" => "Guyana", "calling_code" => "+592");
    $countries[] = array("code" => "HT", "name" => "Haiti", "calling_code" => "+509");
    $countries[] = array("code" => "HN", "name" => "Honduras", "calling_code" => "+504");
    $countries[] = array("code" => "HK", "name" => "Hong Kong", "calling_code" => "+852");
    $countries[] = array("code" => "HU", "name" => "Hungary", "calling_code" => "+36");
    $countries[] = array("code" => "IS", "name" => "Iceland", "calling_code" => "+354");

    $countries[] = array("code" => "ID", "name" => "Indonesia", "calling_code" => "+62");
    $countries[] = array("code" => "IR", "name" => "Iran", "calling_code" => "+98");
    $countries[] = array("code" => "IQ", "name" => "Iraq", "calling_code" => "+964");
    $countries[] = array("code" => "IE", "name" => "Ireland", "calling_code" => "+353");
    $countries[] = array("code" => "IL", "name" => "Israel", "calling_code" => "+972");
    $countries[] = array("code" => "IT", "name" => "Italy", "calling_code" => "+39");
    $countries[] = array("code" => "JM", "name" => "Jamaica", "calling_code" => "+1");
    $countries[] = array("code" => "JP", "name" => "Japan", "calling_code" => "+81");
    $countries[] = array("code" => "JO", "name" => "Jordan", "calling_code" => "+962");
    $countries[] = array("code" => "KZ", "name" => "Kazakhstan", "calling_code" => "+7");
    $countries[] = array("code" => "KE", "name" => "Kenya", "calling_code" => "+254");
    $countries[] = array("code" => "KI", "name" => "Kiribati", "calling_code" => "+686");
    $countries[] = array("code" => "XK", "name" => "Kosovo", "calling_code" => "+381");
    $countries[] = array("code" => "KW", "name" => "Kuwait", "calling_code" => "+965");
    $countries[] = array("code" => "KG", "name" => "Kyrgyzstan", "calling_code" => "+996");
    $countries[] = array("code" => "LA", "name" => "Laos", "calling_code" => "+856");
    $countries[] = array("code" => "LV", "name" => "Latvia", "calling_code" => "+371");
    $countries[] = array("code" => "LB", "name" => "Lebanon", "calling_code" => "+961");
    $countries[] = array("code" => "LS", "name" => "Lesotho", "calling_code" => "+266");
    $countries[] = array("code" => "LR", "name" => "Liberia", "calling_code" => "+231");
    $countries[] = array("code" => "LY", "name" => "Libya", "calling_code" => "+218");
    $countries[] = array("code" => "LI", "name" => "Liechtenstein", "calling_code" => "+423");
    $countries[] = array("code" => "LT", "name" => "Lithuania", "calling_code" => "+370");
    $countries[] = array("code" => "LU", "name" => "Luxembourg", "calling_code" => "+352");
    $countries[] = array("code" => "MO", "name" => "Macau", "calling_code" => "+853");
    $countries[] = array("code" => "MK", "name" => "Macedonia", "calling_code" => "+389");
    $countries[] = array("code" => "MG", "name" => "Madagascar", "calling_code" => "+261");
    $countries[] = array("code" => "MW", "name" => "Malawi", "calling_code" => "+265");
    $countries[] = array("code" => "MY", "name" => "Malaysia", "calling_code" => "+60");
    $countries[] = array("code" => "MV", "name" => "Maldives", "calling_code" => "+960");
    $countries[] = array("code" => "ML", "name" => "Mali", "calling_code" => "+223");
    $countries[] = array("code" => "MT", "name" => "Malta", "calling_code" => "+356");
    $countries[] = array("code" => "MH", "name" => "Marshall Islands", "calling_code" => "+692");
    $countries[] = array("code" => "MQ", "name" => "Martinique", "calling_code" => "+596");
    $countries[] = array("code" => "MR", "name" => "Mauritania", "calling_code" => "+222");
    $countries[] = array("code" => "MU", "name" => "Mauritius", "calling_code" => "+230");
    $countries[] = array("code" => "YT", "name" => "Mayotte", "calling_code" => "+262");
    $countries[] = array("code" => "MX", "name" => "Mexico", "calling_code" => "+52");
    $countries[] = array("code" => "MD", "name" => "Moldova", "calling_code" => "+373");
    $countries[] = array("code" => "MC", "name" => "Monaco", "calling_code" => "+377");
    $countries[] = array("code" => "MN", "name" => "Mongolia", "calling_code" => "+976");
    $countries[] = array("code" => "ME", "name" => "Montenegro", "calling_code" => "+382");
    $countries[] = array("code" => "MS", "name" => "Montserrat", "calling_code" => "+1");
    $countries[] = array("code" => "MA", "name" => "Morocco", "calling_code" => "+212");
    $countries[] = array("code" => "MZ", "name" => "Mozambique", "calling_code" => "+258");
    $countries[] = array("code" => "NA", "name" => "Namibia", "calling_code" => "+264");
    $countries[] = array("code" => "NR", "name" => "Nauru", "calling_code" => "+674");
    $countries[] = array("code" => "NP", "name" => "Nepal", "calling_code" => "+977");
    $countries[] = array("code" => "NL", "name" => "Netherlands", "calling_code" => "+31");
    $countries[] = array("code" => "AN", "name" => "Netherlands Antilles", "calling_code" => "+599");
    $countries[] = array("code" => "NC", "name" => "New Caledonia", "calling_code" => "+687");
    $countries[] = array("code" => "NZ", "name" => "New Zealand", "calling_code" => "+64");
    $countries[] = array("code" => "NI", "name" => "Nicaragua", "calling_code" => "+505");
    $countries[] = array("code" => "NE", "name" => "Niger", "calling_code" => "+227");
    $countries[] = array("code" => "NG", "name" => "Nigeria", "calling_code" => "+234");
    $countries[] = array("code" => "NU", "name" => "Niue", "calling_code" => "+683");
    $countries[] = array("code" => "NF", "name" => "Norfolk Island", "calling_code" => "+672");
    $countries[] = array("code" => "KP", "name" => "North Korea", "calling_code" => "+850");
    $countries[] = array("code" => "MP", "name" => "Northern Mariana Islands", "calling_code" => "+1");
    $countries[] = array("code" => "NO", "name" => "Norway", "calling_code" => "+47");
    $countries[] = array("code" => "OM", "name" => "Oman", "calling_code" => "+968");
    $countries[] = array("code" => "PK", "name" => "Pakistan", "calling_code" => "+92");
    $countries[] = array("code" => "PW", "name" => "Palau", "calling_code" => "+680");
    $countries[] = array("code" => "PS", "name" => "Palestine", "calling_code" => "+970");
    $countries[] = array("code" => "PA", "name" => "Panama", "calling_code" => "+507");
    $countries[] = array("code" => "PG", "name" => "Papua New Guinea", "calling_code" => "+675");
    $countries[] = array("code" => "PY", "name" => "Paraguay", "calling_code" => "+595");
    $countries[] = array("code" => "PE", "name" => "Peru", "calling_code" => "+51");
    $countries[] = array("code" => "PH", "name" => "Philippines", "calling_code" => "+63");
    $countries[] = array("code" => "PL", "name" => "Poland", "calling_code" => "+48");
    $countries[] = array("code" => "PT", "name" => "Portugal", "calling_code" => "+351");
    $countries[] = array("code" => "PR", "name" => "Puerto Rico", "calling_code" => "+1");
    $countries[] = array("code" => "QA", "name" => "Qatar", "calling_code" => "+974");
    $countries[] = array("code" => "CG", "name" => "Republic of the Congo", "calling_code" => "+242");
    $countries[] = array("code" => "RE", "name" => "Réunion", "calling_code" => "+262");
    $countries[] = array("code" => "RO", "name" => "Romania", "calling_code" => "+40");
    $countries[] = array("code" => "RU", "name" => "Russia", "calling_code" => "+7");
    $countries[] = array("code" => "RW", "name" => "Rwanda", "calling_code" => "+250");
    $countries[] = array("code" => "BL", "name" => "Saint Barthélemy", "calling_code" => "+590");
    $countries[] = array("code" => "SH", "name" => "Saint Helena", "calling_code" => "+290");
    $countries[] = array("code" => "KN", "name" => "Saint Kitts and Nevis", "calling_code" => "+1");
    $countries[] = array("code" => "MF", "name" => "Saint Martin", "calling_code" => "+590");
    $countries[] = array("code" => "PM", "name" => "Saint Pierre and Miquelon", "calling_code" => "+508");
    $countries[] = array("code" => "VC", "name" => "Saint Vincent and the Grenadines", "calling_code" => "+1");
    $countries[] = array("code" => "WS", "name" => "Samoa", "calling_code" => "+685");
    $countries[] = array("code" => "SM", "name" => "San Marino", "calling_code" => "+378");
    $countries[] = array("code" => "ST", "name" => "São Tomé and Príncipe", "calling_code" => "+239");
    $countries[] = array("code" => "SA", "name" => "Saudi Arabia", "calling_code" => "+966");
    $countries[] = array("code" => "SN", "name" => "Senegal", "calling_code" => "+221");
    $countries[] = array("code" => "RS", "name" => "Serbia", "calling_code" => "+381");
    $countries[] = array("code" => "SC", "name" => "Seychelles", "calling_code" => "+248");
    $countries[] = array("code" => "SL", "name" => "Sierra Leone", "calling_code" => "+232");
    $countries[] = array("code" => "SG", "name" => "Singapore", "calling_code" => "+65");
    $countries[] = array("code" => "SK", "name" => "Slovakia", "calling_code" => "+421");
    $countries[] = array("code" => "SI", "name" => "Slovenia", "calling_code" => "+386");
    $countries[] = array("code" => "SB", "name" => "Solomon Islands", "calling_code" => "+677");
    $countries[] = array("code" => "SO", "name" => "Somalia", "calling_code" => "+252");
    $countries[] = array("code" => "ZA", "name" => "South Africa", "calling_code" => "+27");
    $countries[] = array("code" => "KR", "name" => "South Korea", "calling_code" => "+82");
    $countries[] = array("code" => "ES", "name" => "Spain", "calling_code" => "+34");
    $countries[] = array("code" => "LK", "name" => "Sri Lanka", "calling_code" => "+94");
    $countries[] = array("code" => "LC", "name" => "St. Lucia", "calling_code" => "+1");
    $countries[] = array("code" => "SD", "name" => "Sudan", "calling_code" => "+249");
    $countries[] = array("code" => "SR", "name" => "Suriname", "calling_code" => "+597");
    $countries[] = array("code" => "SZ", "name" => "Swaziland", "calling_code" => "+268");
    $countries[] = array("code" => "SE", "name" => "Sweden", "calling_code" => "+46");
    $countries[] = array("code" => "CH", "name" => "Switzerland", "calling_code" => "+41");
    $countries[] = array("code" => "SY", "name" => "Syria", "calling_code" => "+963");
    $countries[] = array("code" => "TW", "name" => "Taiwan", "calling_code" => "+886");
    $countries[] = array("code" => "TJ", "name" => "Tajikistan", "calling_code" => "+992");
    $countries[] = array("code" => "TZ", "name" => "Tanzania", "calling_code" => "+255");
    $countries[] = array("code" => "TH", "name" => "Thailand", "calling_code" => "+66");
    $countries[] = array("code" => "BS", "name" => "The Bahamas", "calling_code" => "+1");
    $countries[] = array("code" => "GM", "name" => "The Gambia", "calling_code" => "+220");
    $countries[] = array("code" => "TL", "name" => "Timor-Leste", "calling_code" => "+670");
    $countries[] = array("code" => "TG", "name" => "Togo", "calling_code" => "+228");
    $countries[] = array("code" => "TK", "name" => "Tokelau", "calling_code" => "+690");
    $countries[] = array("code" => "TO", "name" => "Tonga", "calling_code" => "+676");
    $countries[] = array("code" => "TT", "name" => "Trinidad and Tobago", "calling_code" => "+1");
    $countries[] = array("code" => "TN", "name" => "Tunisia", "calling_code" => "+216");
    $countries[] = array("code" => "TR", "name" => "Turkey", "calling_code" => "+90");
    $countries[] = array("code" => "TM", "name" => "Turkmenistan", "calling_code" => "+993");
    $countries[] = array("code" => "TC", "name" => "Turks and Caicos Islands", "calling_code" => "+1");
    $countries[] = array("code" => "TV", "name" => "Tuvalu", "calling_code" => "+688");
    $countries[] = array("code" => "UG", "name" => "Uganda", "calling_code" => "+256");
    $countries[] = array("code" => "UA", "name" => "Ukraine", "calling_code" => "+380");
    $countries[] = array("code" => "AE", "name" => "United Arab Emirates", "calling_code" => "+971");
    $countries[] = array("code" => "GB", "name" => "United Kingdom", "calling_code" => "+44");

    $countries[] = array("code" => "UY", "name" => "Uruguay", "calling_code" => "+598");
    $countries[] = array("code" => "VI", "name" => "US Virgin Islands", "calling_code" => "+1");
    $countries[] = array("code" => "UZ", "name" => "Uzbekistan", "calling_code" => "+998");
    $countries[] = array("code" => "VU", "name" => "Vanuatu", "calling_code" => "+678");
    $countries[] = array("code" => "VA", "name" => "Vatican City", "calling_code" => "+39");
    $countries[] = array("code" => "VE", "name" => "Venezuela", "calling_code" => "+58");
    $countries[] = array("code" => "VN", "name" => "Vietnam", "calling_code" => "+84");
    $countries[] = array("code" => "WF", "name" => "Wallis and Futuna", "calling_code" => "+681");
    $countries[] = array("code" => "YE", "name" => "Yemen", "calling_code" => "+967");
    $countries[] = array("code" => "ZM", "name" => "Zambia", "calling_code" => "+260");
    $countries[] = array("code" => "ZW", "name" => "Zimbabwe", "calling_code" => "+263");

    return $countries;
}