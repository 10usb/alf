<?php
namespace alf;

interface Packable {
	/**
	 * Returns the minimal width this container/element will consume
	 * @return number
	 */
	public function getMinimalWidth();
	
	/**
	 * Returns the calculated width this container/element will consume
	 * @return number
	 */
	public function getCalulatedWidth();
	
	/**
	 * Packs the content and when needed splits into multiple instances that are then returned 
	 * @param number $width
	 * @return self[]|false
	 */
	public function pack($width);
}