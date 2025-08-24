<?php

namespace App\Console\Commands\Ozon;

use App\Events\NewProductsOnOzonEvent;
use Illuminate\Console\Command;
use App\Models\Catalog\Tyres\Tyre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use App\Models\Marketplaces\Ozon\TyreOnOzon;
use App\Services\Repositories\Common\ModelNotFoundException;

class SyncOzonProductListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:sync-product-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Привязка товаров из каталога сайта к товарам на Озон';

    private array $headers;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->headers = [
            'Content-Type' => 'application/json',
            'Client-Id' => Config::get('marketplaces.ozon.clientId'),
            'Api-Key' => Config::get('marketplaces.ozon.apiKey'),
        ];

        $payload = [
            'filter' => [
                'visibility' => 'ALL'
            ],
            'last_id' => "",
            'limit' => 1
        ];

        $response = $this->getProductList($payload);

        $total = $response['total'];
        $payload['limit'] = 1000;
        $index = 1;
        $received = 0;

        $lastId = TyreOnOzon::max('id');

        while ($received < $total) {
            $from = $received + 1;
            $to = $index * 1000;

            if ($to > $total) {
                $to = $total;
            }

            $this->info("Получаем чанк {$from} - {$to} из {$total}");
            $response = $this->getProductList($payload);

            $payload['last_id'] = $response['last_id'];
            $received += count($response['result']);
            $index++;

            $this->info('Синхронизируем данные');

            $items = $response['result'];

            $offers = array_column($items, 'offer_id');

            $chunkTyres = Tyre::query()
                ->whereIn('article', $offers)
                ->where('is_active', true)
                ->pluck('id', 'article')
                ->toArray();

            foreach ($items as $item) {
                try {
                    if (isset($chunkTyres[$item['offer_id']])) {
                        TyreOnOzon::updateOrCreate(
                            [
                                'article' => $item['offer_id'],
                            ],
                            [
                                'ozon_product_id' => $item['id'],
                                'sku' => $item['sku'],
                                'tyre_id' => $chunkTyres[$item['offer_id']],

                            ]
                        );
                    }
                } catch (ModelNotFoundException $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }

        $created = TyreOnOzon::query()
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->pluck('created_at', 'tyre_id')
            ->toArray();

        if (count($created)) {
            $productIds = array_keys($created);
            $start = array_values($created)[0];
            $end = array_pop($created);

            NewProductsOnOzonEvent::dispatch($productIds, $start, $end);
        }

        $this->info('Finished');
    }

    /**
     * Получить сведения о товарах на Озон
     * @param array $payload
     * @return mixed
     */
    private function getProductList(array $payload): mixed
    {
        $response = Http::withHeaders($this->headers)
            ->acceptJson()
            ->post('https://api-seller.ozon.ru/v4/product/info/attributes', $payload);

        return $response->json();
    }
}
