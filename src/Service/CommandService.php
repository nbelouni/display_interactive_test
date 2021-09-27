<?php

namespace App\Service;

class CommandService
{
	public function getCommandFromCSV($customersFilename, $purchasesFilename)
	{
		$customers = $this->getCustomersFromCSV($customersFilename);

		if (!$customers || !count($customers))
			throw new \Exception('Enable to find customers.');
		$command =  $this->getPurchasesFromCSV($customers, $purchasesFilename);
		dump($command);
		//PUT here
	}

	private function getCustomersFromCSV($filename)
	{
		if (!($fd = fopen($filename, 'r')))
			return null;

		$costumers = [];
		$headers = fgetcsv($fd, 1000, ';');
		while (($row = fgetcsv($fd, 1000, ';', FILE_SKIP_EMPTY_LINES)) != false)
		{

			if (array_key_exists(1, $row))
				$customer['salutation'] = ($row[1] === 1 ? 'mme' : $row[1] === 2) ? 'm' : '';
			if (array_key_exists(2, $row))
				$customer['last_name'] = $row[2];
			if (array_key_exists(3, $row))
				$customer['first_name'] = $row[3];
			if (array_key_exists(4, $row))
				$customer['email'] = $row[4];
			$customers[$row[0]] = $customer;
		}

		fclose($fd);
		return $customers;
	}

	private function getPurchasesFromCSV($customers, $purchasesFilename)
	{
		if (!($fd = fopen($purchasesFilename, 'r')))
			return null;

		$headers = fgetcsv($fd, 1000, ';');
		while (($row = fgetcsv($fd, 1000, ';', FILE_SKIP_EMPTY_LINES)) != false)
		{
			$ids = null;
			if (array_key_exists(1, $row))
				$ids = explode('/', $row[1]);
			if ($ids)
			{
				$customerId = $ids[0];
				
				if (array_key_exists(1, $ids))
					$purchase['product_id'] = $ids[1];
				if (array_key_exists(3, $row))
					$purchase['price'] = $row[3];
				if (array_key_exists(4, $row))
					$purchase['currency'] = $row[4];
				if (array_key_exists(2, $row))
					$purchase['quantity'] = $row[2];
				if (array_key_exists(5, $row))
					$purchase['purchased_at'] = $row[5];

				if (array_key_exists($customerId, $customers))
					$customers[$customerId]['purchases'][] = $purchase;//trim purchase to remove customer id;	
			}
		}

		fclose($fd);

		return $customers;
	}

}
