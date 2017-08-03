<?php
namespace alf;

class Line implements Block {
	/**
	 * 
	 * @var \alf\Container
	 */
	private $container;
	
	/**
	 * 
	 * @var \alf\Inline
	 */
	private $items;
	
	/**
	 * 
	 */
	public function __construct(){
		$this->container	= null;
		$this->items		= [];
	}
	
	/**
	 * Called by the parent container when appended to it
	 * @param \alf\Container $container
	 */
	public function setContainer($container){
		$this->container = $container;
	}
	
	/**
	 * Sets a fixed height for this block
	 * @param number $height
	 * @return self
	 */
	public function setHeight($height){
		return $this;
	}
	
	/**
	 * Returns the calculated height this block will consume which could be a fixed value or dynamic value depending on its content
	 * @return number
	 */
	public function getCalulatedHeight(){
		$height = 0;
		foreach($this->items as $item){
			$height = max($height, $item->getHeight());
		}
		return $height;
	}
	
	/**
	 * 
	 * @param \alf\Inline $element
	 */
	public function append($element){
		if(!$element instanceof Inline) throw new \Exception('Unexpected object type expected a Inline');
		$element->setLine($this);
		$items->items[] = $element;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		
	}
}