<?php 

declare(strict_types=1);

namespace Simply\SyTemplate\Contracts;

use  Simply\SyTemplate\Exceptions\FileViewNotFoundException;
use  Simply\SyTemplate\Exceptions\PropertyNotFoundException;
use ReflectionClass;
/**
* @author André Teles
*/

abstract class TemplateContract
{

	/**
	 * [$helper]
	 * @var [array]
	 */
	protected $helper = [];

	/**
	 * [$helpersDefault]
	 * @var [array]
	 */
	protected $helpersDefault = [];

	/**
	 * [$templatePath path to views]
	 * @var [string]
	 */
	protected $templatePath;

	/**
	 * [$fileLayout description]
	 * @var [type]
	 */
	protected $fileLayout;

	/**
	 * [__construct description]
	 * @param string $path [description]
	 */
	public function __construct( string $path ='')
	{
		if( empty($path) ){

			$this->templatePath = "/../../../../resources/views/";
			
			return;
		}

		$this->templatePath = $path;

		if( method_exists($this,'boot') ){

			$this->boot();
		}
	}

	public function __get($property)
	{
		if( ! property_exists($this, $property)){

			throw new PropertyNotFoundException("Property {$property} not found");
		}

		return $this->helper[$property];
	}

	public function __set($property, $value)
	{
		if( !property_exists($this,$property) ){

			$this->helper[$property] = $value;
		}

		throw new PropertyNotFoundException("Property {$property} already exists");
	}

	/**
	 * [setTemplateFile description]
	 * @param [string] $file [description]
	 */
	public function setTemplateFile(string $file): void
	{
		if( !$this->fileIsAvalible($file) ){
			throw new FileViewNotFoundException("Unable to load template file {$file}.php");
		}

		$this->fileLayout = $this->templatePath . $file;
	}

	/**
	 * [loadTemplateFile description]
	 * @return [type] [description]
	 */
	protected function loadTemplateFile(): void
	{	
		include_once $this->fileLayout . '.php';

		return;
	}

	/**
	 * [getTemplatePath description]
	 * @return [type] [description]
	 */
	public function getTemplatePath(): string
	{
		return $this->templatePath;
	}

	/**
	 * [templateIsAvalible description]
	 * @param  string $template [description]
	 * @return [type]           [description]
	 */
	protected function fileIsAvalible( string $file): bool
	{	
		if(! file_exists($this->templatePath  . $file . '.php') ){

			throw new FileViewNotFoundException("Unable to load file {$file}.php");	
		}

		return true;
	}

	/**
	 * [include description]
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public function include($file): void
	{
		if( !$this->fileIsAvalible($file) ){
			throw new FileViewNotFoundException("Error to incluide file {$file}.php");
		}

		include_once $this->templatePath . $file . '.php';
		
		return;	
			
	}

	protected function check(): bool
	{
		foreach($this->helpersDefault as $type => $helper){
			
			$class = new ReflectionClass($helper);
		 	
			 return is_string($type) || $class->isInstantiable();
		}

			if( !empty($this->helpers) ){

				foreach($this->helpersDefault as $type => $helper){
				
				$class = new ReflectionClass($helper);
				
				return is_string($type) || $class->isInstantiable();
			}

		}
	}

	abstract protected  function boot();

	

}