<?php

namespace Tests\Feature\Http\Controllers;

use App\Game;
use App\Score;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameController extends TestCase
{
    use RefreshDatabase;

    /**
     * Get a list of games
     *
     * HTTP Request
     * GET: /api/game/all
     *
     * ------------------------------
     *
     * HTTP Response
     * Status Code: 200
     * JSON Content Type:
     * [
     *     {
     *         "id": 1,
     *         "title": "April Fool's Day",
     *         "startAt": "1585713660",
     *         "scores": [
     *             {
     *                 "player": "Ian",
     *                 "value": "80"
     *             },
     *             {
     *                 "player": "Jeff",
     *                 "value": "71"
     *             },
     *             {
     *                 "player": "Cathy",
     *                 "value": "83"
     *             }
     *         ]
     *     }
     * ]
     *
     */
    public function testAll(): void
    {
        factory(Game::class)->create()->each(function (Game $game) {
            $game->scores()->saveMany([
                factory(Score::class)->make(),
                factory(Score::class)->make(),
                factory(Score::class)->make(),
                factory(Score::class)->make()
            ]);
        });

        $response = $this->json('get', '/api/game/all');
        $response->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', 1)
            ->assertJsonPath('0.title', 'April Fool\'s Day')
            ->assertJsonPath('0.startAt', 1585713660)
            ->assertJsonCount(4, '0.scores')
            ->assertJsonStructure([
                [
                    'id',
                    'title',
                    'startAt',
                    'scores' => [
                        [
                            'player',
                            'value',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Store a new game
     *
     * HTTP Request
     * POST: /api/game
     * JSON Payload:
     * {
     *     "title": "April Fool's Day",
     *     "startAt": 1585713660
     * }
     *
     * ------------------------------
     *
     * HTTP Response
     * Status Code: 2001
     * JSON Content Type:
     * {
     *     "id": 1,
     *     "title": "April Fool's Day",
     *     "startAt": 1585713660,
     *     "scores": []
     * }
     *
     * @return void
     */
    public function testStore(): void
    {
        $startAt = Carbon::create(2020, 04, 01, 04, 01);
        $response = $this->json('post','/api/game', [
            'title' => 'April Fool\'s Day',
            'startAt' => $startAt->timestamp,
        ]);

        $response->assertCreated();
        $response->assertJson([
            'id' => 1,
            'title' => 'April Fool\'s Day',
            'startAt' => $startAt->timestamp,
            'scores' => [],
        ]);

        $this->assertDatabaseHas('games', [
            'title' => 'April Fool\'s Day',
            'startAt' => $startAt->timestamp,
        ]);
    }

    /**
     * Update a game's scores
     *
     * HTTP Request
     * POST: /api/game/{id}/scores
     * JSON Payload:
     * [
     *     {
     *         "player": "Ian",
     *         "value": 80
     *     },
     *     {
     *         "player": "Jeff",
     *         "value": 71
     *     },
     *     {
     *         "player": "Cathy",
     *         "value": 83
     *     }
     * ]
     *
     * ------------------------------
     *
     * HTTP Response
     * Status Code: 200
     * JSON Content Type:
     * {
     *     "id": 1,
     *     "title": "April Fool's Day",
     *     "startAt": "1585713660",
     *     "scores": [
     *         {
     *             "player": "Ian",
     *             "value": "80"
     *         },
     *         {
     *             "player": "Jeff",
     *             "value": "71"
     *         },
     *         {
     *             "player": "Cathy",
     *             "value": "83"
     *         }
     *     ]
     * }
     *
     */
    public function testUpdateScores(): void
    {
        /** @var Game $game */
        $game = factory(Game::class)->create();

        $response = $this->json('put','/api/game/' . $game->id . '/scores', [
            [
                'player' => 'Jane',
                'value' => 85,
            ],
            [
                'player' => 'Jeff',
                'value' => 67,
            ],
            [
                'player' => 'Cathy',
                'value' => 92,
            ],
        ]);

        $response->assertOk();
        $response->assertJsonCount(3, 'scores');
        $response->assertJson([
            'id' => 1,
            'title' => 'April Fool\'s Day',
            'startAt' => 1585713660,
            'scores' => [
                [
                    'player' => 'Jane',
                    'value' => 85,
                ],
                [
                    'player' => 'Jeff',
                    'value' => 67,
                ],
                [
                    'player' => 'Cathy',
                    'value' => 92,
                ],
            ],
        ]);

        $this->assertDatabaseHas('scores', [
            'player' => 'Jane',
            'value' => 85,
            'game_id' => $game->id,
        ]);
        $this->assertDatabaseHas('scores', [
            'player' => 'Jeff',
            'value' => 67,
            'game_id' => $game->id,
        ]);
        $this->assertDatabaseHas('scores', [
            'player' => 'Cathy',
            'value' => 92,
            'game_id' => $game->id,
        ]);
    }
}
