<?php

namespace App\Command;

use App\Document\TripReview;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TripReviewPreviewCommand extends Command
{
    // Nom de la commande pour Symfony
    protected static $defaultName = 'app:trip-review-preview';

    private DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        parent::__construct(self::$defaultName);
        $this->dm = $dm;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Preview all TripReviews in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tripReviews = $this->dm->getRepository(TripReview::class)->findAll();

        if (empty($tripReviews)) {
            $output->writeln('No TripReviews found.');
            return Command::SUCCESS;
        }

        foreach ($tripReviews as $review) {
            $output->writeln(sprintf(
                '[%s] TripId: %s | User: %s | Rating: %d | Comment: %s',
                $review->getId(),
                $review->getTripId(),
                $review->getUserPseudo(),
                $review->getRating(),
                $review->getComment()
            ));
        }

        return Command::SUCCESS;
    }
}
