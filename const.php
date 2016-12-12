<?php
///
// SMS
///
define('SMS_TELCO_SHARE',               .45);

// define('SMS_PROVIDER_SHARE',            .85); // iNET
// define('SMS_PROVIDER_SHARE',            .88); // GAPIT (< 500 tr.)
// define('SMS_PROVIDER_SHARE',            .90); // GAPIT (> 500 tr.)
define('SMS_PROVIDER_SHARE',            0.8); // GAPIT (< 500 tr.)

// sms: NABEM (MV)
define('USER_COM_SHARE_SMS_PARTNER',    .0);
define('USER_COM_SHARE_SMS_K2',         .3); // sau khi chia cho partner
define('USER_COM_SHARE_SMS_MV',         .7);

// sms: NABEMpartner (K2's partners)
define('USER_WAP_SHARE_SMS_PARTNER',    .0);
define('USER_WAP_SHARE_SMS_K2',         .3); // sau khi chia cho partner
define('USER_WAP_SHARE_SMS_MV',         .7);

// sms: NABEMpartner (MV's partners)
define('USER_MV_SHARE_SMS_PARTNER',    .0); // HARDCODE
define('USER_MV_SHARE_SMS_K2',         .3); // sau khi chia cho partner
define('USER_MV_SHARE_SMS_MV',         .7);


///
// CARD
///
// define('CARD_PROVIDER_SHARE',           .85); // VMG
//define('CARD_PROVIDER_SHARE',           .87); // VNPT (< 1 ty)
define('CARD_PROVIDER_SHARE',           .80); // VNPT (< 1 ty)
// define('CARD_PROVIDER_SHARE',           .88); // VNPT (> 1 ty)

// MV
define('USER_COM_SHARE_CARD_PARTNER',   .0);
define('USER_COM_SHARE_CARD_K2',        .3); // sau khi chia cho partner
define('USER_COM_SHARE_CARD_MV',        .7);

// K2's partners
define('USER_WAP_SHARE_CARD_PARTNER',   .0);
define('USER_WAP_SHARE_CARD_K2',        .3); // sau khi chia cho partner
define('USER_WAP_SHARE_CARD_MV',        .7);

// MV's partners
define('USER_MV_SHARE_CARD_PARTNER',   .0); // HARDCODE
define('USER_MV_SHARE_CARD_K2',        .3); // sau khi chia cho partner
define('USER_MV_SHARE_CARD_MV',        .7);


///
// ELSE
///
define('K2_KEY',            'K2TEK');
define('SYNTAX_PREFIX',     'NABEM');
define('K2_CARD_CP',        'K2TEK');

$OWNCARD_PARTNERS = array(
        'mobivas', 'tocdo', 'gsm', 'appstore', 'vmg', 'starcom', 'mvupro'
        );

$MV_RECIPIENTS = array(
        8085, 8185, 8285, 8385, 8485, 8585, 8685, 8785,
        8038, 8138, 8238, 8338, 8438, 8538, 8638, 8738,
        6097, 6197, 6297, 6397, 6497, 6597, 6697, 6797,
        8069, 8169, 8269, 8369, 8469, 8569, 8669, 8769,
        8062, 8162, 8262, 8362, 8462, 8562, 8662, 8762,
        );
