<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ClearTemporaryImagesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'clear-temporary-images';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clears the temporary images which were uploaded due to validation errors.';

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
        $path = public_path() . '/uploads/listings/temporary';
        $dir = new DirectoryIterator($path);
        foreach ($dir as $file) {
            if ($file->isFile() === TRUE && $file->getBasename() !== '.DS_Store') {
                $filename = $file->getFilename();
                $parts = explode('.', $filename);
                $userId = $parts[0];

                $lastModified = $file->getCTime();

                // Letztes erstellte Listing des Users
                $listing = Listing::where('user_id', '=', $userId)->descCreatedAt()->first();
                $mostRecentListing = strtotime($listing->created_at);

                // Letzter Login des Users
                $user = User::find($userId);
                $lastLogin = strtotime($user->last_login);

                // Löschen wenn:
                // 1. nach Erstellung des temporären Bildes der User sich wieder eingeloggt hat
                // 2. nach Erstellung des temporären Bildes ein anderes Listings erstellt wurde
                if($mostRecentListing - $lastModified > 0 || $lastLogin - $lastModified > 0){
                    File::delete($path . '/' . $filename);
                }
            }
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