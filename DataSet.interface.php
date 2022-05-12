<?php

interface DataSet {
	public function getTitleAt($row);
	public function getPeopleCount($row);
	public function getInitialAt($row);
	public function getSurnameAt($row);
	public function getFirstNameAt($row, $initial);
	public function printPerson($person);
}

?>