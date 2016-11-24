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
	 * [$helpers modules helpers]
	 * @var [array]
	 */
	protected $helpersDefault = [
		'string' => \Simply\SyTemplate\Helpers\StringHelper::class
	];

	/** TODO */
	protected $errors = [];

	/** TODO */
	protected $messages = [];

	/**
	 * [$helpers modules helpers]
	 * @var [array]
	 */
	protected $helpers = [];

	/**
	 * [$data description]
	 * @var [mixed]
	 */
	protected $data;

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

	public function content(): ?string
	{			
		$isAvaliable = $this->fileIsAvalible($this->resource);

		return $isAvaliable ? $this->include($this->resource) : $isAvaliable; 

		
	}

	public function register()
	{
		return [
			'messages' => [
					'somethingClassMessages'
			],

			'errors'   => ['somethingClassErrors'] 
		];
		// do nothing
	}

	protected function  boot(): void
	{
		if( !$this->check() ){
			die('error with modules helpers');
		}
		
		foreach($this->helpersDefault as $type => $helper){
				$this->helper[$type] = new $helper;
		}

		if ( !empty($this->helpers) ){
		
			foreach($this->helpers as $type => $helper){
				$this->helper[$type] = new $helper;
			}
		}
		
		if(method_exists($this,'register')){
			
			// TODO		
		}
	}
		 
	
}