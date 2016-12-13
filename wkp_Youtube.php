<?php
/*
 * Adds youtube video without allowing for html content!
 *
 * Use syntax:
 *
 * {youtube:video_id}
 *
 * (c) Wr0ng.Name <https://wr0ng.name/> 2016. GPL
 */

class Youtube
{
	var $desc = array(
		array("Youtube", "adds youtube video without allowing for html content! Syntax {youtube:<the id of the video>}.")
	);

	function formatBegin()
	{
		global $CON;
        $CON = preg_replace("/\{youtube:([a-zA-Z0-9_-]+)\}/U", "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>\n", $CON);
	}
}