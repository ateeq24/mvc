<?php
namespace MVC\Core\Views;

class ViewManager
{
	public $directory;
	public $extension;

	public function render($view, $data = []) {
		$file = $view . self::$directory . self::$extension;
		if (!file_exists($file)) {
			throw new \Exception("Can't find file: $file for view: $view...", 1);
		}
		require $file;
	}
}
