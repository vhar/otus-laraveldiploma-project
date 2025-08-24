{{ $link }}

@if (count($model->photoEntities) < 3 || empty($model->rating))
<ul>
    @if (!count($model->photoEntities))
        <li>Нет картинок с прозрачным фоном для модели</li>
    @else
        @if(empty($model->photoEntities[2]))
            <li>Нет картинки с прозрачным фоном для второго слайда</li>
        @endif
        @if(empty($model->photoEntities[1]))
            <li>Нет картинки с прозрачным фоном для третьего слайда</li>
        @endif
    @endif
    @if (empty($model->tread_pattern))
        <li>Не указан рисунок протектора для модели</li>
    @endif
    @if (empty($model->rating))
        <li>Отсутствует рейтинг для модели шины</li>
    @endif

</ul>
@endif
