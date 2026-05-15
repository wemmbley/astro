# AI Инфраструктура.

Задача этого модуля обеспечить бесперебойную, мультидрайверную AI-Инфраструктуру.

Цель - как можно сильнее скрыть логику, и в идеале дать простейший клиент дающий ответы.

## Драйвера.

Наш главный кадидат - DeepSeek, но ввиду отсутствия бесплатного тарифа был сделан вынужденный временный "съезд" на Gemini для обкатки функционала.

Что касается OpenAI - его поддержка не планируется, ввиду жёсткости политики OpenAI, и неприемлимых ответов самого ChatGPT, ввиду этой самой строжайшей политики.

| Имя        | Статус         | Тестирование  |
|------------|----------------|---------------|
| `DeepSeek` | В разработке   | Не тестирован |
| `Claude`   | Заброшен       | Не тестирован |
| `Gemini`   | Стабилен       | Не тестирован |
| `OpenAI`   | Не планируется | Не тестирован |

## Использование.

Низкоуровневый транспортный уровень. Тотальный контроль.

```php
$client = new AbstractAIClient('BASE_URL','API_KEY');
$message = new Message(
    role: 'user',
    message: 'Hello! How are you?',
);
$messages = new MessageBag($message);
$agent = new AIAgent(
    role: 'astrologer',
    prompt: 'You are astrologer.',
);
$aiRequest = new AbstractAIRequest(
    messages: $messages,
    agent: $agent,
    temperature: 1.5,
    maxTokens: 128,
    model: 'abstract-model-turbo',
    mode: AIRequestMode::SSE,
);
$aiResponse = $client->sendMessage($aiRequest);

echo $aiResponse->getChatHistory();
echo $aiResponse->getLastMessage();
```

Среднеуровневый декларатив с частичной потерей контроля. Fluent Facade.
```php
new AIDriver(driver: 'gemini', model: 'gemini3-turbo')
    ->prompt('Hello! How are you?', 'user')
    ->config(function(AIBlueprint $schema) {
        $schema->temperature(1.5);
        $schema->maxTokens(128);
        $schema->retry(3);

        return $schema;
    })
    ->streaming(function(string $chunk) {
        echo $chunk;
    })
```

Высокоуровневый дешёвый декларатив.
```php
ai('Hello! How are you?')
    ->streaming(function(string $chunk) {
        echo $chunk;
    })
```
