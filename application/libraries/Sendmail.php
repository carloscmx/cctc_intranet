<?php if (!defined('BASEPATH')) exit('No se permite el acceso directo al script');



class Sendmail
{
	public function __construct()
	{
		$this->CI = &get_instance();
		$CI = &get_instance();
		$CI->load->library('email');
		$CI->load->model("M_DirectorioCorreo", "directorio");
	}

	//funcion para enviar mensajes 
	function sendmailMessage($id, $email, $asunto, $mensaje)
	{

		$CI = &get_instance();
		$CI->load->library('email');
		$CI->load->library('seguridad');

		$data = $this->CI->directorio->ObtenerDirectorios($id);
		$password = $this->CI->seguridad->desencriptar($data[0]->dr_password);

		$config = array(
			'protocol'  => $data[0]->sr_protocol,
			'smtp_host' => $data[0]->sr_smtp_host,
			'smtp_port' => $data[0]->sr_smtp_port,
			'smtp_user' => $data[0]->dr_email,
			'smtp_pass' => $password,
			'mailtype'  => "html",
			'charset'   => "utf-8",
			//'validate' => true
		);
		$this->CI->email->initialize($config);
		$this->CI->email->set_mailtype("html");
		$this->CI->email->set_newline("rn");



		$this->CI->email->to($email);
		$this->CI->email->from($data[0]->dr_email);
		$this->CI->email->subject($asunto);
		$this->CI->email->message($mensaje);


		return $this->CI->email->send();
	}
	/**
	 * setEmail
	 *
	 * Envia un mensaje.
	 * @param	string	$iddirectorio
	 * @param	string	$email
	 * @param	string	$asunto
	 * @param	string	$mensaje (html)
	 * @return	void
	 */
	function setEmail($iddirectorio, $email, $asunto, $mensaje)
	{
		return $this->sendmailMessage($iddirectorio, $email, $asunto, $mensaje);
	}
}
