<?php

namespace FabLabBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use FabLabBundle\Entity\Adherent;
use FabLabBundle\Entity\Rechargement;
use \DateTime;

class InitbddCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('initbdd')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $adherentRepository = $em->getRepository('FabLabBundle:Adherent');

        $fileName = '/Users/lemairec/Downloads/membres_csv.csv';
        echo("toto");
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            echo("toto");
            $i = 0;
            while (($data = fgetcsv($handle, null, ",")) !== FALSE) {
                if ($i == 0) { $i = 1;continue; }
                $rows = $data;
                echo(var_dump($rows));
                $adherent = new Adherent();
                $adherent->no = $i;
                $adherent->actif = true;
                $adherent->surname = $rows[1];
                $adherent->name = $rows[2];
                $adherent->adresse = $rows[3];
                $adherent->code_postal = $rows[4];
                $adherent->city = $rows[5];
                if(strlen($rows[6]) > 6){
                    $adherent->birthday = DateTime::createFromFormat('d/m/Y', $rows[6]);
                }
                $adherent->sexe = $rows[7];
                $adherent->activite = $rows[9];
                $adherent->mail = $rows[10];
                $adherent->fondateur = true;
                $adherent->bureau = false;
                $adherent->ca = false;
                $adherent->lettre_info = true;
                $adherent->remarque = $rows[20];
                if($adherent->sexe == "NA"){
                    $adherent->type = "professionnel";
                } else {
                    $adherent->type = "particulier";
                }
                echo(var_dump($adherent));
                $adherentRepository->save($adherent);
                $pricestr = str_replace(",", ".", $rows[18]);
                $cf = floatval($pricestr);
                $rechargement = new Rechargement();
                $rechargement->cf = $cf;
                $rechargement->adherent = $adherent;
                $rechargement->date = new DateTime("2017-01-01");
                $em->persist($rechargement);
                $em->flush();
                $adherentRepository->update_cf($adherent->no);
                $i++;
            }
            fclose($handle);
        }

        if ($input->getOption('option')) {
            // ...
        }


        $adhesionRepository = $em->getRepository('FabLabBundle:Adhesion');
        $produitRepository = $em->getRepository('FabLabBundle:Produit');
        $achatRepository = $em->getRepository('FabLabBundle:Achat');
        $produitRepository->add(1000, "decoupeuse-laser", "A", 0.0, "min");
        $produitRepository->add(1101, "decoupeuse-laser", "B", 0.0, "min");
        $produitRepository->add(2011, "impression-3d-fdm-pla", "A", 0.09, "g");
        $produitRepository->add(2021, "impression-3d-fdm-abs", "A", 0.09, "g");
        $produitRepository->add(2031, "impression-3d-fdm-pet", "A", 0.09, "g");
        $produitRepository->add(2041, "impression-3d-fdm-flex", "A", 0.09, "g");
        $output->writeln('Command result.');
    }

}
