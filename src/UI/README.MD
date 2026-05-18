# UI

Это слой, ответственный за весь Web-UI клиентский.

## Зона ответственности

Тут у нас хранится Vue, разбитый по слоям, c lazy-load островками Solid.

Так же это место хранения InertiaController и web-роутов.

# Архитектура

| Название зоны | Предназначение                     | Пример          |
|---------------|------------------------------------|-----------------|
| App           | Контроллеры, Мидлвары.             | FeedController  |
| Bootstrap     | Единая точка загрузки приложения.  | App.js, App.css |
| Helpers       | Вспомогательные функции.           | Fetcher.ts      |
| Modules       | Доменные зоны UI-областей.         | Feed            |
| Pages         | Все доступные Vue-страницы.        | FeedPage        |
| Routes        | Биндинг всех доступных веб-роутов. | web.php         |

# Solid

Для подключения островка, используйте компонент `SolidIsland`, где укажите `tsx` файл островка.

```vue
<SolidIsland :loader="() => import('@/Solid/MyComponent')" />
```

Solid выступает для сложных реактивностей, где логика `template-first` плохо ложится.

Если неймспейс автоматом не подключается, делаем импорт вручную:

```js
import SolidIsland from "@/Bootstrap/Solid/SolidIsland.vue";
```

### Пример компонента
```tsx
import { createSignal } from 'solid-js'

export default function Test() {
    const [count, setCount] = createSignal(0)

    return (
        <div class="text-white z-99 absolute">
            <button onClick={() => setCount(count() + 1)}>
                <p>Count: {count()}</p>
            </button>
        </div>
    )
}
```
