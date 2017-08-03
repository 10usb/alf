<?php
namespace alf;

class Body implements Container {
	/**
	 * 
	 * @var number
	 */
	private $width;
	
	/**
	 * 
	 * @var \alf\Block[]
	 */
	private $blocks;
	
	/**
	 * 
	 * @param number $width
	 */
	public function __construct($width){
		$this->width	= $width;
		$this->blocks	= [];
	}
	
	/**
	 * Returns the width of the container
	 * @return number
	 */
	public function getWidth(){
		return $this->width;
	}
	
	/**
	 * 
	 * @param \alf\Block $element
	 * @return \alf\Block
	 */
	public function appendBlock($element){
		if(!$element instanceof Block) throw new \Exception('Unexpected object type expected a Block');
		$this->blocks[] = $element;
		$element->setContainer($this);
		return $element;
	}
	
	/**
	 * 
	 * @param \alf\Inline $element
	 * @return \alf\Inline
	 */
	public function appendInline($element){
		if(!$element instanceof Inline) throw new \Exception('Unexpected object type expected a Inline');
		
		return $element;
	}
	/**
	 *
	 * @param string $text
	 * @param array $style
	 */
	public function appendText($text, $style){
		
	}
	
	/**
	 * Returns the minimal height this element will consume
	 * @return number
	 */
	public function getMinimalHeight(){
		if(!$this->blocks) return 0;
		if($this->blocks[0] instanceof Sliceable) return $this->blocks[0]->getMinimalHeight();
		return $this->blocks[0]->getCalulatedHeight();
	}
	
	/**
	 * Returns a slice of this element
	 * @param number $height
	 * @return self|false
	 */
	public function slice($height){
		
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		
	}
}