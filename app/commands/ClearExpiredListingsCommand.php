<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearExpiredListingsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'clear-expired-listings';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deletes the database entries and corresponding images for expired listings.';

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
	 * @return void
	 */
	public function fire()
	{
        $listings = Listing::where('ends_at', '<=', DB::raw('NOW() - INTERVAL 14 DAY'))->get();

        foreach($listings as $listing){
            if($listing->hasImage()){
                $listing->deleteImage();
            }

            // Tags von dem Listing löschen
            $listing->tags()->delete();

            $listing->delete();
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
        return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
        return array();
	}

}