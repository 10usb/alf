<?php
namespace alf;

interface Block extends Element {
	/**
	 * Sets a fixed height for this block
	 * @param number $height
	 */
	public function setPreferredHeight($height);
}