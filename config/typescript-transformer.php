<?php

return [
    'collectors' => [

    ],
    'transformers' => [
        Spatie\LaravelData\Support\TypeScriptTransformer\DataTypeScriptTransformer::class,
        Spatie\TypeScriptTransformer\Transformers\EnumTransformer::class,
    ],
    'searching_path' => base_path('src/API'),
    'output_path' => base_path('src/UI/Routes/Types/Generated'),
    'null_is_optional' => true,
];
