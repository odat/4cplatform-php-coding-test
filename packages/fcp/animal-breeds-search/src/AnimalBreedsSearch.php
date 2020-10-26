<?php

namespace Fcp\AnimalBreedsSearch;

use Fcp\AnimalBreedsSearch\Models\Breed;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimalBreedsSearch
{
    private $endpoint;

    private $version;

    private $apiKey;

    private $url;

    private $timeout;

    public function __construct()
    {
        $service = config('animal-breeds-search.service');

        $this->endpoint = config('animal-breeds-search.services.' . $service . '.endpoint');
        $this->version = config('animal-breeds-search.services.' . $service . '.version');
        $this->apiKey = config('animal-breeds-search.services.' . $service . '.api_key');
        $this->url = implode('/', [$this->endpoint, $this->version]);
        $this->timeout = config('animal-breeds-search.timeout');

        return true;
    }

    protected function buildRequestHeader()
    {
        return [
            'Authorization' => 'key=' . $this->app['config']->get('animal-breeds-search.services.CAT_API_KEY', []),
            'Content-Type'  => 'application/json',
            'project_id'    => $this->config['sender_id'],
        ];
    }

    protected function createHttpDriver($type)
    {
        if ($type == 'cat') {
            $config = $this->app['config']->get('animal-breeds-search.services.endpoint', []);
        }

        return new Client(['timeout' => $config['timeout']]);
    }

    public function search($type, $q)
    {
        /*
         * double check validation
         */
        $request = new Request();
        $request->offsetSet('animal_type', $type);
        $request->offsetSet('breed', $q);

        $request->validate([
            'animal_type' => 'required|in:cat,dog',
            'breed'       => 'required'
        ]);

        /*
         * search from local database
         */
        $oBreeds = Breed::where('name', 'like', '%' . $q . '%')
            ->where('animal_type', $type)
            ->get();

        if ($oBreeds->count() == 0) {
            /*
             * search online
             */
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey
            ])
                ->get(
                    $this->url . '/breeds/search',
                    [
                        'q' => $q
                    ]
                );

            if ($response->successful() === true) {
                $rows = $response->json();

                if (empty($rows)) {
                    return [];
                }

                /*
                 * store on the local database
                 */
                $result = [];
                foreach ($rows as $row) {
                    $oBreed = new Breed();
                    $oBreed->animal_type = $type;
                    $oBreed->name = $row['name'];
                    $oBreed->country_code = $row['country_code'];
                    $oBreed->country_code = $row['country_code'];
                    $oBreed->description = $row['description'];
                    $oBreed->temperament = $row['temperament'];
                    $oBreed->alternative_names = $row['alt_names'];
                    $oBreed->life_span = $row['life_span'];
                    $oBreed->origin = $row['origin'];
                    $oBreed->wikipedia_url = $row['wikipedia_url'];
                    $oBreed->save();

                    $result[] = $oBreed;
                }

                $oBreeds = collect($result)->all();
            }
        }

        return $oBreeds;
    }

    public function find($id)
    {
        $oBreed = Breed::findOrFail($id);
        $name = $oBreed->name;

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])
            ->get(
                $this->url . '/breeds/search',
                [
                    'q' => $name
                ]
            );

        if ($response->successful() === true) {
            $rows = $response->json();

            if (!empty($rows)) {
                $breeds = collect($rows);
                $row = $breeds->first();


                /*
                 * update the record on the local database
                 */
                $oBreed->name = $row['name'];
                $oBreed->country_code = $row['country_code'];
                $oBreed->country_code = $row['country_code'];
                $oBreed->description = $row['description'];
                $oBreed->temperament = $row['temperament'];
                $oBreed->alternative_names = $row['alt_names'];
                $oBreed->life_span = $row['life_span'];
                $oBreed->origin = $row['origin'];
                $oBreed->wikipedia_url = $row['wikipedia_url'];
                $oBreed->save();
            }
        }

        return $oBreed;
    }
}
