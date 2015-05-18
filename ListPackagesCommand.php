<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;

/**
 * Console command for listing project's composer packages
 *
 * @version 1.0.0 
 * @author Barna Szalai <szalai.b@gmail.com>
 */
class ListPackagesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'list:packages';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Listing installed composer packages.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(Filesystem $files)
	{
		$installed = $files->get(base_path().'/vendor/composer/installed.json');

		if (!$installed) {
			$this->error('Error opening /vendor/composer/installed.json');
			exit;
		}

		$this->info('Listing composer packages...'.PHP_EOL);

		$iArray = json_decode($installed, true);

		if ($this->option('search')) {

			$matches = [];

			foreach ($iArray as $k => $v) {
			
			    if (strpos($v['name'], $this->option('search')) !== false) {

			        $matches[$k] = [
			        	'name' => $v['name'],
			        	'version' => $v['version']
			        ];
			    }			    
			}

			$iArray = $matches;
		}

		$finalOutput = [];

		foreach ($iArray as $item) {

			$output = $item['name'];

			if ($this->option('ver')) {
				$output .= ':'.$item['version'];
			} 

			if ($this->option('separate')) {
				
				$output .= PHP_EOL.str_repeat("-", strlen($output));
				
			}

			$finalOutput[] = $output;
		}

		if ($this->option('order') == 'asc') {
			sort($finalOutput, SORT_STRING);	
		} elseif ($this->option('order') == 'desc') {
			rsort($finalOutput, SORT_STRING);
		}

		foreach ($finalOutput as $key => $value) {
			$this->info($value);	
		}		
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['ver', null, InputOption::VALUE_NONE, 'Show package version number', null],
			['separate', null, InputOption::VALUE_NONE, 'Separate vendors by dashes', null],
			['order', null, InputOption::VALUE_OPTIONAL, 'Alphabetical order (asc/desc)', 'asc'],			
			['search', null, InputOption::VALUE_REQUIRED, 'Search in vendor/package names', null],
		];
	}
}