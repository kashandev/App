<?php
final class Log {
	private $filename;
	
	public function __construct($filename) {
		$this->filename = $filename;
	}

    public function setFile($filename) {
        $this->filename = $filename;
    }

    public function write($message) {
		$file = DIR_LOGS . $this->filename;
		
		$handle = fopen($file, 'a+'); 
		
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . $message . PHP_EOL);
			
		fclose($handle); 
	}
}
?>