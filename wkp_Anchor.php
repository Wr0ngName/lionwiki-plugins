<?php
/*
 * Adds an anchor in the page. Nobody thought about it before??
 *
 * Use syntax:
 *
 * {anchor:anchor_name}
 *
 * (c) Wr0ng.Name <https://wr0ng.name/> 2015. GPL
 */

class Anchor
{
	var $desc = array(
		array("Anchor", "adds anchors to the page. Syntax {anchor:the anchor name}.")
	);

	function formatBegin()
	{
		global $CON;
        $CON = preg_replace("/\{anchor:([a-zA-Z0-9_-]+)\}/U", "<a name=\"$1\" ></a>\n", $CON);
	}
}