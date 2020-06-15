<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WoocommerceIR_SMS_Gateways {

	public $mobile = array();
	public $message = '';
	public $senderNumber = '';

	private $username = '';
	private $password = '';

	private static $_instance;

	public static function init() {
		if ( ! self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->username     = PWooSMS()->Options( 'sms_gateway_username' );
		$this->password     = PWooSMS()->Options( 'sms_gateway_password' );
		$this->senderNumber = PWooSMS()->Options( 'sms_gateway_sender' );
	}

	public static function get_sms_gateway() {

		$gateway = array(
			'sunwaysms'     => 'SunwaySMS.com',
			'parandsms'     => 'ParandSMS.ir',
			'gamapayamak'   => 'GAMAPayamak.com',
			'limoosms'      => 'LimooSMS.com',
			'smsfa'         => 'SMSFa.ir',
			'aradsms'       => 'Arad-SMS.ir',
			'farapayamak'   => 'FaraPayamak.ir',
			'payamafraz'    => 'PayamAfraz.com',
			'niazpardaz'    => 'SMS.NiazPardaz.com',
			'niazpardaz_'   => 'Login.NiazPardaz.ir',
			'yektasms'      => 'Yektatech.ir',
			'smsbefrest'    => 'SmsBefrest.ir',
			'relax'         => 'Relax.ir',
			'paaz'          => 'Paaz.ir',
			'postgah'       => 'Postgah.info',
			'idehpayam'     => 'IdehPayam.com',
			'azaranpayamak' => 'Azaranpayamak.ir',
			'smsir'         => 'SMS.ir',
			'manirani'      => 'Manirani.ir',
			'tjp'           => 'TJP.ir',
			'websms'        => 'S1.Websms.ir',
			'payamresan'    => 'Payam-Resan.com',
			'bakhtarpanel'  => 'Bakhtar.xyz',
			'parsgreen'     => 'ParsGreen.com',
			'avalpayam'     => 'Avalpayam.com',
			'iransmsserver' => 'IranSmsServer.com',
			'melipayamak'   => 'MeliPayamak.com',
			'loginpanel'    => 'LoginPanel.ir',
			'smshooshmand'  => 'SmsHooshmand.com',
			'smsfor'        => 'SMSFor.ir',
			'chaparpanel'   => 'ChaparPanel.IR',
			'firstpayamak'  => 'FirstPayamak.ir',
			'netpaydar'     => 'SMS.Netpaydar.com',
			'smspishgaman'  => 'Panel.SmsPishgaman.com',
			'parsianpayam'  => 'ParsianPayam.ir',
			'hostiran'      => 'Hostiran.com',
			'iransms'       => 'IranSMS.co',
			'negins'        => 'Negins.com',
			'kavenegar'     => 'Kavenegar.com',
			'afe'           => 'Afe.ir',
			'aradpayamak'   => 'Aradpayamak.net',
			'isms'          => 'ISms.ir',
			'razpayamak'    => 'RazPayamak.com',
			'_0098'         => '0098SMS.com',
			'sefidsms'      => 'SefidSMS.ir',
			'chapargah'     => 'Chapargah.ir',
			'hafezpayam'    => 'HafezPayam.com',
			'mehrpanel'     => 'MehrPanel.ir',
			'kianartpanel'  => 'KianArtPanel.ir',
			'farstech'      => 'Sms.FarsTech.ir',
			'berandet'      => 'Berandet.ir',
			'nicsms'        => 'NikSms.com',
			'asanak'        => 'Asanak.ir',
			'ssmss'         => 'SSMSS.ir',
			'hiro_sms'      => 'Hiro-Sms.com',
			'sabanovin'     => 'SabaNovin.com',
			'trez'          => 'SmsPanel.Trez.ir',
			'raygansms'     => 'RayganSms.com',
			'sepahansms'    => 'SepahanSms.com (SepahanGostar.com)',
			'_3300'         => 'Sms.3300.ir',
			'smsnegar'      => 'Sms.SmsNegar.com',
			'behsadade'     => 'Sms.BehsaDade.com',
			'flashsms'      => 'FlashSms.ir (AdminPayamak.ir)',
			'payamsms'      => 'PayamSms.com',
			'hadafwp'      	=> 'sms.hadafwp.Com',
			'mehrafraz'    	=> 'mehrafraz.com',
			'irpayamak'     => 'IRPayamak.Com',
			'gamasystems'	=> 'Gama.systems',
			'smsmelli'		=> 'SMSMelli.com',
			'kavenegar_lookUp'	=> 'Kavenegar.com(lookup)',
			'atlaspayamak'	=> 'Atlaspayamak.ir',
		);

		return apply_filters( 'pwoosms_sms_gateways', $gateway );
	}

	public function tjp() {

		$response = false;
		$username = $this->username;
		$password = $this->password;

		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		//$from     = $this->senderNumber;
		$to      = $this->mobile;
		$massage = $this->message;

		try {

			$client = new SoapClient( 'http://sms-login.tjp.ir/webservice/?WSDL', array(
				'login'    => $username,
				'password' => $password
			) );

			$client->sendToMany( $to, $massage );

		} catch ( SoapFault $sf ) {
			$sms_response = $sf->getMessage();
		}

		if ( empty( $sms_response ) ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function hostiran() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function mehrpanel() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client = new SoapClient( "http://87.107.121.52/post/send.asmx?wsdl" );

			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}
	
	
	public function hadafwp() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client = new SoapClient( "http://sms.hadafwp.com/Post/Send.asmx?wsdl" );

			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function parandsms() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client = new SoapClient( "http://87.107.121.52/post/send.asmx?wsdl" );

			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function aradsms() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client = new SoapClient( "http://arad-sms.ir/post/send.asmx?wsdl" );

			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function smsbefrest() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client = new SoapClient( "http://87.107.121.52/post/send.asmx?wsdl" );

			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function relax() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://onlinepanel.ir/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function farstech() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://sms.farstech.ir/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function kianartpanel() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://onlinepanel.ir/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function smspishgaman() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		$to       = $this->mobile;

		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 3 ) == '%2B' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '%2b' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			if ( substr( $uNumber, 0, 1 ) == '0' ) {
				$ret = substr( $uNumber, 1 );
			}
			$to[ $i ] = '98' . $ret;
		}

		PWooSMS()->nusoap();

		try {
			$client                   = new nusoap_client( 'http://82.99.216.45/services/?wsdl', true );
			$client->soap_defencoding = 'UTF-8';
			$client->decode_utf8      = false;

			$results = $client->call( 'Send', array(
				'username'  => $username,
				'password'  => $password,
				'srcNumber' => $from,
				'body'      => $massage,
				'destNo'    => $to,
				'flash'     => '0'
			) );

			$error = array();
			foreach ( $results as $result ) {
				if ( ! isset( $result['Mobile'] ) || stripos( $result['ID'], 'e' ) !== false ) {
					$error[] = $result;
				}
			}

			if ( empty( $error ) ) {
				return $response = true;//success
			}
		} catch ( Exception $e ) {
			$response = $e->getMessage();
		}

		return $response;
	}

	public function paaz() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://sms.paaz.ir/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function farapayamak() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function parsianpayam() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client     = new SoapClient( "http://onepayam.ir/API/Send.asmx?wsdl" );
			$encoding   = "UTF-8";
			$parameters = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'flash'    => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);

			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 0 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function iransmsserver() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://sms.iransmsserver.ir/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function niazpardaz() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function niazpardaz_() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://185.13.231.178/SendService.svc?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'userName'       => $username,
				'password'       => $password,
				'fromNumber'     => $from,
				'toNumbers'      => $to,
				'messageContent' => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'        => false,
				'udh'            => "",
				'recId'          => array( 0 ),
				'status'         => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSMSResult;

		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( strval( $sms_response ) == '0' ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}



	public function payamafraz() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://payamafraz.ir/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function yektasms() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function gamapayamak() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function limoosms() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function smsfa() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( 'http://smsfa.net/API/Send.asmx?WSDL' );
			$sms_response = $client->SendSms(
				array(
					'username' => $username,
					'password' => $password,
					'from'     => $from,
					'to'       => $to,
					'text'     => $massage,
					'flash'    => false,
					'udh'      => ''
				)
			)->SendSmsResult;
		} catch ( SoapFault $sf ) {
			$sms_response = $sf->getMessage();
		}
		if ( intval( $sms_response ) > 0 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function postgah() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( 'http://postgah.net/API/Send.asmx?WSDL' );
			$sms_response = $client->SendSms(
				array(
					'username' => $username,
					'password' => $password,
					'from'     => $from,
					'to'       => $to,
					'text'     => $massage,
					'flash'    => false,
					'udh'      => ''
				)
			)->SendSmsResult;
		} catch ( SoapFault $sf ) {
			$sms_response = $sf->getMessage();
		}
		if ( strval( $sms_response ) == '0' ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function azaranpayamak() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( 'http://azaranpayamak.ir/API/Send.asmx?WSDL' );
			$sms_response = $client->SendSms(
				array(
					'username' => $username,
					'password' => $password,
					'from'     => $from,
					'to'       => $to,
					'text'     => $massage,
					'flash'    => false,
					'udh'      => ''
				)
			)->SendSmsResult;
		} catch ( SoapFault $sf ) {
			$sms_response = $sf->getMessage();
		}
		if ( strval( $sms_response ) == '0' ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function manirani() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( 'http://sms.manirani.ir/API/Send.asmx?WSDL' );
			$sms_response = $client->SendSms(
				array(
					'username' => $username,
					'password' => $password,
					'from'     => $from,
					'to'       => $to,
					'text'     => $massage,
					'flash'    => false,
					'udh'      => ''
				)
			)->SendSmsResult;
		} catch ( SoapFault $sf ) {
			$sms_response = $sf->getMessage();
		}

		if ( intval( $sms_response ) > 0 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function smsir() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to = implode( ',', $this->mobile );

		$content = 'user=' . rawurlencode( $username ) .
		           '&pass=' . rawurlencode( $password ) .
		           '&to=' . rawurlencode( $to ) .
		           '&lineNo=' . rawurlencode( $from ) .
		           '&text=' . rawurlencode( $massage );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'https://ip.sms.ir/SendMessage.ashx?' . $content );
		curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$sms_response = curl_exec( $ch );
		curl_close( $ch );

		if ( strtolower( $sms_response ) == 'ok' || stripos( $sms_response, 'ارسال با موفقیت انجام شد' ) !== false ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}
	
	public function smsmelli() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to = implode( ',', $this->mobile );

		$content = 'uname=' . rawurlencode( $username ) .
		           '&pass=' . rawurlencode( $password ) .
		           '&to=' . rawurlencode( $to ) .
		           '&from=' . rawurlencode( $from ) .
		           '&msg=' . rawurlencode( $massage );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'http://185.4.31.182/class/sms/webservice/send_url.php?' . $content );
		curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$sms_response = curl_exec( $ch );
		curl_close( $ch );

		if ( strtolower( $sms_response ) == 'ok' || stripos( $sms_response, 'done' ) !== false ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function netpaydar() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to = implode( ',', $this->mobile );

		$content = 'user=' . rawurlencode( $username ) .
		           '&pass=' . rawurlencode( $password ) .
		           '&to=' . rawurlencode( $to ) .
		           '&lineNo=' . rawurlencode( $from ) .
		           '&text=' . rawurlencode( $massage );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'http://sms.netpaydar.com/SendMessage.ashx?' . $content );
		curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$sms_response = curl_exec( $ch );
		curl_close( $ch );

		if ( strtolower( $sms_response ) == 'ok' || stripos( $sms_response, 'ارسال با موفقیت انجام شد' ) !== false ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function afe() {

		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return false;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$errors = array();
		foreach ( $this->mobile as $mobile ) {

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, 'http://www.afe.ir/Url/SendSMS?username=' . $username . '&Password=' . $password . '&Number=' . $from . '&mobile=' . $mobile . '&sms=' . urlencode( $massage ) );
			curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );

			if ( empty( $sms_response ) || stripos( $sms_response, 'success' ) === false ) {
				$errors[] = $sms_response;
			}
		}

		if ( empty( $errors ) ) {
			return $response = true;//success
		} else {
			$response = $errors;
		}

		return $response;
	}

	public function iransms() {

		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return false;
		}

		$errors = array();

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		foreach ( $this->mobile as $mobile ) {

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, 'http://www.iransms.co/URLSend.aspx?Username=' . $username . '&Password=' . $password . '&PortalCode=' . $from . '&Mobile=' . $mobile . '&Message=' . urlencode( $massage ) . '&Flash=0' );
			curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );

			if ( abs( $sms_response ) < 30 ) {
				$errors[] = $sms_response;
			}
		}

		if ( empty( $errors ) ) {
			return $response = true;//success
		} else {
			$response = $errors;
		}

		return $response;
	}

	public function negins() {

		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return false;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$errors = array();

		foreach ( $this->mobile as $mobile ) {

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, 'http://negins.com/URLSend.aspx?Username=' . $username . '&Password=' . $password . '&PortalCode=' . $from . '&Mobile=' . $mobile . '&Message=' . urlencode( $massage ) . '&Flash=0' );
			curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );

			if ( abs( $sms_response ) < 30 ) {
				$errors[] = $sms_response;
			}
		}

		if ( empty( $errors ) ) {
			return $response = true;//success
		} else {
			$response = $errors;
		}

		return $response;
	}


	public function hafezpayam() {
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return false;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$errors = array();

		foreach ( $this->mobile as $mobile ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, 'http://hafezpayam.com/URLSend.aspx?Username=' . $username . '&Password=' . $password . '&PortalCode=' . $from . '&Mobile=' . $mobile . '&Message=' . urlencode( $massage ) . '&Flash=0' );
			curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );

			if ( abs( $sms_response ) < 30 ) {
				$errors[] = $sms_response;
			}
		}

		if ( empty( $errors ) ) {
			return $response = true;//success
		} else {
			$response = $errors;
		}

		return $response;
	}

	public function smshooshmand() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = $this->mobile;

		PWooSMS()->nusoap();

		$client = new nusoap_client( "http://185.4.28.100/class/sms/webservice/server.php?wsdl" );

		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8      = true;
		$client->setCredentials( $username, $password, "basic" );

		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 3 ) == '%2B' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '%2b' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			if ( substr( $uNumber, 0, 1 ) == '0' ) {
				$ret = substr( $uNumber, 1 );
			}
			$to[ $i ] = '+98' . $ret;
		}

		$parameters = array(
			'from'       => $from,
			'rcpt_array' => $to,
			'msg'        => $massage,
			'type'       => 'normal'
		);

		$result = $client->call( "enqueue", $parameters );
		if ( ( isset( $result['state'] ) && $result['state'] == 'done' ) && ( isset( $result['errnum'] ) && ( $result['errnum'] == '100' || $result['errnum'] == 100 ) ) ) {
			return $response = true;//success
		} else {
			$response = $result;
		}

		return $response;
	}

	public function smsfor() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}
		$to = $this->mobile;

		PWooSMS()->nusoap();

		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 3 ) == '%2B' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '%2b' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			if ( substr( $uNumber, 0, 1 ) == '0' ) {
				$ret = substr( $uNumber, 1 );
			}
			$to[ $i ] = '0' . $ret;
		}

		$client                   = new nusoap_client( 'http://www.smsfor.ir/webservice/soap/smsService.php?wsdl', 'wsdl' );
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8      = false;

		$params = array(
			'username'         => $username,
			'password'         => $password,
			'sender_number'    => array( $from ),
			'receiver_number'  => $to,
			'note'             => array( $massage ),
			'date'             => array(),
			'request_uniqueid' => array(),
			'flash'            => false,
			'onlysend'         => 'ok',
		);
		$md_res = $client->call( "send_sms", $params );

		if ( empty( $md_res['getMessage()'] ) && empty( $md_res['getMessage()'] ) && is_numeric( str_ireplace( ',', '', $md_res[0] ) ) ) {
			return $response = true;//success
		} else {
			$response = $md_res;
		}

		return $response;
	}

	public function idehpayam() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$soap = new SoapClient( "http://panel.idehpayam.com/webservice/send.php?wsdl" );

			$soap->Username = $username;
			$soap->Password = $password;
			$soap->fromNum  = $from;
			$soap->toNum    = $to;
			$soap->Content  = $massage;
			$soap->Type     = '0';

			$result = $soap->SendSMS( $soap->fromNum, $soap->toNum, $soap->Content, $soap->Type, $soap->Username, $soap->Password );

			if ( ! empty( $result[0] ) && $result[0] > 100 ) {
				return $response = true;//success
			} else {
				$response = $result;
			}

			return $response;

		} catch ( SoapFault $e ) {
			return $e->getMessage();
		}
	}

	public function websms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( ',', $this->mobile );

		$content = 'cusername=' . rawurlencode( $username ) .
		           '&cpassword=' . rawurlencode( $password ) .
		           '&cmobileno=' . rawurlencode( $to ) .
		           '&csender=' . rawurlencode( $from ) .
		           '&cbody=' . rawurlencode( $massage );

		$sms_response = file_get_contents( 'http://s1.websms.ir/wservice.php?' . $content );
		if ( strlen( $sms_response ) > 8 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function bakhtarpanel() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( ',', $this->mobile );

		PWooSMS()->nusoap();

		$client = new nusoap_client( 'http://login.bakhtar.xyz/webservice/server.asmx?wsdl' );

		$status = explode( ',', ( $client->call( 'Sendsms', array(
			'4',
			$from,
			$username,
			$password,
			'98',
			$massage,
			$to,
			false
		) ) ) );

		if ( count( $status ) > 1 && $status[0] == 1 ) {
			return $response = true;//success
		} else {
			$response = $status;
		}

		return $response;
	}



	public function melipayamak() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function payamresan() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( ',', $this->mobile );

		$content = 'http://www.payam-resan.com/APISend.aspx?UserName=' . rawurlencode( $username ) .
		           '&Password=' . rawurlencode( $password ) .
		           '&To=' . rawurlencode( $to ) .
		           '&From=' . rawurlencode( $from ) .
		           '&Text=' . rawurlencode( $massage );

		if ( extension_loaded( 'curl' ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $content );
			curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$sms_response = file_get_contents( $content );
		}

		if ( strtolower( $sms_response ) == '1' || $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;

	}

	public function kavenegar() {

		$response = false;
		$username = $this->username;
		//    $password = $this->password;
		$from    = $this->senderNumber;
		$massage = $this->message;
		if ( empty( $username ) ) {
			return $response;
		}

		$messages = urlencode( $massage );
		$to       = implode( ',', $this->mobile );

		$url = "https://api.kavenegar.com/v1/$username/sms/send.json?sender=$from&receptor=$to&message=$messages";

		if ( extension_loaded( 'curl' ) ) {
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$sms_response = @file_get_contents( $url );
		}

		if ( false !== $sms_response ) {
			$json_response = json_decode( $sms_response );
			if ( ! empty( $json_response->return->status ) && $json_response->return->status == 200 ) {
				return $response = true;//success
			}
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}

	public function parsgreen() {
		$response = false;
		$username = $this->username;
		//  $password = $this->password;
		$from    = $this->senderNumber;
		$massage = $this->message;
		if ( empty( $username ) ) {
			return $response;
		}

		$to = $this->mobile;

		try {
			$url =  'http://sms.parsgreen.ir/Apiv2/Message/SendSms';
			$req= array('SmsBody'=>$massage,'Mobiles'=>$to);
			$ch = curl_init($url);
			$jsonDataEncoded = json_encode($req);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$header = array('authorization: BASIC APIKEY:' . $username, 'Content-Type: application/json;charset=utf-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$result = curl_exec($ch);
			$res = json_decode($result);
			curl_close($ch);
		} catch (Exception $ex) {
			return $response="error";
		}
		if($res->R_Success)
		{
			return $response = true;
		}else {
			$response=$res->R_Message;
		}

		return $response;
	}
	
	public function kavenegar_lookUp() {

		$response = false;
		$username = $this->username;
		//    $password = $this->password;
		$from    = $this->senderNumber;
		$massage = $this->message;
		if ( empty( $username ) ) {
			return $response;
		}

		
		$messages = urlencode( $massage );
		$to       = implode( ',', $this->mobile );

		//return $messages ;
		$params=explode("\n", $massage);
		$tokens=explode(",", $params[0]);
		$lookupValues=explode(",", $params[1]);

		$templateName=end($tokens);
		$tokensParam="";
		
		for ($i = 0; $i <= count($lookupValues) ; $i++) 
		{
			$tokenName=$tokens[$i];
			$lookupval=$lookupValues[$i];
			
			if((strcasecmp($tokenName, 'token10') != 0) && (strcasecmp($tokenName, 'token20') != 0))
			{
				$lookupval=str_replace(' ', '-', $lookupval);
			}

			if($tokens[$i]!=$templateName)	
			{
				$tokensParam.= "&".$tokenName."=".$lookupval;
			}				
			 
		} 

		$templateName=trim($templateName);

		$url = "http://api.kavenegar.com/v1/$username/verify/lookup.json?receptor=$to&template=$templateName".$tokensParam;

		if ( extension_loaded( 'curl' ) ) {
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$sms_response = @file_get_contents( $url );
		}

		if ( false !== $sms_response ) {
			$json_response = json_decode( $sms_response );
			if ( ! empty( $json_response->return->status ) && $json_response->return->status == 200 ) {
				return $response = true;//success
			}
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}

	public function avalpayam() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}
		$to = $this->mobile;


		PWooSMS()->nusoap();

		$client = new nusoap_client( "http://www.avalpayam.com/class/sms/webservice/server.php?wsdl" );

		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8      = true;
		$client->setCredentials( $username, $password, "basic" );

		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 3 ) == '%2B' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '%2b' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			if ( substr( $uNumber, 0, 1 ) == '0' ) {
				$ret = substr( $uNumber, 1 );
			}
			$to[ $i ] = '+98' . $ret;
		}

		$parameters = array(
			'from'       => $from,
			'rcpt_array' => $to,
			'msg'        => $massage,
			'type'       => 'normal'
		);

		$result = $client->call( "enqueue", $parameters );
		if ( ( isset( $result['state'] ) && $result['state'] == 'done' ) && ( isset( $result['errnum'] ) && ( $result['errnum'] == '100' || $result['errnum'] == 100 ) ) ) {
			return $response = true;//success
		} else {
			$response = $result;
		}

		return $response;
	}

	public function loginpanel() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://87.107.121.52/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}
	
	public function atlaspayamak() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://4646.ir/post/send.php?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function chaparpanel() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://87.107.121.52/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function firstpayamak() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client = new SoapClient( "http://ui.firstpayamak.ir/webservice/v2.asmx?WSDL" );
			$params = array(
				'username'         => $username,
				'password'         => $password,
				'recipientNumbers' => $to,
				'senderNumbers'    => array( $from ),
				'messageBodies'    => array( $massage ),
			);

			$sms_response = $client->SendSMS( $params );
			$sms_response = (array) $sms_response->SendSMSResult->long;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( is_array( $sms_response ) ) {
			foreach ( array_filter( $sms_response ) as $send ) {
				if ( $send > 1000 ) {
					return $response = true;//success
				}
			}
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}


	public function aradpayamak() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;

		$massage = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( ';', $this->mobile );

		try {

			$client             = new SoapClient( "http://aradpayamak.net/APPs/SMS/WebService.php?wsdl" );
			$sendsms_parameters = array(
				'domain'   => 'aradpayamak.net',
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => $massage,
				'isflash'  => 0,
			);

			$sms_response = call_user_func_array( array( $client, 'sendSMS' ), $sendsms_parameters );

			if ( ! empty( $sms_response ) ) {
				return $response = true;//success
			}

		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}

	public function isms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;

		$massage = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$data = array(
			'username' => $username,
			'password' => $password,
			'mobiles'  => $this->mobile,
			'body'     => $massage,
			'sender'   => $from,
		);

		$data = http_build_query( $data );
		$ch   = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'http://ws3584.isms.ir/sendWS' );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		$result = json_decode( curl_exec( $ch ), true );
		if ( ! empty( $result["code"] ) && ! empty( $result["message"] ) ) {
			$response = $result;
		} else {
			return $response = true;//success
		}

		return $response;
	}

	public function razpayamak() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client       = new SoapClient( "http://37.228.138.118/post/send.asmx?wsdl" );
			$encoding     = "UTF-8";
			$parameters   = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);
			$sms_response = $client->SendSms( $parameters )->SendSmsResult;
		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function _0098() {

		$username  = $this->username;
		$password  = $this->password;
		$from      = $this->senderNumber;
		$recievers = $this->mobile;
		$massage   = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return false;
		}

		$errors = array();

		foreach ( (array) $recievers as $to ) {

			$content = 'http://www.0098sms.com/sendsmslink.aspx?DOMAIN=0098' .
			           '&USERNAME=' . rawurlencode( $username ) .
			           '&PASSWORD=' . rawurlencode( $password ) .
			           '&FROM=' . rawurlencode( $from ) .
			           '&TO=' . rawurlencode( $to ) .
			           '&TEXT=' . rawurlencode( $massage );

			if ( extension_loaded( 'curl' ) ) {
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $content );
				curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				$sms_response = curl_exec( $ch );
				curl_close( $ch );
			} else {
				$sms_response = file_get_contents( $content );
			}
			$sms_response = intval( $sms_response );

			if ( $sms_response !== 0 ) {
				$errors[ $to ] = $sms_response;
			}
		}

		if ( empty( $errors ) ) {
			return $response = true;//success
		} else {
			$response = $errors;
		}

		return $response;

	}

	public function sefidsms() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {
			$client     = new SoapClient( "http://api.sefidsms.ir/post/send.asmx?wsdl" );
			$encoding   = "UTF-8";
			$parameters = array(
				'username' => $username,
				'password' => $password,
				'from'     => $from,
				'to'       => $to,
				'text'     => iconv( $encoding, 'UTF-8//TRANSLIT', $massage ),
				'isflash'  => false,
				'udh'      => "",
				'recId'    => array( 0 ),
				'status'   => 0
			);

			$sms_response = $client->SendSms( $parameters )->SendSmsResult;

		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $sms_response == 1 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function chapargah() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$massage = iconv( 'UTF-8', 'UTF-8//TRANSLIT', $massage );

		try {
			$client       = new SoapClient( 'http://panel.chapargah.ir/API/Send.asmx?WSDL' );
			$sms_response = $client->SendSms(
				array(
					'username' => $username,
					'password' => $password,
					'from'     => $from,
					'to'       => $to,
					'text'     => $massage,
					'flash'    => false,
					'recId'    => array( 0 ),
					'status'   => 0
				)
			)->SendSmsResult;
		} catch ( SoapFault $sf ) {
			$sms_response = $sf->getMessage();
		}
		if ( strval( $sms_response ) == '0' ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}



	public function berandet() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}


		PWooSMS()->nusoap();

		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 3 ) == '%2B' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '%2b' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			if ( substr( $uNumber, 0, 1 ) == '0' ) {
				$ret = substr( $uNumber, 1 );
			}
			$to[ $i ] = '+98' . $ret;
		}

		$timeout                  = 1800;
		$response_timeout         = 180;
		$client                   = new nusoap_client( "http://berandet.ir/Modules/DevelopmentTools/Groups/Messaging/MessagingWbs.php?wsdl", true, false, false, false, false, $timeout, $response_timeout, '' );
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8      = false;
		$client->response_timeout = $response_timeout;
		$client->timeout          = $timeout;

		$parameter = array(
			'request' => array(
				'username'   => $username,
				'password'   => $password,
				'fromNumber' => $from,
				'message'    => $massage,
				'recieptor'  => $to,
			)
		);

		$result = $client->call( 'sendMessageOneToMany', $parameter );
		$result = json_decode( $result, true );

		if ( ( isset( $result['errCode'] ) && $result['errCode'] < 0 ) || ! empty( $result['err'] ) ) {
			$response = $result;
		} else {
			return $response = true;//success
		}

		return $response;
	}

	public function nicsms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$param = array(
			'username'     => $username,
			'password'     => $password,
			'message'      => $massage,
			'numbers'      => implode( ',', $to ),
			'senderNumber' => $from,
			'sendOn'       => date( 'yyyy/MM/dd-hh:mm' ),
			'sendType'     => 1
		);

		$handler = curl_init( "http://niksms.com/fa/PublicApi/GroupSms" );
		curl_setopt( $handler, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt( $handler, CURLOPT_POSTFIELDS, $param );
		curl_setopt( $handler, CURLOPT_RETURNTRANSFER, true );
		$_response = curl_exec( $handler );
		curl_close( $handler );

		$_response = json_decode( $_response );
		$_response = ! empty( $_response->Status ) ? $_response->Status : 2;

		if ( $_response === 1 || strtolower( $_response ) == 'successful' ) {
			return $response = true;//success
		} else {
			$response = $_response;
		}

		return $response;
	}
	
	
	public function irpayamak() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to = implode( '-', $to );
		$to = str_ireplace( '+98', '0', $to );

		$ch = curl_init( 'http://irpayamak.com/API/SendSms.ashx?username=' . $username . '&password=' . $password . '&from=' . $from . '&to=' . $to . '&message=' . urlencode( trim( $massage ) ) );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Accept: text/html',
			'Connection: Keep-Alive',
			'Content-type: application/x-www-form-urlencoded;charset=UTF-8'
		) );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		$result = curl_exec( $ch );
		curl_close( $ch );

		if ( preg_match( '/\[.*\]/is', (string) $result ) ) {
			return $response = true;//success
		} else {
			$response = $result;
		}

		return $response;
	}

	public function asanak() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to = implode( '-', $to );
		$to = str_ireplace( '+98', '0', $to );

		$ch = curl_init( 'http://panel.asanak.ir/webservice/v1rest/sendsms?username=' . $username . '&password=' . $password . '&source=' . $from . '&destination=' . $to . '&message=' . urlencode( trim( $massage ) ) );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Accept: text/html',
			'Connection: Keep-Alive',
			'Content-type: application/x-www-form-urlencoded;charset=UTF-8'
		) );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		$result = curl_exec( $ch );
		curl_close( $ch );

		if ( preg_match( '/\[.*\]/is', (string) $result ) ) {
			return $response = true;//success
		} else {
			$response = $result;
		}

		return $response;
	}

	public function ssmss() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to      = implode( ",", $to );
		$massage = urlencode( $massage );

		try {

			$param = "login_username=$username&login_password=$password&receiver_number=$to&note_arr=$massage&sender_number=$from";

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, "http://ssmss.ir/webservice/rest/sms_send?$param" );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$results = curl_exec( $ch );
			curl_close( $ch );
			$results = json_decode( $results );

			$response = $results;

			if ( isset( $results->error ) ) {
				$response = $results->error;
			} elseif ( ! empty( $results->result ) && $results->result && ! empty( $results->list ) ) {
				return $response = true;//success
			}

			return $response;

		} catch ( Exception $ex ) {
			return $ex->getMessage();
		}
	}

	public function hiro_sms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$soap = new SoapClient( "http://my.hiro-sms.com/wbs/send.php?wsdl" );

			$soap->Username = $username;
			$soap->Password = $password;
			$soap->fromNum  = $from;
			$soap->toNum    = $to;
			$soap->Content  = $massage;
			$soap->Type     = '0';

			$result = $soap->SendSMS( $soap->fromNum, $soap->toNum, $soap->Content, $soap->Type, $soap->Username, $soap->Password );

			if ( ! empty( $result[0] ) && $result[0] > 100 ) {
				return $response = true;//success
			} else {
				$response = $result;
			}

			return $response;

		} catch ( SoapFault $e ) {
			return $e->getMessage();
		}
	}


	public function sabanovin() {

		$response = false;
		$api_key  = $this->username;
		//$password = $this->password;
		$from    = $this->senderNumber;
		$to      = $this->mobile;
		$massage = $this->message;
		if ( empty( $api_key ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to      = implode( ",", $to );
		$massage = urlencode( $massage );

		try {

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, "https://api.sabanovin.com/v1/$api_key/sms/send.json?gateway=$from&to=$to&text=$massage" );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$results = curl_exec( $ch );
			curl_close( $ch );
			$results = json_decode( $results );

			if ( ! empty( $results->status->code ) && $results->status->code == 200 ) {
				return $response = true;//success
			} else if ( ! empty( $results->status->message ) ) {
				$response = $results->status->code . ":" . $results->status->message;
			} else {
				$response = $results;
			}

			return $response;

		} catch ( Exception $ex ) {
			return $ex->getMessage();
		}
	}

	public function trez() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( '-', $this->mobile );

		$content = 'http://smspanel.trez.ir/SendGroupMessageWithUrl.ashx?Smsclass=1&Username=' . rawurlencode( $username ) .
		           '&Password=' . rawurlencode( $password ) .
		           '&RecNumber=' . rawurlencode( $to ) .
		           '&PhoneNumber=' . rawurlencode( $from ) .
		           '&MessageBody=' . rawurlencode( $massage );

		if ( extension_loaded( 'curl' ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $content );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$sms_response = file_get_contents( $content );
		}

		if ( ! empty( $sms_response ) && $sms_response >= 2000 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function raygansms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( '-', $this->mobile );

		$content = 'http://smspanel.trez.ir/SendGroupMessageWithUrl.ashx?Smsclass=1&Username=' . rawurlencode( $username ) .
		           '&Password=' . rawurlencode( $password ) .
		           '&RecNumber=' . rawurlencode( $to ) .
		           '&PhoneNumber=' . rawurlencode( $from ) .
		           '&MessageBody=' . rawurlencode( $massage );

		if ( extension_loaded( 'curl' ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $content );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$sms_response = file_get_contents( $content );
		}

		if ( ! empty( $sms_response ) && $sms_response >= 2000 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}

	public function sepahansms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client = new SoapClient( "http://www.sepahansms.com/smsSendWebServiceforphp.asmx?wsdl" );

			$sms_response = $client->SendSms( array(
				'UserName'     => $username,
				'Pass'         => $password,
				'Domain'       => 'sepahansms',
				'SmsText'      => array( $massage ),
				'MobileNumber' => $to,
				'SenderNumber' => $from,
				'sendType'     => 'StaticText',
				'smsMode'      => 'SaveInPhone'
			) )->SendSmsResult->long;

			if ( is_array( $sms_response ) || $sms_response > 1000 ) {
				return $response = true;//success
			}

		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}

	public function _3300() {
		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = $this->mobile;


		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = Trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 5 ) == '%2B98' ) {
				$ret = substr( $uNumber, 5 );
			}
			if ( substr( $uNumber, 0, 5 ) == '%2b98' ) {
				$ret = substr( $uNumber, 5 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			$to[ $i ] = '98' . $ret;
		}
		unset( $ret );


		PWooSMS()->nusoap();

		try {
			$client                   = new nusoap_client( 'http://sms.3300.ir/almassms.asmx?wsdl', 'wsdl', '', '', '', '' );
			$client->soap_defencoding = 'UTF-8';
			$client->decode_utf8      = true;

			$param  = array(
				'pUsername' => $username,
				'pPassword' => $password,
				'line'      => $from,
				'messages'  => array( 'string' => ( $massage ) ),
				'mobiles'   => array( 'string' => $to ),
				'Encodings' => array( 'int' => 2 ),
				'mclass'    => array( 'int' => 1 )
			);
			$result = $client->call( "Send", $param );
			$result = isset( $result['SendResult'] ) ? $result['SendResult'] : 0;

			if ( $result < 0 ) {
				return $response = true;//success
			} else {
				$response = $result;
			}

		} catch ( Exception $ex ) {
			$response = $ex->getMessage();
		}

		return $response;
	}
	
	public function gamasystems() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$to = implode( '-', $this->mobile );

		$content = 'http://sms.gama.systems/url/post/SendSMS.ashx?username=' . rawurlencode( $username ) .
		           '&password=' . rawurlencode( $password ) .
		           '&to=' . rawurlencode( $to ) .
		           '&from=' . rawurlencode( $from ) .
		           '&text=' . rawurlencode( $massage );

		if ( extension_loaded( 'curl' ) ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $content );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );
		} else {
			$sms_response = file_get_contents( $content );
		}

		if ( ! empty( $sms_response ) && $sms_response >= 11 ) {
			return $response = true;//success
		} else {
			$response = $sms_response;
		}

		return $response;
	}


	public function smsnegar() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}


		$domain = 'yazd';//todo: smspanel.eshare.ir

		try {

			$client = new SoapClient( "http://sms.smsnegar.com/webservice/Service.asmx?wsdl" );

			$result = $client->SendSms( array(
				"cUserName"     => $username,
				"cPassword"     => $password,
				"cDomainname"   => $domain,
				"cBody"         => $massage,
				"cSmsnumber"    => $to,
				"cGetid"        => "0",
				"nCMessage"     => "1",
				"nTypeSent"     => "1",
				"m_SchedulDate" => "",
				"nSpeedsms"     => "0",
				"nPeriodmin"    => "0",
				"cstarttime"    => "",
				"cEndTime"      => ""
			) );

			if ( ! empty( $result->SendSmsResult ) ) {

				$result  = $result->SendSmsResult;
				$results = explode( ',', $result );
				unset( $result );

				foreach ( $results as $result ) {
					if ( intval( $result ) < 1000 ) {
						$result       = $client->ShowError( array( "cErrorCode" => $result, "cLanShow" => "FA" ) );
						$sms_response = ! empty( $result->ShowErrorResult ) ? $result->ShowErrorResult : $results;
						break;
					}
				}
			} else {
				$sms_response = 'unknown';
			}
		} catch ( Exception $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( empty( $sms_response ) ) {
			return $response = true;//success
		}

		return $sms_response;
	}
	
	public function mehrafraz() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		

		try {

			$client = new SoapClient( "http://www.mehrafraz.com/webservice/service.asmx?wsdl" );

			$result = $client->SendSms( array(
				"cUserName"     => $username,
				"cPassword"     => $password,
				"cDomainname"   => $from,
				"cBody"         => $massage,
				"cSmsnumber"    => implode( ',', $to ),
				"cGetid"        => "0",
				"nCMessage"     => "1",
				"nTypeSent"     => "1",
				"m_SchedulDate" => "",
				"nSpeedsms"     => "0",
				"nPeriodmin"    => "0",
				"cstarttime"    => "",
				"cEndTime"      => ""
			) );

			if ( ! empty( $result->SendSmsResult ) ) {

				$result  = $result->SendSmsResult;
				$results = explode( ',', $result );
				unset( $result );

				foreach ( $results as $result ) {
					if ( intval( $result ) < 1000 ) {
						$result       = $client->ShowError( array( "cErrorCode" => $result, "cLanShow" => "FA" ) );
						$sms_response = ! empty( $result->ShowErrorResult ) ? $result->ShowErrorResult : $results;
						break;
					}
				}
			} else {
				$sms_response = 'unknown';
			}
		} catch ( Exception $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( empty( $sms_response ) ) {
			return $response = true;//success
		}

		return $sms_response;
	}

	public function behsadade() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$to       = implode( ",", $to );
		$massage  = urlencode( $massage );
		$username = urlencode( $username );
		$password = urlencode( $password );
		$from     = urlencode( $from );

		try {

			$param = "login_username=$username&login_password=$password&receiver_number=$to&note_arr=$massage&sender_number=$from";

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, "http://sms.behsadade.com/webservice/rest/sms_send?$param" );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$results = curl_exec( $ch );
			curl_close( $ch );
			$results = json_decode( $results );

			$response = $results;

			if ( isset( $results->error ) ) {
				$response = $results->error;
			} elseif ( ! empty( $results->result ) && $results->result && ! empty( $results->list ) ) {
				return $response = true;//success
			}

			return $response;

		} catch ( Exception $ex ) {
			return $ex->getMessage();
		}
	}
	
	
	


	public function flashsms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		try {

			$client = new SoapClient( "http://flashsms.ir/smsSendWebServiceforphp.asmx?wsdl" );

			$sms_response = $client->SendSms( array(
				'UserName'     => $username,
				'Pass'         => $password,
				'Domain'       => 'adminpayamak',
				'SmsText'      => array( $massage ),
				'MobileNumber' => $to,
				'SenderNumber' => $from,
				'sendType'     => 'StaticText',
				'smsMode'      => 'SaveInPhone'
			) )->SendSmsResult->long;

			if ( is_array( $sms_response ) || $sms_response > 1000 ) {
				return $response = true;//success
			}

		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}
	
	
	

	

	public function payamsms() {

		$response = false;
		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$to       = $this->mobile;
		$massage  = $this->message;
		if ( empty( $username ) || empty( $password ) ) {
			return $response;
		}

		$i = sizeOf( $to );
		while ( $i -- ) {
			$uNumber = trim( $to[ $i ] );
			$ret     = &$uNumber;
			if ( substr( $uNumber, 0, 3 ) == '%2B' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '%2b' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 4 ) == '0098' ) {
				$ret = substr( $uNumber, 4 );
			}
			if ( substr( $uNumber, 0, 3 ) == '098' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 3 ) == '+98' ) {
				$ret = substr( $uNumber, 3 );
			}
			if ( substr( $uNumber, 0, 2 ) == '98' ) {
				$ret = substr( $uNumber, 2 );
			}
			if ( substr( $uNumber, 0, 1 ) == '0' ) {
				$ret = substr( $uNumber, 1 );
			}
			$to[ $i ] = '98' . $ret;
		}

		try {

			$client = new SoapClient( 'http://beta.payamsms.com/wsdl?t=' . time(), array(
				'location' => 'http://beta.payamsms.com/soap',
				'uri'      => 'http://beta.payamsms.com/soap',
				'use'      => SOAP_LITERAL,
				'style'    => SOAP_DOCUMENT,
				'trace'    => 1
			) );

			$sms_response = $client->send( array(
				'userName'      => $username,
				'password'      => $password,
				'sourceNo'      => $from,
				'destNo'        => $to,
				'content'       => $massage,
				'sourcePort'    => 0,
				'destPort'      => 0,
				'messageType'   => 1,
				'clientId'      => null,
				'encoding'      => null,
				'dueTime'       => null,
				'longSupported' => false,
			) );

			if ( isset( $sms_response->sendReturn->status ) && $sms_response->sendReturn->status == 0 ) {
				return $response = true;//success
			} else {
				$sms_response = ! empty( $sms_response->sendReturn->status ) ? $sms_response->sendReturn->status : $sms_response->sendReturn;
			}

		} catch ( SoapFault $ex ) {
			$sms_response = $ex->getMessage();
		}

		if ( $response !== true ) {
			$response = $sms_response;
		}

		return $response;
	}
	
	
	public function sunwaysms() {

		$username = $this->username;
		$password = $this->password;
		$from     = $this->senderNumber;
		$massage  = $this->message;

		if ( empty( $username ) || empty( $password ) ) {
			return false;
		}

		if ( ! extension_loaded( 'curl' ) ) {
			return 'ماژول CURL رو سرور فعال نیست.';
		}

		$errors = array();
		foreach ( $this->mobile as $mobile ) {

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, 'http://sms.sunwaysms.com/SMSWS/HttpService.ashx?service=SendArray&username=' . $username . '&password=' . $password . '&from=' . $from . '&to=' . $mobile . '&message=' . urlencode( $massage ) );
			curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$sms_response = curl_exec( $ch );
			curl_close( $ch );

			if ( empty( $sms_response ) || $sms_response < 10000 ) {
				$errors[] = $sms_response;
			}
		}

		if ( empty( $errors ) ) {
			return $response = true;//success
		} else {
			$response = $errors;
		}

		return $response;
	}
}