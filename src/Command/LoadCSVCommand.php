<?php

namespace App\Command;

use App\Entity\Actor;
use App\Entity\Director;
use App\Entity\Peliculas;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
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

    public function __construct(string $projectDir, ManagerRegistry $doctrine)
    {
        $this->projectDir = $projectDir;
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $entityManager = $this->doctrine->getManager();
        $pathFile = $this->projectDir . '/public/files/IMDb_movies.csv';
        $rows   = array_map('str_getcsv', file($pathFile));
        $header = array_shift($rows);
        $csv    = array();
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
            $item = end($csv);

            $pelicula = new Peliculas();
            $pelicula->setTitulo($item['title']);
            $date = DateTime::createFromFormat('Y-m-d', $item['date_published']);
            $pelicula->setFechaPublicacion($date);
            $pelicula->setGenero($item['genre']);
            $pelicula->setGenero($item['duration']);
            $pelicula->setProductora($item['production_company']);

            $actors = explode(',', $item['actors']);
            foreach ($actors as $tmpActor) {
                $actor = new Actor();
                $actor->setNombre($tmpActor);

                $entityManager->persist($actor);
                $entityManager->flush();

                $pelicula->addActor($actor);
            }

            $director = new Director();
            $director->setNombre($item['director']);

            $entityManager->persist($director);
            $entityManager->flush();
            
            $pelicula->addDirector($director);


            $entityManager->persist($pelicula);
            $entityManager->flush();
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        // the command help shown when running the command with the "--help" option
        $this->setHelp('This command load CSV data...');
    }
}
