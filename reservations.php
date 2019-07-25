<?php

function GenerateChk($DotpayId, $DotpayPin, $Environment, $RedirectionMethod, $ParametersArray,$MultiMerchantList)
{
	$ParametersArray['id'] = $DotpayId;
	$chk = $DotpayPin.(isset($ParametersArray['api_version']) ? $ParametersArray['api_version'] : null).(isset($ParametersArray['charset']) ? $ParametersArray['charset'] : null).
	(isset($ParametersArray['lang']) ? $ParametersArray['lang'] : null).(isset($ParametersArray['id']) ? $ParametersArray['id'] : null).(isset($ParametersArray['pid']) ? $ParametersArray['pid'] : null).(isset($ParametersArray['amount']) ? $ParametersArray['amount'] : null).(isset($ParametersArray['currency']) ? $ParametersArray['currency'] : null).(isset($ParametersArray['description']) ? $ParametersArray['description'] : null).(isset($ParametersArray['control']) ? $ParametersArray['control'] : null).(isset($ParametersArray['channel']) ? $ParametersArray['channel'] : null).(isset($ParametersArray['credit_card_brand']) ? $ParametersArray['credit_card_brand'] : null).(isset($ParametersArray['ch_lock']) ? $ParametersArray['ch_lock'] : null).(isset($ParametersArray['channel_groups']) ? $ParametersArray['channel_groups'] : null).(isset($ParametersArray['onlinetransfer']) ? $ParametersArray['onlinetransfer'] : null).(isset($ParametersArray['url']) ? $ParametersArray['url'] : null).(isset($ParametersArray['type']) ? $ParametersArray['type'] : null).(isset($ParametersArray['buttontext']) ? $ParametersArray['buttontext'] : null).(isset($ParametersArray['urlc']) ? $ParametersArray['urlc'] : null).(isset($ParametersArray['firstname']) ? $ParametersArray['firstname'] : null).(isset($ParametersArray['lastname']) ? $ParametersArray['lastname'] : null).(isset($ParametersArray['email']) ? $ParametersArray['email'] : null).(isset($ParametersArray['street']) ? $ParametersArray['street'] : null).(isset($ParametersArray['street_n1']) ? $ParametersArray['street_n1'] : null).(isset($ParametersArray['street_n2']) ? $ParametersArray['street_n2'] : null).(isset($ParametersArray['state']) ? $ParametersArray['state'] : null).(isset($ParametersArray['addr3']) ? $ParametersArray['addr3'] : null).(isset($ParametersArray['city']) ? $ParametersArray['city'] : null).(isset($ParametersArray['postcode']) ? $ParametersArray['postcode'] : null).(isset($ParametersArray['phone']) ? $ParametersArray['phone'] : null).(isset($ParametersArray['country']) ? $ParametersArray['country'] : null).(isset($ParametersArray['code']) ? $ParametersArray['code'] : null).(isset($ParametersArray['p_info']) ? $ParametersArray['p_info'] : null).(isset($ParametersArray['p_email']) ? $ParametersArray['p_email'] : null).(isset($ParametersArray['n_email']) ? $ParametersArray['n_email'] : null).(isset($ParametersArray['expiration_date']) ? $ParametersArray['expiration_date'] : null).(isset($ParametersArray['deladdr']) ? $ParametersArray['deladdr'] : null).(isset($ParametersArray['recipient_account_number']) ? $ParametersArray['recipient_account_number'] : null).(isset($ParametersArray['recipient_company']) ? $ParametersArray['recipient_company'] : null).(isset($ParametersArray['recipient_first_name']) ? $ParametersArray['recipient_first_name'] : null).(isset($ParametersArray['recipient_last_name']) ? $ParametersArray['recipient_last_name'] : null).(isset($ParametersArray['recipient_address_street']) ? $ParametersArray['recipient_address_street'] : null).(isset($ParametersArray['recipient_address_building']) ? $ParametersArray['recipient_address_building'] : null).(isset($ParametersArray['recipient_address_apartment']) ? $ParametersArray['recipient_address_apartment'] : null).(isset($ParametersArray['recipient_address_postcode']) ? $ParametersArray['recipient_address_postcode'] : null).(isset($ParametersArray['recipient_address_city']) ? $ParametersArray['recipient_address_city'] : null).(isset($ParametersArray['application']) ? $ParametersArray['application'] : null). (isset($ParametersArray['application_version']) ? $ParametersArray['application_version'] : null). (isset($ParametersArray['warranty']) ? $ParametersArray['warranty'] : null). (isset($ParametersArray['bylaw']) ? $ParametersArray['bylaw'] : null). (isset($ParametersArray['personal_data']) ? $ParametersArray['personal_data'] : null). (isset($ParametersArray['credit_card_number']) ? $ParametersArray['credit_card_number'] : null). (isset($ParametersArray['credit_card_expiration_date_year']) ? $ParametersArray['credit_card_expiration_date_year'] : null). (isset($ParametersArray['credit_card_expiration_date_month']) ? $ParametersArray['credit_card_expiration_date_month'] : null). (isset($ParametersArray['credit_card_security_code']) ? $ParametersArray['credit_card_security_code'] : null). (isset($ParametersArray['credit_card_store']) ? $ParametersArray['credit_card_store'] : null). (isset($ParametersArray['credit_card_store_security_code']) ? $ParametersArray['credit_card_store_security_code'] : null). (isset($ParametersArray['credit_card_customer_id']) ? $ParametersArray['credit_card_customer_id'] : null). (isset($ParametersArray['credit_card_id']) ? $ParametersArray['credit_card_id'] : null). (isset($ParametersArray['blik_code']) ? $ParametersArray['blik_code'] : null). (isset($ParametersArray['credit_card_registration']) ? $ParametersArray['credit_card_registration'] : null). (isset($ParametersArray['surcharge_amount']) ? $ParametersArray['surcharge_amount'] : null). (isset($ParametersArray['surcharge']) ? $ParametersArray['surcharge'] : null). (isset($ParametersArray['surcharge']) ? $ParametersArray['surcharge'] : null). (isset($ParametersArray['ignore_last_payment_channel']) ? $ParametersArray['ignore_last_payment_channel'] : null). (isset($ParametersArray['vco_call_id']) ? $ParametersArray['vco_call_id'] : null). (isset($ParametersArray['vco_update_order_info']) ? $ParametersArray['vco_update_order_info'] : null). (isset($ParametersArray['vco_subtotal']) ? $ParametersArray['vco_subtotal'] : null). (isset($ParametersArray['vco_shipping_handling']) ? $ParametersArray['vco_shipping_handling'] : null). (isset($ParametersArray['vco_tax']) ? $ParametersArray['vco_tax'] : null). (isset($ParametersArray['vco_discount']) ? $ParametersArray['vco_discount'] : null). (isset($ParametersArray['vco_gift_wrap']) ? $ParametersArray['vco_gift_wrap'] : null). (isset($ParametersArray['vco_misc']) ? $ParametersArray['vco_misc'] : null). (isset($ParametersArray['vco_promo_code']) ? $ParametersArray['vco_promo_code'] : null). (isset($ParametersArray['credit_card_security_code_required']) ? $ParametersArray['credit_card_security_code_required'] : null). (isset($ParametersArray['credit_card_operation_type']) ? $ParametersArray['credit_card_operation_type'] : null). (isset($ParametersArray['credit_card_avs']) ? $ParametersArray['credit_card_avs'] : null). (isset($ParametersArray['credit_card_threeds']) ? $ParametersArray['credit_card_threeds'] : null);
	
	foreach ($MultiMerchantList as $item)
	{
		foreach($item as $key => $value) {
			$chk = $chk.
			(isset($value) ? $value : null);
		}
	}
	return $chk;
}

