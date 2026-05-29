<?php

declare(strict_types=1);

function getPets(): array
{
    return [
        [
            'id' => 1,
            'name' => 'Biscuit',
            'type' => 'Dog',
            'breed' => 'Golden Retriever',
            'emoji' => '🐕',
            'age' => 3,
            'personality' => 'Loves belly rubs and long walks in the park.',
        ],
        [
            'id' => 2,
            'name' => 'Mochi',
            'type' => 'Cat',
            'breed' => 'Scottish Fold',
            'emoji' => '🐱',
            'age' => 2,
            'personality' => 'Quiet observer who enjoys sunny window naps.',
        ],
        [
            'id' => 3,
            'name' => 'Pip',
            'type' => 'Bird',
            'breed' => 'Budgerigar',
            'emoji' => '🐦',
            'age' => 1,
            'personality' => 'Chirps cheerful greetings every morning.',
        ],
        [
            'id' => 4,
            'name' => 'Nova',
            'type' => 'Dog',
            'breed' => 'Corgi',
            'emoji' => '🐕',
            'age' => 4,
            'personality' => 'Energetic floof with a big personality.',
        ],
        [
            'id' => 5,
            'name' => 'Luna',
            'type' => 'Cat',
            'breed' => 'Maine Coon',
            'emoji' => '🐱',
            'age' => 5,
            'personality' => 'Gentle giant who follows you room to room.',
        ],
        [
            'id' => 6,
            'name' => 'Sunny',
            'type' => 'Bird',
            'breed' => 'Cockatiel',
            'emoji' => '🐦',
            'age' => 2,
            'personality' => 'Whistles little tunes and loves millet treats.',
        ],
        [
            'id' => 7,
            'name' => 'Bean',
            'type' => 'Dog',
            'breed' => 'Beagle',
            'emoji' => '🐕',
            'age' => 6,
            'personality' => 'Expert sniffer with a nose for adventure.',
        ],
        [
            'id' => 8,
            'name' => 'Willow',
            'type' => 'Cat',
            'breed' => 'Siamese',
            'emoji' => '🐱',
            'age' => 1,
            'personality' => 'Chatty companion who demands attention.',
        ],
    ];
}

function getPetStats(): array
{
    $pets = getPets();
    $stats = ['Dog' => 0, 'Cat' => 0, 'Bird' => 0];

    foreach ($pets as $pet) {
        $stats[$pet['type']]++;
    }

    return $stats;
}
