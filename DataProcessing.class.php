<?php

require_once('InMemoryDataSet.class.php');

class DataProcessing {
    private $dataSet; 

    private $titles;
    private $members;

    public function __construct(DataSet $dataSet) {
        $this->dataSet = $dataSet;
    }


    public function processData(): void {
    	foreach ($this->dataSet->getData() as $row) {
    		$this->titles = $this->dataSet->getTitleAt($row);
    		$this->members = $this->dataSet->getPeopleCount($row);
        	
        	if($this->titles >= 1) {
        		$valid[] = $row;
        		if($this->members >= 1) {
        			$multiplePeople[] = rtrim($row, ", ");
        		} else {
        			$singlePerson[] = rtrim($row, ", ");
        		}
        	}

        }

        $this->processSingle($singlePerson);
        $this->processMultiple($multiplePeople);
    }


    public function processSingle($singlePerson): void {
    	foreach($singlePerson as $row) {
    		$person = explode(" ", $row);
    		
    		$initial = $this->dataSet->getInitialAt($row);
    		$firstName = $this->dataSet->getFirstNameAt($person, $initial);
    		$personRecord = [
    			'title' => $person[0],
    			'first_name' => $firstName,
    			'initial' => $this->dataSet->getInitialAt($row),
    			'last_name' => $person[2] ?? $person[1]
    		];
    		$this->dataSet->printPerson($personRecord);
    	}
    }

    public function processMultiple($multiplePeople): void {
    	foreach($multiplePeople as $row) {
    		
    		$andPosition = strpos($row, "and");
    		$separator = ($andPosition > -1)?'and':'&';
    		$people = explode($separator, $row);
    		$member =$this->processMembers($people);
    		$this->processSingle($member);
    	}
    
    }

    public function processMembers($people): array {

		for ($i = 0; $i < count($people); $i++) {
			$member[$i] = trim($people[$i]);
			if($i<count($people) -1 ) {
				$surname = $this->dataSet->getSurnameAt($people[$i+1]);
			}
			
			if(str_word_count($people[$i]) == 1) {
				$member[$i] = $member[$i] . $surname;
			}
				
		}

		return $member;
    }

}

?>