function GenerateChkDotpayRedirection ($DotpayId, $DotpayPin, $Environment, $RedirectionMethod, $ParametersArray, $MultiMerchantList) {
	$ParametersArray['id'] = $DotpayId;
	$ChkParametersChain = GenerateChk($DotpayId, $DotpayPin, $Environment, $RedirectionMethod, $ParametersArray,$MultiMerchantList);
	//echo $ChkParametersChain;
	$ChkValue = hash('sha256',$ChkParametersChain);
	if ($Environment == 'production') $EnvironmentAddress = 'https://ssl.dotpay.pl/t2/';
	else if ($Environment == 'test') $EnvironmentAddress = 'https://ssl.dotpay.pl/test_payment/';
	
	if ($RedirectionMethod == 'POST') {
		$RedirectionCode = '<form action="'.$EnvironmentAddress.'" method="POST" id="dotpay_redirection_form">'.PHP_EOL;
		foreach($ParametersArray as $key => $value) {
			$RedirectionCode .= "\t".'<input name="'.$key.'" value="'.$value.'" type="hidden"/>'.PHP_EOL;
		}
                $RedirectionCode .='<input type="submit" value="ok" /></form>';
		return $RedirectionCode;
	}
	else if ($RedirectionMethod == 'GET') {
		$RedirectionCode = $EnvironmentAddress.'?';
		foreach($ParametersArray as $key => $value) {
		$RedirectionCode .= $key.'='.rawurlencode($value).'&';
		}
		foreach ($MultiMerchantList as $item)
		{
		foreach($item as $key => $value) {
		$RedirectionCode .= $key.'='.rawurlencode($value).'&';
		}
		}
		$RedirectionCode .= 'chk='.$ChkValue;
		return $RedirectionCode;
	}
}
    
