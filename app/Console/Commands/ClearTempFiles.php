<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\File\IFileRepository;

class ClearTempFiles extends Command {

    private $fileRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear unused files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IFileRepository $iFileRepository) {
        parent::__construct();
        $this->fileRepository = $iFileRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $days = env('CLEAR_OLD_FILES_DAYS', 1);
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln('<comment>Deleting files...</comment>');

        $this->fileRepository->clear_old_files($days);

        $output->writeln('<info>Operation complete!</info>');
        return 0;
    }
}
