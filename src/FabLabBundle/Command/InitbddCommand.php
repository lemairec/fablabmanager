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
        $adherent = $adherentsRepository->add(12, "Clément", "Lemaire", 1);
        $adhesionRepository->add($adherent->no, "2010-01-01", 1);
        $adherent = $adherentsRepository->add(13, "", "NTN", 0);
        $adhesionRepository->add($adherent->no, "2010-01-03", 1);
        $produitRepository->add(1, "impression 3d", 1, 0.09, "ct/g");
        $output->writeln('Command result.');
    }

}
