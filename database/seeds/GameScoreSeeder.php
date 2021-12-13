<?php

use App\Game;
use Illuminate\Database\Seeder;

class GameScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Game $game01 */
        $game01 = Game::create([
            'title' => 'Golf Team',
            'startAt' => 1585652827,
        ]);
        /** @var Game $game02 */
        $game02 = Game::create([
            'title' => 'April Fool\'s Day',
            'startAt' => 1585713660,
        ]);

        $game01->scores()->createMany([
            [
                'player' => 'Mars',
                'value' => 57,
            ],
            [
                'player' => 'Penny',
                'value' => 76,
            ],
        ]);

        $game02->scores()->createMany([
            [
                'player' => 'Ivy',
                'value' => 89,
            ],
            [
                'player' => 'Zack',
                'value' => 67,
            ],
            [
                'player' => 'John',
                'value' => 73,
            ],
        ]);
    }
}