function set_reservation_in_db($type, $conditions, $persons, $client, $formalAgreements, $services_optional, $res_id) {
    global $wpdb;
    $wpdb->insert( 
        'wp_reservation_params', 
        array( 
            'type' => $type, 
            'conditions' => json_encode($conditions),
            'persons' => json_encode($persons),
            'client' => json_encode($client),
            'formalAgreements' => json_encode($formalAgreements),
            'services_optional' => json_encode($services_optional),
            'res_id' => $res_id
        ), 
        array( 
            '%s', 
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
        ) 
    );
    return $wpdb->insert_id;
}
    
function get_reservation_from_db($id) {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT * FROM  `wp_reservation_params` WHERE id = {$id}" );
    return array($row->type, json_decode($row->conditions), json_decode($row->persons), json_decode($row->client), json_decode($row->formalAgreements), json_decode($row->services_optional), $row->res_id);
}
      
function set_reservation_in_mds($id, $new_type = NULL) {

    list($type, $conditions, $persons, $client, $formalAgreements, $services_optional, $res_id) = get_reservation_from_db($id);
    if(!empty($new_type)) {
        $type = $new_type;  
    }
   
    $xml = new XMLWriter(); 
    $xml->openMemory(); 
    $xml->startDocument('1.0', 'UTF-8');
			 
    $xml->startElement('mds');

        $xml->startElement('auth');
            $xml->writeElement('login', esc_attr( get_option('login')));
                $xml->writeElement('pass', esc_attr( get_option('password')));
                $xml->writeElement('source', 'MDSWS');
                $xml->writeElement('srcDomain', 'citytravel.pl');
            $xml->endElement();

            $xml->startElement('request');
                $xml->writeElement('type', $type);
                $xml->startElement('conditions');
                    if(!empty($conditions)) {
                        foreach($conditions as $key=>$val) {
                            $xml->writeElement($key, $val);
                        }
                    }
                $xml->endElement();		
                $xml->startElement('forminfo');
                    $xml->startElement('persons');
                    if(!empty($persons)) {
                        foreach($persons as $key=>$val) {
                            $xml->startElement('person');
                                $xml->writeAttribute('int', $key);
                                $xml->writeElement('gender', $val->gender);
                                $xml->writeElement('lastname', $val->lastname);
                                $xml->writeElement('firstname', $val->firstname);
                                $xml->writeElement('birthdate', date('d.m.Y', $val->birthdate));
                                $xml->writeElement('name', $val->name);
                                $xml->writeElement('passport', $val->passport);
                                $xml->writeElement('zipcode', $val->zipcode);
                                $xml->writeElement('street', $val->street);
                                $xml->writeElement('email', $val->email);
                                if(empty($val->address)) 
                                    $val->address = $client->address;
                                $xml->writeElement('address', $val->address);
                                if(empty($val->post_code)) 
                                    $val->post_code = $client->post_code;
                                $xml->writeElement('post_code', $val->post_code);
                                if(empty($val->city)) 
                                    $val->city = $client->city;
                                $xml->writeElement('city', $val->city);
                                if(empty($val->phone)) 
                                    $val->phone = $client->phone;
                                $xml->writeElement('phone', $val->phone);
                                $xml->writeElement('passport_number', '1234');
                            $xml->endElement();	    
                        }
                    }
                    $xml->endElement();	
                    $xml->startElement('client');
                        $xml->writeElement('type', $client->type);
                        $xml->writeElement('gender', $client->gender);
                        $xml->writeElement('firstname', $client->firstname);
                        $xml->writeElement('lastname', $client->lastname);
                        $xml->writeElement('post_code', $client->post_code);
                        $xml->writeElement('post_city', $client->post_city);
                        $xml->writeElement('city', $client->city);
                        $xml->writeElement('address', $client->address);
                        $xml->writeElement('phone', $client->phone);
                        $xml->writeElement('workphone', $client->phone);
                        $xml->writeElement('cellphone', $client->phone);
                        $xml->writeElement('fax', $client->phone);
                        $xml->writeElement('email_address', $client->email_address);
                        $xml->writeElement('email', $client->email_address);
                        $xml->writeElement('taxidentifier', $client->taxidentifier);
                        $xml->writeElement('country', $client->country);  
                        $xml->writeElement('birthdate', date('d.m.Y', $persons[0]->birthdate));
                        $xml->writeElement('name', $client->name);
                        $xml->writeElement('street', $client->street);
                        $xml->writeElement('zipcode', $client->zipcode);
                    $xml->endElement();
                    $xml->writeElement('client_birthdate', '15.12.1988');
                    if(!empty($services_optional)) {
                        $xml->startElement('services_optional');
                        foreach($services_optional as $key=>$val) {
                            $xml->startElement('service');
                                $xml->writeAttribute('int', $key);
                                $xml->writeElement('codeElemType', $val->codeElemType);
                                $xml->writeElement('codeOptServType', $val->codeOptServType);
                                $xml->writeElement('code', $val->code);
                                $xml->writeElement('type', $val->type);
                                $xml->writeElement('checked', $val->checked);
                                if(!empty($val->allocations)) {
                                    $xml->startElement('allocations');
                                    foreach($val->allocations as $akey => $alloc) {
                                        $xml->startElement('allocate');
                                            $xml->writeAttribute('int', $akey);
                                            $xml->writeElement('value', $alloc->value);
                                            $xml->writeElement('checked', $alloc->checked);
                                        $xml->endElement();	  
                                    }
                                    $xml->endElement();	  
                                }
                                $xml->writeElement('date_from', $val->date_from);
                                $xml->writeElement('date_to', $val->date_to);
                            $xml->endElement();	    
                        }
                        $xml->endElement();	
                    }
                    if(!empty($formalAgreements)) {
                        $xml->startElement('formalAgreements');
                        foreach($formalAgreements as $key=>$val) {
                            $xml->startElement('formalAgreement');
                                $xml->writeAttribute('int', $key);
                                if(!empty($val->code)) $xml->writeElement('code', $val->code);
                                if(!empty($val->selected)) $xml->writeElement('selected', $val->selected);
                            $xml->endElement();	    
                        }
                        $xml->endElement();	
                    }
                    $xml->writeElement('includeTFGservice', 1);
                $xml->endElement();		
            $xml->endElement();

        $xml->endElement();
    $xml->endDocument();   

    //wysyłka do MerlinX-a
    $xml_response_string = post_xml($GLOBALS['mds_url_booking'], $xml->outputMemory(true));   

    if(!$xml_response_string) {
        die('ERROR');
    }
        
    $xml_array = new SimpleXMLElement($xml_response_string);
    if(!empty($xml_array)) {
        $booking_number_tab = (array)$xml_array->result['bookingNumber'];
        $booking_number = $booking_number_tab[0];
        if(!empty($booking_number)) {
            update_field('field_5c813ef33367f', $booking_number, $res_id);
        }
        $currency = $xml_array->pricetotal['operCurrency'];
    }
    else {
        $booking_number = 'T'.$res_id;
        $currency = 'PLN';
    }

    $data = array('persons' => $persons, 'booking_number' => $booking_number, 'kwota_zaliczki' => $_POST['kwota_zaliczki'],
        'currency' => $currency, 'res_id' => $res_id, 'conditions' => $conditions);

    //sprawdzamy czy można zrobić opcję
    if($type=='check') {
        if($xml_array->result['msgCode']==740 || $xml_array->result['msgCode']==712 || $xml_array->result['msgCode']==726) {  
            return set_reservation_in_mds($id, 'optionbooking');
        } 
        else {
            $result = $xml_array->result['msgText'];
            $page_path = get_page_by_path($_POST['xCode'],OBJECT,'hotels');
            if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); 
            $link = add_query_arg(array('oferta' => $_POST['id_oferty'], 'msg' => urlencode($result)), get_permalink($page_path));
            wp_redirect($link);exit;
        }
    }
    elseif($xml_array->status!='ERROR') {
        if($xml_array->result['msgCode']==200) {
            //tu wyślij maila
            $body = (!empty($new_type)) ? get_email_body('cititravel-potwierdzenie-rezerwacji-z-przelewem', $data) :
                get_email_body('cititravel-potwierdzenie-rezerwacji-zwyklej', $data);
            }       
            else {
                return set_reservation_in_mds($id, 'book');
            }
        }

    if(!empty($body)) {
	$headers = 'From: Cititravel.pl <admin@cititravel.pl>' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8'. "\r\n";
	   
	if(!empty($booking_number)) {
            wp_mail(array($client->email_address), 'Rezerwacja ze strony Cititravel.pl', $body, $headers);
            return $booking_number;     
        }    
    }
    else {
        return false;
    }
}
    
