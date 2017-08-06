<?php
namespace alf;

class Line implements Block {
	/**
	 *
	 * @var number
	 */
	private $width;
	
	/**
	 * 
	 * @var \alf\Inline
	 */
	private $items;
	
	/**
	 * 
	 */
	public function __construct($width){
		$this->width	= $width;
		$this->items	= [];
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
	 * @see \alf\Block::setPreferredHeight()
	 */
	public function setPreferredHeight($height){
		/* Nothing todo */
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginLeft()
	 */
	public function getMarginLeft(){
		return 0;
	}
	
	/**
	 * TODO calculate the margin
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginTop()
	 */
	public function getMarginTop(){
		$this->verticalAlignChilds();
		return 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginRight()
	 */
	public function getMarginRight(){
		return 0;
	}
	
	/**
	 * TODO calculate the margin
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginBottom()
	 */
	public function getMarginBottom(){
		$this->verticalAlignChilds();
		return 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getWidth()
	 */
	public function getWidth(){
		return $this->width;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getHeight()
	 */
	public function getHeight(){
		$height = 0;
		foreach($this->items as $item){
			$height = max($height, $item->getHeight());
		}
		return $height;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getContentWidth(){
		$width = 0;
		foreach($this->items as $item){
			$width+= $item->getWidth();
		}
		return $width;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getContentTrailMargin(){
		if(!$this->items) return 0;
		return end($this->items)->getMarginRight();
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
	 */
	private function verticalAlignChilds(){
		$height = $this->getHeight();
		
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