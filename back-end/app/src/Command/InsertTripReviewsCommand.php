<?php

namespace App\Command;

use App\Document\TripReview;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertTripReviewsCommand extends Command
{
    private DocumentManager $dm;

    // Retire $defaultName
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        parent::__construct(); // Toujours appeler parent::__construct() après tes propriétés
    }

    protected function configure(): void
    {
        $this
            ->setName('app:insert-trip-reviews') // ✅ définit explicitement le nom
            ->setDescription('Insert sample TripReview documents into MongoDB.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $reviewsData = [
            ['tripId' => 'trip_001', 'userId' => 'user_001', 'comment' => 'Amazing trip!', 'rating' => 5],
            ['tripId' => 'trip_002', 'userId' => 'user_002', 'comment' => 'Not bad', 'rating' => 3],
        ];

        foreach ($reviewsData as $data) {
            $review = new TripReview();
            $review->setTripId($data['tripId'])
                   ->setUserId($data['userId'])
                   ->setComment($data['comment'])
                   ->setRating($data['rating']);
            $this->dm->persist($review);
        }

        $this->dm->flush();

        $output->writeln('Inserted ' . count($reviewsData) . ' TripReview documents.');

        return Command::SUCCESS;
    }
}
