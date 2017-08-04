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
	 *
	 * @param \alf\Inline $element
	 */
	public function append($element){
		if(!$element instanceof Inline) throw new \Exception('Unexpected object type expected a Inline');
		
		if($this->items){
			$last = end($this->items);
			$element->setLineLeft($last->getLineLeft() + $last->getWidth() + max($last->getMarginRight(), $element->getMarginLeft()));
		}else{
			$element->setLineLeft(0);
		}
		
		$this->items[] = $element;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Block::setContainer()
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
	 * Returns the minimal height this element will consume
	 * @return number
	 */
	public function getMinimalHeight(){
		
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
	
	public function getMarginLeft(){
		return 0;
	}
	
	public function getMarginTop(){
		$this->verticalAlignChilds();
		return 0;
	}
	
	public function getMarginRight(){
		return 0;
	}
	
	public function getMarginBottom(){
		$this->verticalAlignChilds();
		return 0;
	}
	
	public function getWidth(){
		return 0;
	}
	
	public function getHeight(){
		return $this->getCalulatedHeight();
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		$this->verticalAlignChilds();
		
		foreach($this->items as $item){
			$item->render($canvas);
		}
	}
	
	/**
	 * 
	 * @throws \Exception
	 */
	private function verticalAlignChilds(){
		$height = $this->getCalulatedHeight();
		
		foreach($this->items as $item){
			switch($item->getVerticalAlignment()){
				case Inline::ALIGN_TOP:
					$item->setLineTop(0);
				break;
				case Inline::ALIGN_MIDDLE:
					$item->setLineTop(($height - $item->getHeight()) / 2);
				break;
				case Inline::ALIGN_BOTTOM:
					$item->setLineTop($height - $item->getHeight());
				break;
				throw new \Exception('Unknown alignment');
			}
			
		}
	}
}