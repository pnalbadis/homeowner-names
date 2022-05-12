<?php

require_once('DataSet.interface.php');

class InMemoryDataSet implements DataSet {

	const TITLE_REGEX = '/(Mr|Mrs|Ms|Mister|Dr|Miss|Prof)\b/m';
	const MULTIPLE_REGEX = '/(and|&)/m';
	const INITIAL_REGEX = '/([A-Z][.]\s){1,2}|[A-Z]{1}\s/m';
    const SURNAME_REGEX = '/\s(\w+)$/m';

    private $data;

    public function __construct(object $data) {
        $this->data = $data;
    }

    public function getData(): object {
    	return $this->data;
    }

    public function getTitleAt($row): int {
    	return preg_match_all(self::TITLE_REGEX, $row, $matches, PREG_OFFSET_CAPTURE );
    }

    public function getPeopleCount($row): int {
    	return preg_match_all(self::MULTIPLE_REGEX,$row, $matches, PREG_OFFSET_CAPTURE );
    }

    public function getInitialAt($row): ?string {
    	preg_match(self::INITIAL_REGEX,$row, $matches);
    	return empty($matches)? NULL : $matches[0];
    }

    public function getSurnameAt($row): ?string {
    	preg_match(self::SURNAME_REGEX,$row, $matches);
    	return empty($matches)? NULL : $matches[0];
    }

    public function getFirstNameAt($row, $initial): ?string {
    	$length = count($row);
    	if( $length === 3 && $initial === null) return $row[1];
    	if( $length === 4 && $initial !== null) return $row[2];
    	return null;
    }

    public function printPerson($person): void {
        foreach($person as $attribute => $value) {
            echo '$person['.$attribute.'] => '.($value ?? 'null').PHP_EOL;

        }
        echo PHP_EOL;
    }

}

?>