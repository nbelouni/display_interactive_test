<?php

namespace App\Service;

class CommandService
{
	public function getCommandFromCSV($customersFilename, $purchasesFilename)
	{
		$customers = $this->getCustomersFromCSV($customersFilename);

		if (!$customers || !count($customers))
			throw new \Exception('Enable to find customers.');
		return $this->getPurchasesFromCSV($customers, $purchasesFilename);
	}

	public function getCustomersFromCSV($customersFilename)
	{
		return null;
	}

	public function getPurchasesFromCSV($customers, $purchasesFilename)
	{
		return $customers;
	}
}
