<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Подключаем модуль инфоблок
if (!CModule::IncludeModule("iblock")) {
    ShowError("Модуль Инфоблоков не установлен");
    return;
}

// Настройки компонента
$arParams = array(
    "IBLOCK_ID" => 1, // Укажите ID вашего инфоблока
    "ELEMENT_COUNT" => 10, // Количество элементов для вывода
);

// Получение элементов инфоблока
$arFilter = array(
    'IBLOCK_ID' => $arParams["IBLOCK_ID"],
    'ACTIVE' => 'Y',
);
$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => $arParams["ELEMENT_COUNT"]));

// Массив для хранения элементов
$arResult = array();

// Заполнение массива элементами
while ($ob = $res->GetNextElement()) {
    $fields = $ob->GetFields();
    $props = $ob->GetProperties(); // Получаем свойства элемента

    $itemData = array(
        'ID' => $fields['ID'],
        'NAME' => $fields['NAME'],
        'DETAIL_PAGE_URL' => $fields['DETAIL_PAGE_URL'],
        'PREVIEW_TEXT' => $fields['PREVIEW_TEXT'],
        'PROPERTY_VALUES' => $props,
    );

    $arResult[] = $itemData; // Добавляем элемент в результат
}

// Передаем данные в шаблон
$this->IncludeComponentTemplate();
?>

<!-- Шаблон компонента: template.php -->
<div class="custom-component">
    <h2>Список элементов</h2>
    <?php if (!empty($arResult)): ?>
        <ul>
            <?php foreach ($arResult as $item): ?>
                <li>
                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a>
                    <p><?= $item['PREVIEW_TEXT'] ?></p>
                    <?php if (!empty($item['PROPERTY_VALUES'])): ?>
                        <ul>
                            <?php foreach ($item['PROPERTY_VALUES'] as $propName => $propValue): ?>
                                <li><?= $propName ?>: <?= is_array($propValue['VALUE']) ? implode(', ', $propValue['VALUE']) : $propValue['VALUE'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет данных для отображения.</p>
    <?php endif; ?>
</div>