<?php

namespace App\Command;

use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Peliculas;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:load-csv')]
class LoadCSVCommand extends Command
{
    protected static $defaultName = 'app:load-csv';
    private $projectDir;
    private $doctrine;
    private $logger;

    public function __construct(string $projectDir, ManagerRegistry $doctrine, LoggerInterface $logger)
    {
        $this->projectDir = $projectDir;
        $this->doctrine = $doctrine;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityManager = $this->doctrine->getManager();
        $pathFile = $this->projectDir . '/public/files/IMDb_movies.csv';
        $rows   = array_map('str_getcsv', file($pathFile));
        $header = array_shift($rows);
        $csv    = array();

        $batchSize = 20;
        $loopIndex = 0;
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
            $item = end($csv);

            $date = DateTime::createFromFormat('Y-m-d', $item['date_published']);
            $dateTime = $date instanceof DateTime ? $date : null;

            $pelicula = new Peliculas();
            $pelicula->setTitulo($item['title']);
            $pelicula->setFechaPublicacion($dateTime);
            $pelicula->setGenero($item['genre']);
            $pelicula->setDuracion($item['duration']);
            $pelicula->setProductora($item['production_company']);

            $actors = explode(',', $item['actors']);
            foreach ($actors as $tmpActor) {
                $actor = new Actor();
                $actor->setNombre($tmpActor);
                $entityManager->persist($actor);
                $pelicula->addActor($actor);
            }
            $director = new Director();
            $director->setNombre($item['director']);
            $entityManager->persist($director);
            $pelicula->addDirector($director);
            $entityManager->persist($pelicula);

            if (($loopIndex % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear(); // Detaches all objects from Doctrine!
                $this->logger->log(LogLevel::DEBUG, 'Working on insert data to database');
            }
            $loopIndex++;
        }

        $entityManager->flush();
        $entityManager->clear();
        $this->logger->log(LogLevel::DEBUG, 'Data import finished');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        // the command help shown when running the command with the "--help" option
        $this->setHelp('This command load CSV data...');
    }
}
