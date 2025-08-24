@php
/**
 *  @var \App\Services\UseCases\Commands\Telegram\Marcetplases\Ozon\NewProductsCommand $command
 */
@endphp
Новые товары на Озон

<a href="{{ env('APP_URL') }}/admin/catalog/tyres?created[start]={{ $command->start->format("Y-m-d") }}&created[end]={{ $command->end->format("Y-m-d") }}">Посмотреть</a>
