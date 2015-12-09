<?php


class RadioList 
{
	private $name;  //select list identifer
	private $label; //list label
  private $items;  // array of items
  private $options; // hold all html options
  private $selectMenu; // final select menu
    
    
  function __construct($name, $itemArray='') 
  {
        $this->items = $itemArray;
        $this->name = $name;
    }
   
  private function BuildOptionsWithArrayIndices($items) 
  {
  
			foreach($items as $key => $val) 
			{ 
				$this->options .= '<input type=radio name='.$this->name.' id='.$key.' value='.$val . ' >'
				."<label for=$key>" . $val ."</label> " ;
			} 

    }
  private function BuildOptionsWithDbRows($rows,$idCol,$valCol,$defaultValToCheck) 
  {

			foreach($rows as $index => $row) 
			{ 
				($row[$idCol] == $defaultValToCheck) ? $buttonCheck='checked': $buttonCheck = '';
				$this->options .= '<input type=radio name='.$this->name." id=$index value=$row[$idCol] $buttonCheck >" 
					."<label for=$index>" . $row[$valCol] ."</label> " ;
			} 

    }

  private function BuildOptions() 
  {
  
			foreach($this->items as $key => $val) 
			{ 
				$this->options .= '<input type=radio name='.$this->name.' id='.$key.' value='.$key . '>'
				."<label for=$key>" . $val ."</label> " ;
			} 

    }
    
  private function BuildControl() 
  {
        $this->selectMenu = 
        	'<fieldset>'.$this->label . 	$this->options .'</fieldset>';
        	
    }

	private function BuildLegend($text)
	{
		$this->label =
			'<legend>' .	$text . '</legend><p>';
	}
	
  public function MakeMenu($labelText) 
  {
        $this->BuildOptions();
        if(!empty($labelText)) $this->BuildLegend($labelText);
        $this->BuildControl();
        return $this->selectMenu;
    }
  public function MakeMenuWithDBRows($labelText,$idCol,$valCol) 
  {
        $this->BuildOptionsWithDbRows($this->items,$idCol,$valCol,0) ;
        if(!empty($labelText)) $this->BuildLegend($labelText);
        $this->BuildControl();
        return $this->selectMenu;
    }
  public function MakeDBRowMenuWithDefault($labelText,$idCol,$valCol,$defaultValToCheck) 
  {
        $this->BuildOptionsWithDbRows($this->items,$idCol,$valCol,$defaultValToCheck) ;
        if(!empty($labelText)) $this->BuildLegend($labelText);
        $this->BuildControl();
        return $this->selectMenu;
    }
    
  public function MakeMenuWithArrayIndices($labelText) 
  {
        $this->BuildOptionsWithArrayIndices();
        if(!empty($labelText)) $this->BuildLegend($labelText);
        $this->BuildControl();
        return $this->selectMenu;
    }

}
?>