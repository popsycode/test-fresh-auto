#Задание:

Есть xml файл, нужно на выходе получить xml, у которого название тегов, названия атрибутов и содержимое тегов, будет в обратном порядке. Файл может быть произвольного размера (очень большим)

Пример:
```xml
<?xml version="1.0" encoding="utf-8"?>
<abc>
    <def name="first">inner text</def>
</abc>
```

Должен стать таким:
```xml
<?xml version="1.0" encoding="utf-8"?>
<cba>
  <fed eman="tsrif">txet renni</fed>
</cba>
```

#Решение:

###Установка
- git clone
- Выполнить `php composer install` (Запуск в docker `bush composer install`)

###Запуск
Основной файл run.php
- `php run.php`(Запуск в docker `bush run`)