add_action('wp_ajax_rezerwacja', 'process_rezerwacja');
add_action('wp_ajax_nopriv_rezerwacja', 'process_rezerwacja');

function process_rezerwacja() {
    if ( empty($_POST) || !wp_verify_nonce($_POST['rezerwacja'],'rezerwacja') ) {
	echo 'You targeted the right function, but sorry, your nonce did not verify.';
	wp_redirect(get_site_url());
    } else {
        $persons = array();
                    
        $my_reservation = array(
            'post_title'    => $_POST['imie']." ".$_POST['nazwisko'],
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'reservations'
        );
        
        $res_id = wp_insert_post( $my_reservation );
        $type = ($_POST['iCheck']=='telefonicznie') ? 0 : 1;
        update_field('field_5b1026dcae59a', $type, $res_id);
        $kwota = ($_POST['iCheck_price']=='calosc') ? 0 : 1;
        update_field('field_5b1026f4ae59b', $kwota, $res_id);
        $payment = ($_POST['iCheck_payment']=='online') ? 0 : 1;
        update_field('field_5b1026fdae59c', $payment, $res_id);
        update_field('field_5b102715ae59d', 'new', $res_id);
        update_field('field_5b10274bae59f', $_POST['price'], $res_id);
                    
        update_field('field_5b10278a2c450', $_POST['plec'], $res_id);
        update_field('field_5b10279a2c451', $_POST['imie'], $res_id);
        update_field('field_5b1027a12c452', $_POST['nazwisko'], $res_id);
        update_field('field_5b1027a72c453', $_POST['ulica'], $res_id);
        update_field('field_5b109f8a5c125', $_POST['numer_domu'], $res_id);
        update_field('field_5b1027b02c454', $_POST['kod_pocztowy'], $res_id);
        update_field('field_5b1027b72c455', $_POST['miasto'], $res_id);
        update_field('field_5b1027bc2c456', $_POST['numer_telefonu'], $res_id);
        update_field('field_5b1027c72c457', $_POST['email'], $res_id);
                  
        $client = new stdClass();
        $client->type = 'person';
        $client->gender = 'H';
        $client->firstname = $_POST['imie'];
        $client->lastname = $_POST['nazwisko'];
        $client->name = $_POST['imie'].' '.$_POST['nazwisko'];
        $client->post_code = $_POST['kod_pocztowy'];
        $client->post_city = $_POST['miasto'];
        $client->city = $_POST['miasto'];
        $client->address = $_POST['ulica']." ".$_POST['numer_domu'];
        $client->phone = $_POST['numer_telefonu'];
        $client->workphone = $_POST['numer_telefonu'];
        $client->cellphone = $_POST['numer_telefonu'];
        $client->fax = $_POST['numer_telefonu'];
        $client->email_address = $_POST['email'];
        $client->email = $_POST['email'];
        $client->taxidentifier = '';
        $client->country = 'PL';
        $client->birthdate = date('d.m.Y', $_POST['data_urodzenia']);
        $client->street = $_POST['ulica'];
        $client->zipcode = $_POST['kod_pocztowy'];
              
        update_field('field_5b102851f43ae', $_POST['dorosly1_plec'], $res_id);
        update_field('field_5b102860f43af', $_POST['dorosly1_imie'], $res_id);
        update_field('field_5b102876f43b0', $_POST['dorosly1_nazwisko'], $res_id);
        update_field('field_5b102883f43b1', $_POST['dorosly1_data_urodzenia'], $res_id);
        update_field('field_5b102893f43b2', $_POST['dorosly1_cena'], $res_id);
        
        $person1 = new stdClass();
        $person1->gender = $_POST['dorosly1_plec'];
        $person1->lastname = $_POST['dorosly1_nazwisko'];
        $person1->firstname = $_POST['dorosly1_imie'];
        $person1->name = $_POST['dorosly1_imie'].' '.$_POST['dorosly1_nazwisko'];
        //$person1->passport = 1;
        //$person1->zipcode = '65-035';
        //$person1->city = 'Poznań';
        //$person1->street = 'erwer';
        //$person1->phone = '432532';
        //$person1->email = 'regina.szulc@artagency.pl';
        $person1->birthdate = date('d.m.Y', strtotime($_POST['dorosly1_data_urodzenia']));
        $persons[] = $person1;
                    
        if(!empty($_POST['dorosly2_plec'])) {
            update_field('field_5b10289ef43b3', $_POST['dorosly2_plec'], $res_id);
            update_field('field_5b1028aaf43b4', $_POST['dorosly2_imie'], $res_id);
            update_field('field_5b1028b1f43b5', $_POST['dorosly2_nazwisko'], $res_id);
            update_field('field_5b1028b7f43b6', $_POST['dorosly2_data_urodzenia'], $res_id);
            update_field('field_5b1028bdf43b7', $_POST['dorosly2_cena'], $res_id);
                       
            $person2 = new stdClass();
            $person2->gender = $_POST['dorosly2_plec'];
            $person2->lastname = $_POST['dorosly2_nazwisko'];
            $person2->firstname = $_POST['dorosly2_imie'];
            $person2->birthdate = date('d.m.Y', strtotime($_POST['dorosly2_data_urodzenia']));
            $person2->name = $_POST['dorosly2_imie'].' '.$_POST['dorosly2_nazwisko'];
            //$person2->passport = 1;
            //$person2->zipcode = '65-035';
            //$person2->city = 'Poznań';
            //$person2->street = 'erwer';
            //$person2->phone = '432532';
            //$person2->email = 'regina.szulc@artagency.pl';
            $persons[] = $person2;
        }
                    
        if(!empty($_POST['dorosly3_plec'])) {
            update_field('field_5b10a220b1ae9', $_POST['dorosly3_plec'], $res_id);
            update_field('field_5b10a226b1aea', $_POST['dorosly3_imie'], $res_id);
            update_field('field_5b10a22cb1aeb', $_POST['dorosly3_nazwisko'], $res_id);
            update_field('field_5b10a233b1aec', $_POST['dorosly3_data_urodzenia'], $res_id);
            update_field('field_5b10a23db1aed', $_POST['dorosly3_cena'], $res_id);
                        
            $person3 = new stdClass();
            $person3->gender = $_POST['dorosly3_plec'];
            $person3->lastname = $_POST['dorosly3_nazwisko'];
            $person3->firstname = $_POST['dorosly3_imie'];
            $person3->birthdate = date('d.m.Y', strtotime($_POST['dorosly3_data_urodzenia']));
            $persons[] = $person3;
        }
                    
        if(!empty($_POST['dziecko1_plec'])) {
            update_field('field_5b105a19ee8e9', $_POST['dziecko1_plec'], $res_id);
            update_field('field_5b105a23ee8eb', $_POST['dziecko1_imie'], $res_id);
            update_field('field_5b105a28ee8ec', $_POST['dziecko1_nazwisko'], $res_id);
            update_field('field_5b105a2bee8ed', $_POST['dziecko1_data_urodzenia'], $res_id);
            update_field('field_5b105a2fee8ee', $_POST['dziecko1_cena'], $res_id);
                      
            $person4 = new stdClass();
            $person4->gender = $_POST['dziecko1_plec'];
            $person4->lastname = $_POST['dziecko1_nazwisko'];
            $person4->firstname = $_POST['dziecko1_imie'];
            $person4->birthdate = date('d.m.Y', strtotime($_POST['dziecko1_data_urodzenia']));
            $persons[] = $person4;
        }
                    
        if(!empty($_POST['dziecko2_plec'])) {
            update_field('field_5b105a78ee8f0', $_POST['dziecko2_plec'], $res_id);
            update_field('field_5b105a7bee8f1', $_POST['dziecko2_imie'], $res_id);
            update_field('field_5b105a86ee8f2', $_POST['dziecko2_nazwisko'], $res_id);
            update_field('field_5b105a8bee8f3', $_POST['dziecko2_data_urodzenia'], $res_id);
            update_field('field_5b105a8fee8f4', $_POST['dziecko2_cena'], $res_id);
                       
            $person5 = new stdClass();
            $person5->gender = $_POST['dziecko2_plec'];
            $person5->lastname = $_POST['dziecko2_nazwisko'];
            $person5->firstname = $_POST['dziecko2_imie'];
            $person5->birthdate = date('d.m.Y', strtotime($_POST['dziecko2_data_urodzenia']));
            $persons[] = $person5;
        }
                    
        update_field('field_5b105b2a0cb76', $_POST['id_oferty'], $res_id);
        update_field('field_5b105b310cb77', $_POST['hotel'], $res_id);
        update_field('field_5b105b370cb78', $_POST['kierunek'], $res_id);
        $attachment = media_sideload_image($_POST['zdjecie'], $res_id, '', 'id');
        update_field('field_5b105b3c0cb79', $attachment, $res_id);  
        update_field('field_5b105b440cb7a', $_POST['dlugosc_pobytu'], $res_id);
        update_field('field_5b105b4b0cb7b', $_POST['data_wyjazdu'], $res_id);
        update_field('field_5b105b540cb7c', $_POST['data_powrotu'], $res_id);
        update_field('field_5b105b5d0cb7d', $_POST['wylot_z'], $res_id);
        update_field('field_5b105b640cb7e', $_POST['zakwaterowanie'], $res_id);
        update_field('field_5b105b6a0cb7f', $_POST['wyzywienie'], $res_id);
        update_field('field_5b105b740cb80', $_POST['kod_oferty'], $res_id);
        update_field('field_5b105b790cb81', $_POST['organizator'], $res_id);
        update_field('field_5b105b7f0cb82', $_POST['paszport'], $res_id);
        update_field('field_5c73e53b2d91f', $_POST['kategoria'], $res_id);
        update_field('field_5b102715ae59d', 'new', $res_id);

        $conditions = array(
            'par_adt' => (int)$_POST['par_adt'],
            'par_chd' => (int)$_POST['par_chd'],
            'par_inf' => 0,
            'currency' => 'PLN',
            'ofr_id' => $_POST['id_oferty'],
            'ofr_tourOp' => $_POST['tour_op'],
            'language' => 'PL');
                  
        $services_optional = array();
        $formalAgreements = array();
                    
        $new_agreement = new stdClass();
        $new_agreement->code = 'conditions';
        $new_agreement->selected = 1;
                    
        $allocations = array();
        $all = new stdClass();
        $all->value = 1;
        $all->checked = 0;
        $allocations[] = $all;
                   
        $formalAgreements[] = $new_agreement;
                    
        /*$new_service = new stdClass();
        $new_service->codeElemType = 'M';
        $new_service->codeOptServType = 'A';
        $new_service->code = 'MARZENIE';
        $new_service->type = 'Usługa dodatkowa';
        $new_service->checked = 0;
        $new_service->allocations = $allocations;
        $new_service->date_from = '30.04.2018';
        $new_service->date_to = '30.06.2018';
                    
        $services_optional[] = $new_service;
                             
        $page_path = get_page_by_path($_POST['xCode'],OBJECT,'hotels');
        if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); 
        $link = add_query_arg(array('oferta' => $_POST['id_oferty'], 'msg' => urlencode($result)), get_permalink($page_path));*/

        send_sms_to_group('reservation');
        send_sms_to_number($_POST['numer_telefonu'], 'reservation');
        
        if($_POST['iCheck']=='telefonicznie') {
            $data = array('persons' => $persons, 'booking_number' => 'T'.$res_id, 'kwota_zaliczki' => $_POST['kwota_zaliczki'],
                'currency' => 'PLN', 'res_id' => $res_id, 'conditions' => (object)$conditions);
            $body = get_email_body('cititravel-potwierdzenie-rezerwacji-telefonicznej', $data);
            $headers = 'From: Cititravel.pl <admin@cititravel.pl>' . "\r\n";
            $headers .= 'Content-Type: text/html; charset=UTF-8'. "\r\n";
	   
            if(!empty($res_id)) {
		wp_mail(array($_POST['email']), 'Rezerwacja ze strony Cititravel.pl', $body, $headers);
            }    
            wp_redirect('http://cititravel.pl/podziekowanie-za-zamowienie'); 
        }
        elseif($_POST['iCheck_payment']=='dotpay') {
            $new_res_id = set_reservation_in_db('check', $conditions, $persons, $client, $formalAgreements, $services_optional, $res_id);  
            set_reservation_in_mds($new_res_id);
            $price = ($_POST['iCheck_price']=='zaliczka') ? $_POST['kwota_zaliczki'] : $_POST['price'];
            $ParametersArray = array (
                "api_version" => "dev",
                "amount" => (float)$price,
                "currency" => "PLN",
                "description" => $_POST['kod_oferty'],
                "type" => "0",
                "url" => 'https://cititravel.pl/podziekowanie-za-zamowienie',
                "urlc" => "https://cititravel.pl/check_reservation.php?res_id=".$res_id,
                "firstname" => $_POST['imie'],
                "lastname" => $_POST['nazwisko'],
                "email" => $_POST['email'],
                "street" => $_POST['ulica'],
                "street_n1" => $_POST['numer_domu'],
                "city" => $_POST['miasto'],
                "postcode" => $_POST['kod_pocztowy'],
                "phone" => $_POST['numer_telefonu'],
                "country" => "POL",
                "ignore_last_payment_channel" => "true"
            );            
                    
            $redirect_link = GenerateChkDotpayRedirection ("110397","9LfsjK7IgRgtFrtC4otfkJN1r0ZaqWtK", "production", "GET", $ParametersArray,array());
            // $redirect_link = GenerateChkDotpayRedirection ("752142","OOJWPmry0nQ7boE9nsdhVCzlfKCh1s97", "test", "GET", $ParametersArray,array());
            wp_redirect($redirect_link);exit;
        }
        else {
            $id = set_reservation_in_db('check', $conditions, $persons, $client, $formalAgreements, $services_optional, $res_id); 
            if(set_reservation_in_mds($id)>0) {
                wp_redirect('http://cititravel.pl/podziekowanie-za-zamowienie'); 
            }
        }
    }
}
        
