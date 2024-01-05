<?php
//class MY_master{
	function getMaster()
	{
		return $arrCommon = array(

			//'email_from' => 'helpdesk@codsindia.com',
			'email_from' => 'helpdesk@thedigestive.in',

			'email_from_name' => 'HELPDESK',

			'email_thankyou'=>'	Thank you.<br><br>						
						 ',
			'email_bestregards'=>'Best Regards<br>
						Team Cods<br>',
			'email_communication'=>'Please allow at least 24 hours for us to respond to your specific querries by email or telephonic communication.<br><br>',

			'searchParameters'=> array(""=>"Select parameter","datefromto"=>"Date","patient id"=>"Patient id","first name"=>"First name","middle name"=>"Middle name","last name"=>"Last name","full name"=>"Full name","email"=>"Email","mobile"=>"Mobile"),
			//'globalSearchParams'=> array(""=>"Select parameter","datefromto"=>"Date","first name"=>"First name","middle name"=>"Middle name","last name"=>"Last name","full name"=>"Full name","email"=>"Email","mobile"=>"Mobile"),
			'globalSearchParams'=> array(""=>"Select parameter","name"=>"Name","email"=>"Email","mobile"=>"Mobile"),

			'enquirysearch'=> array(""=>"Select parameter","datefromto"=>"Date","name"=>"Name","email"=>"Email","mobile"=>"Mobile"),

			'per_page' => '30',

			'product_sizes' => array(
				array("width"=> 44 , "height"=> 54) ,
				array("width"=> 90 , "height"=> 110) ,
				array("width"=> 187 , "height"=> 194) ,
				array("width"=> 229 , "height"=> 238) ,
				array("width"=> 269 , "height"=> 331 ),

			),
			'client_response' => array(
				"" => "Select Client Response",
				"not_applicable " => "Not Applicable",
				"not_intrested" => "Not Interested",
				"wrong_number" => "Wrong Number",
			),
			'lead_type' => array(
				"" => "Select Lead Type",
				"hot " => "Hot",
				"warm" => "Warm",
				"cold" => "Cold",
			),
			'stage' => array(
				"" => "Select stage",
				"followup" => "Followup",
				"close" => "Close",
			),
			'search_stage' => array(
				"" => "Select stage",
				"entry" => "New",
				"followup" => "Followup",
				"appointment" => "Appointment",
				"walkin" => "Walkin",
				"prospect_appointment" => "Prospect appointment",
				"prospect_walkin" => "Prospect walkin",
				"patient" => "Patient",
				"close" => "Close",
			),
			'communication_mode' => array(
				"" => "Select Communication",
				"call" => "Call",
				"skype" => "Skype",
				"email" => "Email",
			),
			'area_mumbai' => array(
				"" => "Select Area",
				"South Mumbai" => "South Mumbai",
				"Central Mumbai" => "Central Mumbai",
				"Western Mumbai" => "Western Mumbai",
			),
			'payment_mode' => array(
				''=>'Select payment mode',
				'cash' => 'Cash',
				'cheque' => 'Cheque',
				'demand_draft' => 'Demand draft',
				'credit_debit_card' => 'Credit or Debit card',
				'NEFT' => 'NEFT',
				'RTGS' => 'RTGS',
			),
			'appointment_type' => array(
				'nutrition' => array(
					''=>'Select appointment type',
					'appointment' => 'Appointment',
					'prospect_appointment' => 'Prospect appointment',
				),
				'marketing' => array(
					''=>'Select appointment type',
					'BS Prospect' => 'BS Prospect',
					'BS Prospect follow up' => 'BS follow up',
					'GS Prospect' => 'GS Prospect',
					'GS Prospect follow up' => 'GS follow up',
					'7 days' => '7 days',
					'1 month' => '1 month',
					'3 months' => '3 months',
					'6 months' => '6 months',
					'1 year' => '1 year',
					'1 year plus' => '1 year plus',
					'9 month' => '9 month',
					'BS patient overseas' => 'BS patient overseas',
					'Band Adjustment' => 'Band Adjustment',
					'Diet consultation' => 'Diet consultation',
					'Diet package' => 'Diet package',
					'Patient follow up' => 'Patient follow up',
					'Psychology' => 'Psychology',
					'Skype BS Prospect' => 'Skype BS Prospect',
					'Skype follow up' => 'Skype follow up',
					'Weight LOSS' => 'Weight LOSS',
				),
			),
			'appointment_with' => array('' => 'Select appointment with',
				'Surgeon' => 'Surgeon',
				'Nutritionist' => 'Nutritionist',
				'Fitness trainer' => 'Fitness trainer',
			),
			'doctors_specialisation' => array('Surgeon' => 'Surgeon',
				'Nutritionist' => 'Nutritionist',
				'Fitness trainer' => 'Fitness trainer',
			),
			'boolean' => array(
				"" => "Select",
				"Yes" => "Yes",
				"No" => "NO"
			),
			'rooms' => array(''=>'Select room', '1'=>'Classic', '2' => 'Premium', '3'=>'Single first class', '4' => 'Deluxe with pantry', '5' =>'Suite', '6' => 'Royal suite','7' => 'General', '8' => 'Not applicable'),
			'opd' => array(''=>'Select OPD', 'gamdevi'=>'Gamdevi', 'malad'=>'Malad'),
			'opd_search' => array(''=>'Select OPD', 'gamdevi'=>'Mumbai(Gamdevi)', 'malad'=>'Mumbai(Malad)'),
			'appointment_cities' => array(
				"" => "Select Citiy",
				"mumbai" => "Mumbai",
				"surat" => "Surat",
				"raipur" => "Raipur",
				"vadodara" => "Vadodara",
				"dubai" => "Dubai",
				"nagpur" => "Nagpur",
			),

			'selectgender' => array(''=>'Select Gender','Male' => 'Male', 'Female' => 'Female'),

			'selectstatus' => array(''=>'Select Status','active' => 'Active', 'Inactive' => 'Inactive'),
			'accountstatus' => array(''=>'Select Status','1' => 'Active', '0' => 'Inactive'),

			'maritalstatus' => array(''=>'Select Marital Status','Married' => 'Married', 'Un Married' => 'Un Married'),

			'agelist' => array("" => "Select Age")+array_combine(range(1,80),range(1,80)),

			'time' => array("" => "Select time",
				"00:00:00" => "00:00 AM",
				"00:30:00" => "00:30 AM",
				"01:00:00" => "01:00 AM",
				"01:30:00" => "01:30 AM",
				"02:00:00" => "02:00 AM",
				"02:30:00" => "02:30 AM",
				"03:00:00" => "03:00 AM",
				"03:30:00" => "03:30 AM",
				"04:00:00" => "04:00 AM",
				"04:30:00" => "04:30 AM",
				"05:00:00" => "05:00 AM",
				"05:30:00" => "05:30 AM",
				"06:00:00" => "06:00 AM",
				"06:30:00" => "06:30 AM",
				"07:00:00" => "07:00 AM",
				"07:30:00" => "07:30 AM",
				"08:00:00" => "08:00 AM",
				"08:30:00" => "08:30 AM",
				"09:00:00" => "09:00 AM",
				"09:30:00" => "09:30 AM",
				"10:00:00" => "10:00 AM",
				"10:30:00" => "10:30 AM",
				"11:00:00" => "11:00 AM",
				"11:30:00" => "11:30 AM",
				"12:00:00" => "12:00 PM",
				"12:30:00" => "12:30 PM",
				"13:00:00" => "01:00 PM",
				"13:30:00" => "01:30 PM",
				"14:00:00" => "02:00 PM",
				"14:30:00" => "02:30 PM",
				"15:00:00" => "03:00 PM",
				"15:30:00" => "03:30 PM",
				"16:00:00" => "04:00 PM",
				"16:30:00" => "04:30 PM",
				"17:00:00" => "05:00 PM",
				"17:30:00" => "05:30 PM",
				"18:00:00" => "06:00 PM",
				"18:30:00" => "06:30 PM",
				"19:00:00" => "07:00 PM",
				"19:30:00" => "07:30 PM",
				"20:00:00" => "08:00 PM",
				"20:30:00" => "08:30 PM",
				"21:00:00" => "09:00 PM",
				"21:30:00" => "09:30 PM",
				"22:00:00" => "10:00 PM",
				"22:30:00" => "10:30 PM",
				"23:00:00" => "11:00 PM",
				"23:30:00" => "11:30 PM",
			),
			'working_hours' => array("" => "Select time",
				"09:00:00" => "09:00 AM",
				"09:30:00" => "09:30 AM",
				"10:00:00" => "10:00 AM",
				"10:30:00" => "10:30 AM",
				"11:00:00" => "11:00 AM",
				"11:30:00" => "11:30 AM",
				"12:00:00" => "12:00 PM",
				"12:30:00" => "12:30 PM",
				"13:00:00" => "01:00 PM",
				"13:30:00" => "01:30 PM",
				"14:00:00" => "02:00 PM",
				"14:30:00" => "02:30 PM",
				"15:00:00" => "03:00 PM",
				"15:30:00" => "03:30 PM",
				"16:00:00" => "04:00 PM",
				"16:30:00" => "04:30 PM",
				"17:00:00" => "05:00 PM",
				"17:30:00" => "05:30 PM",
				"18:00:00" => "06:00 PM",
				"18:30:00" => "06:30 PM",
				"19:00:00" => "07:00 PM",
				"19:30:00" => "07:30 PM",
				"20:00:00" => "08:00 PM",
			),

			'heightlist' => array(
				"" => "Select Height",
				"142"=>"142 cm",
				"144.5"=>"144.5 cm",
				"147"=>"147 cm",
				"150"=>"150 cm",
				"152.5"=>"152.5 cm",
				"155"=>"155 cm",
				"157.5"=>"157.5 cm",
				"160"=>"160 cm",
				"162.5"=>"162.5 cm",
				"165"=>"165 cm",
				"167.5"=>"167.5 cm",
				"170"=>"170 cm",
				"172.5"=>"172.5 cm",
				"175"=>"175 cm",
				"177.5"=>"177.5 cm",
				"180"=>"180 cm",
				"183"=>"183 cm",
				"185.5"=>"185.5 cm",
				"188"=>"188 cm",
				"190.5"=>"190.5 cm"
			),
			'countrylist' => array (
				""=>"Select Country",
				"India" => "India",
				"Albania" => "Albania" ,
				"Algeria" => "Algeria",
				"American Samoa" => "American Samoa",
				"Andorra" => "Andorra",
				"Angola" => "Angola",
				"Anguilla" => "Anguilla",
				"Antigua &amp; Barbuda" => "Antigua &amp; Barbuda",
				"Argentina" => "Argentina",
				"Armenia" => "Armenia",
				"Australia" => "Australia",
				"Austria" => "Austria",
				"Azerbaijan" => "Azerbaijan",
				"Bahamas" => "Bahamas",
				"Bahrain" => "Bahrain",
				"Bangladesh" => "Bangladesh",
				"Barbados" => "Barbados",
				"Belarus" => "Belarus",
				"Belgium" => "Belgium",
				"Belize" => "Belize",
				"Bermuda" => "Bermuda",
				"Bhutan" => "Bhutan",
				"Bolivia" => "Bolivia",
				"Bosnia and Herzegovina" => "Bosnia and Herzegovina",
				"Botswana" => "Botswana",
				"Brazil" => "Brazil",
				"Brunei" => "Brunei",
				"Bulgaria" => "Bulgaria",
				"Burkina Faso" => "Burkina Faso",
				"Burundi" => "Burundi",
				"Cambodia" => "Cambodia",
				"Cameroon" => "Cameroon",
				"Canada" => "Canada",
				"Cape Verde" => "Cape Verde",
				"Cayman Islands" => "Cayman Islands",
				"Central African Republic" => "Central African Republic",
				"Chad" => "Chad",
				"Chile" => "Chile",
				"China" => "China",
				"Colombia" => "Colombia",
				"Comoros" => "Comoros",
				"Congo (DRC)" => "Congo (DRC)",
				"Congo" => "Congo",
				"Cook Islands" => "Cook Islands",
				"Costa Rica" => "Costa Rica",
				"Cote d'Ivoire" => "Cote d'Ivoire",
				"Croatia (Hrvatska)" => "Croatia (Hrvatska)",
				"Cuba" => "Cuba",
				"Cyprus" => "Cyprus",
				"Czech Republic" => "Czech Republic",
				"Denmark" => "Denmark",
				"Djibouti" => "Djibouti",
				"Dominica" => "Dominica",
				"Dominican Republic" => "Dominican Republic",
				"East Timor" => "East Timor",
				"Ecuador" => "Ecuador",
				"Egypt" => "Egypt",
				"El Salvador" => "El Salvador",
				"Equatorial Guinea" => "Equatorial Guinea",
				"Eritrea" => "Eritrea",
				"Estonia" => "Estonia",
				"Ethiopia" => "Ethiopia",
				"Falkland Islands" => "Falkland Islands",
				"Faroe Islands" => "Faroe Islands",
				"Fiji Islands" => "Fiji Islands",
				"Finland" => "Finland",
				"France" => "France",
				"French Guiana" => "French Guiana",
				"French Polynesia" => "French Polynesia",
				"Gabon" => "Gabon",
				"Gambia" => "Gambia",
				"Georgia" => "Georgia",
				"Germany" => "Germany",
				"Ghana" => "Ghana",
				"Gibraltar" => "Gibraltar",
				"Greece" => "Greece",
				"Greenland" => "Greenland",
				"Grenada" => "Grenada",
				"Guadeloupe" => "Guadeloupe",
				"Guam" => "Guam",
				"Guatemala" => "Guatemala",
				"Guinea" => "Guinea",
				"Guinea-Bissau" => "Guinea-Bissau",
				"Guyana" => "Guyana",
				"Haiti" => "Haiti",
				"Honduras" => "Honduras",
				"Hong Kong SAR" => "Hong Kong SAR",
				"Hungary" => "Hungary",
				"Iceland" => "Iceland",
				"Indonesia" => "Indonesia",
				"Iran" => "Iran",
				"Iraq" => "Iraq",
				"Ireland" => "Ireland",
				"Israel" => "Israel",
				"Italy" => "Italy",
				"Jamaica" => "Jamaica",
				"Japan" => "Japan",
				"Jordan" => "Jordan",
				"Kazakhstan" => "Kazakhstan",
				"Kenya" => "Kenya",
				"Kiribati" => "Kiribati",
				"Kuwait" => "Kuwait",
				"Kyrgyzstan" => "Kyrgyzstan",
				"Laos" => "Laos",
				"Latvia" => "Latvia",
				"Lebanon" => "Lebanon",
				"Lesotho" => "Lesotho",
				"Liberia" => "Liberia",
				"Libya" => "Libya",
				"Liechtenstein" => "Liechtenstein",
				"Lithuania" => "Lithuania",
				"Luxembourg" => "Luxembourg",
				"Macao SAR" => "Macao SAR",
				"Macedonia" => "Macedonia",
				"Madagascar" => "Madagascar",
				"Malawi" => "Malawi",
				"Malaysia" => "Malaysia",
				"Maldives" => "Maldives",
				"Mali" => "Mali",
				"Malta" => "Malta",
				"Martinique" => "Martinique",
				"Mauritania" => "Mauritania",
				"Mauritius" => "Mauritius",
				"Mayotte" => "Mayotte",
				"Mexico" => "Mexico",
				"Micronesia" => "Micronesia",
				"Moldova" => "Moldova",
				"Monaco" => "Monaco",
				"Mongolia" => "Mongolia",
				"Montserrat" => "Montserrat",
				"Morocco" => "Morocco",
				"Mozambique" => "Mozambique",
				"Myanmar" => "Myanmar",
				"Namibia" => "Namibia",
				"Nauru" => "Nauru",
				"Nepal" => "Nepal",
				"Netherlands Antilles" => "Netherlands Antilles",
				"Netherlands" => "Netherlands",
				"New Caledonia" => "New Caledonia",
				"New Zealand" => "New Zealand",
				"Nicaragua" => "Nicaragua",
				"Niger" => "Niger",
				"Nigeria" => "Nigeria",
				"Niue" => "Niue",
				"Norfolk Island" => "Norfolk Island",
				"North Korea" => "North Korea",
				"Norway" => "Norway",
				"Oman" => "Oman",
				"Pakistan" => "Pakistan",
				"Panama" => "Panama",
				"Papua New Guinea" => "Papua New Guinea",
				"Paraguay" => "Paraguay",
				"Peru" => "Peru",
				"Philippines" => "Philippines",
				"Pitcairn Islands" => "Pitcairn Islands",
				"Poland" => "Poland",
				"Portugal" => "Portugal",
				"Puerto Rico" => "Puerto Rico",
				"Qatar" => "Qatar",
				"Reunion" => "Reunion",
				"Romania" => "Romania",
				"Russia" => "Russia",
				"Rwanda" => "Rwanda",
				"Samoa" => "Samoa",
				"San Marino" => "San Marino",
				"Sao Tome and Principe" => "Sao Tome and Principe",
				"Saudi Arabia" => "Saudi Arabia",
				"Senegal" => "Senegal",
				"Serbia and Montenegro" => "Serbia and Montenegro",
				"Seychelles" => "Seychelles",
				"Sierra Leone" => "Sierra Leone",
				"Singapore" => "Singapore",
				"Slovakia" => "Slovakia",
				"Slovenia" => "Slovenia",
				"Solomon Islands" => "Solomon Islands",
				"Somalia" => "Somalia",
				"South Africa" => "South Africa",
				"South Korea" => "South Korea",
				"Spain" => "Spain",
				"Sri Lanka" => "Sri Lanka",
				"St. Helena" => "St. Helena",
				"St. Kitts and Nevis" => "St. Kitts and Nevis",
				"St. Lucia" => "St. Lucia",
				"St. Pierre and Miquelon" => "St. Pierre and Miquelon",
				"St. Vincent &amp; Grenadines" => "St. Vincent &amp; Grenadines",
				"Sudan" => "Sudan",
				"Suriname" => "Suriname",
				"Swaziland" => "Swaziland",
				"Sweden" => "Sweden",
				"Switzerland" => "Switzerland",
				"Syria" => "Syria",
				"Taiwan" => "Taiwan",
				"Tajikistan" => "Tajikistan",
				"Tanzania" => "Tanzania",
				"Thailand" => "Thailand",
				"Togo" => "Togo",
				"Tokelau" => "Tokelau",
				"Tonga" => "Tonga",
				"Trinidad and Tobago" => "Trinidad and Tobago",
				"Tunisia" => "Tunisia",
				"Turkey" => "Turkey",
				"Turkmenistan" => "Turkmenistan",
				"Turks and Caicos Islands" => "Turks and Caicos Islands",
				"Tuvalu" => "Tuvalu",
				"Uganda" => "Uganda",
				"Ukraine" => "Ukraine",
				"United Arab Emirates" => "United Arab Emirates",
				"United Kingdom" => "United Kingdom",
				"Uruguay" => "Uruguay",
				"USA" => "USA",
				"Uzbekistan" => "Uzbekistan",
				"Vanuatu" => "Vanuatu",
				"Venezuela" => "Venezuela",
				"Vietnam" => "Vietnam",
				"Virgin Islands (British)" => "Virgin Islands (British)",
				"Virgin Islands" => "Virgin Islands",
				"Wallis and Futuna" => "Wallis and Futuna",
				"Yemen" => "Yemen",
				"Yugoslavia" => "Yugoslavia",
				"Zambia" => "Zambia",
				"Zimbabwe" => "Zimbabwe",
			),

			'stateslist' => array(
				""=>"State",
				"none" =>"None(Other than india)",
				"Andhra Pradesh"=>"Andhra Pradesh",
				"Arunachal Pradesh"=>"Arunachal Pradesh",
				"Assam"=>"Assam",
				"Bihar"=>"Bihar",
				"Chhattisgarh"=>"Chhattisgarh",
				"Goa"=>"Goa",
				"Gujarat"=>"Gujarat",
				"Haryana"=>"Haryana",
				"Himachal Pradesh"=>"Himachal Pradesh",
				"Jammu and Kashmir"=>"Jammu and Kashmir",
				"Jharkhand"=>"Jharkhand",
				"Karnataka"=>"Karnataka",
				"Kerala"=>"Kerala",
				"Madhya Pradesh"=>"Madhya Pradesh",
				"Maharashtra"=>"Maharashtra",
				"Manipur"=>"Manipur",
				"Meghalaya"=>"Meghalaya",
				"Mizoram"=>"Mizoram",
				"Nagaland"=>"Nagaland",
				"Odisha"=>"Odisha",
				"Punjab"=>"Punjab",
				"Rajasthan"=>"Rajasthan",
				"Sikkim"=>"Sikkim",
				"Tamil Nadu"=>"Tamil Nadu",
				"Telangana"=>"Telangana",
				"Tripura"=>"Tripura",
				"Uttar Pradesh"=>"Uttar Pradesh",
				"Uttarakhand"=>"Uttarakhand",
				"West Bengal"=>"West Bengal",
				"Andaman and Nicobar Islands"=>"Andaman and Nicobar Islands",
				"Chandigarh"=>"Chandigarh",
				"Dadra and Nagar Haveli"=>"Dadra and Nagar Haveli",
				"Daman and Diu"=>"Daman and Diu",
				"Lakshadweep"=>"Lakshadweep",
				"National Capital Territory"=>"National Capital Territory",
				"Puducherry"=>"Puducherry"
			),

			'citieslist' => array(
				"" => "Select City",
				"none" =>"None(Other than india)",
				"ABU DHABI" => "ABU DHABI",
				"ADEN" => "ADEN",
				"AGRA" => "AGRA",
				"AHEMDABAD" => "AHEMDABAD",
				"AHMEDNAGAR" =>	"AHMEDNAGAR",
				"AJMER" => "AJMER",
				"AKOLA" => "AKOLA",
				"AMBERNATH" =>	"AMBERNATH",
				"AMRAVATI" => "AMRAVATI",
				"AMRITSAR" => "AMRITSAR",
				"ANDHRA PRADESH" => "ANDHRA PRADESH",
				"ANKLESHWAR" =>	"ANKLESHWAR",
				"AUCKLAND" => "AUCKLAND",
				"AURAGABABAD" => "AURAGABABAD",
				"BAGHDAD" => "BAGHDAD",
				"BALTIMORE" =>	"BALTIMORE",
				"BANGALORE" =>	"BANGALORE",
				"BAREILLY" => "BAREILLY",
				"BARODA" => "BARODA",
				"BATHINDA" => "BATHINDA",
				"BEED" => "BEED",
				"BELGAUM"=>"BELGAUM",
				"BHARUCH" => "BHARUCH",
				"BHATINDA" => "BHATINDA",
				"BHAVNAGAR" => "BHAVNAGAR",
				"BHILAD" => "BHILAD",
				"BHOPAL" => "BHOPAL",
				"BIHAR" => "BIHAR",
				"BIKANER" => "BIKANER",
				"BILASPUR" => "BILASPUR",
				"BIRMINGHAM" =>	"BIRMINGHAM",
				"CAIRO" => "CAIRO",
				"CALCUTTA" => "CALCUTTA",
				"CALGARY, ALBERTA" => "CALGARY, ALBERTA",
				"CALIFORNIA" =>	"CALIFORNIA",
				"CHANDIGARH" =>	"CHANDIGARH",
				"CHANDRAPUR" =>	"CHANDRAPUR",
				"CHENNAI" => "CHENNAI",
				"DAHANU" => "DAHANU",
				"DAMAN" => "DAMAN",
				"DAR E SALAAM" => "DAR E SALAAM",
				"DELHI" => "DELHI",
				"DHAKA"=>"DHAKA",
				"DHULIA"=>"DHULIA",
				"DUBAI"=>"DUBAI",
				"FARIDABAD"=>"FARIDABAD",
				"GHAZIABAD"=>"GHAZIABAD",
				"GOA"=>"GOA",
				"GONDIA"=>"GONDIA",
				"GREATER NOIDA"=>"GREATER NOIDA",
				"GUJARAT" =>"GUJARAT",
				"GURGAON"=>"GURGAON",
				"GWALIOR"=>"GWALIOR",
				"HARYANA"=>"HARYANA",
				"HONG KONG"=>"HONG KONG",
				"HYDERABAD"=>"HYDERABAD",
				"INDORE"=>"INDORE",
				"JABALPUR"=>"JABALPUR",
				"JAIPUR"=>"JAIPUR",
				"JAKARTA TIMUR"=>"JAKARTA TIMUR",
				"JALGAON"=>"JALGAON",
				"JALNA"=>"JALNA",
				"JAMMU"=>"JAMMU",
				"JAMNAGAR"=>"JAMNAGAR",
				"JEDDAH"=>"JEDDAH",
				"JODHPUR"=>"JODHPUR",
				"KANPUR"=>"KANPUR",
				"KARACHI"=>"KARACHI",
				"KARNATAKA"=>"KARNATAKA",
				"KASHMIR"=>"KASHMIR",
				"KATHMANDU"=>"KATHMANDU",
				"KATRA"=>"KATRA",
				"KENYA"=>"KENYA",
				"KOLHAPUR"=>"KOLHAPUR",
				"KOLKATA"=>"KOLKATA",
				"KUTCH"=>"KUTCH",
				"KUWAIT"=>"KUWAIT",
				"LAGOS"=>"LAGOS",
				"LONAVALA"=>"LONAVALA",
				"LONDON"=>"LONDON",
				"LUCKNOW"=>"LUCKNOW",
				"LUDHIANA"=>"LUDHIANA",
				"MADAGASCAR"=>"MADAGASCAR",
				"MALEGAON"=>"MALEGAON",
				"MELBOURNE"=>"MELBOURNE",
				"MORADABAD"=>"MORADABAD",
				"MOZAMBIQUE"=>"MOZAMBIQUE",
				"MUMBAI"=>"MUMBAI",
				"MURADABAD"=>"MURADABAD",
				"MUSCUT"=>"MUSCUT",
				"MUZAFFALPUR"=>"MUZAFFALPUR",
				"MUZAFFARNAGAR"=>"MUZAFFARNAGAR",
				"MYSORE"=>"MYSORE",
				"NAGPUR"=>"NAGPUR",
				"NAIROBI"=>"NAIROBI",
				"NASIK"=>"NASIK",
				"NEW PANVEL"=>"NEW PANVEL",
				"NEW YORK"=>"NEW YORK",
				"NEWCASTLE"=>"NEWCASTLE",
				"NIGERIA"=>"NIGERIA",
				"NOIDA"=>"NOIDA",
				"OMAN"=>"OMAN",
				"ONTARIO"=>"ONTARIO",
				"PANJIM"=>"PANJIM",
				"PATNA"=>"PATNA",
				"PEN"=>"PEN",
				"PIMPRI"=>"PIMPRI",
				"PUNE"=>"PUNE",
				"PUNJAB"=>"PUNJAB",
				"RAIGAD"=>"RAIGAD",
				"RAIPUR"=>"RAIPUR",
				"RAJASTHAN"=>"RAJASTHAN",
				"RAJASTHAN"=>"RAJASTHAN",
				"RANCHI"=>"RANCHI",
				"RATLAM"=>"RATLAM",
				"RATNAGRI"=>"RATNAGRI",
				"RISHIKESH"=>"RISHIKESH",
				"ROHTAK"=>"ROHTAK",
				"RUWI"=>"RUWI",
				"SAN DIEGO"=>"SAN DIEGO",
				"SAN PAULO"=>"SAN PAULO",
				"SAWANTWADI"=>"SAWANTWADI",
				"SECUNDERABAD"=>"SECUNDERABAD",
				"SHARJAH"=>"SHARJAH",
				"SILVASSA"=>"SILVASSA",
				"SINAGAPORE"=>"SINAGAPORE",
				"SOLAPUR"=>"SOLAPUR",
				"SRILANKA"=>"SRILANKA",
				"SURAT"=>"SURAT",
				"TANZANIA"=>"TANZANIA",
				"THANE"=>"THANE",
				"TRIVENDRUM"=>"TRIVENDRUM",
				"UDAIPUR"=>"UDAIPUR",
				"ULHASNAGAR"=>"ULHASNAGAR",
				"UMBERGAON"=>"UMBERGAON",
				"VADODARA"=>"VADODARA",
				"VALSAD"=>"VALSAD",
				"VAPI"=>"VAPI",
				"VARANASI"=>"VARANASI",
				"VASAI"=>"VASAI",
				"VIJAYAWADA"=>"VIJAYAWADA",
				"VIRAR"=>"VIRAR",
				"VISAKHAPATNA"=>"VISAKHAPATNA",
				"VYARA"=>"VYARA",
				"YAVATMAL"=>"YAVATMAL",
				"OTHERS"=>"OTHERS"
			),



			'selectcountrycode' => array(""=>"Select", "Afghanistan" => "+93",
				"Albania" => "+355",
				"Algeria" => "+213",
				"American Samoa" => "+684",
				"Andorra" => "+376",
				"Angola" => "+244",
				"Anguilla" => "+1",
				"Antigua & Barbuda" => "+1",
				"Argentina" => "+54",
				"Armenia" => "+374",
				"Australia" => "+61",
				"Austria" => "+43",
				"Azerbaijan" => "+994",
				"Bahamas" => "+1" ,
				"Bahrain" => "+973" ,
				"Bangladesh" => "+880" ,
				"Barbados" => "+1" ,
				"Belarus" => "+375" ,
				"Belgium" => "+32" ,
				"Belize" => "+501" ,

				"Bermuda" => "+1" ,

				"Bhutan" => "+975" ,

				"Bolivia" => "+591" ,

				"Bosnia and Herzegovina" => "+387" ,

				"Botswana" => "+267" ,

				"Brazil" => "+55" ,

				"Virgin Islands (British)" => "+1" ,

				"Brunei" => "+673" ,

				"Bulgaria" => "+359" ,

				"Burkina Faso" => "+226" ,

				"Burundi" => "+257" ,

				"Cote d'Ivoire" => "+225" ,

				"Cambodia" => "+855" ,

				"Cameroon" => "+237" ,

				"Canada" => "+1" ,

				"Cape Verde" => "+238" ,

				"Cayman Islands" => "+1" ,

				"Central African Republic" => "+236" ,

				"Chad" => "+235" ,

				"Chile" => "+56" ,

				"China" => "+86" ,

				"Colombia" => "+57" ,

				"Comoros" => "+269" ,

				"Congo" => "+242" ,

				"Cook Islands" => "+682" ,

				"Costa Rica" => "+506" ,

				"Croatia (Hrvatska)" => "+385" ,

				"Cuba" => "+53" ,

				"Cyprus" => "+357" ,

				"Czech Republic" => "+420" ,

				"North Korea" => "+850" ,

				"Congo (DRC)" => "+243" ,

				"Denmark" => "+45" ,

				"Djibouti" => "+253" ,

				"Dominica" => "+1" ,

				"Dominican Republic" => "+1" ,

				"East Timor" => "+670" ,

				"Ecuador" => "+593" ,

				"Egypt" => "+20" ,

				"El Salvador" => "+503" ,

				"Equatorial Guinea" => "+240" ,

				"Eritrea" => "+291" ,

				"Estonia" => "+372" ,

				"Ethiopia" => "+251" ,

				"Falkland Islands" => "+500" ,

				"Faroe Islands" => "+298" ,

				"Fiji Islands" => "+679" ,

				"Finland" => "+358" ,

				"France" => "+33" ,

				"French Guiana" => "+594" ,

				"French Polynesia" => "+689" ,

				"Gabon" => "+241" ,

				"Gambia" => "+220" ,

				"Georgia" => "+995" ,

				"Germany" => "+49" ,

				"Ghana" => "+233" ,

				"Gibraltar" => "+350" ,

				"Greece" => "+30" ,

				"Greenland" => "+299" ,

				"Grenada" => "+1" ,

				"Guadeloupe" => "+590" ,

				"Guam" => "+1" ,

				"Guatemala" => "+502" ,

				"Guinea" => "+224" ,

				"Guinea-Bissau" => "+245" ,

				"Guyana" => "+592" ,

				"Haiti" => "+509" ,

				"Honduras" => "+504" ,

				"Hong Kong SAR" => "+852" ,

				"Hungary" => "+36" ,

				"Iceland" => "+354" ,

				"India" => "+91" ,

				"Indonesia" => "+62" ,

				"Iran" => "+98" ,

				"Iraq" => "+964" ,

				"Ireland" => "+353" ,

				"Israel" => "+972" ,

				"Italy" => "+39" ,

				"Jamaica" => "+1" ,

				"Japan" => "+81" ,

				"Jordan" => "+962" ,

				"Kazakhstan" => "+7" ,

				"Kenya" => "+254" ,

				"Kiribati" => "+686" ,

				"Korea" => "+82" ,

				"Kuwait" => "+965" ,

				"Kyrgyzstan" => "+996" ,

				"Laos" => "+856" ,

				"Latvia" => "+371" ,

				"Lebanon" => "+961" ,

				"Lesotho" => "+266" ,

				"Liberia" => "+231" ,

				"Libya" => "+218" ,

				"Liechtenstein" => "+423" ,

				"Lithuania" => "+370" ,

				"Luxembourg" => "+352" ,

				"Macao SAR" => "+853" ,

				"Madagascar" => "+261" ,

				"Malawi" => "+265" ,

				"Malaysia" => "+60" ,

				"Maldives" => "+960" ,

				"Mali" => "+223" ,

				"Malta" => "+356" ,

				"Martinique" => "+596" ,

				"Mauritania" => "+222" ,

				"Mauritius" => "+230" ,

				"Mayotte" => "+269" ,

				"Mexico" => "+52" ,

				"Micronesia" => "+691" ,

				"Moldova" => "+373" ,

				"Monaco" => "+377" ,

				"Mongolia" => "+976" ,

				"Montserrat" => "+1" ,

				"Morocco" => "+212" ,

				"Mozambique" => "+258" ,

				"Myanmar" => "+95" ,

				"Namibia" => "+264" ,

				"Nauru" => "+674" ,

				"Nepal" => "+977" ,

				"Netherlands" => "+31" ,

				"Netherlands Antilles" => "+599" ,

				"New Caledonia" => "+687" ,

				"New Zealand" => "+64" ,

				"Nicaragua" => "+505" ,

				"Niger" => "+227" ,

				"Nigeria" => "+234" ,

				"Niue" => "+683" ,

				"Norfolk Island" => "+672" ,

				"Norway" => "+47" ,

				"Oman" => "+968" ,

				"Pakistan" => "+92" ,

				"Panama" => "+507" ,

				"Papua New Guinea" => "+675" ,

				"Paraguay" => "+595" ,

				"Peru" => "+51" ,

				"Philippines" => "+63" ,

				"Pitcairn Islands" => "+672" ,

				"Poland" => "+48" ,

				"Portugal" => "+351" ,

				"Puerto Rico" => "+1" ,

				"Qatar" => "+974" ,

				"Reunion" => "+262" ,

				"Romania" => "+40" ,

				"Russia" => "+7" ,

				"Rwanda" => "+250" ,

				"St. Helena" => "+290" ,

				"St. Kitts and Nevis" => "+1" ,

				"St. Lucia" => "+1" ,

				"St. Pierre and Miquelon" => "+508" ,

				"St. Vincent & Grenadines" => "+1" ,

				"Samoa" => "+685" ,

				"San Marino" => "+378" ,

				"Sao Tome and Principe" => "+239" ,

				"Saudi Arabia" => "+966" ,

				"Senegal" => "+221" ,

				"Serbia and Montenegro" => "+381" ,

				"Seychelles" => "+248" ,

				"Sierra Leone" => "+232" ,

				"Singapore" => "+65" ,

				"Slovakia" => "+421" ,

				"Slovenia" => "+386" ,

				"Solomon Islands" => "+677" ,

				"Somalia" => "+252" ,

				"South Africa" => "+27" ,

				"Spain" => "+34" ,

				"Sri Lanka" => "+94" ,

				"Sudan" => "+249" ,

				"Suriname" => "+597" ,

				"Swaziland" => "+268" ,

				"Sweden" => "+46" ,

				"Switzerland" => "+41" ,

				"Syria" => "+963" ,

				"Taiwan" => "+886" ,

				"Tajikistan" => "+992" ,

				"Tanzania" => "+255" ,

				"Thailand" => "+66" ,

				"Macedonia" => "+389" ,

				"Togo" => "+228" ,

				"Tokelau" => "+690" ,

				"Tonga" => "+676" ,

				"Trinidad and Tobago" => "+1" ,

				"Tunisia" => "+216" ,

				"Turkey" => "+90" ,

				"Turkmenistan" => "+993" ,

				"Turks and Caicos Islands" => "+1" ,

				"Tuvalu" => "+688" ,

				"Uganda" => "+256" ,

				"Ukraine" => "+380" ,

				"United Arab Emirates" => "+971" ,

				"United Kingdom" => "+44" ,

				"Virgin Islands" => "+1" ,

				"Uruguay" => "+598" ,

				"USA" => "+1" ,

				"Uzbekistan" => "+998" ,

				"Vanuatu" => "+678" ,

				"Venezuela" => "+58" ,

				"Vietnam" => "+84" ,

				"Wallis and Futuna" => "+681" ,

				"Yemen" => "+967" ,

				"Yugoslavia" => "+381" ,

				"Zambia" => "+260" ,

				"Zimbabwe" => "+263"),

			'surgery_type' => array('' => 'Select surgery',
				'B/S Patient' => 'B/S Patient',
				'Band (Loose / Tight)' => 'Band (Loose / Tight)',
				'Bariatic' => 'Bariatic',
				'Body Fat Analysis' => 'Body Fat Analysis',
				'For any other not listed above' => 'For any other not listed above',
				'Non Bariatric Surgery' => 'Non Bariatric Surgery',
				'Post surgery' => 'Post surgery',
				'Weight Loss (Carlyne - Diet Only)' => 'Weight Loss (Carlyne - Diet Only)',
				'Weight Loss (E-Diets )' => 'Weight Loss (E-Diets )',
				'Weight Loss (jason - Fitness & Diet)' => 'Weight Loss (jason - Fitness & Diet) )'
			),

			'type_of_surgeries' => array('' => 'Select type of surgery',
				'bariatic surgery' => 'Bariatic surgery',
				'general surgery' => 'General surgery',
				'non surgical' => 'Non Surgical'
			),

			'client_type' => array( '' => 'Select client',
				'Normal' => 'Normal',
				'Vip' => 'VIP'
			),

			'meeting_type' => array ('' => 'Select meeting',
				'1 month F/U' => '1 month F/U',
				'1 Year F/U' => '1 Year F/U',
				'1 year plus F/U' => '1 year plus F/U',
				'12 weeks F/U' => '12 weeks F/U',
				'3 month F/U' => '3 month F/U',
				'6 month F/U' => '6 month F/U',
				'7 days F/U' => '7 days F/U',
				'Any' => 'Any',
				'F/U' => 'F/U',
				'First visit' => 'First visit',
				'persession' => 'persession',
				'Prospect' => 'Prospect',
				'Prospect F/U' => 'Prospect F/U'
			),

			'monthlist' => array ('' => 'Select month',
				'01' => 'January',
				'02' => 'February',
				'03' => 'March',
				'04' => 'April',
				'05' => 'May',
				'06' => 'June',
				'07' => 'July',
				'08' => 'August',
				'09' => 'September',
				'10' => 'October',
				'11' => 'November',
				'12' => 'December'
			),
			'yearslist' => array("" => "Select year")+array_combine(range(2015,date("Y")),range(2015,date("Y"))),
			'paymentType' => array(''=>'Select payment type',
				'credit' => 'Credit',
				'self' => 'Self',
				'credit_self' => 'Credit + Self'
			),
			'paymentStatus' => array(''=>'Select status',
				'completed' => 'Completed',
				'pending' => 'Pending',
			),
			'surgerySearchpParameters' => array(
				'' => 'Select',
				'room booking' => 'Room booking',
				'sign surgery' => 'Sign surgery',
				'admission letter' => 'Admission letter',
			),
			'appointmentStatus' => array(''=>'Select status',
				'booked'=>'Booked',
				'cancelled'=>'Patient Cancelled',
				'clinic_cancelled'=>'Clinic Cancelled',
				'walkin'=>'Walkin'
			),
			'surgeryType' => array("" =>"Select one",
				"endoscopy" => "Endoscopy",
				"laparoscopy" =>"Laparoscopy",
				"single_incision" =>"Single incision",
				"minilaparoscopy" =>"Minilaparoscopy"),
			"surgeryCategory"=> array(""=>"Select one",
				"intra-gastric_balloon"=>"Intra-gastric balloon",
				"adjustable_gastric_banding"=>"Adjustable Gastric Banding",
				"sleeve_gastrectomy"=>"Sleeve Gastrectomy",
				"mini_gastric_bypass"=>"Mini Gastric Bypass",
				"roux_en_y_gastric_bypass"=>"Roux en y Gastric Bypass",
				"banded_roux-en_y_gastric_bypass"=>"Banded Roux-en Y Gastric Bypass",
				"sleeve_with_djb"=>"Sleeve with DJB",
				"duodenal_switch"=>"Duodenal Switch",
				"revisional_surgery"=>"Revisional surgery"),
			"cruralRepair"=> array(""=>"Select one",
				"yes"=>"Yes",
				"no"=>"No"),
			"GJAnastomosis"=> array(""=>"Select one",
				"circular_stapler"=>"Circular stapler",
				"linear_stapler"=>"Linear stapler",
				"hand_sewn"=>"Hand sewn",
			),
			"boolNumaric" => array("0" => "No", "1" => "Yes"),
			"leak"=> array(
				""=>"Select one",
				"early"=>"Early",
				"late"=>"Late",
			),
			"level"=> array(
				''=>'Select one',
				'high'=>'High',
				'normal'=>'Normal',
				'low'=>'Low'
			),
			"fibro_scan_cap_level"=> array(
				''=>'Select one',
				'high'=>'High',
				'normal'=>'Normal'
			),
			"fibro_scan_e_level"=> array(
				''=>'Select one',
				'high'=>'High',
				'normal'=>'Normal'
			),
			"fibro_scan_steatosis_level"=> array(
				''=>'Select one',
				'mild'=>'Mild',
				'mod'=>'Mod',
				'severe'=>'Severe'
			),
			"fatty_liver_level"=> array(
				'NULL'=>'Select one',
				"mild"=> "Mild",
				"mod"=> "Mod",
				"sever"=> "Sever"
			),
			"fibro_scan_fibrosis_level"=> array(
				'NULL'=>'Select one',
				'mild_fibrosis'=>'Mild fibrosis',
				'mod_fibrosis'=>'Moderate fibrosis',
				'severe_fibrosis'=>'Severe fibrosis',
				'cirrhosis'=>'Cirrhosis'
			),
			"sleep_apnea_level"=> array(
				'NULL'=>'Select one',
				"absent"=> "Absent",
				"mild"=> "Mild",
				"moderate"=> "Moderate",
				"severe"=> "Severe",
			),
			"urine_routine_pus_level"=> array(
				''=>'Select one',
				'high'=>'High',
				'normal'=>'Normal'
			),
			"urine_routine_rbcs_level"=> array(
				''=>'Select one',
				'high'=>'High',
				'normal'=>'Normal'
			),
			/*"activity_phase"=> array(
			 ''=>'Select one',
			 'consulting_registration'=>'Consulting/Registration',
			 'pre_operative'=>'Pre operative',
			 'surgery'=>'Surgery',
			 'post_operative'=>'Post operative'
			),
			"activity_type"=> array(
			'lab_investigation' => 'Lab Investigation',
			'pre_operative_dieting' => 'Pre operative dieting',
			'specialist_report' => 'Specialist report',
			'other' => 'Other',
			'weight_measurement' => 'Weight measurement'
			),*/
			"li_units"=>array(
				"rbs"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"total_proteins"=> array(
					'0'=>'Select one',
					'1'=>'gms/dl',
					'2'=>'g/L'
				),
				"ppinsulin"=>  array(
					'0'=>'Select one',
					'1'=>'uIU/ml',
					'2'=>'pmol/L',
					'3'=>'mU/L'
				),
				"hb"=>  array(
					'0'=>'Select one',
					'1'=>'gms/dl',
					'2'=>'g/L'
				),
				"fbs"=>  array(
					'0'=>'Select one',
					'1'=>'mg/dL',
					'2'=>'mmol/L',
				),
				"stimulated_cpeptide"=>  array(
					'0'=>'Select one',
					'1'=>'ng/ml',
					'2'=>'nmol/L',
				),
				"finsulin"=>  array(
					'0'=>'Select one',
					'1'=>'uIU/ml',
					'2'=>'pmol/L',
					'3'=>'mU/L',
				),
				"ppbs"=>  array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L',
				),
				"t3"=>  array(
					'0'=>'Select one',
					'1'=>'ng/dl',
					'2'=>'pmol/L',
					'3'=>'pg/dl',
					'4'=>'pg/ml'
				),
				"t4"=> array(
					'0'=>'Select one',
					'1'=>'ug/dl',
					'2'=>'pmol/L',
					'3'=>'ng/dl'
				),
				"tsh"=> array(
					'0'=>'Select one',
					'1'=>'uIU/ml',
					'2'=>'uIU/L'
				),
				"spth"=> array(
					'0'=>'Select one',
					'1'=>'pg/ml',
					'2'=>'ng/L'
				),
				"sr_calcium"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"ionised_calcium"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"phosphorus"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L',
					'3'=>'mg/L'
				),
				"total_cholesterol"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"vldlc"=> array(
					'0'=>'Select one',
					'1'=>'mg/ml',
					'2'=>'mg/dl'
				),
				"ldlc"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"hdlc"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"tg"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"urinealbumin"=> array(
					'0'=>'Select one',
					'1'=>'mg/L',
				),
				"crp"=> array(
					'0'=>'Select one',
					'1'=>'mg/L',
				),
				"alkpo4"=> array(
					'0'=>'Select one',
					'1'=>'IU/L',
					'2'=>'U/L',
				),
				"albumin"=> array(
					'0'=>'Select one',
					'1'=>'gms/dl',
					'2'=>'g/L',
				),
				"tbili"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'umol/L',
				),
				"dbili"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'umol/L',
				),
				"ibili"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'umol/L',
				),
				"sgpt"=> array(
					'0'=>'Select one',
					'1'=>'IU/L',
					'2'=>'U/L',
				),
				"globulin"=> array(
					'0'=>'Select one',
					'1'=>'gms/dl',
					'2'=>'gm%',
				),
				"sgot"=> array(
					'0'=>'Select one',
					'1'=>'IU/L',
					'2'=>'U/L',
				),
				"ggt"=> array(
					'0'=>'Select one',
					'1'=>'IU/L',
					'2'=>'U/L',
				),
				"sr_iron"=> array(
					'0'=>'Select one',
					'1'=>'ug/dl',
					'2'=>'umol/L',
				),
				"folic_acid"=> array(
					'0'=>'Select one',
					'1'=>'ng/dl',
					'2'=>'nmol/L',
					'3'=>'ng/ml',
					'4'=>'ug/L',
				),
				"b12"=> array(
					'0'=>'Select one',
					'1'=>'pg/ml',
					'2'=>'pmol/L',
					'3'=>'ng/L',
				),
				"tibc"=> array(
					'0'=>'Select one',
					'1'=>'ug/dl',
					'2'=>'umol/L',
				),
				"tsi"=> array(
					'0'=>'Select one',
					'1'=>'gms/dl'
				),
				"sferritin"=> array(
					'0'=>'Select one',
					'1'=>'ng/dl',
					'2'=>'pmol/L',
					'3'=>'ng/ml',
					'4'=>'ug/L'
				),
				"svtd3"=> array(
					'0'=>'Select one',
					'1'=>'ng/ml',
					'2'=>'nmol/L'
				),
				"homocysteine"=> array(
					'0'=>'Select one',
					'1'=>'Umol/L',
					'2'=>'mg/l',
					'3'=>'umol/L',
				),
				"screat"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'umol/L'
				),
				"bun"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'mmol/L'
				),
				"suric_acid"=> array(
					'0'=>'Select one',
					'1'=>'mg/dl',
					'2'=>'umol/L',
					'3'=>'mmol/L'
				),
				"na"=> array(
					'0'=>'Select one',
					'1'=>'mEq/L',
					'2'=>'mmol/L'
				),
				"k"=> array(
					'0'=>'Select one',
					'1'=>'mEq/L',
					'2'=>'mmol/L'
				),
				"cl"=> array(
					'0'=>'Select one',
					'1'=>'mEq/L',
					'2'=>'mmol/L'
				),
				"total_leucocyte_count"=> array(
					'0'=>'Select one',
					'1'=>"/c.mm"
				),
				"platelet_count"=> array(
					'0'=>'Select one',
					'1'=>"10^3/c.mm"
				),
				"pt"=> array(
					'0'=>'Select one',
					'1'=>"Seconds",
				),
				"fibro_scan_cap"=> array(
					'0'=>'Select one',
					'1'=>"dB/m",
				),
				"fibro_scan_e"=> array(
					'0'=>'Select one',
					'1'=>"kPa",
				),
				"fibro_scan_steatosis"=> array(
					'0'=>'Select one',
					'1'=>"%",
				),
				"echo_ef"=> array(
					'0'=>'Select one',
					'1'=>"%",
				),
				"urine_routine_pus"=> array(
					'0'=>'Select one',
					'1'=>"/hpf",
				),
				"urine_routine_rbcs"=> array(
					'0'=>'Select one',
					'1'=>"/hpf",
				),
				"hba1c"=> array(
					'0'=>'Select one',
					'1'=>"%",
				),
				"fc_peptide"=>  array(
					'0'=>'Select one',
					'1'=>'ng/mL',
					'2'=>'nmol/L',
				),
				"ppc_peptide"=>  array(
					'0'=>'Select one',
					'1'=>'ng/mL',
					'2'=>'nmol/L',
				),
				"total_cholesterol"=> array(
					'0'=>'Select one',
					'1'=>'mg/dL',
					'2'=>'mmol/L',
				),
			),

			"li_calculations"=>array(
				"rbs" => array("0"=>0, "1"=>1, "2"=>18.016 ),
				"ppinsulin" => array("0"=>0, "1"=>1, "2"=>0.144, "3"=>1 ),
				"hb" => array("0"=>0, "1"=>1, "2"=>0.1 ),
				"fbs" => array("0"=>0, "1"=>1, "2"=>18.016 ),
				"stimulated_cpeptide" => array("0"=>0, "1"=>1, "2"=>3.020 ),
				"finsulin" => array("0"=>0, "1"=>1, "2"=>0.144, "3"=>1 ),
				"ppbs" => array("0"=>0, "1"=>1, "2"=>18.016 ),
				"t3" => array("0"=>0, "1"=>1, "2"=>0.065, "3"=>0.001, "4"=>0.1 ),
				"t4" => array("0"=>0, "1"=>1, "2"=>0.00008, "3"=>0.001 ),
				"tsh" => array("0"=>0, "1"=>1, "2"=>1 ),
				"spth" => array("0"=>0, "1"=>1, "2"=>1 ),
				"sr_calcium" => array("0"=>0, "1"=>1, "2"=>4.008 ),
				"ionised_calcium" => array("0"=>0, "1"=>1, "2"=>1 ),
				"phosphorus" => array("0"=>0, "1"=>1, "2"=>3.097, "3"=>0.1 ),
				"total_cholesterol" => array("0"=>0, "1"=>1, "2"=>38.665 ),
				"vldlc" => array("0"=>0, "1"=>1, "2"=>0.01 ),
				"ldlc" => array("0"=>0, "1"=>1, "2"=>38.665 ),
				"hdlc" => array("0"=>0, "1"=>1, "2"=>38.665 ),
				"tg" => array("0"=>0, "1"=>1, "2"=>88.574 ),
				"urinealbumin" => array("0"=>0, "1"=>1 ),
				"crp" => array("0"=>0, "1"=>1 ),
				"alkpo4" => array("0"=>0, "1"=>1, "2"=>1 ),
				"albumin" => array("0"=>0, "1"=>1, "2"=>0.1 ),
				"total_proteins" => array("0"=>0, "1"=>1, "2"=>0.1 ),
				"tbili" => array("0"=>0, "1"=>1, "2"=>0.058 ),
				"dbili" => array("0"=>0, "1"=>1, "2"=>0.058 ),
				"ibili" => array("0"=>0, "1"=>1, "2"=>0.058 ),
				"sgpt" => array("0"=>0, "1"=>1, "2"=>1 ),
				"globulin" => array("0"=>0, "1"=>1, "2"=>1 ),
				"sgot" => array("0"=>0, "1"=>1, "2"=>1 ),
				"ggt" => array("0"=>0, "1"=>1, "2"=>1 ),
				"agratio" => array("0"=>0, "1"=>1 ),
				"sr_iron" => array("0"=>0, "1"=>1, "2"=>5.585 ),
				"folic_acid" => array("0"=>0, "1"=>1, "2"=>44.140, "3"=>100, "4"=>100 ),
				"b12" => array("0"=>0, "1"=>1, "2"=>1.355, "3"=>1 ),
				"tibc" => array("0"=>0, "1"=>1, "2"=>5.585 ),
				"tsi" => array("0"=>0, "1"=>1 ),
				"sferritin" => array("0"=>0, "1"=>1, "2"=>44.504, "3"=>100, "4"=>100 ),
				"svtd3" => array("0"=>0, "1"=>1, "2"=>0.385 ),
				"homocysteine" => array("0"=>0, "1"=>1, "2"=>0.135, "3"=>0.000001 ),
				"screat" => array("0"=>0, "1"=>1, "2"=>0.011 ),
				"bun" => array("0"=>0, "1"=>1, "2"=>2.8 ),
				"suric_acid" => array("0"=>0, "1"=>1, "2"=>0.017, "3"=>16.811 ),
				"na" => array("0"=>0, "1"=>1, "2"=>1 ),
				"k" => array("0"=>0, "1"=>1, "2"=>1 ),
				"cl" => array("0"=>0, "1"=>1, "2"=>1 ),
				"total_leucocyte_count"=> array("0"=>0,"1"=>1),
				"platelet_count"=> array("0"=>0,"1"=>1),
				"pt"=> array("0"=>0,"1"=>1),
				"fibro_scan_cap"=> array("0"=>0,"1"=>1),
				"fibro_scan_e"=> array("0"=>0,"1"=>1),
				"urine_routine_pus"=> array("0"=>0,"1"=>1),
				"urine_routine_rbcs"=> array("0"=>0,"1"=>1),
				"hba1c"=> array("0"=>0,"1"=>1),
				"echo_ef"=> array("0"=>0,"1"=>1),
				"fc_peptide" => array("0"=>0, "1"=>1, "2"=>3.020 ),
				"ppc_peptide" => array("0"=>0, "1"=>1, "2"=>3.020 ),
				"total_cholesterol" => array("0"=>0, "1"=>1, "2"=>18.016 ),
			),

			"li_unit_id"=>array(
				"rbs"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"total_proteins"=> array(
					'gms/dl'=>'1',
					'g/L'=>'2'
				),
				"ppinsulin"=> array(
					'uIU/ml'=>1,
					'pmol/L'=>2,
					'mU/L'=>3
				),
				"hb"=> array(
					'gms/dl'=>1,
					'g/L'=>2
				),
				"fbs"=> array(
					'mg/dL'=>1,
					'mmol/L'=>2
				),
				"stimulated_cpeptide"=> array(
					'ng/ml'=>1,
					'nmol/L'=>2
				),
				"finsulin"=> array(
					'uIU/ml'=>1,
					'pmol/L'=>2,
					'mU/L'=>3
				),
				"ppbs"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"t3"=> array(
					'ng/dl'=>1,
					'pmol/L'=>2,
					'pg/dl'=>3,
					'pg/ml'=>4
				),
				"t4"=> array(
					'ug/dl'=>1,
					'pmol/L'=>2,
					'ng/dl'=>3
				),
				"tsh"=> array(
					'uIU/ml'=>1,
					'uIU/L'=>2
				),
				"spth"=> array(
					'pg/ml'=>1,
					'ng/L'=>2
				),
				"sr_calcium"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"ionised_calcium"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"phosphorus"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2,
					'mg/L'=>3
				),
				"total_cholesterol"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"vldlc"=> array(
					'mg/ml'=>1,
					'mg/dl'=>2
				),
				"ldlc"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"hdlc"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"tg"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"urinealbumin"=> array(
					'mg/L'=>1
				),
				"crp"=> array(
					'mg/L'=>1
				),
				"alkpo4"=> array(
					'IU/L'=>1,
					'U/L'=>2
				),
				"albumin"=> array(
					'gms/dl'=>1,
					'g/L'=>2
				),
				"tbili"=> array(
					'mg/dl'=>1,
					'umol/L'=>2
				),
				"dbili"=> array(
					'mg/dl'=>1,
					'umol/L'=>2
				),
				"ibili"=> array(
					'mg/dl'=>1,
					'umol/L'=>2
				),
				"sgpt"=> array(
					'IU/L'=>1,
					'U/L'=>2
				),
				"globulin"=> array(
					'gms/dl'=>1,
					'gm%'=>2
				),
				"sgot"=> array(
					'IU/L'=>1,
					'U/L'=>2
				),
				"ggt"=> array(
					'IU/L'=>1,
					'U/L'=>2
				),
				"sr_iron"=> array(
					'ug/dl'=>1,
					'umol/L'=>2
				),
				"folic_acid"=> array(
					'ng/dl'=>1,
					'nmol/L'=>2,
					'ng/ml'=>3,
					'ug/L'=>4
				),
				"b12"=> array(
					'pg/ml'=>1,
					'pmol/L'=>2,
					'ng/L'=>3
				),
				"tibc"=> array(
					'ug/dl'=>1,
					'umol/L'=>2
				),
				"tsi"=> array(
					'gms/dl'=>1,
				),
				"sferritin"=> array(
					'ng/dl'=>1,
					'pmol/L'=>2,
					'ng/ml'=>3,
					'ug/L'=>4
				),
				"svtd3"=> array(
					'ng/ml'=>1,
					'nmol/L'=>2
				),
				"homocysteine"=> array(
					'Umol/L'=>1,
					'mg/l'=>2,
					'umol/L'=>3
				),
				"screat"=> array(
					'mg/dl'=>1,
					'umol/L'=>2
				),
				"bun"=> array(
					'mg/dl'=>1,
					'mmol/L'=>2
				),
				"suric_acid"=> array(
					'mg/dl'=>1,
					'umol/L'=>2,
					'mmol/L'=>3
				),
				"na"=> array(
					'mEq/L'=>1,
					'mmol/L'=>2
				),
				"k"=> array(
					'mEq/L'=>1,
					'mmol/L'=>2
				),
				"cl"=> array(
					'mEq/L'=>1,
					'mmol/L'=>2
				),
				//units from google
				"total_leucocyte_count"=> array(
					"/c.mm"=>1
				),
				"platelet_count"=> array(
					"10^3/c.mm"=>1
				),
				"pt"=> array(
					"Seconds"=>1,
				),
				"fibro_scan_cap"=> array(
					"dB/m"=>1,
				),
				"fibro_scan_e"=> array(
					"kPa"=>1,
				),
				"fibro_scan_steatosis"=> array(
					"%"=>1,
				),
				"echo_ef"=> array(
					"%"=>1,
				),
				"urine_routine_pus"=> array(
					'Select one'=>0,
					"/hpf"=>1,
				),
				"urine_routine_rbcs"=> array(
					'Select one'=>0,
					"/hpf"=>1,
				),
				"hba1c"=> array(
					'Select one'=>0,
					"%"=>1,
				),
				"fc_peptide"=>  array(
					'Select one'=>0,
					'ng/mL'=>1,
					'nmol/L'=>2,
				),
				"ppc_peptide"=>  array(
					'Select one'=>'0',
					'ng/mL'=>'1',
					'nmol/L'=>'2',
				),
				"total_cholesterol"=> array(
					'Select one'=>'0',
					'mg/dL'=>'1',
					'mmol/L'=>'2',
				)
			),

			"fibro_scan_steatosis"=> array(
				'0'=>'Select one',
				'S1(<30)'=>'S1(<30)',
				'S2(30-60)'=>'S2(30-60)',
				'S3(>30)'=>'S3(>30)',
			),
			"fibro_scan_fibrosis"=> array(
				'NULL'=>'Select one',
				'f1'=>'F1',
				'f2'=>'F2',
				'f3'=>'F3',
				'f4'=>'F4',
			),

			"histopath_liver_biopsy_fibrosis"=> array(
				'NULL'=>'Select one',
				"grade1"=>"Grade1",
				"grade2"=>"Grade2",
				"grade3"=>"Grade3"
			),
			"ugi_endoscopy_grade_esophagitis"=> array(
				'NULL'=>'Select one',
				"grade1"=>"Grade1",
				"grade2"=>"Grade2",
				"grade3"=>"Grade3"
			),
			"ugi_endoscopy_flap_valve_grade"=> array(
				'0'=>'Select one',
				"1"=> "1",
				"2"=> "2",
				"3"=> "3",
				"4"=> "4",
			),
			"ugi_endoscopy_reflux_grade"=> array(
				'NULL'=>'Select one',
				"nil"=> "Nil",
				"a"=> "A",
				"b"=> "B",
				"c"=> "C",
				"d"=> "D",
			),
			"ugi_endoscopy_polyps"=> array(
				'NULL'=>'Select one',
				"yes"=> "Yes",
				"no"=> "No",
			),
			"ugi_endoscopy_hpylori"=> array(
				'NULL'=>'Select one',
				"present"=> "Present",
				"absent"=> "Absent",
			),

			"hbs_ag"=> array(
				'NULL'=>'Select one',
				"positive"=> "Positive",
				"negative"=> "Negative",
			),
			"hcv"=> array(
				'NULL'=>'Select one',
				"positive"=> "Positive",
				"negative"=> "Negative",
			),
			"hiv"=> array(
				'NULL'=>'Select one',
				"positive"=> "Positive",
				"negative"=> "Negative",
			),
			"fatty_liver"=> array(
				'NULL'=>'Select one',
				"grade1"=> "Grade1",
				"grade2"=> "Grade2",
				"grade3"=> "Grade3",
				"absent"=> "Absent",
			),

			"followup_status"=> array(
				'NULL'=>'Select one',
				'pending'=>'Pending',
				'walkin'=>'Walkin',
				'phone'=>'Phone'
			),
			"followup_date"=> array(
				'2'=>'+7 days',
				'5'=>'+1 months',
				'7'=>'+3 months',
				'11'=>'+6 months',
				'14'=>'+9 months',
				'18'=>'+1 year',
				'19'=>'+18 months',
				'20'=>'+2 year',
				'22'=>'+3 year',
				'23'=>'+4 year',
				'24'=>'+5 year',
			),
			"dropdown_arr"=>array("fatty_liver","hiv","hcv","hbs_ag","ugi_endoscopy_grade_esophagitis","ugi_endoscopy_hpylori","ugi_endoscopy_polyps","ugi_endoscopy_reflux_grade","histopath_liver_biopsy_fibrosis","fibro_scan_fibrosis"),
			//Patient signup dropdown
			'patient_status' => array(''=>'Select Status','1' => 'Active', '0' => 'Inactive'),
			//intake consumptions dropdown
			'intake_duration' => array("" => "Select",
				"Daily" => "Daily",
				"Fortnightly" => "Fortnightly",
				"Weekly" => "Weekly",
				"Monthly" =>  "Monthly",
			),
			//intake consumptions dropdown
			'water_intake' => array("" => "Select","Less than 1" => "Less than 1")+array_combine(range(1,8),range(1,8)),
			//intake consumptions dropdown
			'spead_eat' => array("" => "Select", "Slow"=> "Slow","Moderate"=> "Moderate","Fast"=> "Fast"),
			//Weight loss attempts dropdown
			'weightloss_attempts' => array("0" => "Attempts")+array_combine(range(1,20),range(1,20)),
			//intake number of times
			'intake_no_times'=>array("" => "Select")+array_combine(range(1,8),range(1,8)),
			//Weight loss attempts dropdown
			'amount_of_weightloss' => array("0" => "Weight loss")+array_combine(range(1,20),range(1,20)) + array("20+" => "20+") + array("30+" => "30+") + array("40+" => "40+") + array("50+" => "50+"),
			//Weight loss attempts dropdown
			'since_over_weight' => array("0" => "Select")+array("1-5" => "1-5","5-10" => "5-10","10-15" => "10-15","15-20" => "15-20","20 years +" => "20 years +"),
			//recommendations dropdown
			'diagnosis' => array(	"LSG or Banded RYGB post endoscopy and blood tests" =>  "LSG or Banded RYGB post endoscopy and blood tests",
				"MGB or Banded RYGB post endoscopy and blood test" =>   "MGB or Banded RYGB post endoscopy and blood test",
				"To decide on surgery post investigations" => " To decide on surgery post investigations",
				"Trial diet and exercise and then decide surgery" => "Trial diet and exercise and then decide surgery",
				"Not for surgery / Non surgical weight loss" => "Not for surgery / Non surgical weight loss",
				"Bio enteric intra gastric balloon" => "Bio enteric intra gastric balloon",
				"Other" => "Other"),
			//recommendations dropdown
			'referrers' => array(  "Endocrinologist" => "Endocrinologist",
				"Cardiologist" => "Cardiologist",
				"Nephrologist" => "Nephrologist",
				"Chest physician" => "Chest physician",
				"Cosmetic Surgeon" => "Cosmetic Surgeon",
				"Hepatologist" => "Hepatologist"),
