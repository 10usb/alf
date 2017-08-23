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
	 * 
	 * @return \alf\Block[]
	 */
	public function getBlocks(){
		return $this->blocks;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::appendBlock()
	 */
	public function appendBlock($element){
		if(!$element instanceof Block) throw new \Exception('Unexpected object type expected a Block');
		$this->blocks[] = $element;
		return $element;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::appendInline()
	 */
	public function appendInline($element){
		if(!$element instanceof Inline) throw new \Exception('Unexpected object type expected a Inline');
		
		// Get a line with full, empty or new
		if(!end($this->blocks) instanceof Line){
			$this->blocks[] = new Line($this->width);
		}
		
		/** @var \alf\Line $line */
		$line = end($this->blocks);
		$remain		= $this->width - $line->getContentWidth() - max($line->getContentTrailMargin(), $element->getMarginLeft()) - $element->getMarginRight();
		if($remain < $element->getWidth()){
			$this->blocks[] = new Line($this->width);
			$line = end($this->blocks);
		}
		
		$line->append($element);
		
		return $element;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::appendText()
	 */
	public function appendText($text, $font, $color, $lineHeight = false, $style = []){
		if(!is_string($text)) throw new \Exception('Unexpected type expected a string ^^');
		if(!$font instanceof Font) throw new \Exception('Unexpected object type expected a Font');
		
		// Get a line with full, empty or new
		if(!end($this->blocks) instanceof Line){
			$this->blocks[] = new Line($this->width);
		}
		/** @var \alf\Line $line */
		$line = end($this->blocks);
		
		if($this->width === false){
			$line->append(new Text($text, $font, $color, $lineHeight, $style));
		}else{
			// Split text into words
			$words = preg_split('/\s+/', $text);
			while(count($words) > 0){
				$length		= count($words);
				$segment	= implode(' ', array_slice($words, 0, $length));
				$remain		= $this->width - $line->getContentWidth() - $line->getContentTrailMargin(); 
				
				// Cut-off text to get a length fitting
				while($length > 1 && $font->getTextWith($segment) > $remain){
					$length/=2;
					$segment = implode(' ', array_slice($words, 0, $length));
				}
				
				if($length == 1 && $remain < $this->width && $font->getTextWith($segment) > $remain){
					$this->blocks[] = new Line($this->width);
					$line = end($this->blocks);
					continue;
				}
				
				if($length == 1 && $font->getTextWith($segment) > $this->width){
					// Split word
					$length	= strlen($words[0]) / 2;
					$segment= substr($words[0], 0, $length);
					
					while($length > 1 && $font->getTextWith($segment) > $this->width){
						$length/=2;
						$segment = substr($words[0], 0, $length);
					}
					
					$segment= substr($words[0], 0, $length + 1);
					while($length < strlen($words[0]) && $font->getTextWith($segment) < $this->width){
						$length++;
						$segment = substr($words[0], 0, $length + 1);
					}
					
					$line->append(new Text(substr($words[0], 0, $length), $font, $color, $lineHeight, $style));
					$this->blocks[] = new Line($this->width);
					$line = end($this->blocks);
					
					$words[0] = substr($words[0], $length);
					continue;
				}
				
				$segment = implode(' ', array_slice($words, 0, $length + 1));
				while($length < count($words) && $font->getTextWith($segment) < $remain){
					$length++;
					$segment = implode(' ', array_slice($words, 0, $length + 1));
				}
				
				$line->append(new Text(implode(' ', array_splice($words, 0, $length)), $font, $color, $lineHeight, $style));
				
				if(count($words) > 0){
					$this->blocks[] = new Line($this->width);
					$line = end($this->blocks);
				}
			}
		}
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::getContentWidth()
	 */
	public function getContentWidth($throw = true){
		if($throw && $this->width === false) throw new \Exception('Width not set');
		return $this->width;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Sliceable::getMinimalHeight()
	 */
	public function getMinimalHeight(){
		if(!$this->blocks) return 0;
		if($this->blocks[0] instanceof Sliceable) return $this->blocks[0]->getMinimalHeight();
		return $this->blocks[0]->getHeight();
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::getCalulatedHeight()
	 */
	public function getCalulatedHeight(){
		$height = 0;
		$margin = 0;
		foreach($this->blocks as $index=>$block){
			if($index > 0){
				$height+= max($margin, $block->getMarginTop());
			}
			$height+= $block->getHeight();
			$margin = $block->getMarginBottom();
		}
		return $height;
	}
	
	/**
	 * TODO inpliment this method
	 * {@inheritDoc}
	 * @see \alf\Sliceable::slice()
	 */
	public function slice($height){
		// No slicing is needed when its within the defined height
		if($this->getCalulatedHeight() <= $height) return false;
		
		// If only 1 child check if that can be split
		if(count($this->blocks) <= 1){
			if($this->blocks[0] instanceof Sliceable && $block = $this->blocks[0]->slice($height - $sliceHeight)){
				// Create new body
				$slice = new self($this->width);
				$slice->blocks[] = $block;
				return $slice;
			}
			
			return false;
		}
		
		$sliceHeight = 0;
		$margin = 0;
		foreach($this->blocks as $index=>$block){
			if($index > 0){
				$temp = max($margin, $block->getMarginTop()) + $block->getHeight();
			}else{
				$temp = $block->getHeight();
			}
			if(($sliceHeight + $temp) > $height) break;
			
			$sliceHeight+= $temp;
			$margin = $block->getMarginBottom();
			$count++;
		}
		
		// Slice of the piece that fits
		$blocks = array_splice($this->blocks, 0, $count);
		
		// Check if the last line can be split
		if($this->blocks[0] instanceof Sliceable && $this->blocks[0]->getMinimalHeight() <= ($height - $sliceHeight)){
			if($block = $this->blocks[0]->slice($height - $sliceHeight)){
				$blocks[] = $block;
			}
		}
		
		// Makes sure atleast one line is cut of
		if(count($blocks)<=0){
			$blocks = array_splice($this->blocks, 0, 1);
		}
		
		// Create new body
		$slice = new self($this->width);
		$slice->blocks = $blocks;
		return $slice;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Packable::getMinimalWidth()
	 */
	public function getMinimalWidth(){
		$width = 0;
		
		foreach($this->blocks as $block){
			$width = max($width, $block->getMinimalWidth());
			
		}
		
		return $width;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Packable::getCalulatedWidth()
	 */
	public function getCalulatedWidth(){
		$width = 0;
		
		foreach($this->blocks as $block){
			$width = max($width, $block->getCalulatedWidth());
			
		}
		
		return $width;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Packable::pack()
	 */
	public function pack($width){
		$blocks = [];
		
		foreach($this->blocks as $block){
			if($repalcements = $block->pack($width)){
				foreach($repalcements as $repalcement){
					$blocks[] = $repalcement;
				}
			}else{
				$blocks[] = $block;
			}
		}
		
		$this->width	= $width;
		$this->blocks	= $blocks;
		return false;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		$top = 0;
		$margin = 0;
		foreach($this->blocks as $index=>$block){
			if($index > 0){
				$top+= max($margin, $block->getMarginTop());
			}
			$block->render(new TranslatedCanvas($canvas, 0, $top));
			
			$top+= $block->getHeight();
			$margin = $block->getMarginBottom();
		}
	}
}