function get_email_body($template, $data) {
     
    $body = file_get_contents(get_template_directory() .'/emails/'.$template.'.php'); 
    $persons = $data['persons'];
    $booking_number = $data['booking_number'];
    $kwota_zaliczki = $data['kwota_zaliczki'];
    $currency = $data['currency'];
    $res_id = $data['res_id'];
    $conditions = $data['conditions'];

    if(!empty($body)) {
        $arr_from_pt = array('{$gender}', '{$firstname}', '{$lastname}', '{$birthdate}');
        $persons_table = '';
        if(!empty($persons)) {
            foreach($persons as $person) {
                $gender = ($person->gender=='F') ? 'Pani' : 'Pan';
                $arr_to_pt = array($gender, $person->firstname, $person->lastname, $person->birthdate);
                $pt = file_get_contents(get_template_directory() .'/emails/persons_table.php');  
                $persons_table .= str_replace($arr_from_pt, $arr_to_pt, $pt);
            }
        }
             
        $arr_from = array('{$numer_rezerwacji}', '{$hotel}', '{$kierunek}', '{$dlugosc_pobytu}', '{$data_wyjazdu}', '{$data_powrotu}',
			'{$wylot_z}', '{$zakwaterowanie}', '{$wyzywienie}', '{$kod_oferty}', '{$organizator}', '{$liczba_uczestnikow}',
			'{$cena}', '{$persons_table}', '{$kwota_zaliczki}', '{$logo}', '{$kategoria}', '{$hotel_link}');
                
        $hotel = get_field('field_5b105b310cb77', $res_id);
        $kierunek = get_field('field_5b105b370cb78', $res_id);
        $dlugosc_pobytu = get_field('field_5b105b440cb7a', $res_id);
        $data_wyjazdu = get_field('field_5b105b4b0cb7b', $res_id);
        $data_powrotu = get_field('field_5b105b540cb7c', $res_id);
        $wylot_z = get_field('field_5b105b5d0cb7d', $res_id);
        $zakwaterowanie = get_field('field_5b105b640cb7e', $res_id);
        $wyzywienie = get_field('field_5b105b6a0cb7f', $res_id);
        $kod_oferty = get_field('field_5b105b740cb80', $res_id);
        $organizator = get_field('field_5b105b790cb81', $res_id);
        $zdjecie = get_field('field_5b105b3c0cb79', $res_id);
        $cena = get_field('field_5b10274bae59f', $res_id);
        $kategoria = (int)get_field('field_5c73e53b2d91f', $res_id);
        if(!empty($zdjecie)) {
            if(is_array($zdjecie)) $zd = $zdjecie['url'];
            else $zd = $zdjecie;
            $logo = "<img src=".$zd." moz-do-not-send='true' width='350'>";
        }
        
        if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); 
        $link = add_query_arg(array('oferta' => $conditions->ofr_id), get_permalink($page_path));
           
        if($kategoria>=10 && $kategoria<20) {
            $new_kategoria = '<img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true">';
        }
        elseif($kategoria>=20 && $kategoria<30) {
            $new_kategoria = '<img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true">';
        }
        elseif($kategoria>=30 && $kategoria<40) {
            $new_kategoria = '<img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true">';
        }
        elseif($kategoria>=40 && $kategoria<50) {
            $new_kategoria = '<img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true">';
        }
        elseif($kategoria>=50) {
            $new_kategoria = '<img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true"><img src="https://cititravel.pl/wp-content/themes/cititravel_theme/img/gwiazdka.png" alt="" class="gw" moz-do-not-send="true">';
        }
        else {
            $new_kategoria='';   
        }
        
        $ilosc = $conditions->par_adt+$conditions->par_chd;
        $arr_to = array($booking_number, $hotel, $kierunek, $dlugosc_pobytu, $data_wyjazdu, $data_powrotu, $wylot_z, $zakwaterowanie,
			$wyzywienie, $kod_oferty, $organizator, $ilosc, $cena." ".$currency, $persons_table,
                        $kwota_zaliczki." ".$currency, $logo, $new_kategoria, $link);
  
	$body = str_replace($arr_from, $arr_to, $body);
        return $body;
    }
    return NULL;
}

