<?php

namespace App\Modules\Inventory\Controllers\Admin;
use Illuminate\Support\Facades\Response;

class Files {

	function convertToCSV($data, $options)
	{
		if(is_array($options) && isset($options['headers']) && is_array($options['headers']))
		{
			$headers = $options['headers'];
		}
		else
		{
			$headers = array(
				'Content-Type' => 'text/csv',
				'Content-Disposition' => 'attachment; filename="ExportFilename.csv"'
				);
		}

		$output = '';

		if(isset($options['firstRow']) && is_array($options['firstRow']))
		{
			$output .= implode("\t", $options['firstRow']);
			$output .= "\n"; // new line after the first line
		}

		if(isset($options['columns']) && is_array($options['columns']))
		{
			$columns = $options['columns'];
		}
		else
		{
			$objectKeys = get_object_vars($data[0]);
			$columns = array_keys($objectKeys);
		}

		foreach($data as $row)
		{
			foreach($columns as $column)
			{
				$output .= str_replace(',', ';', $row->$column);
				$output .= "\t";
			}

			$output .= "\n";
		}

		return Response::make($output, 200, $headers);
	}

}