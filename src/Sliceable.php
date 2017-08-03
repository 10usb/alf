<?php
namespace alf;

interface Sliceable {
	/**
	 * Returns the minimal height this container will consume
	 * @return number
	 */
	public function getMinimalHeight();
	
	/**
	 * Returns a slice of this element
	 * @param number $height
	 * @return self|false
	 */
	public function slice($height);
}