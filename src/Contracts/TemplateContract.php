<?php 

declare(strict_types=1);

namespace Simply\SyTemplate\Contracts;

use  Simply\SyTemplate\Exceptions\FileViewNotFoundException;
/**
* @author André Teles
*/

abstract class TemplateContract
{
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
	}

	/**
	 * [setTemplateFile description]
	 * @param [string] $file [description]
	 */
	public function setTemplateFile(string $file): void
	{
		if( !$this->fileIsAvalible($file) ){
			die('template not found!');
		}

		$this->fileLayout = "/../../../../resources/views/{$file}.php";
	}

	/**
	 * [loadTemplateFile description]
	 * @return [type] [description]
	 */
	protected function loadTemplateFile(): void
	{
		include_once __DIR__ . $this->fileLayout;

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
		if(! file_exists(__DIR__ . $this->templatePath . $file . '.php') ){

			throw new FileViewNotFoundException("Unable to load file {$file}.php");	
		}

		return true;
		
		//return file_exists(__DIR__ . $this->templatePath . $template . '.php');
	}

	/**
	 * [include description]
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public function include($file): void
	{
		if( !$this->fileIsAvalible($file) ){
			// throw new FileViewNotFoundException("File {$file} not found");
			die('erro ao carregar conteudo');
		}

		include_once __DIR__ . $this->templatePath . $file . '.php';
		
		return;	
			
	}

}