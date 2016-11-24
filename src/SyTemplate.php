<?php 

declare(strict_types=1);

namespace Simply\SyTemplate;

use Simply\SyTemplate\Contracts\TemplateContract;

/**
* @author André Teles
*/

class SyTemplate extends TemplateContract
{
	/**
	 * [$data description]
	 * @var [mixed]
	 */
	private $data;

	/**
	 * [$resource description]
	 * @var [string]
	 */
	private $resource;


	public function render($resource, $data = '', $layout = true): void
	{
		$this->data = $data;

		$this->resource = $resource;
		
		if( $layout !== true && !$this->fileIsAvalible($this->resource)){

			$this->content($this->resource);

			return; 
		}

		$this->loadTemplateFile();

	}

	public function content()
	{			
		$isAvaliable = $this->fileIsAvalible($this->resource);

		return $isAvaliable ? $this->include($this->resource) : $isAvaliable; 

		
	}

}