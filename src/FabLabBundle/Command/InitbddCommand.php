<?php

namespace FabLabBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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

        if ($input->getOption('option')) {
            // ...
        }

        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $adherentsRepository = $em->getRepository('FabLabBundle:Adherent');
        $adhesionRepository = $em->getRepository('FabLabBundle:Adhesion');
        $produitRepository = $em->getRepository('FabLabBundle:Produit');
        $achatRepository = $em->getRepository('FabLabBundle:Achat');
        $adherent = $adherentsRepository->add(12, "Clément", "Lemaire", 1);
        $adhesionRepository->add($adherent->no, "2010-01-01", 1);
        $adherent = $adherentsRepository->add(13, "", "NTN", 0);
        $adhesionRepository->add($adherent->no, "2010-01-03", 100);
        $produitRepository->add(1000, "decoupeuse-laser", 0, 0.0, "min");
        $produitRepository->add(1101, "decoupeuse-laser", 1, 0.0, "min");
        $produitRepository->add(2011, "impression-3d-fdm-pla", 1, 0.09, "g");
        $produitRepository->add(2021, "impression-3d-fdm-abs", 1, 0.09, "g");
        $produitRepository->add(2031, "impression-3d-fdm-pet", 1, 0.09, "g");
        $produitRepository->add(2041, "impression-3d-fdm-flex", 1, 0.09, "g");
        $achatRepository->add(12, 1000, "2010-01-01", 20);
        $achatRepository->add(12, 2011, "2010-01-01", 20);
        $output->writeln('Command result.');
    }

}
