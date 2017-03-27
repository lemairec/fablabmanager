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

    protected function importAdherents(){
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $adherentRepository = $em->getRepository('FabLabBundle:Adherent');

        $fileName = '/Users/lemairec/Downloads/membres_csv.csv';
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
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $adherentRepository = $em->getRepository('FabLabBundle:Adherent');

        $produitRepository = $em->getRepository('FabLabBundle:Produit');
        $produitRepository->add(1000, "decoupeuse-laser", "A", 0.0, "min");
        $produitRepository->add(1100, "decoupeuse-laser", "B", 0.0, "min");
        $produitRepository->add(2000, "plotter-2d-black", "A", 7.0, "m");
        $produitRepository->add(2001, "plotter-2d-color", "A", 8.0, "m");
        $produitRepository->add(2100, "plotter-2d-black", "B", 14.0, "min");
        $produitRepository->add(2002, "plotter-2d-color", "B", 16.0, "m");
        $produitRepository->add(3000, "impression-3d-fdm-pla", "A", 0.09, "g");
        $produitRepository->add(3001, "impression-3d-fdm-abs", "A", 0.09, "g");
        $produitRepository->add(3002, "impression-3d-fdm-pet", "A", 0.09, "g");
        $produitRepository->add(3003, "impression-3d-fdm-flex", "A", 0.09, "g");
        $produitRepository->add(3100, "impression-3d-fdm", "B", 4, "h");
        $produitRepository->add(4000, "impression-3d-resine-standard", "A", 0.44, "ml");
        $produitRepository->add(4001, "impression-3d-resine-dure", "A", 0.55, "ml");
        $produitRepository->add(4002, "impression-3d-resine-flexible", "A", 0.56, "ml");
        $produitRepository->add(4003, "impression-3d-resine-calcinable", "A", 0.78, "ml");
        $produitRepository->add(4100, "impression-3d-resine-standard", "B", 0.88, "ml");
        $produitRepository->add(4101, "impression-3d-resine-dure", "B", 1.10, "ml");
        $produitRepository->add(4102, "impression-3d-resine-flexible", "B", 1.12, "ml");
        $produitRepository->add(4103, "impression-3d-resine-calcinable", "B", 1.56, "ml");
        $produitRepository->add(5000, "soudure", "A", 0.5, "forfait");
        $produitRepository->add(5001, "soudure", "B", 1.0, "forfait");
        $produitRepository->add(6000, "fraiseuse", "A", 2, "15 min");
        $produitRepository->add(6001, "fraiseuse", "B", 8, "15 min");
        $produitRepository->add(7000, "tour", "A", 2, "15 min");
        $produitRepository->add(7001, "tour", "B", 6, "15 min");
        $produitRepository->add(8000, "brodeuse", "A", 0.13, "m de fils");
        $produitRepository->add(8001, "brodeuse", "B", 0.26, "m de fils");
        $output->writeln('Command result.');

        $this->importAdherents();
        $adhesionRepository = $em->getRepository('FabLabBundle:Adhesion');
        $achatRepository = $em->getRepository('FabLabBundle:Achat');
    }

}
