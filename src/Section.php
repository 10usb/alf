<?php
namespace alf;

class Section implements Block, Inline, Container {
	/**
	 * 
	 * @var array
	 */
	private $border;
	
	/**
	 * 
	 * @var array
	 */
	private $padding;
	
	/**
	 * 
	 * @var \alf\Container
	 */
	private $contents;
}