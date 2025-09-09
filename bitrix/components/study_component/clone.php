<?php
    # Проверяем что запрос к файлу не был прямым
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

    # Подключаем модуль iblock, если модуль не удалось подключить, 
    # то выводим ошибку и завершаем выполнение файла
    if (!Cmodule::IncludeModule("iblock")){
        ShowError("Не удалось подключить модуль iblock");
        return;
    }

    # Создаем массив для фильтра, будем выбирать данные по ID и активности
    $arFilter = [
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y"
    ];

    # Создаем массив для данных, которые будем получать
    $arSelect = [
        "ID",
        "NAME",
        "PREVIEW_TEXT",
        "DETAIL_PAGE_URL",
        "DATE_ACTIVE_FROM"
    ];

    # Создаем пустой массив в ячейке массива arResult
    $arResult["ITEMS"] = [];

    # Получаем все элементы инфоблока по заданным параметрам
    $res = CIBlockElement::GetList(
        ["DATE_ACTIVE_FROM" => "DESC"], # Устанавливаем сортировку
        $arFilter,                      # Устанавливаем фильтр
        false,                          # Нет группировки
        ["nTopCount" => 10],            # Выводим максиммум 10 записей
        $arSelect                       # Устанавливаем список элементов, которые выбираем
    );

    # Выкручиваем в цикле все элеметы и добавляем в массив
    while ($ob = $res->GetNext()){
        $arResult["ITEMS"] = $ob;
    }

    # Подключаем шаблон для компонента
    $this->IncludeComponentTemplate();

?>

<?php if (!defined("B_PROLOG_INCLUDED" || B_PROLOG_INCLUDED !== true)) die(); ?>

<div class="simple__list">
    <?php if (!empty($arResult["ITEMS"])): ?>
        <?php foreach($arResult["ITEMS"] as $item): ?>
            <div class="simple__list-item">
                <h3>
                    <a href="<?= htmlspecialcharsbx($item["DETAIL_PAGE_URL"]) ?>">
                        <?= htmlspecialcharsbx($item["NAME"]) ?>
                    </a>
                </h3>
                <p><?= htmlspecialcharsbx($item["PREVIEW_TEXT"]) ?></p>
                <small><?= $itemp["DATE_ACTIVE_FROM"] ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет элементов для отображения.</p>
    <?php endif; ?>
</div>