function sms_send($params, $token, $backup = false)
{

    static $content;

    if ($backup == true) {
        $url = 'https://api2.smsapi.pl/sms.do';
    } else {
        $url = 'https://api.smsapi.pl/sms.do';
    }

    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, $params);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $token"
    ));

    $content = curl_exec($c);
    $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);

    if ($http_status != 200 && $backup == false) {
        $backup = true;
        sms_send($params, $token, $backup);
    }

    curl_close($c);
    return $content;
}

function send_sms_to_group($type) {
    $token = "DemZiVnZDWMFZBspjqyujUnx654DY4sDrhdmAALs";
    $msg = ($type=='request') ? 'Wyslano zapytanie ogolne na biuro@cititravel.pl ze strony Cititravel.pl' : "W konsoli serwisu pojawila sie nowa rezerwacja/zapytanie. Pobierz z CMS.";
    $params = array(   
        'group'         => 'Konsultanci',     
        'from' => 'Cititravel',
        'message' => $msg
    );
    return sms_send($params, $token);
}

function send_sms_to_number($number, $type) {
    $message = ($type=='request') ? 'Dziekujemy za zlozenie zapytania w portalu Cititravel.pl. Nasz Konsultant skontaktuje sie z Panstwem najszybciej jak to bedzie mozliwe w celu dokonczenia rezerwacji.
Pozdrawiamy
Zespol www.cititravel.pl
tel. 224875555' : 'Dziekujemy za dokonanie rezerwacji w portalu Cititravel.pl. Nasz Konsultant skontaktuje sie z Panstwem najszybciej jak to bedzie mozliwe w celu potwierdzenia dostepnosci miejsc. 
Pozdrawiamy 
Zespol www.cititravel.pl
tel. 224875555';
    
    if($type == 'client') {
        $message = 'Dziekujemy za wyslanie zapytania, nasi konsultanci skontaktuja sie z Panstwem.
Pozdrawiamy
Zespol www.cititravel.pl
tel. 224875555';
    }
    $token = "DemZiVnZDWMFZBspjqyujUnx654DY4sDrhdmAALs";
    $params = array(   
        'to'         => $number,     
        'from' => 'Cititravel', 
        'message' => $message
    );
    return sms_send($params, $token);
}

add_action('parse_request', 'check_sms_url_handler');

function check_sms_url_handler() {
    if(strpos($_SERVER["REQUEST_URI"], '/check_sms') !== false) {  
        echo send_sms_to_number('695522915', 'request');
        echo send_sms_to_number('695522915', 'reservation');
        exit;
    }
}