<?php
/*
 * ReCaptcha plugin is simple spam filtering plugin. It asks user simple questions
 * (If today is saturday, what day is tomorrow?). It is active only when no
 * password protection is used.
 *
 * (c) Wr0ng.Name 2017.
 */

class ReCaptcha
{
	var $desc = array(
		array("ReCaptcha plugin", "is a spam filtering plugin using Google ReCaptcha.")
	);

	var $google_api_key;
	var $google_api_secret;
	var $permanent = true; // remember first correct answer and don't ask again
	var $cookie_password;
	var $use_javascript_autofill = false;

	function ReCaptcha()
	{
		global $PLUGINS_DIR;

		$this->google_api_key = "";		/* GOOGLE RECAPTCHA API ID */
		$this->google_api_secret = "";	/* GOOGLE RECAPTCHA API SECRET KEY */
		
		$this->cookie_password = md5($_SERVER["SCRIPT_FILENAME"] . date("Ymd") . $_SERVER["REMOTE_ADDR"]); // pseudo random string
	}

	/*
	 * This is for the possibility of authentization during the preview
	 */

	function actionBegin()
	{
		global $preview;

		if($_REQUEST["qid"] && $preview)
			$this->checkCaptcha();
	}

	function checkCaptcha()
	{
		global $PASSWORD, $error;

		if(!empty($PASSWORD) || ($this->permanent && $_COOKIE["LW_CAPTCHA"] == $this->cookie_password))
			return false;

		//First, we check if the field exists
		if(isset($_REQUEST['g-recaptcha-response'])){
			$captcha = $_REQUEST['g-recaptcha-response']; //It exists, we store the value
		}

		if(!$captcha)
			return true;

		//We ask google for the results of the captcha
		$check = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$this->google_api_secret."&response=".$captcha);

		//If the answer is false, this is a bot
		if($check.success == false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	 * By convention, writingPage hook is expected to return false if
	 * everything is ok and true if page should not be saved.
	 */

	function writingPage() { return $this->checkCaptcha(); }

	function template()
	{
		global $html, $PASSWORD, $action, $preview, $HEAD;

		if(($action != "edit" && !$preview) || !empty($PASSWORD)
			|| ($this->permanent && $_COOKIE["LW_CAPTCHA"] == $this->cookie_password))
			return;

		$html = template_replace("plugin:RECAPTCHA", "<div class=\"g-recaptcha\" data-sitekey=\"".$this->google_api_key."\"></div>", $html);

		$HEAD .= "<script src='https://www.google.com/recaptcha/api.js'></script>";
	}

	function commentsTemplate()
	{
		global $comments_html, $PASSWORD, $HEAD;

		if(!empty($PASSWORD) || ($this->permanent && $_COOKIE["LW_CAPTCHA"] == $this->cookie_password)) {
			$comments_html = template_replace("plugin:RECAPTCHA", "", $comments_html);

			return;
		}

		$comments_html = template_replace("plugin:RECAPTCHA", "<div class=\"g-recaptcha\" data-sitekey=\"".$this->google_api_key."\"></div>", $comments_html);

		$HEAD .= "<script src='https://www.google.com/recaptcha/api.js'></script>";
	}
}