//Surgical history
			'type' => array(
				"" => "Select type",
				"Open" => "Open",
				"Laparoscopy" => "Laparoscopy"
			),
			'annotation_type'=>array(
				'weightprofile' => 'Weight profile',
				'labinvestigation' => 'Lab investigation',
				'comorbmedication' => 'comorb medication',
				'account' => 'Account',
				'surgicalhistory' => 'Surgical history',
				'psychometric' => 'Psychometric',
				'comorbdetail' => 'Comorb detail',
				'weightlossattempts' => 'Weightloss attempts',
				'followup' => 'Followup',
				'task' => 'Task'
			),
			"intra_gastric_balloon_type" => array(
				"" => "Select one",
				"insertion" => "Insertion",
				"removal" => "Removal",
			),
			"concomitant_surgery"=> array(
				"" => "Select one",
				"cholecystectomy"=>"Cholecystectomy",
				"umbilical_hernia"=>"Umbilical hernia",
				"ventral_hernia"=>"Ventral hernia",
				"hysterectomy"=>"Hysterectomy",
				"appendectomy"=>"Appendectomy",
				"ovarian_cystectomy"=>"Ovarian cystectomy",
				"adrenalectomy"=>"Adrenalectomy",
				"myemectomy"=>"Myemectomy",
				"tubal_ligation"=>"Tubal ligation",
				"oophorectomy"=>"Oophorectomy",
				"ureteroscopy"=>"Ureteroscopy",
				"remnant_gastrectomy"=>"Remnant gastrectomy",
				"other"=>"Other",
				"nil"=>"NIL",
			),
			'post_op_cx' => array(
				'' => "Select one",
				'leak' => 'Leak',
				'haemorrage' => 'Haemorrage',
				'marginal_ulcer' => 'Marginal ulcer',
				'internal_hernia' => 'Internal hernia',
				'cholelithiasis' => 'Cholelithiasis',
				'vte' => 'VTE',
				'stricture' => 'Stricture',
				'reflux' => 'Reflux'
			),
			/*'search_condition_varchar' => array(
				'equal' => 'Equal',
				'not_equal' => 'Doest not equal',
				'like' => 'Contain data',
				'not_like' => 'Does not contain data',
				'begin_with' => 'Begin with',
				'doesnot_begin_with' => 'Does not begin with',
				'end_with' => 'End with',
				'doesnot_end_with' => 'Does not end with'
				),
			'search_condition_int' => array(
				'equal' => 'Equal',
				'not_equal' => 'Doest not equal',
				'greater_than' => 'Is greater than',
				'greated_than_equal' => 'Is greater than or equal',
				'less_than' => 'Is less than',
				'less_than_equal' => 'Is less than or equal'
				),
			'where_operators' => array(
				'equal' => '=',
				'not_equal' => '!=',
				'like' => '%__%',
				'not_like' => '!%__%',
				'begin_with' => '__%',
				'doesnot_begin_with' => '!__%',
				'end_with' => '%__',
				'doesnot_end_with' => '!%__',
				'greater_than' => '>',
				'greated_than_equal' => '>=',
				'less_than' => '<',
				'less_than_equal' => '<='
				),
			'group_options' => array(
				'' => 'Select one',
				'select_row' => 'Select row',
				'delete' => 'Delete'
				),	*/
			'conditional_operators' => array(
				'equal'=>'=',
				'not_equal'=>'!=',
				'in'=>'IN',
				'not_in'=>'NOT IN',
				'less'=>'<',
				'less_or_equal'=>'<=',
				'greater'=>'>',
				'greater_or_equal'=>'>=',
				'begins_with'=>'LIKE',
				'not_begins_with'=>'NOT LIKE',
				'contains'=>'LIKE',
				'not_contains'=>'NOT LIKE',
				'ends_with'=>'LIKE',
				'not_ends_with'=>'NOT LIKE',
				'is_empty'=>'=',
				'is_not_empty'=>'!=',
				'is_null'=>'IS NULL',
				'is_not_null'=>'IS NOT NULL'),
			'multiselect_exclude_operators' => array(
				'equal','not_equal','less','less_or_equal','greater','greater_or_equal','begins_with','not_begins_with','contains','not_contains','ends_with','not_ends_with',
				'is_empty','is_not_empty','is_null','is_not_null'),
			/*'group_options' => array(
				'select_row' => 'Select row',
				'de_select_row' => 'Deselect row',
				'select_group' => 'Select group',
				'unselect_group' => 'Unselect group',
				'ungroup' => 'Ungroup',
				'group_to_and' => 'Group to and',
				'group_to_or' => 'Group to or',
				'add_clause' => 'Add clause',
				'delete' => 'Delete'
				),		*/

			'employment_status' => array("" => "Select employment status",
				"Full Time" => "Full Time",
				"Part Time" => "Part Time",
				"Self Employed" => "Self Employed",
				"Home Maker" => "Home Maker",
				"Student" => "Student",
				"Retired" => "Retired",
				"Disability" => "Disability",
				"Un Employed" => "Un Employed",
				"Not Specified" => "Not Specified"
			),
			'communication_preference' => array("" => "Select communication preference",
				"Home Phone " => "Home Phone",
				"Work Phone" => "Work Phone",
				"Mobile" => "Mobile",
				"SMS" => "SMS",
				"Email" => "Email",
				"Facebook" => "Facebook",
				"Others" => "Others"
			),
			'patient_stage' => array(
				"" => "Select one",
				"patient " => "Patient",
				"prospect" => "Prospect"
			),
			'shareinformation'=>array("Photo" => "Photo","Case Histoty" => "Case Histoty","Telephone Number" => "Telephone Number","Email" => "Email"),
			'comorb_duration'=>array("0" => "Duration","0.5"=>"0.5","0.75"=>"0.75")+array_combine(range(1,20),range(1,20)),
			'comorb_drugs'=>array("0" => "Drugs")+array_combine(range(1,30),range(1,30)),
			'acidity_type'=>array("0" => "Slect Type")+array("Mild"=>"Mild","Moderate"=>"Moderate","Severe"=>"Severe"),
			'followup_recommendations'=>array(""=>"Select one",
				"next_follow_up_after_3_months" => "NEXT FOLLOW UP AFTER 3 MONTHS",
				"next_follow_up_after_6_months" => "NEXT FOLLOW UP AFTER 6 MONTHS",
				"next_follow_up_after_1_year" => "NEXT FOLLOW UP AFTER 1 YEAR",
				"kindly_visit_your_physician" =>	"KINDLY VISIT YOUR PHYSICIAN",
				"advised_to_repeat_few_tests" => "ADVISED TO REPEAT FEW TESTS",
				"advised_to_send_pending_reports" => "ADVISED TO SEND PENDING REPORTS",
				"followup_regularly_as_advised_by_the_nutritionist" => "FOLLOW UP REGULARLY AS ADVISED BY THE NUTRITIONIST",
				"any_other" => "ANY OTHER"),
			'visit_physician'=>array(""=>"Select one",
				"diabetes" => "DIABETES",
				"hypertension" => "HYPERTENSION",
				"thyroid" => "THYROID",
				"any_other_medication" => "ANY OTHER MEDICATIONS"),
			'payment_status' =>array(""=>"Select status","paid"=>"Paid","cancel"=>"Cancel"),
			'weightprofile_gender' =>array(""=>"Select gender","M"=>"Male","F"=>"Female"),
			'display_status'=>array(''=>'Select Status','1' => 'Active', '0' => 'Inactive','active' => 'Active', 'inactive' => 'Inactive'),
			'rate_card_countries' => array('' => 'Select Country', 'india' => 'India', 'dubai' => 'Dubai'),
			'sms_type' => array('' => 'Select One', 'immediate' => 'Immediate', 'later' => 'Later'),
			'company_name'=>'Digestive Health Institute',
			'company_web'=>'http://thedigestive.in/',
		);

//		$object = new stdClass();
//		foreach ($arrCommon as $key=>$value){
//			$object->$key= $value;
//		}
//		return $object;
//	}
}

