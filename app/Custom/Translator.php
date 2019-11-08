<?php
	namespace App\Custom;

	use Illuminate\Support\Facades\Storage;
	class Translator{
		private $sources = [
			"czsk" => "letters.json"
		];
		private $selected;

		public function __construct($source = "czsk"){
			if(array_key_exists($source, $this->sources)){
				$this->selected = $source;
			}else{
				$this->selected = "czsk";
			}
		}

		public function translate($str){
			$abs = "private/jsons/translator";
			if(!Storage::exists($abs.$this->sources[$this->selected])){
				return false;
			}
			$letters = Storage::get($abs.$this->sources[$this->selected]);
			dd($letters);
		}
	}
?>