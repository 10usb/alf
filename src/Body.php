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
		return $element;
	}
	
	/**
	 * 
	 * @param \alf\Inline $element
	 * @return \alf\Inline
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
	 * @param string $text
	 * @param array $style
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
			while($length < count($words) && $font->getTextWith($segment) < $this->width){
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
		$top = 0;
		foreach($this->blocks as $block){
			$block->render(new TranslatedCanvas($canvas, 0, $top));
			
			$top+= $block->getCalulatedHeight();
		}
	}
}