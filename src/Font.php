<?php
namespace alf;

interface Font {
	/**
	 * 
	 * @return string
	 */
	public function getName();
	
	/**
	 *
	 * @return number
	 */
	public function getSize();
	
	/**
	 * 
	 * @param string $text
	 * @return number
	 */
	public function getTextWith($text);
}