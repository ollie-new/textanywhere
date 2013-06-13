textanywhere
============

Lightweight CodeIgniter library for Textanywhere: www.textanywhere.net

This is just a little lib for Textanywhere's TextEmail service - http://www.textanywhere.net/sms-services/text-email-gateway.aspx

Usage:

    //load the textanywhere lib
    $this->load->library('textanywhere');

    //set some vars
    $email_from = 'email.address@domain.com'; //email address to send SMS from
    $sms_from_name = 'SMS From name';         //name to appear as 'from' in the SMS header<br>
    $smtp_host = 'Email host';                //your email host
    $smtp_user = 'email username';            //username for your email host
    $smtp_pass = 'supersecret';               //password for your email host

    //configure textanywhere
    $textanywhere_config['email_from'] = $email_from;
    $textanywhere_config['sms_from_name'] = $sms_from_name;
    $textanywhere_config['smtp_host'] = $smtp_host;
    $textanywhere_config['smtp_user'] = $smtp_user;
    $textanywhere_config['smtp_pass'] = $smtp_pass;

    $this->textanywhere->initialize($textanywhere_config);

    //send an SMS
    $this->textanywhere->send_sms($mobile_number, $message);
