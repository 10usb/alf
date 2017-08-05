<?php
namespace alf;

class Image implements /*Block, */Inline {
	/**
	 * 
	 * @var string
	 */
	private $source;
	
	/**
	 * 
	 * @var array
	 */
	private $style;
	
	/**
	 *
	 * @var number $lineLeft
	 * @var number $lineTop
	 */
	private $lineLeft, $lineTop;
	
	/**
	 * Construct an image
	 * 
	 * Remarks:
	 * $style must contain width or height or both 
	 * 
	 * @param string $source
	 * @param array $style
	 */
	public function __construct($source, $style){
		$this->source		= $source;
		$this->style		= $style;
		$this->lineLeft		= 0;
		$this->lineTop		= 0;
		
		if(isset($style['width'], $style['height'])){
			if(!is_numeric($style['width']) || !is_numeric($style['height'])) throw new \Exception('Width or height is not a number');
		}elseif(isset($style['width'])){
			if(!is_numeric($style['width'])) throw new \Exception('Width is not a number');
			$info = getimagesize($source);
			$this->style['height'] = $info[1] / $info[0] * $style['width'];
		}elseif(isset($style['height'])){
			if(!is_numeric($style['height'])) throw new \Exception('Height is not a number');
			$info = getimagesize($source);
			$this->style['width'] = $info[0] / $info[1] * $style['height'];
		}else{
			throw new \Exception('No dimension property given');
		}
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Inline::setLineLeft()
	 */
	public function setLineLeft($value){
		$this->lineLeft = $value;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Inline::getLineLeft()
	 */
	public function getLineLeft(){
		return $this->lineLeft;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Inline::setLineTop()
	 */
	public function setLineTop($value){
		$this->lineTop = $value;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Inline::getFloating()
	 */
	public function getFloating(){
		return Inline::FLOAT_NONE;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Inline::getVerticalAlignment()
	 */
	public function getVerticalAlignment(){
		return Inline::ALIGN_MIDDLE;
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
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginTop()
	 */
	public function getMarginTop(){
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
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginBottom()
	 */
	public function getMarginBottom(){
		return 0;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getWidth()
	 */
	public function getWidth(){
		return $this->style['width'];
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getHeight()
	 */
	public function getHeight(){
		return $this->style['height'];
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		$canvas->drawImage($this->source, $this->lineLeft, $this->lineTop, $this->getWidth(), $this->getHeight());
	}
}